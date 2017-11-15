<?php
App::uses('ComponentCollection', 'Controller');
App::uses('CardComponent', 'Controller/Component');
App::uses('MailComponent', 'Controller/Component');

/**
 * 月額課金失敗BPへの即時課金試行処理
 *  - charge_resultがCHARGE_NGで3日間即時課金を試していないBPを取得
 *    card_changedがTrueのBPも取得
 *  - カード変更がなく、最初の失敗から2週間経過していたらサービスを停止する。
 *  - 上記以外の場合、即時課金を試す。
 *  - 課金成功ならcharge_resultをCHARGE_OKにし、課金成功メールを支援者に送信する。
 *  - 失敗なら失敗通知メールを支援者に送信し、old_charge_date_for_failを更新する。
 *  - カード変更ありで、最初の失敗から2週間経過していたらサービスを停止する。
 */
class CaptureMonthlyShell extends AppShell
{
    public $uses = array('BackedProject', 'Setting');
    public $tasks = array('Url');

    public function startup()
    {
        $this->setting = $this->Setting->findById(1);
        $this->setting = $this->setting['Setting'];
        $collection = new ComponentCollection();
        $this->Card = new CardComponent($collection, $this->setting);
        $this->Mail = new MailComponent($collection, $this->setting);
        parent::startup();
    }

    public function main()
    {
        $bps = $this->BackedProject->get_monthly_of_failing(10);
        if(empty($bps)) return;
        foreach($bps as $bp){
            $changed = $this->_chk_card_changed($bp);
            $passed = $this->_chk_certain_period_passed($bp);
            if(!$changed && $passed){
                $this->_stop_service($bp);
            }
            if($this->_pay($bp)){
                $this->_success($bp);
                $this->_mail_success($bp);
            }else{
                $this->_fail($bp);
                $this->_mail_fail($bp);
                if($changed && $passed){
                    $this->_stop_service($bp);
                }
            }
        }
    }

    public function _chk_card_changed($bp)
    {
        if($bp['BackedProject']['card_changed']){
            return true;
        }
        return false;
    }

    /**
     * old_charge_dateから一定期間経過していたらtrueを返す
     * @param $bp
     * @return bool
     */
    public function _chk_certain_period_passed($bp)
    {
        $bp = $bp['BackedProject'];
        $start = new DateTime($bp['old_charge_date']);
        $period = new DateTime(date('Y-m-d', strtotime('-14days')));
        if($start <= $period) return true;
        return false;
    }

    public function _stop_service($bp)
    {
        if($this->BackedProject->stop_monthly_service($bp['BackedProject']['id'])){
            return true;
        }
        return false;
    }

    public function _pay($bp)
    {
        $backer = $bp['Backer'];
        $pj = $bp['Project'];
        $bp = $bp['BackedProject'];
        $data = array(
            'amount' => $bp['invest_amount'],
            'order_id' => $this->BackedProject->get_order_id($pj['id'], $backer['id']),
            'user_id' => $backer['id']
        );
        $result = $this->Card->charge_capture_for_monthly_fail($data);
        if($result[0]) return true;
        return false;
    }

    public function _success($bp)
    {
        if($this->BackedProject->save_monthly_success_while_failing($bp)){
            return true;
        }
        return false;
    }

    public function _mail_success($bp)
    {
        list($backer, $pj, $result) = $this->_make_result($bp);
        if($this->Mail->success_monthly_charge($backer, $pj, $result)){
            return true;
        }
        return false;
    }

    public function _fail($bp)
    {
        if($this->BackedProject->save_monthly_fail_while_failing($bp)){
            return true;
        }
        return false;
    }

    public function _mail_fail($bp)
    {
        list($backer, $pj, $result) = $this->_make_result($bp);
        if($this->Mail->fail_monthly_charge_backer($backer, $pj, $result)){
            return true;
        }
        return false;
    }

    private function _make_result($bp)
    {
        $backer = $bp['Backer'];
        $pj = $bp['Project'];
        $pj['url'] = $this->Url->getProjectViewUrl($this->setting['site_url'], $pj['id']);
        $bp = $bp['BackedProject'];
        $result = array(
            'amount' => $bp['invest_amount'],
            'old_charge_date' => date('Y-m-d'),
            'url' => $this->Url->getMypageCardUrl($this->setting['site_url'])
        );
        return array($backer, $pj, $result);
    }

}