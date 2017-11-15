<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ContactController extends AppController
{
    public $uses = array('Contact');
    public $components = array('Mail');

    /**
     * アクセス許可設定
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'confirm', 'complete');
        $this->Security->validatePost = false;
        $this->Security->csrfUseOnce  = false;
        //Boxの背景グレーバージョン
        $this->set('login_page', 1);
    }

    /**
     * コンタクトフォームページ
     */
    public function index()
    {
        $this->set('title', 'お問合せ');
        if($this->request->is('post') || $this->request->is('put')){
            $this->Contact->set($this->request->data);
            if($this->Contact->validates()){
                if($this->sendmail($this->request->data)){
                    $this->Session->setFlash('お問合わせを受け付けました。ご返信まで今しばらくお待ちください。');
                    $this->redirect(array('action' => 'index'));
                    return true;
                }else{
                    $this->Session->setFlash('メールが送信できませんでした。'.OSORE);
                    return false;
                }
            }else{
                $this->Session->setFlash('メールが送信できませんでした。'.OSORE);
                return false;
            }
        }
    }

    /**
     * メール送信関数
     * @param Array $data
     * @return boolean
     */
    private function sendmail($data)
    {
        if($this->Mail->contact($data, 'admin')){
            if($this->Mail->contact($data, 'user')){
                return true;
            }
        }
        return false;
    }

}