<?php
App::uses('AppController', 'Controller');

class ProjectsController extends AppController
{
    public $uses = array(
        'Project', 'Partner', 'Toppage', 'Partner', 'Area',
        'FavouriteProject', 'Report', 'Setting', 'ReportContent',
        'BackedProject'
    );
    public $components = array('Mail');
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('view', 'index');
        //Ajax時の対応
        if($this->action === 'add'){
            $this->Security->validatePost = false;
            $this->Security->csrfUseOnce  = false;
            $this->Security->csrfCheck    = false;
        }
        //ajaxでログインしてない場合スルーさせる（authComponentのajaxLoginまでいかずに、下記のリダイレクトさせてしまうから）
        if(!($this->request->is('ajax') && !$this->auth_user)){
            //subdomainなしの場合リダイレクト
            if(!$this->setting){
                $this->redirect(Configure::read('url_full_path'));
            }
        }
    }

    /**
     * プロジェクト検索画面
     */
    public function index()
    {
        $this->set('categories', $this->Project->Category->get_list());
        $this->set('areas', $this->Area->get_list());
        if($this->request->is('post') || $this->request->is('put')){
            $d = $this->request->data['Project'];
            $area_id = ($this->setting['cat_type_num'] == 2) ? $d['area_id'] : null;
            if(empty($d['school'])) $d['school'] = null;
            if(empty($d['birth_area'])) $d['birth_area'] = null;
            $this->paginate = $this->Project->search_projects(
                $d['category_id'], $area_id, $d['birth_area'], $d['school'], $d['order']
            );
        }else{
            $this->paginate = $this->Project->search_projects(null, null, null, null, null);
        }
        $this->set('title', 'プロジェクト検索');
        $this->set('projects', $this->paginate('Project'));
    }

    /**
     * 投稿済みプロジェクト一覧画面（マイページ）
     */
    public function registered()
    {
        $this->layout = 'mypage';
        $this->paginate = $this->Project->get_pj_of_user($this->Auth->user('id'), 'options', 10, 0);
        $this->set('projects', $this->paginate('Project'));
        //マイページのサブメニュー用
        $this->set('menu_mode', 'registered');
        $this->set('categories', $this->Project->Category->get_list());
    }

    /**
     * プロジェクト詳細画面
     * @param string $id
     * @param null   $mode
     * @param int    $report_id
     * @return void
     */
    public function view($id = null, $mode = null, $report_id = null)
    {
        $project = $this->Project->get_project_for_view($id);
        if(!$project) $this->redirect('/');
        $this->set('title', $project['Project']['project_name']);
        $this->set(compact('mode', 'project'));
        $this->_chk_favorite($id);
        $this->_chk_active($id, $project);

        //プロジェクト詳細、コメント、支援者一覧、経過報告毎にviewを分ける
        if($mode){
            switch($mode){
                case 'comment':
                    return $this->_comment($id);
                case 'backers':
                    return $this->_backers($id);
                case 'report':
                    return $this->_report($id);
                case 'report_view':
                    return $this->_report_view($id, $report_id);
            }
        }else{
            //プロジェクトコンテントの取得
            $contents = Cache::read('project_contents_'.$id);
            if($contents === false){
                $contents = $this->Project->ProjectContent->get_contents($id);
                Cache::write('project_contents_'.$id, $contents);
            }
            $this->set(compact('contents'));
            if($this->smart_phone){
                return $this->render('sp/view_sp', 'project_view_sp');
            }else{
                return $this->render('view', 'project_view');
            }
        }
    }

    /**
     * プロジェクトに支援可能か確認する
     *  - 募集期間が過ぎていないか？（月額型以外）
     *  - 既に支援済みでないか？（月額型のみ）
     */
    private function _chk_active($pj_id, $pj)
    {
        if($this->Project->check_backing_enable($pj_id, $this->Auth->user('id'))){
            $this->set('pj_active', true);
        }else{
            $this->set('pj_active', false);
            $this->_set_reason_of_not_active($pj);
        }
    }

    /**
     * 支援不可能な理由をセット
     *  - 月額でnot activeならサービス終了（募集終了）
     *  - 月額でactiveなら支援済み
     *  - 月額でない場合募集終了
     * @param $pj
     */
    private function _set_reason_of_not_active($pj)
    {
        $pj = $pj['Project'];
        if($pj['pay_pattern'] == MONTHLY && !$pj['active']){
            $reason = 'このプロジェクトの募集は終了しました';
            $reason_sp = '募集が終了しました';
        }elseif($pj['pay_pattern'] == MONTHLY && $pj['active']){
            $reason = 'このプロジェクトは支援済みです';
            $reason_sp = '支援済みです';
        }else{
            $reason = 'このプロジェクトの募集は終了しました';
            $reason_sp = '募集が終了しました';
        }
        $this->set(compact('reason', 'reason_sp'));
    }

    private function _chk_favorite($id)
    {
        if($this->Auth->user('id')){
            $this->set('favourite', $this->FavouriteProject->check_favourite($this->Auth->user('id'), $id));
        }
    }

    private function _comment($id)
    {
        $this->paginate = $this->Project->Comment->get_by_pj_id($id, true);
        $this->set('comments', $this->paginate('User'));
        if($this->smart_phone){
            return $this->render('sp/view_comment_sp', 'project_view_sp');
        }else{
            return $this->render('view_comment', 'project_view');
        }
    }

    private function _backers($id)
    {
        $this->paginate = $this->Project->User->get_backers($id);
        $this->set('backers', $this->paginate('User'));
        if($this->smart_phone){
            return $this->render('sp/view_bakers_sp', 'project_view_sp');
        }else{
            return $this->render('view_bakers', 'project_view');
        }
    }

    private function _report($id)
    {
        $this->paginate = $this->Report->get_open_reports_options_of_project($id, 15, -1);
        $this->set('reports', $this->paginate('Report'));
        if($this->smart_phone){
            return $this->render('sp/view_report_sp', 'project_view_sp');
        }else{
            return $this->render('view_report', 'project_view');
        }
    }

    private function _report_view($id, $report_id)
    {
        $report = $this->Report->get_report_of_project($report_id, $id);
        if(!$report) $this->redirect('/');
        $this->set(compact('report'));
        $this->set('report_contents', $this->ReportContent->get_contents($report_id));
        if($this->smart_phone){
            return $this->render('sp/view_report_view_sp', 'project_view_sp');
        }else{
            return $this->render('view_report_view', 'project_view');
        }
    }

    /**
     * プロジェクト投稿画面
     */
    public function add()
    {
        $this->layout = 'mypage';
        $this->set('categories', $this->Project->Category->get_list());
        $this->set('areas', $this->Area->get_list());
        $this->_chk_email();

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->autoRender = false;
            $this->request->data['Project']['user_id'] = $this->Auth->user('id');
            $this->request->data['Project']['pic'] = null;
            if (!empty($this->request->params['form']['pic'])) {
                $this->request->data['Project']['pic'] = $this->request->params['form']['pic'];
            }

            // バリデーション
            $this->Project->set($this->request->data);
            if (!$this->Project->validates()) {
                return json_encode(array(
                    'status' => 0, 'msg' => '入力内容を確認してください。',
                    'errors' => $this->Project->validationErrors,
                ));
            }

            // セッションに保存
            $session_key = hash('sha256', "project_user_{$this->Auth->user('id')}");
            $this->Session->write($session_key, $this->request->data);

            if ($this->Session->write($session_key, $this->request->data)) {
                return json_encode(array(
                    'status'       => 1,
                    'msg'          => 'プロジェクトを保存しました。'
                ));
            } else {
                return json_encode(array(
                    'status' => 0,
                    'msg'    => 'エラーが発生しました。恐れ入りますが、再度お試しください。'
                ));
                $this->log("couldn't write to session_key {$session_key} for user (id=$this->Auth->user('id'))", LOG_DEBUG);
            }
        }
    }

    /**
     * リターン追加
     */
    public function add_return($id = null)
    {
        $this->layout = 'mypage';
        $session_key = hash('sha256', "project_user_{$this->Auth->user('id')}");

        if (!empty($id)) {
            $project = $this->Project->get_pj_by_id($id, array('BackingLevel'));
        } else {
            // セッションから取得
            $project = $this->Session->read($session_key);
        }

        if (empty($project)) {
            $this->log("project (id={$id}) is not found.", LOG_DEBUG);
            $this->redirect('/');
        }

        // 本人のみ編集可
        if ($project['Project']['user_id'] != $this->Auth->user('id')) {
            $this->log("user (user_id={$this->Auth->user('id')}) cannot edit project (id={$id}) of user (user_id={$project['Project']['user_id']}).", LOG_DEBUG);
            $this->redirect('/');
        }
        // 公開後のプロジェクトは編集不可 追加のみ
        $disabled = !empty($project['Project']['opened']) ? true : false;

        $this->set(compact('project', 'disabled'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $max_level = $this->request->data['Project']['max_back_level'];
            $project['Project']['max_back_level'] = $max_level;
            $project['BackingLevel'] = $this->request->data['BackingLevel'];

            // セッションに保存
            $this->Session->write($session_key, $project);
            $this->redirect(array('action' => 'confirm', $id));
        } else {
            $this->request->data = $project;
        }
    }

    /**
     * 確認
     */
    public function confirm($id = null) {
        $this->layout = 'mypage';
        $this->set('categories', $this->Project->Category->get_list());

        if (!empty($id)) {
            $project = $this->Project->get_pj_by_id($id, array('BackingLevel'));
        } else {
            // セッションから取得
            $session_key = hash('sha256', "project_user_{$this->Auth->user('id')}");
            $project = $this->Session->read($session_key);
        }

        if (empty($project)) {
            $this->log("project (id={$id}) is not found.", LOG_DEBUG);
            $this->redirect('/');
        }

        $this->set(compact('project'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Ring->bindUp('Project');
            if ($this->Project->saveAll($project, array('deep' => true))) {
                $this->Session->setFlash("プロジェクトの新規作成を受け付けました。サイト管理者からの連絡をいましばらくお待ちください。");
                $this->Session->delete($session_key);

                $this->Mail->pj_create($this->auth_user, $this->Project->read(), 'admin');
                $this->Mail->pj_create($this->auth_user, $this->Project->read(), 'user');
            } else {
                $this->log($this->Project->validationErrors, LOG_DEBUG);
                $this->Session->setFlash("プロジェクトの登録ができませんでした。恐れ入りますが、入力内容をご確認の上、再度お試しください。");
            }
        }
    }

    private function _chk_email()
    {
        if(empty($this->auth_user['User']['email'])){
            $this->Session->setFlash('プロジェクトの作成は、メールアドレスの認証を完了していただく必要があります。');
            $this->redirect($this->referer());
        }
    }

    private function _chk_add_input($data)
    {
        if(empty($data['Project']['project_name'])
           || empty($data['Project']['pic'])
           || empty($data['Project']['category_id'])
           || empty($data['Project']['pay_pattern'])
           || empty($data['Project']['description'])
           || empty($data['Project']['return'])
           || empty($data['Project']['contact'])
           || empty($data['Project']['rule'])
        ){
            return false;
        }
        if($data['Project']['pay_pattern'] == MONTHLY){
            if(empty($data['Project']['goal_backers'])) return false;
        }else{
            if(empty($data['Project']['goal_amount'])) return false;
        }
        if($this->setting['cat_type_num'] == 2){
            if(empty($data['Project']['area_id'])){
                return false;
            }
        }
        return true;
    }

    private function _save_fields()
    {
        $fields = array(
            'Project' => array(
                'project_name', 'category_id', 'goal_amount', 'goal_backers',
                'pay_pattern', 'description', 'return', 'contact',
                'rule', 'user_id', 'created', 'modified', 'pic',
            ),
            'ProjectContent' => array(
                 'open', 'type', 'txt_content', 'movie_type', 'movie_code',
            ),
        );
        if($this->setting['cat_type_num'] == 2){
            $fields[] = 'area_id';
        }
        return $fields;
    }

}
