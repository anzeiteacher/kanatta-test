<?php
App::uses('AppController', 'Controller');

class BackedProjectsController extends AppController
{
    public $uses = array('Project', 'BackedProject', 'BackingLevel', 'User');
    public $components = array('Mail', 'Card');
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('hoge');
    }

    /**
     * 支援金額・支援コメントの入力画面
     *  - 決済パターンが月額課金の場合、金額は固定。
     *  - 月額課金以外は最低支援金額以上で自由に入力可能。
     * @param int $backing_level_id
     * @param int project_id
     */
    public function add($backing_level_id = null, $project_id = null)
    {
        list($pj, $bl) = $this->_init_check($project_id, $backing_level_id);
        if(!$pj || !$bl) return $this->redirect('/');
        $this->set(compact('pj'));
        if($this->request->is('post') || $this->request->is('put')){
            //決済パターンが月額課金の場合、金額は固定
            if($pj['Project']['pay_pattern'] == MONTHLY){
                $this->request->data['BackedProject']['invest_amount'] = $bl['BackingLevel']['invest_amount'];
            }
            if(!$this->_check_invest_amount_etc($bl)) return;
            if($bl['BackingLevel']['delivery'] == 2){
                $this->User->id = $this->Auth->user('id');
                if(!$this->User->save($this->request->data, true, array('receive_address', 'name'))){
                    return $this->Session->setFlash('登録できませんでした。'.OSORE);
                }
            }
            $this->_set_backed_info_to_session($project_id, $backing_level_id);
//            return $this->redirect(array('action' => 'card'));

             list($pj, $bl, $bp) = $this->_card_init();
             $shop_id = 'tshop00030635';
             $user_id = $this->Auth->user('id');
             $pj_id = $bp['pj_id'];
             $order_id = $this->BackedProject->get_order_id($pj_id, $user_id);
             $url = 'https://pt01.mul-pay.jp/link/tshop00030635/Multi/Entry';
             $url .= '?ShopID='. $shop_id;
             $url .= '&OrderID='. $order_id;
             $datetime = date('YmdHis');
             $url .= '&Amount=3000&DateTime=' .$datetime;

             $str = $shop_id.'|'.$order_id.'|3000||6re8enmt|'.$datetime;
             //MD5変換
             $url .= '&ShopPassString='.md5($str);
             $url .= '&RetURL='.'https://kanatta-test.jp/mypage';
//             $url .= '&UseCredit=1&JobCd=AUTH';
             $url .= '&UseCvs=1&ReceiptsDisp11=1111111111&ReceiptsDisp12=0000-000-111&ReceiptsDisp13=09:00-20:00';
             $site_id = '';
             $member_id = '';
//             $str = $site_id.'|'.$member_id.'|3000||JPY|h3xryw4f|'.$datetime;

 //            $url .= '&SiteID=1&MemberID=AUTH&MemberPassString=';

//echo $url;
//POSTデータ
// $data = array(
//             		'ShopID' => $shop_id,
//             		'OrderID' => $order_id
// 		);
// $data = http_build_query($data, "", "&");

// //header
// $header = array(
//     "Content-Type: application/x-www-form-urlencoded",
//     "Content-Length: ".strlen($data)
// );

// $context = array(
//     "http" => array(
//         "method"  => "POST",
//         "header"  => implode("\r\n", $header),
//         "content" => $data
//     )
// );

//$url = "https://pt01.mul-pay.jp/link/tshop00030635/Multi/Entry";
//echo file_get_contents($url, false, stream_context_create($context));

//             $content = http_build_query($data);
//             $options = array('http' => array(
//             		'method' => 'POST',
//             		'content' => $content
//             ));
//             $contents = file_get_contents($url, false, stream_context_create($options));
// echo ("<pre>");
// print_r ($contents);
// echo ("</pre>");

//exit;
//            return header('Location:https://k01.mul-pay.jp/link/9101679755779/Multi/Entry');
            return header('Location:'.$url);

//            return $this->redirect(file_get_contents($url, false, stream_context_create($context)));
        }else{
            $this->request->data['User']['receive_address'] = $this->auth_user['User']['receive_address'];
            $this->request->data['User']['name'] = $this->auth_user['User']['name'];
        }
    }

    /**
     * project、backingLevelの有効性チェック
     */
    private function _init_check($project_id, $backing_level_id)
    {
        if(empty($this->auth_user['User']['email'])){
            $this->Session->setFlash('支援には事前にメールアドレス認証を完了いただく必要がございます。');
            return false;
        }
        $project = $this->Project->check_backing_enable($project_id, $this->Auth->user('id'));
        if(!$project) return false;
        $backing_level = $this->BackingLevel->check_backing_level($backing_level_id, $project_id);
        if(!$backing_level) return false;
        $this->set(compact('backing_level', 'project'));
        return array($project, $backing_level);
    }

    /**
     * 支援金額やリターン配送先住所の入力チェック
     */
    private function _check_invest_amount_etc($backing_level)
    {
        //支援金額のチェック
        $data = $this->request->data;
        if(empty($data['BackedProject']['invest_amount'])){
            $this->set('error', '支援金額を入力してください。');
            return false;
        }
        $invest_amount = $data['BackedProject']['invest_amount'];
        if(!$this->BackingLevel->check_invest_amount($backing_level, $invest_amount)){
            $this->set('error', '最低支援金額以上の金額を入力してください');
            return false;
        }
        if(!$this->BackingLevel->check_max_count($backing_level)){
            $this->set('error', 'OUT OF STOCK!');
            return false;
        }
        //配送方法が郵送で、配送先が空の場合はエラー
        $delivery = $backing_level['BackingLevel']['delivery'];
        if($delivery == 2){
            if(empty($data['User']['receive_address'])){
                $this->Session->setFlash('リターン配送先住所を入力してください');
                return false;
            }
            if(empty($data['User']['name'])){
                $this->Session->setFlash('氏名を入力してください');
                return false;
            }
        }
        return true;
    }

    /**
     * 支援情報をセッションに保存
     */
    private function _set_backed_info_to_session($project_id, $backing_level_id)
    {
        $bp = array(
            'user_id' => $this->Auth->user('id'),
            'pj_id' => $project_id,
            'bl_id' => $backing_level_id,
            'amount' => $this->request->data['BackedProject']['invest_amount'],
            'comment' => $this->request->data['BackedProject']['comment']
        );
        $this->Session->write('backed_project', $bp);
    }

    /**
     * カード入力・決済実行画面
     */
    public function card()
    {
        list($pj, $bl, $bp) = $this->_card_init();
        $card_no = $this->_get_card_no();
        $pay_pattern = $pj['Project']['pay_pattern'];
        $this->set(compact('pay_pattern'));
        if($this->request->is('post') || $this->request->is('put')){
            $this->Project->begin();
            //プロジェクトの支援金額・支援人数を更新
            if($pj = $this->Project->add_backed_to_project($bp, $pj)){
                //支援パターンの購入数を更新
                if($this->BackingLevel->put_backing_level_now_count($bl)){
                    $data = $this->request->data;
                    if(empty($data['Card']['now_card']) || empty($card_no)){
                        $new_card = $data['BackedProject'];
                        if(!$this->_validate_card($new_card) ||
                           !$this->_set_member() ||
                           !$this->_set_card($new_card, $card_no))
                        {
                            return $this->Project->rollback();
                        }
                    }
                    list($status, $out) = $this->_pay($bp['pj_id'], $bp['amount'], $pay_pattern);
                    if($status){
                        if($backed_project = $this->_save_info_of_pay($bp, $out, $pay_pattern)){
                            $this->_mail_back_complete($backed_project, $pj);
                            $this->Session->setFlash('ありがとうございます！支援が完了しました！');
                            $this->Project->commit();
                            return $this->redirect('/mypage');
                        }
                    }
                }
            }
            $this->Project->rollback();
            $this->Session->setFlash('決済登録に失敗しました。'.OSORE);
            $this->log('All or Nothing 決済登録失敗：'.date('Y/m/d H:i'));
        }
    }

    private function _pay($pj_id, $amount, $pay_pattern)
    {
        $user_id = $this->Auth->user('id');
        $data = array(
            'order_id' => $this->BackedProject->get_order_id($pj_id, $user_id),
            'amount' => $amount,
            'user_id' => $user_id
        );
        switch($pay_pattern){
            case ALL_OR_NOTHING:
                $result = $this->Card->pay_for_all_or_nothing($data);
                break;
            case ALL_IN:
                $result = $this->Card->pay_for_all_in($data);
                break;
            case MONTHLY:
                $result = $this->Card->pay_for_monthly($data);
        }
        list($status, $out, $err) = $result;
        if(!$status){
            $this->_error($err);
            return array(false, null);
        }
        return array(true, $out);
    }

    private function _error($err, $msg=null)
    {
        if(!$msg) $msg = $err;
        $this->Session->setFlash($msg);
        $this->set(compact('err'));
    }

    private function _card_init()
    {
        $bp = $this->Session->read('backed_project');
        if(empty($bp)) $this->redirect('/');
        $this->set('backed_project', $bp);
        list($pj, $bl) = $this->_init_check($bp['pj_id'], $bp['bl_id']);
        if(!$pj || !$bl) $this->redirect('/');
        return array($pj, $bl, $bp);
    }

    private function _get_card_no()
    {
        $user_id = $this->Auth->user('id');
        list($status, $card_no, $err) = $this->Card->get_card_of_member($user_id);
        $this->set(compact('card_no'));
        return $card_no;
    }

    private function _validate_card($card)
    {
        list($status, $err) = $this->Card->validate_card_info($card, array('code'));
        if(!$status){
            $this->_error($err, 'カード情報の入力が正しくありません');
            return false;
        }
        return true;
    }

    /**
     * 会員登録されてなかったら会員登録する
     */
    private function _set_member()
    {
        $user_id = $this->Auth->user('id');
        list($status, $member, $err) = $this->Card->get_member($user_id);
        if(!$status){
            $this->_error($err);
            return false;
        }
        if(empty($member)){
            list($status, $err) = $this->Card->set_member($user_id);
            if(!$status){
                $this->_error($err);
                return false;
            }
        }
        return true;
    }

    /**
     * カードの登録
     * @param $card
     * @param $now_card (既存カードの有無)
     * @return bool
     */
    private function _set_card($card, $now_card)
    {
        $user_id = $this->Auth->user('id');
        $mode = !empty($now_card) ? 'update' : 'new';
        list($status, $err) = $this->Card->set_card_of_member($user_id, $card, $mode);
        if(!$status){
            $this->_error($err);
            return false;
        }
        return true;
    }

    /**
     * 決済情報をBackedProjectに登録
     * @param array  $bp (backed_project)
     * @param object $out (GMOの決済結果オブジェクト)
     * @param int $pay_pattern
     * @return array $backed_project (更新後backed_project)
     */
    private function _save_info_of_pay($bp, $out, $pay_pattern)
    {
        switch($pay_pattern){
            case ALL_OR_NOTHING:
            case ALL_IN:
                $data = $this->BackedProject->_set_pay_result_for_allornothing_or_allin($out, $bp, $pay_pattern);
                break;
            case MONTHLY:
                $data = $this->BackedProject->_set_pay_result_for_monthly($out, $bp);
        }
        $this->BackedProject->create();
        if($this->BackedProject->save($data)){
            $this->Session->delete('backed_project');
            return $this->BackedProject->read();
        }else{
            $this->log($status.'登録完了後のBackedProjectへのデータ登録が失敗しました。');
            return false;
        }
    }

    /**
     * プロジェクトオーナーと管理者と支援者に支援完了の連絡メールを送信する関数
     * @param array $backed_project
     * @param array $project
     *
     * @return boolean
     */
    private function _mail_back_complete($backed_project, $project)
    {
        $User = ClassRegistry::init('User');
        $owner  = $User->findById($project['Project']['user_id']);
        $backer = $User->findById($backed_project['BackedProject']['user_id']);
        $this->Mail->back_complete_owner($owner, $backer, $project, $backed_project, 'admin');
        $this->Mail->back_complete_owner($owner, $backer, $project, $backed_project, 'user');
        $this->Mail->back_complete_backer($backer, $project, $backed_project);
        return true;
    }

}
