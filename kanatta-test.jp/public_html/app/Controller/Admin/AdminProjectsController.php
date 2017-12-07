<?php
App::uses('AppController', 'Controller');

class AdminProjectsController extends AppController
{
    public $uses = array('Project', 'Area', 'Setting',
                         'BackedProject', 'BackingLevel');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('hoge');
        //Ajax時の対応
        if($this->action === 'edit_design'
           || $this->action === 'edit_design_top'
           || $this->action === 'admin_edit_thumb'
           || $this->action === 'admin_edit_detail'
           || $this->action === 'admin_create'
        ){
            $this->Security->validatePost = false;
            $this->Security->csrfUseOnce  = false;
            $this->Security->csrfCheck    = false;
        }
        if($this->action === 'admin_edit_level'){
            $this->Security->validatePost = false;
            $this->Security->csrfCheck    = false;
        }
        $this->layout = 'admin';
    }

    /**
     * サイト管理 - プロジェクト一覧
     */
    public function admin_index()
    {
        $this->set('categories', $this->Project->Category->find('list'));
        $conditions = array();
        if(isset($this->request->query['search_id'])){
            if(!empty($this->request->query['search_id'])){
                $conditions[]['AND'] = array('Project.id' => $this->request->query['search_id']);
            }
        }
        $this->Project->recursive = 0;
        $this->paginate = array(
            'order' => 'Project.created desc',
            'limit' => '30'
        );
        $this->set('projects', $this->paginate('Project', $conditions));
    }

    /**
     * プロジェクトの作成関数（ユーザは自分になる）
     * 画像必須（プロジェクト一覧でgrid表示するときに崩れるから）
     */
    public function admin_create()
    {
        //メアド登録チェック
        if(empty($this->auth_user['User']['email'])){
            $this->Session->setFlash('プロジェクトの作成は、メール認証を完了させていただく必要がございます。');
            $this->redirect($this->referer());
        }
        if($this->request->is('post') || $this->request->is('put')){
            $this->layout = 'ajax';
            $this->autoRender = false;
            $this->request->data['Project']['user_id'] = $this->auth_user['User']['id'];
            $this->request->data['Project']['rule']    = '1';
            $this->request->data['Project']['contact'] = 'ご自分で作成したプロジェクトです';
            $this->request->data['Project']['return']  = 'ご自分で作成したプロジェクトです';
            if(!empty($this->request->params['form']['pic'])){
                $this->request->data['Project']['pic'] = $this->request->params['form']['pic'];
            }else{
                $this->request->data['Project']['pic'] = null;
            }
            $chk_result = $this->_chk_input_for_create($this->request->data['Project']);
            if(!$chk_result[0]) return $this->_json_output(0, $chk_result[1]);
            $this->Ring->bindUp('Project');
            $this->Project->create();
            if($this->Project->save($this->request->data, true, array(
                'user_id', 'rule', 'contact', 'return', 'pic', 'category_id', 'area_id',
                'goal_amount', 'project_name', 'description', 'goal_backers', 'pay_pattern',
                'no_goal'
            ))){
                $this->Session->setFlash('プロジェクトを作成しました');
                return $this->_json_output(1, 'プロジェクトを作成しました');
            }else{
                return $this->_json_output(0, 'プロジェクトが作成できませんでした。'.OSORE);
            }
        }
        $this->set('categories', $this->Project->Category->get_list());
        $this->set('areas', $this->Area->get_list());
    }

    private function _json_output($status, $msg)
    {
        return json_encode(array('status' => $status, 'msg' => $msg));
    }

    /**
     * admin_createアクションの入力チェック
     * @params array $data
     * @return array (status, err_msg)
     */
    private function _chk_input_for_create($data)
    {
        if(empty($data['project_name']) || empty($data['pic']) ||
           empty($data['category_id']) || empty($data['description'] ||
           empty($data['pay_pattern'])))
        {
            return array(false, '必須項目を入力してください');
        }
        return $this->_chk_input_goal($data);
    }

    /**
     * admin_editアクションの入力チェック
     * @params array $data
     * @return array (status, err_msg)
     */
    private function _chk_input_for_edit($data)
    {
        return $this->_chk_input_goal($data);
    }

    /**
     * 決済パターンに応じた目標値の入力チェック
     *  - All or Nothing　か All Inの場合、目標金額も必須
     *  - 月額課金の場合、目標人数も必須
     * @param $data
     * @return array (status, err_msg)
     */
    private function _chk_input_goal($data)
    {
        switch($data['pay_pattern']){
            case ALL_OR_NOTHING:
                if(!empty($data['no_goal'])){
                    return array(false, 'All or Nothingの場合、目標を非表示にはできません');
                }
            case ALL_IN:
                if(empty($data['no_goal'])){
                    if(empty($data['goal_amount'])){
                        return array(false, '目標金額を入力してください');
                    }elseif(!is_numeric($data['goal_amount'])){
                        return array(false, '目標金額は数値を入力してください');
                    }
                }
                break;
            case MONTHLY:
                if(empty($data['no_goal'])){
                    if(empty($data['goal_backers'])){
                        return array(false, '目標人数を入力してください');
                    }elseif(!is_numeric($data['goal_backers'])){
                        return array(false, '目標人数は数値を入力してください');
                    }
                }
        }
        return array(true, null);
    }

    /**
     * 管理者プロジェクト編集画面（基本情報）
     * @param string $id
     * @throws NotFoundException
     * @return void
     */
    public function admin_edit($id = null)
    {
        $this->Project->recursive = 0;
        $project = $this->Project->findById($id);
        if(!$project) $this->redirect('/');
        $this->set(compact('project'));
        if($this->request->is('post') || $this->request->is('put')){
            $this->request->data['Project']['id'] = $id;
            if(empty($this->request->data['Project']['pay_pattern'])){
                $this->request->data['Project']['pay_pattern'] = $project['Project']['pay_pattern'];
            }
            if(empty($this->request->data['Project']['no_goal'])){
                $this->request->data['Project']['no_goal'] = $project['Project']['no_goal'];
            }
            $chk_result = $this->_chk_input_for_edit($this->request->data['Project']);
            if(!$chk_result[0]) return $this->Session->setFlash($chk_result[1]);
            $fields = array(
                'project_name', 'category_id', 'area_id', 'description',
                'goal_amount', 'collection_term', 'modified', 'return',
                'contact', 'pay_pattern', 'goal_backers', 'no_goal'
            );
            $this->Project->begin();
            $this->Project->id = $id;
            if($this->Project->save($this->request->data, true, $fields)){
                $this->Project->commit();
                $this->Session->setFlash('プロジェクトを更新しました');
                $this->redirect(array('action' => 'admin_edit', $id));
            }else{
                $this->Session->setFlash('プロジェクトが更新できませんでした。'.OSORE);
                $this->_set_project_option();
            }
            $this->Project->rollback();
        }else{
            $this->request->data = $project;
            $this->_set_project_option();
        }
    }

    /**
     * プロジェクト追加・編集時のオプションのセット関数
     */
    private function _set_project_option()
    {
        $this->set('categories', $this->Project->Category->get_list());
        $this->set('areas', $this->Area->get_list());
        $this->_set_time_options();
    }

    /**
     * プロジェクト開始・終了日時のタイムオプション
     * @param bool $value
     */
    private function _set_time_options($value = true)
    {
        $start_option = array(
            'minYear' => date('Y'),
            'maxYear' => date('Y'),
            'separator' => array('年', '月', '日'),
            'monthNames' => false,
            'required' => true
        );
        $end_option   = array(
            'minYear' => date('Y'),
            'maxYear' => date('Y') + 1,
            'separator' => array('年', '月', '日'),
            'monthNames' => false,
            'required' => true
        );
        if(!$value){
            unset($start_option['value']);
            unset($end_option['value']);
        }
        $this->set(compact('start_option', 'end_option'));
    }

    /**
     * プロジェクトの作成ユーザーの変更
     */
    public function admin_change_user($pj_id, $user_id = null)
    {
        $this->Project->recursive = 0;
        $project = $this->Project->findById($pj_id);
        if(!$project) $this->redirect('/');
        $this->set(compact('project'));
        if($this->request->is('post') || $this->request->is('put')){
            if(!empty($user_id)){
                if($this->Project->change_user($pj_id, $user_id)){
                    $this->Session->setFlash('ユーザーを変更しました。');
                    return $this->redirect('/admin/admin_projects/edit/'.$pj_id);
                }else{
                    return $this->Session->setFlash('登録に失敗しました。恐れ入りますが、再度お試しください。');
                }
            }else{
                $email = !empty($this->request->data['User']['email_like']) ? $this->request->data['User']['email_like'] : null;
                $this->paginate = $this->Project->User->get_users_by_email($email, true, 30);
                $users = $this->paginate('User');
                return $this->set(compact('users'));
            }
        }else{
            $this->paginate = $this->Project->User->get_all_users(true, 30);
            $users = $this->paginate('User');
            return $this->set(compact('users'));
        }
    }

    /**
     * 管理者プロジェクト編集画面（サムネイル画像）
     */
    public function admin_edit_thumb($id = null)
    {
        $project = $this->Project->findById($id);
        if(empty($project)) $this->redirect('/');
        $this->set(compact('project'));
        if($this->request->is('post') || $this->request->is('put')){
            if(!$project){
                $this->set('result', 'ERROR');
                return $this->render('edit_ajax');
            }
            $this->layout = 'ajax';
            $this->autoRender = false;
            if(!empty($this->request->params['form']['pic'])){
                $this->request->data['Project']['pic'] = $this->request->params['form']['pic'];
            }else{
                $this->request->data['Project']['pic'] = null;
            }
            $this->Project->id = $id;
            $this->request->data['Project']['id'] = $id;
            $this->Ring->bindUp('Project');
            if($this->Project->save($this->request->data, true, array(
                'thumbnail_type', 'thumbnail_movie_code', 'thumbnail_movie_type', 'pic'
            )))
            {
                return json_encode(array('status' => 1, 'msg' => 'プロジェクトを更新しました'));
            }else{
                return json_encode(array('status' => 0, 'msg' => '更新に失敗しました。恐れ入りますが再度お試しください。'));
            }
        }else{
            if(!$project) $this->redirect('/');
            $this->request->data = $project;
        }
    }

    /**
     * 管理者プロジェクト編集画面（プロジェクト詳細）
     */
    public function admin_edit_detail($project_id = null)
    {
        $project = $this->Project->findById($project_id);
        if(!$project) $this->redirect('/');
        $this->set(compact('project'));
        $project_contents = $this->Project->ProjectContent->get_contents($project_id);
        $this->set(compact('project_contents'));
    }

    /**
     * 管理者プロジェクト編集画面（支援パターン）
     */
    public function admin_edit_level($id = null)
    {
        $project = $this->Project->get_pj_by_id($id, array('BackingLevel'));
        if(!$project) $this->redirect('/');
        $this->set(compact('project'));
        if($this->request->is('post') || $this->request->is('put')){
            $max_level = $this->request->data['Project']['max_back_level'];
            $this->Project->begin();
            $this->Project->id = $id;
            if($this->Project->saveField('max_back_level', $max_level)){
                if($this->Project->BackingLevel->edit_backing_level($this->request->data['BackingLevel'], $id)){
                    $this->Project->commit();
                    $this->Session->setFlash('プロジェクトを保存しました');
                    return $this->redirect('/admin/admin_projects/edit_level/'.$id);
                }
            }
            $this->Project->rollback();
            $this->Session->setFlash('プロジェクトを保存できませんでした。');
        }else{
            $this->request->data = $project;
        }
    }

    /**
     * プロジェクト削除（管理者画面）
     * - opened yesは削除できない
     * - backers が1以上は削除できない
     * @param string $project_id
     */
    public function admin_delete($project_id = null)
    {
        $result = $this->Project->delete_project($project_id);
        switch($result[0]){
            case 1:
                $this->Session->setFlash('プロジェクトを削除しました');
                break;
            case 2:
                $this->Session->setFlash('プロジェクトが削除できませんでした');
                break;
            case 3:
                $this->Session->setFlash($result[1]);
        }
        $this->redirect('/admin/admin_projects/');
    }

    /**
     * テストプロジェクト削除（管理者画面）
     *  - 条件問わず削除可能
     *  - 関連するお気に入り、支援パターン、支援データ、PJ詳細コンテンツ、活動報告もすべて削除される
     */
    public function admin_delete_test_pj($id = null)
    {
        if(! $this->request->is('post')) $this->redirect('/');
        $pj = $this->Project->findById($id);
        if(! $pj) $this->redirect('/');
        $this->Project->begin();
        if($this->Project->delete_test_pj($id)){
            $this->Project->commit();
            $this->Session->setFlash('プロジェクトを削除しました');
            return $this->redirect('/admin/admin_projects');
        }
        $this->Project->rollback();
        $this->Session->setFlash('プロジェクトが削除できませんでした。');
        return $this->redirect('/admin/admin_projects');
    }

    /**
     * プロジェクトのトップページ表示に関する設定画面
     */
    public function admin_toppage()
    {
        if($this->request->is('post') || $this->request->is('put')){
            if(!empty($this->request->data['Project']['project_name'])){
                $this->paginate = $this->Project->get_pj_by_name($this->request->data['Project']['project_name']);
                return $this->set('projects', $this->paginate('Project'));
            }
        }
        $this->paginate = $this->Project->get_pj('options', 'open', 30, -1);
        $this->set('projects', $this->paginate('Project'));
    }

    /**
     * トップページのピックアッププロジェクトに設定する関数
     */
    public function admin_set_pickup($project_id = null)
    {
        $result = $this->Setting->set_pickup_project($project_id);
        if($result){
            $this->Session->setFlash('ピックアッププロジェクトに設定しました。');
        }else{
            $this->Session->setFlash('ピックアッププロジェクトの設定に失敗しました。恐れ入りますが、再度お試しください。');
        }
        $this->redirect(array('action' => 'admin_toppage'));
    }

    /**
     * トップページのピックアッププロジェクトを解除する関数
     */
    public function admin_unset_pickup()
    {
        $result = $this->Setting->unset_pickup_project();
        if($result){
            $this->Session->setFlash('ピックアッププロジェクトを解除しました。');
        }else{
            $this->Session->setFlash('ピックアッププロジェクトの解除に失敗しました。恐れ入りますが、再度お試しください。');
        }
        $this->redirect(array('action' => 'admin_toppage'));
    }

    /**
     * トップページの優先表示プロジェクトに設定する関数
     */
    public function admin_set_top($project_id = null)
    {
        $result = $this->Setting->set_top_project($project_id);
        if($result){
            $this->Session->setFlash('優先表示プロジェクトに設定しました。');
        }else{
            $this->Session->setFlash('優先表示プロジェクトの設定に失敗しました。恐れ入りますが、再度お試しください。');
        }
        $this->redirect(array('action' => 'admin_toppage'));
    }

    /**
     * トップページの優先表示プロジェクトを解除する関数
     */
    public function admin_unset_top($project_id = null)
    {
        $result = $this->Setting->unset_top_project($project_id);
        if($result){
            $this->Session->setFlash('優先表示プロジェクトを解除しました。');
        }else{
            $this->Session->setFlash('優先表示プロジェクトの解除に失敗しました。恐れ入りますが、再度お試しください。');
        }
        $this->redirect(array('action' => 'admin_toppage'));
    }

    /**
     * プロジェクト公開設定（管理画面）
     * @param int $project_id
     */
    public function admin_open($project_id = null)
    {
        $result = $this->Project->project_open($project_id, $this->setting);
        switch($result[0]){
            case 1:
                $this->Session->setFlash('公開しました');
                break;
            case 2:
                $this->Session->setFlash('公開できませんでした。恐れ入りますが再度お試しください。');
                break;
            case 3:
                $this->Session->setFlash($result[1]);
        }
        return $this->redirect($this->referer());
    }

    /**
     * プロジェクトの停止
     */
    public function admin_stop($project_id)
    {
        if($this->Project->project_stop($project_id)){
            $this->Session->setFlash('公開を停止しました');
        }else{
            $this->Session->setFlash('公開を停止できませんでした。恐れ入りますが再度お試しください');
        }
        return $this->redirect($this->referer());
    }

    /**
     * プロジェクトの再開
     */
    public function admin_restart($project_id)
    {
        if($this->Project->project_restart($project_id)){
            $this->Session->setFlash('公開を再開しました');
        }else{
            $this->Session->setFlash('公開を再開できませんでした。恐れ入りますが再度お試しください');
        }
        return $this->redirect($this->referer());
    }

    /**
     * 支援の管理 - 公開中プロジェクト一覧
     */
    public function admin_open_projects()
    {
        $this->set('pay_patterns', Configure::read('PAY_PATTERN'));
        if($this->request->is('post') || $this->request->is('put')){
            $d = $this->request->data;
            $id = !empty($d['Project']['id']) ? $d['Project']['id'] : null;
            $pattern = !empty($d['Project']['pay_pattern']) ? $d['Project']['pay_pattern'] : null;
            $this->paginate = $this->Project->get_open_projects($id, $pattern);
        }else{
            $this->paginate = $this->Project->get_open_projects();
        }
        $projects = $this->paginate('Project');
        $this->set(compact('projects'));
    }

    /**
     * プロジェクトの支援者一覧を表示する
     */
    public function admin_backers($pj_id)
    {
        $project = $this->Project->findById($pj_id);
        if(!$project) $this->redict('/');
        $this->paginate = $this->Project->BackedProject->get_backers_of_project($pj_id, 'options', 30);
        $backers = $this->paginate('User');
        $this->set(compact('backers', 'project'));
        $this->set('statuses', Configure::read('STATUSES'));
        $this->set('charge_results', Configure::read('CHARGE_RESULTS'));
    }

    /**
     * 手動プロジェクトを削除する
     * （projects/backingLevelの数値も修正する）
     */
    public function admin_del_bp($bp_id)
    {
        $this->BackedProject->begin();
        if($this->request->is('post')){
            $bp = $this->BackedProject->findById($bp_id);
            if($bp && $bp['BackedProject']['manual_flag']){
                $bp = $bp['BackedProject'];
                if($this->BackedProject->delete($bp_id)){
                    $this->_update_backing_count(
                        $bp['project_id'], $bp['backing_level_id']
                    );
                    $this->Session->setFlash('削除しました');
                    $this->BackedProject->commit();
                    $this->redirect($this->referer());
                }
            }
        }
        $this->Session->setFlash('失敗しました');
        $this->BackedProject->rollback();
        $this->redirect($this->referer());
    }

    /**
     * project,backing_levelに支援者数、支援総額を更新
     */
    private function _update_backing_count($pj_id, $bl_id)
    {
        $pj = $this->Project->findById($pj_id);
        $this->Project->add_backed_to_project(null, $pj, $mode = 'not add');
        $bls = $this->BackingLevel->findAllByProjectId($pj_id);
        $this->Project->id = $pj_id;
        $this->Project->saveField('max_back_level', count($bls));

        $bl = $this->BackingLevel->findById($bl_id);
        $this->BackingLevel->put_backing_level_now_count($bl, $mode = 'not add');
    }

    /**
     * 成功したプロジェクトの支援者一覧をCSVダウンロードする
     */
    public function admin_csv_backers($project_id)
    {
        $project = $this->Project->findById($project_id);
        if(!$project) $this->redict('/');
        $backers = $this->Project->BackedProject->get_backers_of_project($project_id, 'all', 10000);
        $this->layout = false;
        $filename = $project['Project']['project_name'].'支援者一覧_'.date('Ymd');
        if($project['Project']['pay_pattern'] == MONTHLY){
            $th = array(
                '支援日', '支援方法', '決済ID', '決済の状態', '支援金額',
                '前回課金日', '前回課金結果', '次回課金日', 'ユーザ名', '氏名',
                'メールアドレス', '住所', '支援パターン', 'リターン内容', '支援コメント'
            );
        }else{
            $th = array(
                '支援日', '支援方法', '決済ID', '決済の状態', '支援金額',
                 'ユーザ名', '氏名', 'メールアドレス', '住所', '支援パターン',
                'リターン内容', '支援コメント'
            );
        }
        $this->set(compact('filename', 'th', 'backers', 'project'));
        $this->set('statuses', Configure::read('STATUSES'));
        $this->set('charge_results', Configure::read('CHARGE_RESULTS'));
    }
    
    /**
     * 成功したプロジェクトの明細をダウンロードする
     */
    public function admin_pdf_statement($project_id)
    {
        $project = $this->Project->findById($project_id);
        if(!$project) $this->redict('/');
        $statement = $this->Project
        $this->layout = false;
        $filename = $project['Project']['project_name'].'プロジェクト明細_'.date('Ymd');
        $th = array('ニックネーム', 'プロジェクト名', '支援者数', '総支援額', '手数料','振込金額');
        $this->set('statuses', Configure::read('STATUSES'));
        $this->set('charge_results', Configure::read('CHARGE_RESULTS'));
    }

    /**
     * 月額課金型PJの課金を終了する
     *  - backed_projectsのstatusをキャンセルにする
     *  - GMOのキャンセルはCRONで対応する
     *  - projectsのactiveもnoにする
     */
    public function admin_stop_monthly_service($pj_id)
    {
        if(!$this->request->is('post')) $this->redirect('/');
        $pj = $this->Project->findById($pj_id);
        if(empty($pj) ||
           $pj['Project']['pay_pattern'] != MONTHLY ||
           $pj['Project']['active'] != 1)
        {
            $this->redirect(array('action' => 'open_projects'));
        }
        $this->Project->begin();
        if($this->Project->BackedProject->stop_all_for_monthly($pj_id)){
            $this->Project->id = $pj_id;
            if($this->Project->saveField('active', 0)){
                $this->Session->setFlash('プロジェクトの課金を停止しました');
                $this->Project->commit();
            }
        }else{
            $this->Session->setFlash('プロジェクトの課金の停止に失敗しました。');
            $this->Project->rollback();
        }
        $this->redirect(array('action' => 'open_projects'));
    }


}
