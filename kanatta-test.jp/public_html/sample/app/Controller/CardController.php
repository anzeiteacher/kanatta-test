<?php
App::uses('AppController', 'Controller');

class CardController extends AppController
{
    public $uses = array('BackedProject');
    public $components = array('Mail', 'Card');
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('hoge');
        $this->layout = 'mypage';
    }

    /**
     * マイページ - カード登録画面
     */
    public function index()
    {
        $now_card = $this->_get_card();
        if(!$now_card[0]) return;
        if($this->request->is('post') || $this->request->is('put')){
            $card = $this->request->data['Card'];
            $user_id = $this->Auth->user('id');

            //カード情報のバリデーションチェック
            list($status, $err) = $this->Card->validate_card_info($card);
            if(!$status) return $this->_error($err, 'カード情報の入力が正しくありません');

            if(empty($now_card[1])){
                //会員登録されてなかったら会員登録する
                list($status, $member, $err) = $this->Card->get_member($user_id);
                if(!$status) return $this->_error($err);
                if(empty($member)){
                    list($status, $err) = $this->Card->set_member($user_id);
                    if(!$status) return $this->_error($err);
                }
                $mode = 'new';
            }else{
                $mode = 'update';
            }

            //新しいカード情報を登録
            list($status, $err) = $this->Card->set_card_of_member($user_id, $card, $mode);
            if(!$status) return $this->_error($err);
            $this->_chk_failing_pay($user_id);
            $this->Session->setFlash('カードを登録しました');
            $this->redirect('/card');
        }
    }

    /**
     * 登録済みカードを確認
     * @return array (status, card_no)
     */
    private function _get_card()
    {
        list($status, $card_no, $err) = $this->Card->get_card_of_member($this->Auth->user('id'));
        if(!$status){
            $err['get_card_err'] = KESSAI_NETWORK_ERROR;
            $this->_error($err, '決済サービスとの接続エラーが発生しました');
            return array(false, null);
        }else{
            $this->set(compact('card_no'));
            return array(true, $card_no);
        }
    }

    /**
     * 現在失敗中のBPのcard_changedをTrueにする
     * @param $user_id
     * @return bool
     */
    private function _chk_failing_pay($user_id)
    {
        if($this->BackedProject->set_card_changed_to_failing($user_id)){
            return true;
        }
        return false;
    }

    /**
     * マイページ - カード情報を削除する
     */
    public function delete()
    {
        if(!$this->request->is('post')) $this->redirect('/card');
        list($status, $err) = $this->Card->delete_card_of_member($this->Auth->user('id'));
        if(!$status){
            $this->_error($err);
        }else{
            $this->Session->setFlash('カード情報を削除しました');
        }
        $this->redirect('/card');
    }

    /**
     * マイページ - 月額課金購入一覧画面
     */
    public function monthly()
    {
        $this->paginate = $this->BackedProject->get_monthly_pay($this->Auth->user('id'));
        $bps = $this->paginate('BackedProject');
        foreach($bps as $idx => $b){
            $tmp = $b['BackedProject']['old_charge_date'];
            $old = !empty($tmp) ? date('Y年m月d日', strtotime($tmp)) : '-';
            $tmp = $b['BackedProject']['charge_result'];
            if(empty($tmp)){
                $result = '-';
            }else{
                $result = ($tmp == CHARGE_OK) ? '成功' : '失敗';
            }
            $tmp = $b['BackedProject']['next_charge_date'];
            $next = !empty($tmp) ? date('Y年m月d日', strtotime($tmp)) : '-';
            $bps[$idx]['BackedProject']['old_charge_date'] = $old;
            $bps[$idx]['BackedProject']['charge_result'] = $result;
            $bps[$idx]['BackedProject']['next_charge_date'] = $next;
        }
        $this->set('bps', $bps);
    }

    /**
     * 月額課金のキャンセル
     */
    public function stop($bp_id)
    {
        $this->BackedProject->begin();
        $bp = $this->_chk_stop($bp_id);
        $flag = false;
        if($this->BackedProject->stop_for_monthly($bp_id)){
            if($this->Card->stop_for_monthly($bp['recurring_id'])){
                $this->BackedProject->gmo_cancelled_flag_true($bp_id);
                $flag = true;
            }
        }
        if($flag){
            $this->Session->setFlash('課金をキャンセルしました');
            $this->BackedProject->commit();
            list($pj, $user) = $this->_get_pj($bp);
            $this->_update_backing_level($bp);
            $this->_update_pj($bp);
            $this->_mail_cancel_monthly($bp, $pj, $user);
        }else{
            $this->Session->setFlash('課金がキャンセルできませんでした。'.OSORE);
            $this->BackedProject->rollback();
        }
        return $this->redirect('/card/monthly');
    }

    private function _chk_stop($bp_id)
    {
        $url = '/card/monthly';
        if(!$this->request->is('post')) return $this->redirect($url);
        $bp = $this->BackedProject->findById($bp_id);
        if(empty($bp['BackedProject'])) return $this->redirect($url);
        $bp = $bp['BackedProject'];
        if($bp['user_id'] != $this->Auth->user('id') ||
           $bp['pay_pattern'] != MONTHLY ||
           $bp['status'] == STATUS_CANCEL)
        {
            return $this->redirect($url);
        }
        return $this->_edit_bp($bp);
    }

    private function _edit_bp($bp)
    {
        $bp['charge_start_date'] = date('Y/m/d', strtotime($bp['charge_start_date']));
        if(!empty($bp['old_charge_date'])){
            $bp['old_charge_date'] = date('Y/m/d', strtotime($bp['old_charge_date']));
        }
        if(!empty($bp['charge_result'])){
            $results = Configure::read('CHARGE_RESULTS');
            $bp['charge_result'] = $results[$bp['charge_result']];
        }else{
            $bp['charge_result'] = '';
        }
        return $bp;
    }

    private function _get_pj($bp)
    {
        $Project = ClassRegistry::init('Project');
        $User = ClassRegistry::init('User');
        $pj = $Project->findById($bp['project_id']);
        $user = $User->findById($pj['Project']['user_id']);
        return array($pj['Project'], $user['User']);
    }

    private function _update_backing_level($bp)
    {
        $Level = ClassRegistry::init('BackingLevel');
        $bl = array('BackingLevel' => array('id' => $bp['backing_level_id']));
        if($Level->put_backing_level_now_count($bl, 'del')) return true;
        return false;
    }

    private function _update_pj($bp)
    {
        $PJ = ClassRegistry::init('Project');
        $pj = array('Project' => array('id' => $bp['project_id']));
        if($PJ->add_backed_to_project($bp, $pj, 'del')) return true;
        return false;
    }

    private function _mail_cancel_monthly($bp, $pj, $user)
    {
        $this->Mail->cancel_monthly($bp, $pj, $user, 'user');
        $this->Mail->cancel_monthly($bp, $pj, $user, 'admin');
    }

    private function _error($err, $msg=null)
    {
        if(!$msg) $msg = $err;
        $this->Session->setFlash($msg);
        $this->set(compact('err'));
    }

}
