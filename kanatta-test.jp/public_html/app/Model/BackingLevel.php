<?php
App::uses('AppModel', 'Model');

/**
 * BackingLevel Model
 */
class BackingLevel extends AppModel
{

    /**
     * Validation rules
     */
    public $validate = array(
       'name' => array(
            'notblank' => array(
                'rule'    => array('notblank'),
                'message' => array('支援パターン名を入力してください。'),
             )
        ),
        'invest_amount' => array(
            'notblank' => array(
                'rule'    => array('notblank'),
                'message' => array('最低支援額を入力してください。'),
            ),
            'numeric' => array(
                'rule' => array('numeric'),
                'message' => array('最低支援額は数値を入力してください。'),
            ),
            'range' => array(
                'rule'       => array('range', 199, 2900001),
                'message'    => '最低支援額は200〜2900000円の間で入力してください。',
                'allowEmpty' => true,
            ),
        ),
        'return_amount' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => array('リターン内容を入力してください。'),
            ),
        ),
    );

    /**
     * belongsTo associations
     */
    public $belongsTo = array(
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
            'conditions' => '', 'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     */
    public $hasMany = array(
        'BackedProject' => array(
            'className' => 'BackedProject',
            'foreignKey' => 'backing_level_id',
            'dependent' => false
        )
    );

    /**
     * 支援パターンがプロジェクトに所属するかチェックする関数
     * @param int $bl_id
     * @param int $project_id
     * @return array $backing_level or null
     */
    public function check_backing_level($bl_id, $project_id)
    {
        $this->id = $bl_id;
        $bl = $this->read();
        if($bl['BackingLevel']['project_id'] != $project_id) return null;
        return $bl;
    }

    /**
     * 支援金額のチェック関数
     * 選択している支援パターンの設定金額以上が入力されているか？
     * @param array $bl
     * @param int   $invest_amount
     * @return boolean
     */
    public function check_invest_amount($bl, $invest_amount)
    {
        if($bl['BackingLevel']['invest_amount'] <= $invest_amount) return true;
        return false;
    }

    /**
     * 支援パターンが最大支援回数を超過していないかのチェック関数
     */
    public function check_max_count($bl)
    {
        $bl = $bl['BackingLevel'];
        if(isset($bl['max_count']) && $bl['max_count']){
            if($bl['max_count'] <= $bl['now_count']) return false;
        }
        return true;
    }

    /**
     * プロジェクトの支援パターンを更新する関数
     * 支援パターンデータが$dataに入っているので$project_idを適用して、全部保存する
     * その後、$dataにない支援パターンを削除する
     * controller側でtransctionしているのでここでは考慮しない
     */
    public function edit_backing_level($data, $pj_id)
    {
        $backing_level_ids = array();
        foreach($data as $d){
            $d['project_id'] = $pj_id;
            if(!empty($d['id'])){
                $this->id = $d['id'];
            }else{
                $this->create();
            }
            if(!$this->save(array(
                'BackingLevel' => $d, true, array(
                    'project_id', 'invest_amount', 'return_amount', 'max_count', 'delivery'
                )
            )))
            {
                return false;
            }
            $backing_level_ids[] = $this->id;
        }
        $conditions = array(
            'BackingLevel.project_id' => $pj_id,
            'NOT' => array('BackingLevel.id' => $backing_level_ids)
        );
        if(!$this->deleteAll($conditions, false)) return false;
        return true;
    }

    /**
     * 支援パターンの現在購入回数を登録する関数
     * @param array $bl
     * @param string  $mode add or del
     * @return bool
     */
    public function put_backing_level_now_count($bl, $mode = 'add')
    {
        $bl = $bl['BackingLevel'];
        $conditions = array(
            'BackedProject.backing_level_id' => $bl['id'],
            'BackedProject.status not' => STATUS_CANCEL
        );
        $now_count = $this->BackedProject->find('count', array('conditions' => $conditions));
        $this->id = $bl['id'];
        if($mode == 'add') $now_count += 1;
        if($this->saveField('now_count', $now_count)) return true;
        return false;
    }

}
