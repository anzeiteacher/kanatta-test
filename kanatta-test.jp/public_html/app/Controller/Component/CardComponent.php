<?php
App::uses('Component', 'Controller');
$vendor = App::path('Vendor');
$path   = $vendor[0].'gpay_client'.DS;
set_include_path(get_include_path().PATH_SEPARATOR.$path);
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/SearchMemberInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/SearchMember');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/SaveMemberInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/SaveMember');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/SearchCardInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/SearchCard');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/SaveCardInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/SaveCard');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/DeleteCardInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/DeleteCard');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/EntryExecTranInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/EntryExecTran');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/AlterTranInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/AlterTran');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/RegisterRecurringCreditInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/RegisterRecurringCredit');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/UnregisterRecurringInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/UnregisterRecurring');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/input/SearchRecurringResultInput');
App::import('Vendor', 'gpay_client/com/gmo_pg/client/tran/SearchRecurringResult');

/**
 * クレジットカード関連
 */
class CardComponent extends Component
{
    public $setting = null;
    public function __construct($collection, $settings = array())
    {
        parent::__construct($collection, $settings);
        if(!empty($settings)){
            $this->setting = $settings;
        }
    }

    public function startup(Controller $controller)
    {
        $this->controller = $controller;
        if(!empty($this->controller->setting)){
            $this->setting = $this->controller->setting;
        }
    }

    /**
     * 実行後のエラーチェック
     * @param obj $exe(GMOの各種実行オブジェクト)
     * @param obj $out（GMOの各種出力オブジェクト）
     * @param array $obj_of_out($outに入っているオブジェクト名の配列)
     * @return array(status, err_msg)
     *         statusは、(1 => ok, 2 => 通信エラー, 3 => 処理エラー)
     */
    private function _err_chk($exe, $out, $obj_of_out=null)
    {
        if($exe->isExceptionOccured()){
            return array(2, KESSAI_NETWORK_ERROR);
        }else{
            if(empty($obj_of_out)){
                if(!empty($out->errList)){
                    return array(3, '決済エラーが発生しました。'.OSORE);
                }
            }else{
                foreach($obj_of_out as $obj_name){
                    if(!empty($out->{$obj_name}->errList)){
                        return array(3, '決済エラーが発生しました。'.OSORE);
                    }
                }
            }
        }
        return array(1, null);
    }

    private function _set_site_id_pass($in)
    {
        $in->setSiteId($this->setting['gmo_site_id']);
        $in->setSitePass($this->setting['gmo_site_pass']);
        return $in;
    }

    private function _set_shop_id_pass($in)
    {
        $in->setShopId($this->setting['gmo_id']);
        $in->setShopPass($this->setting['gmo_password']);
        return $in;
    }

    /**
     * GMOの会員情報を取得
     *  - GMOのMemberIDは、サイトのuser_idと同じ
     * @param int $user_id
     * @return array ($status, $out, $err_msg)
     */
    public function get_member($user_id)
    {
        $in = new SearchMemberInput();
        $in = $this->_set_site_id_pass($in);
        $in->setMemberId($user_id);
        $exe = new SearchMember();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1){
            return array(true, $out, null);
        }elseif($status == 3){
            return array(true, null, null);
        }else{
            return array(false, null, $err_msg);
        }
    }

    /**
     * 会員のカード情報を取得
     * @param $user_id
     * @return array (status, $card_no, $err_msg)
     */
    public function get_card_of_member($user_id)
    {
        $in = new SearchCardInput();
        $in = $this->_set_site_id_pass($in);
        $in->setMemberId($user_id);
        $in->setSeqMode(0); //論理モード
        $exe = new SearchCard();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1){
            return array(true, $out->getCardList()[0]['CardNo'], null);
        }elseif($status == 3){
            return array(true, null, null);
        }else{
            return array(false, null, $err_msg);
        }
    }

    /**
     * GMOに会員情報を登録
     *  - GMOのMemberIDは、サイトのuser_idと同じ
     * @param int $user_id
     * @return array ($status, $err_msg)
     */
    public function set_member($user_id)
    {
        $in = new SaveCardInput();
        $in = $this->_set_site_id_pass($in);
        $in->setMemberId($user_id);
        $exe = new SaveMember();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * 会員のカード情報を登録
     * @param $user_id
     * @param $card
     * @return array ($status, $err_msg)
     */
    public function set_card_of_member($user_id, $card, $mode = 'update')
    {
        $in = new SaveCardInput();
        $in = $this->_set_site_id_pass($in);
        $in->setMemberId($user_id);
        $in->setCardNo($card['card_no']);
        $in->setExpire($card['year'].$card['month']);
        $in->setDefaultFlag(1);
        if($mode == 'update') $in->setCardSeq(0); //常に1番目のカードを更新する
        $exe = new SaveCard();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * 会員のカード情報を削除
     * @param $user_id
     * @return array ($status, $err_msg)
     */
    public function delete_card_of_member($user_id)
    {
        $in = new DeleteCardInput();
        $in = $this->_set_site_id_pass($in);
        $in->setMemberId($user_id);
        $in->setCardSeq(0);
        $exe = new DeleteCard();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * 入力されたカード情報のチェック
     * @param array $card
     * @param array $option_target（カード番号、有効期限以外のチェック対象）
     * @return array (status, err_msg)
     */
    public function validate_card_info($card, $option_target=array())
    {
        $error = array();
        if(empty($card['card_no'])){
            $error['card_no'] = 'カード番号を入力してください';
        }elseif(!is_numeric($card['card_no'])){
            $error['card_no'] = 'カード番号は数値を入力してください';
        }
        if(empty($card['month']) || empty($card['year'])){
            $error['expire'] = '有効期限を入力してください';
        }
        if(in_array('code', $option_target)){
            if(empty($card['code'])){
                $error['code'] = 'セキュリティーコードを入力してください';
            }elseif(!is_numeric($card['code'])){
                $error['code'] = 'セキュリティーコードは数値を入力してください';
            }
        }
        if(!empty($error)) return array(false, $error);
        return array(true, null);
    }

    /**
     * All or Nothing時の仮売上登録
     * @param $data (order_id, amount, user_id)
     * @return array
     */
    public function pay_for_all_or_nothing($data)
    {
       return $this->_pay_for_allornothing_or_allin($data, 'AUTH');
    }

    /**
     * All or Nothing時の売上確定
     * @param array $data
     * @return array
     */
    public function sales_for_all_or_nothing($data)
    {
        $in = new AlterTranInput();
        $in = $this->_set_shop_id_pass($in);
        $in->setAccessId($data['accessId']);
        $in->setAccessPass($data['accessPass']);
        $in->setJobCd('SALES');
        $in->setAmount($data['invest_amount']);
        $exe = new AlterTran();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * All or Nothing時の決済キャンセル
     * @param array $data
     * @return array
     */
    public function cancel_for_all_or_nothing($data)
    {
        $in = new AlterTranInput();
        $in = $this->_set_shop_id_pass($in);
        $in->setAccessId($data['accessId']);
        $in->setAccessPass($data['accessPass']);
        $in->setJobCd('VOID');
        $in->setAmount($data['invest_amount']);
        $exe = new AlterTran();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * All In時の売上確定
     * @param $data (order_id, amount, user_id)
     * @return array
     */
    public function pay_for_all_in($data)
    {
        return $this->_pay_for_allornothing_or_allin($data, 'CAPTURE');
    }

    /**
     * 月額課金時の自動売上登録
     * @param $data
     * @return array
     */
    public function pay_for_monthly($data)
    {
        $tomorrow = date("d", strtotime("+1 day"));
        $in = new RegisterRecurringCreditInput();
        $in = $this->_set_shop_id_pass($in);
        $in = $this->_set_site_id_pass($in);
        $in->setRecurringID($data['order_id']);
        $in->setAmount($data['amount']);
        $in->setChargeDay($tomorrow);
        $in->setRegistType(1); //会員ID指定
        $in->setMemberID($data['user_id']);
        $exe = new RegisterRecurringCredit();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, $out, null);
        return array(false, null, $err_msg);
    }

    /**
     * 月額課金時の課金キャンセル
     * @param $recurring_id
     * @return array
     */
    public function stop_for_monthly($recurring_id)
    {
        $in = new UnregisterRecurringInput();
        $in = $this->_set_shop_id_pass($in);
        $in->setRecurringID($recurring_id);
        $exe = new UnregisterRecurring();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, null);
        return array(false, $err_msg);
    }

    /**
     * 月額課金の成否チェック
     */
    public function check_monthly_charge($recurring_id)
    {
        $in = new SearchRecurringResultInput();
        $in = $this->_set_shop_id_pass($in);
        $in->setRecurringID($recurring_id);
        $exe = new SearchRecurringResult();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk($exe, $out);
        if($status == 1) return array(true, $out, null);
        return array(false, null, $err_msg);
    }

    /**
     * 月額課金失敗時の都度課金
     */
    public function charge_capture_for_monthly_fail($data)
    {
        return $this->_pay_for_allornothing_or_allin($data, 'CAPTURE');
    }

    private function _pay_for_allornothing_or_allin($data, $job_cd)
    {
        $in = $this->_set_entry_exec_tran_input($data, $job_cd);
        $exe = new EntryExecTran();
        $out = $exe->exec($in);
        list($status, $err_msg) = $this->_err_chk(
            $exe, $out, array('entryTranOutput', 'execTranOutput')
        );
        if($status == 1) return array(true, $out, null);
        return array(false, null, $err_msg);
    }

    private function _set_entry_exec_tran_input($data, $job_cd)
    {
        $order_id   = $data['order_id'];
        $entry_in = new  EntryTranInput();
        $entry_in = $this->_set_shop_id_pass($entry_in);
        $entry_in->setAmount($data['amount']);
        $entry_in->setOrderId($order_id);
        $entry_in->setJobCd($job_cd);

        $exec_in = new ExecTranInput();
        $exec_in = $this->_set_site_id_pass($exec_in);
        $exec_in->setOrderId($order_id);
        $exec_in->setMethod('1');
        $exec_in->setMemberID($data['user_id']);
        $exec_in->setCardSeq(0);

        $in = new EntryExecTranInput();
        $in->setEntryTranInput($entry_in);
        $in->setExecTranInput($exec_in);
        return $in;
    }

    /**
     * テスト用 - メンバー登録＆カード登録
     */
    public function _test_save_member_and_card($user_id)
    {
        $card = array(
            'card_no' => '4111111111111111',
            'year' => '22',
            'month' => '12'
        );
        $result = $this->get_member($user_id);
        if(!$result[1]){
            $result = $this->set_member($user_id);
            if(!$result[0]) return false;
            $result = $this->set_card_of_member($user_id, $card, 'new');
            if(!$result[0]) return false;
        }else{
            $result = $this->get_card_of_member($user_id);
            $mode = 'update';
            if(!$result[1]) $mode = 'new';
            $result = $this->set_card_of_member($user_id, $card, $mode);
            if(!$result[0]) return false;
        }
        return true;
    }

}