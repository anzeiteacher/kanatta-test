<?php
App::uses('AppController', 'Controller');

class CategoriesController extends AppController
{
    public $uses = array(
        'Category', 'Project', 'Area'
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'c2');
    }

    public function index($id)
    {
        $category = $this->Category->findById($id);
        if(empty($category)) $this->redirect('/');
        $this->set('category_name', $category['Category']['name']);
        $this->paginate = $this->Project->search_projects($id, null, null, null,  null, 30);
        $this->set('projects', $this->paginate('Project'));
    }

    /**
     * 特定のカテゴリ2に該当するPJ一覧画面
     */
    public function c2($id)
    {
        $category = $this->Area->findById($id);
        if(empty($category)) $this->redirect('/');
        $this->set('category_name', $category['Area']['name']);
        $this->paginate = $this->Project->search_projects(null, $id, null, null,  null, 30);
        $this->set('projects', $this->paginate('Project'));
    }

}
