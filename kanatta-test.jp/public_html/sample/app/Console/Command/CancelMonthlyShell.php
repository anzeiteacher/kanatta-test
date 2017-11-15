<?php
App::uses('ComponentCollection', 'Controller');
App::uses('CardComponent', 'Controller/Component');

/**
 * 月額課金のキャンセル処理
 * - StatusがSTATUS_CANCELで、gmo_cancelled_flagがfalseのBPを取得
 * - GMOにアクセスし、BPの自動売上をキャンセルする
 * - キャンセル成功なら、gmo_cancelled_flagをtrueにする
 */
class CancelMonthlyShell extends AppShell
{
    public $uses = array('BackedProject', 'Setting');

    public function startup()
    {
        $this->setting = $this->Setting->findById(1);
        $this->setting = $this->setting['Setting'];
        $collection = new ComponentCollection();
        $this->Card = new CardComponent($collection, $this->setting);
        parent::startup();
    }

    public function main()
    {
        $bps = $this->BackedProject->get_target_of_gmo_cancel(30);
        $flag = true;
        foreach($bps as $bp){
            if($this->_gmo_cancel($bp)){
                if($this->_success($bp)){
                    continue;
                }
            }
            $flag = false;
        }
        return $flag;
    }

    private function _gmo_cancel($bp)
    {
        $result = $this->Card->stop_for_monthly($bp['BackedProject']['recurring_id']);
        if($result[0]) return true;
        return false;
    }

    private function _success($bp)
    {
        if($this->BackedProject->gmo_cancelled_flag_true($bp['BackedProject']['id'])){
            return true;
        }
        return false;
    }


}