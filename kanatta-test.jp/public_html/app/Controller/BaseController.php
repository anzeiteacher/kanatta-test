<?php
App::uses('AppController', 'Controller');
App::uses('Cache', 'Cache');

class BaseController extends AppController
{
    public $helpers = array('Setting');
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('index'));
        $this->Project = ClassRegistry::init('Project');
        $this->Report = ClassRegistry::init('Report');
    }

    /**
     * トップページ
     */
    public function index()
    {
        $pj_limit = 15; //おすすめ表示数
        $pickup_id = $this->setting['toppage_pickup_project_id'];
        $this->_set_pickup_pj($pickup_id);
        list($high_pjs, $high_ids) = $this->_get_high_priority_pj($pickup_id, $pj_limit);
        $this->_set_toppage_pjs($pickup_id, $high_ids, $high_pjs, $pj_limit);
        $this->_set_reports();
        $this->_set_pjs_by_categories();
        $this->set('top_title', $this->setting['site_title']);
        $this->set('description', $this->setting['site_description']);
        $this->render('crowd_top', 'default_top');
    }

    /**
     * ピックアッププロジェクトの取得
     * @param $pickup_id
     */
    private function _set_pickup_pj($pickup_id)
    {
        $pickup_pj = $this->Project->get_pickup_pj($pickup_id);
        if(!empty($pickup_pj)){
            $this->set(compact('pickup_pj'));
        }
    }

    /**
     * 優先プロジェクトの取得
     * @param $pickup_id
     * @return array
     */
    private function _get_high_priority_pj($pickup_id, $limit)
    {
        $high_ids = $this->setting['toppage_projects_ids'];
        $high_ids = json_decode($high_ids, true);
        $high_pjs = null;
        if(!empty($high_ids)){
            $high_pjs = $this->Project->get_high_priority_pj($high_ids, $pickup_id, $limit);
        }
        return array($high_pjs, $high_ids);
    }

    /**
     * 当該サイトのプロジェクト一覧の取得
     * @param $pickup_id
     * @param $high_ids
     * @param $high_pjs
     * @return array
     */
    private function _set_toppage_pjs($pickup_id, $high_ids, $high_pjs, $limit)
    {
        $pjs = $this->Project->get_toppage_pj($pickup_id, $high_ids, $limit);
        if(!empty($high_ids)){
            $pjs = array_merge($high_pjs, $pjs);
        }
        $this->set(compact('pjs'));
    }

    /**
     * カテゴリ毎のプロジェクト一覧の取得
     */
    private function _set_pjs_by_categories()
    {
        $pjs_by_cat = $this->Project->get_toppage_pj_by_cat(10);
        $this->set(compact('pjs_by_cat'));
        $this->set('categories', $this->Project->Category->find('list'));
    }

    /**
     * 活動報告の取得
     */
    private function _set_reports()
    {
        $reports = $this->Report->get_new_reports_in_site($this->setting['id']);
        $this->set(compact('reports'));
    }



}
