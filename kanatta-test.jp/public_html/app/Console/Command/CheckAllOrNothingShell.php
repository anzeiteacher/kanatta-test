<?php
App::uses('ComponentCollection', 'Controller');
App::uses('CardComponent', 'Controller/Component');
App::uses('MailComponent', 'Controller/Component');

/**
 * All or Nothing型プロジェクトの達成チェック
 * 売上確定・キャンセル、メール通知
 */
class CheckAllOrNothingShell extends AppShell
{
    public $uses = array('Project', 'BackedProject', 'User', 'Setting');

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
        $pj = $this->Project->get_finish_and_active_allornothing_pj();
        if(empty($pj)) return;
        if($this->_check_achieved($pj)){
            $result = $this->_success($pj);
        }else{
            $result = $this->_fail($pj);
        }
        if($result) $this->_project_non_active($pj);
    }

    /**
     * 該当プロジェクトが成功したか失敗したかをチェックする関数
     * @param array $pj
     * @return boolean
     */
    private function _check_achieved($pj)
    {
        $goal_amount = $pj['Project']['goal_amount'];
        $collected_amount = $pj['Project']['collected_amount'];
        if($goal_amount <= $collected_amount) return true;
        return false;
    }

    /**
     * 成功したプロジェクトの支援全てに対して決済を実行する関数
     * @param array $pj
     * @return bool
     */
    private function _success($pj)
    {
        $bps = $this->BackedProject->get_kariuriage_bps($pj['Project']['id']);
        $result = true;
        foreach($bps as $bp){
            if($this->_exec_pay($bp)){
                $this->mail_exec_to_backer($pj, $bp);
            }else{
                $result = false;
            }
        }
        return $result;
    }

    /**
     * 失敗したプロジェクトの支援全てに対して決済をキャンセルする関数
     * @param array $pj
     * @return bool
     */
    private function _fail($pj)
    {
        $bps = $this->BackedProject->get_kariuriage_bps($pj['Project']['id']);
        $result = true;
        foreach($bps as $bp){
            if($this->_cancel_pay($bp)){
                $this->mail_cancel_to_backer($pj, $bp);
            }else{
                $result = false;
            }
        }
        return $result;
    }

    /**
     * GMOペイメントの決済売上確定処理
     * @param array $bp
     * @return bool
     */
    private function _exec_pay($bp)
    {
        $flag = true;
        $this->BackedProject->begin();
        if(! $this->_save_status_to_bp(STATUS_KAKUTEI, $bp)){
            $flag = false;
        }else{
            $out = null;
            if(! $bp['BackedProject']['manual_flag']){
                $out = $this->Card->sales_for_all_or_nothing($bp['BackedProject']);
                if(!$out[0]){
                    $this->log($out[1]);
                    $flag = false;
                }
            }
        }
        if($flag){
            $this->BackedProject->commit();
            return true;
        }else{
            $this->BackedProject->rollback();
            return false;
        }
    }

    /**
     * GMOペイメントの決済キャンセル処理
     * @param array $bp
     * @return bool
     */
    private function _cancel_pay($bp)
    {
        $flag = true;
        $this->BackedProject->begin();
        if(! $this->_save_status_to_bp(STATUS_FAIL, $bp)){
            $flag = false;
        }else{
            $out = null;
            if(! $bp['BackedProject']['manual_flag']){
                $out = $this->Card->cancel_for_all_or_nothing($bp['BackedProject']);
                if(!$out[0]){
                    $this->log($out[1]);
                    $flag = false;
                }
            }
        }
        if($flag){
            $this->BackedProject->commit();
            return true;
        }else{
            $this->BackedProject->rollback();
            return false;
        }
    }

    /**
     * PJを非アクティブにして、管理者・PJオーナに完了通知メール
     */
    private function _project_non_active($pj)
    {
        $this->Project->begin();
        $this->Project->id = $pj['Project']['id'];
        if($this->Project->saveField('active', 0)){
            if($this->mail_fin_to_owner($pj)){
                $this->Project->commit();
                return true;
            }
        }
        $this->Project->rollback();
        return false;
    }

    /**
     * 決済実行結果をbacked_projectsテーブルに登録する関数
     * @param int $status
     * @param array $bp
     * @return bool
     */
    private function _save_status_to_bp($status, $bp)
    {
        $this->BackedProject->id = $bp['BackedProject']['id'];
        if($this->BackedProject->saveField('status', $status)) return true;
        return false;
    }

    /**
     * 支援者にプロジェクト成功の連絡メールを送信する関数
     * @param array $pj
     * @param array $bp
     * @return boolean
     */
    private function mail_exec_to_backer($pj, $bp)
    {
        if($bp['BackedProject']['manual_flag']) return true;
        $user = $this->User->findById($bp['BackedProject']['user_id']);
        if($this->Mail->exec_complete($pj, $bp, $user)) return true;
        return false;
    }

    /**
     * 支援者にプロジェクト失敗の連絡メールを送信する関数
     * @param array $pj
     * @param array $bp
     * @return boolean
     */
    private function mail_cancel_to_backer($pj, $bp)
    {
        if($bp['BackedProject']['manual_flag']) return true;
        $user = $this->User->findById($bp['BackedProject']['user_id']);
        if($this->Mail->cancel_complete($pj, $bp, $user)) return true;
        return false;
    }

    /**
     * プロジェクトオーナーと管理者にプロジェクト終了の連絡メールを送信する関数
     * @param array $pj
     * @return boolean
     */
    private function mail_fin_to_owner($pj)
    {
        $user = $this->User->findById($pj['Project']['user_id']);
        $ok_ng = $this->_check_achieved($pj);
        if($this->Mail->project_fin($pj, $user, $ok_ng, 'admin')){
            if($this->Mail->project_fin($pj, $user, $ok_ng, 'user')){
                return true;
            }
        }
        return false;
    }

}