<?php
App::uses('AppModel', 'Model');

class BackedProject extends AppModel
{

    /**
     * Validation rules
     * @var array
     */
    public $validate = array(
        'invest_amount' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '支援金額を入力してください',
                'allowEmpty' => false,
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => '支援金額は数値を入力してください'
            )
        ),
        'comment' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '支援コメントを入力してください',
                'allowEmpty' => true,
            ),
        ),
    );

    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Project' => array(
            'className' => 'Project', 'foreignKey' => 'project_id', 'conditions' => '', 'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User', 'foreignKey' => 'user_id', 'conditions' => '', 'fields' => '', 'order' => ''
        ),
        'BackingLevel' => array(
            'className' => 'BackingLevel', 'foreignKey' => 'backing_level_id', 'conditions' => '',
            'fields' => '', 'order' => ''
        )
    );

    /**
     * 該当プロジェクトの有効なbacked_projectを取得する関数
     *  - BPのstatusがSTATUS_CANCELの場合は有効でない
     */
    public function get_by_pj_id($project_id, $option = true)
    {
        $options = array(
            'conditions' => array(
                'BackedProject.project_id' => $project_id,
                'BackedProject.status not' => STATUS_CANCEL
            )
        );
        if($option) return $options;
        return $this->find('all', $options);
    }

    /**
     * 既に該当の月額課金PJに支援しているかチェック
     *  - キャンセル後に再度支援はできる
     * @param int $user_id
     * @param int $pj_id
     * @return bool (支援済みならtrue)
     */
    public function chk_payed_to_monthly_pj($user_id, $pj_id)
    {
        $options = array(
            'conditions' => array(
                'BackedProject.user_id' => $user_id,
                'BackedProject.project_id' => $pj_id,
                'BackedProject.pay_pattern' => MONTHLY,
                'BackedProject.status NOT' => STATUS_CANCEL
            )
        );
        if($this->find('first', $options)) return true;
        return false;
    }

    /**
     * オーダーID作成関数
     * （GMOペイメントのOrderIdは、半角英数字と-のみ使用可）
     */
    public function get_order_id($pj_id, $user_id)
    {
        $str = substr(base_convert(md5(uniqid()), 16, 36), 0, 8);
        return $pj_id.'-'.$user_id.'-'.$str;
    }

    /**
     * All or NothingかAll inの支援完了時の決済結果をモデル配列にセットする
     * @param $out
     * @param $bp
     * @param $pay_pattern
     * @return array
     */
    public function _set_pay_result_for_allornothing_or_allin($out, $bp, $pay_pattern)
    {
        $status = ($pay_pattern == ALL_OR_NOTHING) ? STATUS_KARIURIAGE : STATUS_KAKUTEI;
        return array(
            'BackedProject' => array(
                'pay_pattern' => $pay_pattern,
                'user_id' => $bp['user_id'],
                'project_id' => $bp['pj_id'],
                'backing_level_id' => $bp['bl_id'],
                'invest_amount' => $bp['amount'],
                'comment' => $bp['comment'],
                'status' => $status,
                'accessId' => $out->getAccessId(),
                'accessPass' => $out->getAccessPass(),
                'orderId' => $out->getOrderId()
            )
        );
    }

    /**
     * Monthlyの支援完了時の決済結果をモデル配列にセットする
     * @param $out
     * @param $bp
     * @return array
     */
    public function _set_pay_result_for_monthly($out, $bp)
    {
        return array(
            'BackedProject' => array(
                'pay_pattern' => MONTHLY,
                'user_id' => $bp['user_id'],
                'project_id' => $bp['pj_id'],
                'backing_level_id' => $bp['bl_id'],
                'invest_amount' => $bp['amount'],
                'comment' => $bp['comment'],
                'status' => STATUS_MONTHLY,
                'recurring_id' => $out->getRecurringID(),
                'charge_day' => $out->getChargeDay(),
                'charge_start_date' => $out->getChargeStartDate(),
                'next_charge_date' => $out->getNextChargeDate()
            )
        );
    }

    /**
     * プロジェクトの支援者一覧を取得するオプションを返す関数
     * user画像を表示するため、Userをfindする
     * @param int    $project_id
     * @param string $mode ('options' or 'all')
     * @param int    $limit
     * @return array
     */
    public function get_backers_of_project($project_id, $mode = 'options', $limit = 30)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'backed_projects',
                    'alias' => 'BackedProject',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.user_id = User.id'),
                ),
                array(
                    'table' => 'backing_levels',
                    'alias' => 'BackingLevel',
                    'type' => 'left',
                    'conditions' => array('BackedProject.backing_level_id = BackingLevel.id'),
                ),
            ),
            'conditions' => array(
                'BackedProject.project_id' => $project_id,
            ),
            'order' => array('BackedProject.created' => 'ASC'),
            'limit' => $limit,
            'fields' => array(
                'User.id', 'User.nick_name', 'User.name', 'User.email', 'User.receive_address',
                'BackedProject.id', 'BackedProject.created', 'BackedProject.invest_amount',
                'BackedProject.comment', 'BackedProject.manual_flag',
                'BackedProject.status', 'BackedProject.orderId', 'BackedProject.recurring_id',
                'BackedProject.charge_start_date', 'BackedProject.old_charge_date',
                'BackedProject.next_charge_date', 'BackedProject.charge_result',
                'BackedProject.old_charge_date_for_fail', 'BackedProject.gmo_cancelled_flag',
                'BackingLevel.id', 'BackingLevel.name', 'BackingLevel.invest_amount',
                'BackingLevel.return_amount', 'BackingLevel.now_count'
            )
        );
        if($mode == 'options') return $options;
        $User = ClassRegistry::init('User');
        return $User->find('all', $options);
    }

    /**
     * あるプロジェクトの支援者を全て取得する（取得するユーザは重複しない）
     * （get_backers_of_project()は重複する）
     * @param $pj_id
     */
    public function get_backers_of_project_distinct($pj_id)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'backed_projects',
                    'alias' => 'BackedProject',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.user_id = User.id'),
                )
            ),
            'conditions' => array(
                'BackedProject.project_id' => $pj_id,
            ),
            'fields' => array(
                'DISTINCT User.id', 'User.nick_name', 'User.name', 'User.email'
            )
        );
        $User = ClassRegistry::init('User');
        return $User->find('all', $options);
    }

    /**
     * プロジェクトの支援者一覧のリターン内容を整形する関数
     * 支援者一覧の配列を、
     * ユーザの重複表示をしないようにしつつ、
     * リターン内容のサマリーを作成する関数
     */
    public function make_return_summary($users)
    {
        $new_users = array();
        foreach($users as $u){
            if(!array_key_exists($u['User']['id'], $new_users)){
                $new_users[$u['User']['id']] = $u;
            }
            if(!empty($new_users[$u['User']['id']]['return_summary'][$u['BackingLevel']['id']])){
                $new_users[$u['User']['id']]['return_summary'][$u['BackingLevel']['id']]['count'] += 1;
            }else{
                $new_users[$u['User']['id']]['return_summary'][$u['BackingLevel']['id']]['count']         = 1;
                $new_users[$u['User']['id']]['return_summary'][$u['BackingLevel']['id']]['return_amount'] = $u['BackingLevel']['return_amount'];
            }
        }
        return $new_users;
    }

    /**
     * 仮売上ステータスのbacked_projectを取得
     * @param int $pj_id
     * @return array
     */
    public function get_kariuriage_bps($pj_id)
    {
        $options = array(
            'conditions' => array(
                'BackedProject.project_id' => $pj_id,
                'BackedProject.status' => STATUS_KARIURIAGE,
            )
        );
        return $this->find('all', $options);
    }

    /**
     * ユーザが課金中の月額課金プロジェクトを取得
     * @param int $user_id
     * @param int $limit
     * @param string $mode
     * @return array $backed_project
     */
    public function get_monthly_pay($user_id, $limit = 30, $mode = 'options')
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'projects',
                    'alias' => 'Project',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.project_id = Project.id'),
                ),
            ),
            'conditions' => array(
                'BackedProject.user_id' => $user_id,
                'BackedProject.status' => STATUS_MONTHLY
            ),
            'order' => array('BackedProject.id' => 'DESC'),
            'limit' => $limit,
            'fields' => array(
                'BackedProject.id', 'BackedProject.invest_amount', 'BackedProject.recurring_id',
                'BackedProject.old_charge_date', 'BackedProject.charge_result',
                'BackedProject.next_charge_date',
                'Project.id', 'Project.project_name',
            )
        );
        if($mode == 'options') return $options;
        return $this->find('all', $options);
    }

    /**
     * 月額課金のキャンセル
     */
    public function stop_for_monthly($bp_id)
    {
        $this->id = $bp_id;
        if($this->saveField('status', STATUS_CANCEL)) return true;
        return false;
    }

    /**
     * 月課金のキャンセル（PJの全ての月額課金決済）
     */
    public function stop_all_for_monthly($pj_id)
    {
        $data = array(
            'BackedProject.status' => STATUS_CANCEL
        );
        $conditions = array(
            'BackedProject.project_id' => $pj_id,
            'BackedProject.status NOT' => STATUS_CANCEL,
            'BackedProject.gmo_cancelled_flag' => 0
        );
        if($this->updateAll($data, $conditions)) return true;
        return false;
    }

    /**
     * 月額課金で次回決済日が今日より前のBPを取得
     *  - 支援者、プロジェクト、プロジェクトオーナー情報も取得
     */
    public function get_monthly_of_charge_date_in_past($limit = 10)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'projects',
                    'alias' => 'Project',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.project_id = Project.id'),
                ),
                array(
                    'table' => 'users',
                    'alias' => 'Backer',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.user_id = Backer.id'),
                ),
                array(
                    'table' => 'users',
                    'alias' => 'Owner',
                    'type' => 'inner',
                    'conditions' => array('Project.user_id = Owner.id'),
                ),
            ),
            'conditions' => array(
                'BackedProject.pay_pattern' => MONTHLY,
                'BackedProject.status' => array(STATUS_MONTHLY, STATUS_STOP),
                'BackedProject.recurring_id !=' => null,
                'BackedProject.manual_flag' => 0,
                'BackedProject.next_charge_date <' => date('Y-m-d')
            ),
            'limit' => $limit,
            'order' => array(
                'BackedProject.next_charge_date' => 'ASC',
                'BackedProject.id' => 'ASC'
            ),
            'fields' => array(
                'BackedProject.id', 'BackedProject.recurring_id', 'BackedProject.next_charge_date',
                'Project.id', 'Project.project_name',
                'Backer.id', 'Backer.nick_name', 'Backer.name', 'Backer.email',
                'Owner.id', 'Owner.nick_name', 'Owner.name', 'Owner.email',
            )
        );
        return $this->find('all', $options);
    }

    /**
     * 月額課金結果を保存
     */
    public function save_monthly_charge_result($id, $result)
    {
        $result['old_charge_date_for_fail'] = null;
        $result['card_changed'] = false;
        if($result['charge_result'] == CHARGE_OK){
            $result['status'] = STATUS_MONTHLY;
        }
        $data = array('BackedProject' => $result);
        $this->id = $id;
        if($this->save($data, true, array(
            'old_charge_date', 'next_charge_date', 'charge_result',
            'old_charge_date_for_fail', 'chard_changed', 'status')))
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 課金失敗中のBPを取得
     *  - charge_resultがCHARGE_NG
     *  - old_charge_dateから3日以上経過している
     *  - old_charge_date_for_failが空か、ある場合それから3日以上経過している
     *  - 上記条件に合致しなくても、card_changedがTrueのものは取得する
     */
    public function get_monthly_of_failing($limit = 10)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'projects',
                    'alias' => 'Project',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.project_id = Project.id'),
                ),
                array(
                    'table' => 'users',
                    'alias' => 'Backer',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.user_id = Backer.id'),
                )
            ),
            'conditions' => array(
                'BackedProject.pay_pattern' => MONTHLY,
                'BackedProject.recurring_id !=' => null,
                'BackedProject.manual_flag' => 0,
                'BackedProject.charge_result' => CHARGE_NG,
                'OR' => array(
                    array(
                        'BackedProject.old_charge_date <' => date('Y-m-d', strtotime('-3days')),
                        'BackedProject.status' => STATUS_MONTHLY,
                        'OR' => array(
                            'BackedProject.old_charge_date_for_fail' => null,
                            'AND' => array(
                                'BackedProject.old_charge_date_for_fail not' => null,
                                'BackedProject.old_charge_date_for_fail <' => date('Y-m-d', strtotime('-3days'))
                            )
                        )
                    ),
                    array(
                        'BackedProject.card_changed' => True,
                        'BackedProject.status' => array(STATUS_MONTHLY, STATUS_STOP)
                    )
                )
            ),
            'limit' => $limit,
            'order' => array(
                'BackedProject.card_changed' => 'DESC',
                'BackedProject.old_charge_date' => 'ASC',
                'BackedProject.id' => 'ASC'
            ),
            'fields' => array(
                'BackedProject.id', 'BackedProject.recurring_id', 'BackedProject.next_charge_date',
                'BackedProject.invest_amount', 'BackedProject.old_charge_date', 'BackedProject.card_changed',
                'Project.id', 'Project.project_name',
                'Backer.id', 'Backer.nick_name', 'Backer.name', 'Backer.email',
            )
        );
        return $this->find('all', $options);
    }

    /**
     * 月額課金のサービスを停止する($idの有効性チェックはしない)
     * - statusをSTATUS_STOPにする
     * - card_changedをfalseにする
     */
    public function stop_monthly_service($id)
    {
        $this->id = $id;
        $data = array(
            'BackedProject' => array(
                'status' => STATUS_STOP,
                'card_changed' => false,
                'old_charge_date_for_fail' => null
            )
        );
        if($this->save($data, true, array('status', 'card_changed'))){
            return true;
        }
        return false;
    }

    /**
     * 月額課金の課金失敗中に、都度課金が成功した場合のBP更新処理
     * @param $bp
     * @return bool
     */
    public function save_monthly_success_while_failing($bp)
    {
        $data = array(
            'BackedProject' => array(
                'charge_result' => CHARGE_OK,
                'old_charge_date_for_fail' => null,
                'old_charge_date' => date('Y-m-d'),
                'card_changed' => false,
                'status' => STATUS_MONTHLY
            )
        );
        $this->id = $bp['BackedProject']['id'];
        if($this->save($data, true, array(
            'charge_result', 'old_charge_date_for_fail',
            'old_charge_date', 'card_changed', 'status'
        ))){
            return true;
        }
        return false;
    }

    /**
     * 月額課金の課金失敗中に、都度課金が失敗した場合のBP更新処理
     *  - charge_resultをCHARGE_NGにする
     *  - old_charge_date_for_failを更新にする
     *  - card_changedをfalseにする
     * @param $bp
     * @return bool
     */
    public function save_monthly_fail_while_failing($bp)
    {
        $data = array(
            'BackedProject' => array(
                'charge_result' => CHARGE_NG,
                'old_charge_date_for_fail' => date('Y-m-d'),
                'card_changed' => false
            )
        );
        $this->id = $bp['BackedProject']['id'];
        if($this->save($data, true, array(
            'charge_result', 'old_charge_date_for_fail', 'card_changed'
        ))){
            return true;
        }
        return false;
    }

    /**
     * gmo_cancelled_flagをtrueにする
     */
    public function gmo_cancelled_flag_true($id)
    {
        $this->id = $id;
        if($this->saveField('gmo_cancelled_flag', true)){
            return true;
        }
        return false;
    }

    /**
     * サービス提供終了となりGMOキャンセルすべき月額BPを取得する
     */
    public function get_target_of_gmo_cancel($limit = 30)
    {
        $options = array(
            'conditions' => array(
                'BackedProject.status' => STATUS_CANCEL,
                'BackedProject.gmo_cancelled_flag' => false,
                'BackedProject.pay_pattern' => MONTHLY,
                'BackedProject.manual_flag' => 0,
                'BackedProject.recurring_id !=' => null,
            ),
            'order' => array('BackedProject.id' => 'ASC'),
            'limit' => $limit
        );
        return $this->find('all', $options);
    }

    /**
     * ユーザの失敗中の月額BPのcard_changedをTrueにする取得する(カード変更時に利用)
     */
    public function set_card_changed_to_failing($user_id)
    {
        $conditions = array(
            'BackedProject.user_id' => $user_id,
            'BackedProject.status' => array(STATUS_MONTHLY, STATUS_STOP),
            'BackedProject.pay_pattern' => MONTHLY,
            'BackedProject.manual_flag' => 0,
            'BackedProject.old_charge_date not' => null,
            'BackedProject.charge_result' => CHARGE_NG
        );
        $data = array('BackedProject.card_changed' => true);
        if($this->updateAll($data, $conditions)) return true;
        return false;
    }

}
