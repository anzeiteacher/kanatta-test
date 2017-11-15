<?php
App::uses('AppModel', 'Model');

class Category extends AppModel
{
    public $displayField = 'name';
    public $validate = array('name' => array('notblank' => array('rule' => array('notblank')),),);
    public $hasMany = array(
        'Project' => array(
            'className' => 'Project', 'foreignKey' => 'category_id', 'dependent' => false, 'conditions' => '',
            'fields' => '', 'order' => '', 'limit' => '', 'offset' => '', 'exclusive' => '',
            'finderQuery' => '', 'counterQuery' => ''
        )
    );

    /**
     * カテゴリーの取得
     */
    public function get_categories()
    {
        $options = array('order' => array('Category.order' => 'ASC'));
        return $this->find('all', $options);
    }

    /**
     * カテゴリーリストの取得
     */
    public function get_list()
    {
        $options = array('order' => array('Category.order' => 'ASC'));
        return $this->find('list', $options);
    }

    /**
     * カテゴリーの利用チェック
     * プロジェクトで既に登録されているかチェック
     * 登録されている場合は、Trueを返す
     */
    public function use_check($category_id)
    {
        $Project = ClassRegistry::init('Project');
        if($Project->findByCategoryId($category_id)){
            return true;
        }
        return false;
    }

}
