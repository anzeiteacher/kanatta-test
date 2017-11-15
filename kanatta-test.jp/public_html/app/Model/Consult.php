<?php
App::uses('AppModel', 'Model');

class Consult extends AppModel
{
    public $useTable = false;
    public $validate = array(
        'name' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '名前を入力してください。',
                'allowEmpty' => false,
                'required' => true
            ),
        ),
        'mail' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => 'メールアドレスを入力してください。',
                'allowEmpty' => false,
                'required' => true
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => '正しいメールアドレスを入力してください。'
            )
        ),
        'phone' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '電話番号を入力してください。',
                'allowEmpty' => false,
                'required' => true
            ),
        ),
        'overview' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => 'プロジェクトの概要を入力してください。',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'content' => array(
            'notblank' => array(
                'rule' => array('notblank'),
                'message' => '相談内容を入力してください。',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
    );
}