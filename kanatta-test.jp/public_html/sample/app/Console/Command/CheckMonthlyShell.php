<?php
App::uses('ComponentCollection', 'Controller');
App::uses('CardComponent', 'Controller/Component');
App::uses('MailComponent', 'Controller/Component');

/**
 * 月額課金の課金成否チェック
 * - 次回課金日が今日より前のものについて、課金成否をチェックする
 * - 成功であれば支援者に課金成功通知メールを送付
 * - 失敗であれば、管理者、PJオーナ、支援者に課金失敗通知メールを送付
 */
class CheckMonthlyShell extends AppShell
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
        $bps = $this->BackedProject->get_monthly_of_charge_date_in_past();
        if(empty($bps)) return;
        foreach($bps as $bp){
            $result = $this->_chk_charge($bp['BackedProject']['recurring_id']);
            $this->BackedProject->begin();
            if($this->_save_bp($bp['BackedProject']['id'], $result)){
                $this->BackedProject->commit();
                $this->_mail($bp, $result);
            }
            $this->BackedProject->rollback();
        }
    }

    private function _chk_charge($recurring_id)
    {
        list($status, $out, $err) = $this->Card->check_monthly_charge($recurring_id);
        if(!$status) return null;
        $result = array(
            'amount' => $out->getAmount(),
            'next_charge_date' => $out->getNextChargeDate(),
            'old_charge_date' => $out->getProcessDate(),
            'err_code' => $out->getChargeErrCode(),
            'err_info' => $out->getChargeErrInfo()
        );
        if(!empty($result['err_code']) || !empty($result['err_info'])){
            $result['charge_result'] = CHARGE_NG;
        }else{
            $result['charge_result'] = CHARGE_OK;
        }
        return $result;
    }

    private function _save_bp($id, $result)
    {
        if($this->BackedProject->save_monthly_charge_result($id, $result)){
            return true;
        }
        return false;
    }

    public function _mail($bp, $result)
    {
        $backer = $bp['Backer'];
        $owner = $bp['Owner'];
        $pj = $bp['Project'];
        $pj['url'] = $this->Url->getProjectViewUrl($this->setting['site_url'], $pj['id']);
        if($result['charge_result'] == CHARGE_OK){
            if($this->_mail_success($backer, $pj, $result)) return true;
        }else{
            if($this->_mail_fail($backer, $owner, $pj, $result)) return true;
        }
        return false;
    }

    private function _mail_success($backer, $pj, $result)
    {
        if($this->Mail->success_monthly_charge($backer, $pj, $result)) return true;
        return false;
    }

    private function _mail_fail($backer, $owner, $pj, $result)
    {
        $result['url'] = $this->Url->getMypageCardUrl($this->setting['site_url']);
        $flag = true;
        if(!$this->Mail->fail_monthly_charge_owner($backer, $owner, $pj, $result, 'admin')){
            $flag = false;
        }
        if(!$this->Mail->fail_monthly_charge_owner($backer, $owner, $pj, $result, 'user')){
            $flag = false;
        }
        if(!$this->Mail->fail_monthly_charge_backer($backer, $pj, $result)){
            $flag = false;
        }
        if($flag) return true;
        return false;
    }

}