<?php
App::uses('AppModel', 'Model');

/**
 * Class Project
 * opened -> 1 (公開中）
 * active -> 1 (募集中・募集前）
 * stop -> 1 （募集停止中）※合わせてopenendもnoにする前提
 */
class Project extends AppModel
{
    public $displayField = 'project_name';
    public $actsAs = array(
        'Filebinder.Bindable' => array(
            'dbStorage' => false, 'beforeAttach' => 'resize', 'afterAttach' => 'thumbnail'
        )
    );
    public $bindFields = array();
    public $validate = array(
        'pic' => array(
            'checkExtension' => array(
                'rule' => array('checkExtension', array(
                    'jpg', 'jpeg', 'png', 'gif')
                ),
                'message' => array('jpg・jpeg・png・gif画像をアップロードしてください。')
            ),
            'size' => array(
                'maxFileSize' => array(
                    'rule'    => array('fileSize', '<=', '1MB'),
                    'message' => array('画像サイズの上限は1MBです。')
                ),
                'minFileSize' => array(
                	'rule'     => array('fileSize', '>', 0),
                     'message' => array('画像サイズは0B以上必要です。')
                ),
        	),
            'illegalCode' => array(
                'rule' => array('checkIllegalCode'),
            ),
        ), 'project_name' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => 'プロジェクト名を入力してください',
                'allowEmpty' => false,
            ),
        ),
        'goal_amount' => array(
           'notblank' => array(
                'rule'    => 'validate_goal_amount',
                'message' => '目標金額を入力してください。',
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber'),
                'message' => '目標金額は数値を入力してください。',
                'allowEmpty' => true,
            ),
            'range' => array(
                'rule'       => array('range', 9999, 10000001),
                'message'    => '目標金額は10000〜10000000円の間で入力してください。',
                'allowEmpty' => true,
            ),
        ),
        'goal_backers' => array(
            'notblank' => array(
                'rule'    => 'validate_goal_backers',
            	'message' => '目標人数を入力してください。',
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber'),
                'message' => '目標人数は数値を入力してください。',
                'allowEmpty' => true,
            ),
        ),
        'collection_term' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '募集期間を入力してください。',
                'allowEmpty' => false,
            ),
            'naturalNumber' => array(
                'rule' => array('naturalNumber'),
                'message' => '募集期間は数値を入力してください。',
            ),
            'range' => array(
                'rule' => array('range', 14, 81),
                'message' => '15から80までの数字を入力してください。',
            ),
        ), 'rule' => array(
            'equalTo' => array(
                'rule' => array(
                    'equalTo', '1'
                ), 'message' => '規約に同意してください。', 'allowEmpty' => true, 'on' => 'create'
            )
        ), 'contact' => array(
            'notblank' => array(
                'rule' => array('notblank'), 'message' => '連絡先を入力してください。', 'on' => 'create'
            )
        ),
    );
    /**
     * belongsTo associations
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category', 'foreignKey' => 'category_id', 'conditions' => '', 'fields' => '',
            'order' => ''
        ), 'User' => array(
            'className' => 'User', 'foreignKey' => 'user_id', 'conditions' => '', 'fields' => '', 'order' => ''
        )
    );
    /**
     * hasMany associations
     * @var array
     */
    public $hasMany = array(
        'BackingLevel' => array(
            'className' => 'BackingLevel', 'foreignKey' => 'project_id', 'dependent' => false,
            'conditions' => '', 'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        ), 'Comment' => array(
            'className' => 'Comment', 'foreignKey' => 'project_id', 'dependent' => false, 'conditions' => '',
            'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        ), 'Report' => array(
            'className' => 'Report', 'foreignKey' => 'project_id', 'dependent' => false, 'conditions' => '',
            'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        ), 'ProjectContent' => array(
            'className' => 'ProjectContent', 'foreignKey' => 'project_id', 'dependent' => false,
            'conditions' => '', 'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        ), 'BackedProject' => array(
            'className' => 'BackedProject', 'foreignKey' => 'project_id', 'dependent' => true,
            'conditions' => '', 'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        )
    );

    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->bindFields[] = array(
            'field' => 'pic',
            'tmpPath' => Configure::read('file_path').'tmp'.DS,
            'filePath' => Configure::read('file_path').'upload'.DS,
        );
    }

    /**
     * 画像リサイズ
     * @param array $tmp_file_path
     * @return bool
     */
    public function resize($tmp_file_path)
    {
        return $this->resize_image($tmp_file_path, 750, 500);
    }

    /**
     * サムネイル作成
     * @param array $file_path
     * @return bool
     */
    public function thumbnail($file_path)
    {
        return $this->create_thumbnail($file_path, array(array(400, 267),));
    }

    /**
     * IDからプロジェクト取得
     * @param int   $id
     * @param array $joins (backing_levels)
     * @return array
     */
    public function get_pj_by_id($id, $joins = array())
    {
        $options = array(
            'conditions' => array('Project.id' => $id),
            'recursive' => 1,
        );
        $hasmany = array_keys($this->hasMany);
        $unbind_list = array_diff($hasmany, $joins);
        $this->unbindModel(array('hasMany' => $unbind_list));
        return $this->find('first', $options);
    }

    /**
     * プロジェクト取得
     * @param string $mode   (options, all, list, first)
     * @param string $opened (all, open, close)
     * @param int    $limit
     * @param int    $recursive
     * @return array
     */
    public function get_pj($mode = 'all', $opened = 'all', $limit = 10, $recursive = -1)
    {
        $options = array(
            'limit' => $limit,
            'recursive' => $recursive,
            'order' => array('Project.created' => 'DESC')
        );
        switch($opened){
            case 'open':
                $options['conditions']['Project.opened'] = 1;
                $options['conditions']['Project.stop']   = 0;
                break;
            case 'close':
                $options['conditions']['Project.opened'] = 0;
        }
        return $this->_switch_return_mode($mode, $options);
    }

    /**
     * モデルのreturn形式をmodeによって切り替える
     */
    private function _switch_return_mode($mode, $options)
    {
        switch($mode){
            case 'options':
                return $options;
            case 'all':
                return $this->find('all', $options);
            case 'first':
                return $this->find('first', $options);
            case 'list':
                return $this->find('list', $options);
        }
    }

    /**
     * 公開中のプロジェクト一覧を取得（id, patterの検索機能つき）
     * @param int $id project_id
     * @param int $pattern pay_pattern
     * @param string $mode
     * @param int $limit
     * @return array
     */
    public function get_open_projects($id = null, $pattern = null, $mode = 'options', $limit = 30)
    {
        $options = array(
            'conditions' => array(
                'Project.opened' => 1,
                'Project.stop' => 0,
            ),
            'order' => array('Project.id' => 'DESC'),
            'limit' => $limit
        );
        if($id) $options['conditions']['Project.id'] = $id;
        if($pattern) $options['conditions']['Project.pay_pattern'] = $pattern;
        if($mode == 'options') return $options;
        return $this->_switch_return_mode($mode, $options);
    }

    /**
     * 募集終了済みでactive状態のAll or Nothing型PJを一つ取得（達成チェック・売上確定処理用）
     */
    public function get_finish_and_active_allornothing_pj()
    {
        $options = array(
            'conditions' => array(
                'Project.opened' => 1,
                'Project.stop' => 0,
                'Project.active' => 1,
                'Project.pay_pattern' => ALL_OR_NOTHING,
                'Project.collection_end_date <=' => date('Y-m-d 0:0:0')
            ),
            'order' => array(
                'Project.collection_end_date' => 'ASC',
                'Project.id' => 'ASC'
            )
        );
        return $this->find('first', $options);
    }

    /**
     * ユーザがPJを公開していないかチェックする
     */
    public function chk_user_opened_pj($user_id)
    {
        $options = array(
            'conditions' => array(
                'Project.user_id' => $user_id, 'Project.opened' => 1
            ), 'limit' => 1, 'fields' => array('Project.id')
        );
        if($this->find('first', $options)) return false;
        return true;
    }

    /**
     * ユーザが作成したPJを返す
     * 公開中のみ表示
     * @param int    $user_id
     * @param string $mode    (options, all, list, first)
     * @param int    $limit
     * @param int    $recursive
     * @return array
     */
    public function get_pj_of_user($user_id, $mode = 'options', $limit = 10, $recursive = 0)
    {
        $options = array(
            'conditions' => array(
                'Project.user_id' => $user_id,
                'Project.opened' => 1,
                'Project.stop' => 0
            ),
            'order' => array('Project.id' => 'DESC'),
            'limit' => $limit,
            'recursive' => $recursive,
            'fields' => array(
                'Project.id', 'Project.project_name', 'Project.category_id',
                'Project.goal_amount', 'Project.collection_start_date',
                'Project.collection_end_date', 'Project.backers', 'Project.opened',
                'Project.collected_amount', 'Project.pay_pattern', 'Project.goal_backers',
                'Project.no_goal'
            )
        );
        return $this->_switch_return_mode($mode, $options);
    }

    /**
     * 支援したPJを返す
     * @param int    $user_id
     * @param string $mode    (options, all, list, first)
     * @param int    $limit
     * @return array
     */
    public function get_back_pj_of_user($user_id, $mode = 'options', $limit = 10)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'backed_projects',
                    'alias' => 'BackedProject',
                    'type' => 'inner',
                    'conditions' => array('Project.id = BackedProject.project_id',),
                ),
                array(
                    'table' => 'backing_levels',
                    'alias' => 'BackingLevel',
                    'type' => 'inner',
                    'conditions' => array('BackedProject.backing_level_id = BackingLevel.id',),
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('Project.user_id = User.id',),
                ),
            ),
            'order' => array('BackedProject.created' => 'DESC'),
            'limit' => $limit,
            'conditions' => array(
                'BackedProject.user_id' => $user_id,
                'Project.opened' => 1,
                'BackedProject.status not' => STATUS_CANCEL
            ),
            'fields' => array(
                'Project.id', 'Project.project_name', 'Project.goal_amount', 'Project.collected_amount',
                'Project.collection_end_date', 'Project.category_id', 'Project.backers', 'Project.description',
                'Project.opened', 'BackedProject.id', 'BackedProject.invest_amount', 'BackedProject.comment',
                'BackingLevel.id', 'BackingLevel.invest_amount', 'BackingLevel.return_amount',
                'BackingLevel.now_count', 'User.id', 'User.nick_name', 'Project.pay_pattern',
                'Project.goal_backers', 'Project.no_goal'
            ),
        );
        return $this->_switch_return_mode($mode, $options);
    }

    /**
     * TOPPAGE用 ピックアップPJの取得
     * @param int $pickup_pj_id
     * @return array
     */
    public function get_pickup_pj($pickup_pj_id)
    {
        if(empty($pickup_pj_id)) return null;
        $options = array(
            'conditions' => array(
                'Project.id' => $pickup_pj_id,
                'Project.opened' => 1,
                'Project.stop' => 0
            )
        );
        return $this->find('first', $options);
    }

    /**
     * TOPPAGE用　優先プロジェクトの取得関数
     * @param array $top_pj_ids
     * @param int $pickup_pj_id
     * @param int $limit
     * @return array
     */
    public function get_high_priority_pj($top_pj_ids, $pickup_pj_id, $limit = 10)
    {
        $options = array(
            'conditions' => array(
                'Project.id' => $top_pj_ids,
                'Project.id !=' => $pickup_pj_id,
                'Project.opened' => 1,
                'Project.stop' => 0
            ),
            'order' => array(
                'Project.active' => 'DESC',
                'Project.collected_amount' => 'DESC'
            ),
            'limit' => $limit
        );
        return $this->find('all', $options);
    }

    /**
     * TOPPAGE用 Project一覧の取得関数
     * 公開中、ストップでない
     * ピックアップPJと、優先PJを除く
     * 募集してる順、支援額多い順
     */
    public function get_toppage_pj($pickup_pj_id, $top_pj_ids, $limit = 30)
    {
        $count = count($top_pj_ids);
        if($pickup_pj_id){
            $top_pj_ids[] = $pickup_pj_id;
            $count += 1;
        }
        if($limit <= $count) return array();
        $options = array(
            'joins' => array(
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'conditions' => array('Category.id = Project.category_id'),
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('Project.user_id = User.id',),
                ),
            ),
            'conditions' => array(
                'Project.id !=' => $top_pj_ids,
                'Project.opened' => 1,
                'Project.stop' => 0,
            ),
            'order' => array(
                'Project.active' => 'DESC',
                'Project.no_goal' => 'DESC',
                'Project.collected_amount' => 'DESC'
            ),
            'limit' => ($limit - $count),
            'fields' => array(
                'Project.id', 'Project.project_name', 'Project.category_id', 'Project.goal_amount',
                'Project.collection_start_date', 'Project.collection_end_date', 'Project.backers',
                'Project.opened', 'Project.collected_amount', 'Project.pay_pattern',
                'Project.goal_backers', 'Project.no_goal', 'User.id', 'User.nick_name', 'Category.name',
                'Category.id'
            )
        );
        return $this->find('all', $options);
    }

    /**
     * トップページ用　カテゴリ別プロジェクト一覧取得
     */
    public function get_toppage_pj_by_cat($limit = 15)
    {
        $Cat = ClassRegistry::init('Category');
        $options = array(
            'conditions' => array(
                'Category.show_top_flag' => 1
            ),
            'order' => array('Category.order' => 'ASC')
        );
        $c_ids = $Cat->find('list', $options);
        $pjs = array();
        foreach($c_ids as $id => $name){
            $options = array(
                'conditions' => array(
                    'Project.category_id' => $id,
                    'Project.opened' => 1,
                    'Project.stop' => 0
                ),
                'order' => array(
                    'Project.active' => 'DESC',
                    'Project.no_goal' => 'DESC',
                    'Project.collected_amount' => 'DESC',
                ),
                'limit' => $limit,
                'fields' => array(
                    'Project.id', 'Project.project_name', 'Project.category_id', 'Project.goal_amount',
                    'Project.collection_start_date', 'Project.collection_end_date', 'Project.backers',
                    'Project.opened', 'Project.collected_amount', 'Project.pay_pattern',
                    'Project.goal_backers', 'Project.no_goal'
                )
            );
            $tmp = $this->find('all', $options);
            if(!empty($tmp)) $pjs[] = array('name' => $name, 'pj' => $tmp);
        }
        return $pjs;
    }

    /**
     * プロジェクト検索用
     * プロジェクトのオプションを返す関数
     */
    public function search_projects($category_id, $area_id, $birth_area, $school,  $sort, $limit = 30)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('Project.user_id = User.id'),
                )
            ),
            'conditions' => array(
                'Project.opened' => 1,
                'Project.stop' => 0,
            ),
            'order' => array(
                'Project.active' => 'DESC',
                'Project.no_goal' => 'DESC',
                'Project.collected_amount' => 'DESC',
            ),
            'limit' => $limit,
            'fields' => array(
                'Project.id', 'Project.project_name', 'Project.category_id', 'Project.goal_amount',
                'Project.collection_start_date', 'Project.collection_end_date', 'Project.backers',
                'Project.opened', 'Project.collected_amount', 'Project.pay_pattern',
                'Project.goal_backers', 'Project.no_goal'
            )
        );
        if(!empty($category_id)){
            $options['conditions']['Project.category_id'] = $category_id;
        }
        if(!empty($birth_area)){
            $options['conditions']['User.birth_area'] = $birth_area;
        }
        if(!empty($school)){
            $options['conditions']['User.school LIKE'] = "%$school%";
        }
        if(!empty($area_id)){
            $options['conditions']['Project.area_id'] = $area_id;
        }
        switch($sort){
            case 1: //支援金額の多い順
                unset($options['order']);
                $options['order'] = array(
                    'Project.collected_amount' => 'DESC'
                );
                break;
            case 2: //新着順
                unset($options['order']);
                $options['order']['Project.collection_start_date'] = 'DESC';
                break;
            case 3: //募集終了が近い順
                unset($options['order']);
                $options['order']['Project.collection_end_date'] = 'ASC';
                $options['conditions']['Project.active'] = 1;
                $options['conditions']['Project.collection_end_date >'] = date('Y-m-d');
                break;
        }
        return $options;
    }

    /**
     * プロジェクトの削除
     *  - 公開中は削除できない
     *  - 支援数が1以上は削除できない
     * @param int $project_id
     * @return array $result 1 => OK, 2 => ERROR, 3 => 削除できない状態
     */
    public function delete_project($project_id)
    {
        $project = $this->findById($project_id);
        if(!$project) return array(2, null);
        if($project['Project']['opened'] != 0){
            return array(3, '公開中のプロジェクトは削除できません');
        }
        if($project['Project']['backers'] != 0){
            return array(3, '支援者のいるプロジェクトは削除できません');
        }
        if($this->delete($project_id)) return array(1, null);
        return array(2, null);
    }

    /**
     * 支援可能なプロジェクトかチェックする関数
     * OKならProject配列を返す
     *  - 存在するか？
     *  - 公開中か？
     *  - Activeか？
     *  - 募集期間は終わっていないか？（Allornothing or Allin）
     *  - 月額の場合すでに支援していないか？
     *  - STOPされてないか？
     * @param int $pj_id
     * @param int $user_id
     * @param int $recursive
     * @return array
     */
    public function check_backing_enable($pj_id, $user_id,  $recursive = 0)
    {
        $this->recursive = $recursive;
        $pj = $this->findById($pj_id);
        if(!$pj) return null;
        if($pj['Project']['opened'] != 1) return null;
        if($pj['Project']['active'] != 1) return null;
        if(!$this->_check_collection_end_date($pj)) return null;
        if($pj['Project']['stop']) return null;
        if($pj['Project']['pay_pattern'] == MONTHLY){
            $BP = ClassRegistry::init('BackedProject');
            if($BP->chk_payed_to_monthly_pj($user_id, $pj_id)) return null;
        }
        return $pj;
    }

    /**
     * 募集日が過ぎていないか確認する関数
     *  - 決済パターンが月額課金の場合は無期限なのでtrue
     *  - projectsのno_goalがtrueの場合、All INでも募集期限は無期限なのでtrue
     * @param array $pj
     * @return boolean 過ぎてたらfalse
     */
    public function _check_collection_end_date($pj)
    {
        if(!empty($pj['Project']['pay_pattern']) && $pj['Project']['pay_pattern'] != MONTHLY){
            return true;
        }
        if(!$pj['Project']['no_goal']){
            return true;
        }
        $current_date = new DateTime(date('Y-m-d,H:i:s'));
        $closing_date = new DateTime($pj['Project']['collection_end_date']);
        if($closing_date > $current_date) return true;
        return false;
    }

    /**
     * プロジェクトをプロジェクト名から取得する
     * 公開されているもののみ
     * オプションを返す
     */
    public function get_pj_by_name($pj_name)
    {
        return array(
            'conditions' => array(
                'Project.project_name LIKE' => "%{$pj_name}%",
                'Project.opened' => 1,
                'Project.stop' => 0
            )
        );
    }

    /**
     * プロジェクトの公開
     * - 写真が登録されている
     * - コンテンツが登録されている
     * - 支援パターンが登録されている
     * - （決済パターンが月額課金以外の場合）目標金額が入力されている
     * - （決済パターンが月額課金の場合）目標人数が入力されている
     * - プロジェクト名が入力されている
     * - カテゴリーが選択されている
     * - プロジェクト概要が入力されている
     * 以上がクリアされていれば公開される。
     * 公開時に、現在の時間から、collection_termの日数後の時間をcollection_end_dateに登録する
     * 現在の時間をcollection_start_dateに登録する
     * 更に、SiteFeeを登録する
     * 公開後は、募集開始と終了時間、Feeを変更することはできない
     * @param int   $project_id
     * @param array $setting
     * @return array array(code, message) 1 => ok, 2 => ERROR 3 => 公開できない状態
     */
    public function project_open($project_id, $setting)
    {
        $check_result = $this->_open_checks($project_id);
        if($check_result[0] != 1) return $check_result;
        $project = $check_result[2];
        //開始時間の取得
        $start_time = date('Y-m-d H:i:s');
        //終了時間の設定
        $term     = $project['Project']['collection_term'];
        $end_time = date('Y-m-d H:i:s', strtotime($start_time.'+'.$term.'days'));
        //月額あるいは目標非表示の場合は2038年に設定
        if($project['Project']['no_goal'] || $project['Project']['pay_pattern'] == MONTHLY){
            $end_time = '2038-01-01 00:00:00';
        }
        //登録データの作成
        $data = array(
            'Project' => array(
                'opened' => 1,
                'collection_start_date' => $start_time,
                'collection_end_date' => $end_time,
                'site_fee' => $setting['fee']
            )
        );
        //公開処理
        $this->id = $project_id;
        if($this->save($data, true, array(
            'opened', 'collection_start_date', 'collection_end_date', 'site_fee'
        ))){
            return array(1, null);
        }else{
            return array(2, null);
        }
    }

    /**
     * プロジェクト公開時のチェック
     */
    private function _open_checks($project_id)
    {
        $project = $this->findById($project_id);
        if(!$project) return array(2, null);
        $data = $project['Project'];
        $BackingLevel = ClassRegistry::init('BackingLevel');
        if(!$BackingLevel->findByProjectId($project_id)){
            return array(3, '支援パターンが登録されていません。');
        }
        if(empty($data['project_name'])){
            return array(3, 'プロジェクト名が登録されていません。');
        }
        if(empty($data['category_id'])){
            return array(3, 'カテゴリーが登録されていません。');
        }
        if(empty($data['description'])){
            return array(3, 'プロジェクト概要が登録されていません。');
        }
        if(empty($data['pay_pattern'])){
            return array(3, '決済パターンが登録されていません。');
        }
        if(!$data['no_goal']){
            switch($data['pay_pattern']){
                case ALL_OR_NOTHING:
                case ALL_IN:
                    if(empty($data['goal_amount'])){
                        return array(3, '目標金額が登録されていません。');
                    }
                    break;
                case MONTHLY:
                    if(empty($data['goal_backers'])){
                        return array(3, '目標人数が登録されていません。');
                    }
            }
        }
        if(empty($data['pic'])){
            return array(3, 'サムネイル画像が登録されていません。');
        }
        if(!empty($data['stop'])){
            return array(3, 'プロジェクトが中断中の状態は公開できません。');
        }
        return array(1, null, $project);
    }

    /**
     * 公開ストップ処理
     */
    public function project_stop($id)
    {
        $project = $this->findById($id);
        if(!$project) return false;
        $this->id = $id;
        if($this->saveField('stop', 1)) return true;
        return false;
    }

    /**
     * 公開再開処理
     */
    public function project_restart($id)
    {
        $project = $this->findById($id);
        if(!$project) return false;
        $this->id = $id;
        if($this->saveField('stop', 0)) return true;
        return false;
    }

    /**
     * プロジェクト作成ユーザの変更
     */
    public function change_user($pj_id, $user_id)
    {
        $this->id = $pj_id;
        if($this->saveField('user_id', $user_id)) return true;
        return false;
    }

    /**
     * プロジェクトの現在の支援金額等に$bpの内容を追加する
     * $bpは、これからGMOペイメントで仮売り上げ登録する予定の支援内容
     * @param array $bp (backed_project)
     * @param array $pj (project)
     * @param string $mode add or del
     * @return array / null
     */
    public function add_backed_to_project($bp, $pj, $mode = 'add')
    {
        $BP = ClassRegistry::init('BackedProject');
        $backed_projects = $BP->get_by_pj_id($pj['Project']['id'], false);
        $backers = count($backed_projects);
        $collected_amount = 0;
        foreach($backed_projects as $b){
            $collected_amount += $b['BackedProject']['invest_amount'];
        }
        if($mode == 'add'){
            $backers += 1;
            $collected_amount += $bp['amount'];
        }
        $pj['Project']['backers'] = $backers;
        $pj['Project']['collected_amount'] = $collected_amount;
        $this->id = $pj['Project']['id'];
        if(!$this->save($pj, true, array('backers', 'collected_amount'))){
            return null;
        }else{
            return $pj;
        }
    }

    /**
     * project view用
     * @param int $id
     * @return array $project
     */
    public function get_project_for_view($id)
    {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'conditions' => array('Category.id = Project.category_id'),
                ),
                array(
                    'table' => 'areas',
                    'alias' => 'Area',
                    'type' => 'left',
                    'conditions' => array('Project.area_id = Area.id'),
                ),
            ),
            'conditions' => array(
                'Project.opened' => 1,
                'Project.stop' => 0,
                'Project.id' => $id
            ),
            'fields' => array(
                'Project.id', 'Project.user_id', 'Project.project_name',
                'Project.goal_amount', 'Project.collection_start_date',
                'Project.collection_end_date', 'Project.thumbnail_type',
                'Project.thumbnail_movie_type', 'Project.thumbnail_movie_code',
                'Project.backers', 'Project.comment_cnt', 'Project.report_cnt',
                'Project.collected_amount', 'Project.description', 'Category.name',
                'Category.id', 'Area.id', 'Area.name', 'Project.pay_pattern', 'Project.goal_backers',
                'Project.active', 'Project.no_goal'
            )
        );
        $project = $this->find('first', $options);
        if(!$project) return null;
        $BackingLevel = ClassRegistry::init('BackingLevel');
        $project['BackingLevel'] = $BackingLevel->findAllByProjectId($id);
        $User = ClassRegistry::init('User');
        $project['User'] = $User->findById($project['Project']['user_id']);
        return $project;
    }

    /**
     * Projectに、活動報告の数を登録する関数
     */
    public function save_report_cnt($project_id, $report_cnt)
    {
        $this->id = $project_id;
        if($this->saveField('report_cnt', $report_cnt)) return true;
        return false;
    }

    /**
     * Projectに、コメントの数を登録する関数
     */
    public function save_comment_cnt($project_id, $comment_cnt)
    {
        $this->id = $project_id;
        if($this->saveField('comment_cnt', $comment_cnt)) return true;
        return false;
    }

    /**
     * テストプロジェクトを削除する
     */
    public function delete_test_pj($id)
    {
        if($this->delete($id)){
            $PC = ClassRegistry::init('ProjectContent');
            if($PC->deleteAll(array('ProjectContent.project_id' => $id), false)){
                $PCO = ClassRegistry::init('ProjectContentOrder');
                if($PCO->deleteAll(array('ProjectContentOrder.project_id' => $id), false)){
                    $BP = ClassRegistry::init('BackedProject');
                    if($BP->deleteAll(array('BackedProject.project_id' => $id), false)){
                        $BL = ClassRegistry::init('BackingLevel');
                        if($BL->deleteAll(array('BackingLevel.project_id' => $id), false)){
                            $CO = ClassRegistry::init('Comment');
                            if($CO->deleteAll(array('Comment.project_id' => $id), false)){
                                $FA = ClassRegistry::init('FavouriteProject');
                                if($FA->deleteAll(array('FavouriteProject.project_id' => $id), false)){
                                    $RE = ClassRegistry::init('Report');
                                    $reports = $RE->findAllByProjectId($id);
                                    $id_list = array();
                                    foreach($reports as $r){
                                        $id_list[] = $r['Report']['id'];
                                    }
                                    if($RE->deleteAll(array('Report.project_id' => $id), false)){
                                        $REC = ClassRegistry::init('ReportContent');
                                        if($REC->deleteAll(array('ReportContent.report_id' => $id_list) ,false)){
                                            $RECO = ClassRegistry::init('ReportContentOrder');
                                            if($RECO->deleteAll(array('ReportContentOrder.report_id' => $id_list), false)){
                                                return true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
        return false;
    }

    /**
     * 目標金額チェック
     * - 決済パターンがAll or Nothing/All Inの場合は必須
     * @return boolean
     */
    public function validate_goal_amount() {
        assert($this->data[$this->alias]);

        $data = $this->data[$this->alias];
    	if ($data['pay_pattern'] == MONTHLY)
            return true;

        if (!empty($data['goal_amount']))
            return true;

        return false;
    }

    /**
     * 目標人数チェック
     * - 決済パターンが月額課金の場合は必須
     * @return boolean
     */
    public function validate_goal_backers() {
        assert($this->data[$this->alias]);

    	$data = $this->data[$this->alias];
    	if ($data['pay_pattern'] != MONTHLY)
            return true;

        if (!empty($data['goal_backers']))
            return true;

        return false;
    }
    
    /**
     * プロジェクト明細取得
     */
    public function get_statement_of_project($project_id) {
        $options = array(
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('Project.user_id = User.id',),
                ),
            ),
            'conditions' => array(
                'Project.project_id' => $project_id,
                'Project.opened' => 1,
                'BackedProject.status not' => STATUS_CANCEL
            ),
            'fields' => array(
                'Project.project_name', 'Project.collected_amount',
                'Project.opened', 'User.nick_name', 'Project.backwes', 'Project.site_fee', 'Project.project_owner_price'
            ),
        );
        return $this->_switch_return_mode($mode, $options);
    }
}
