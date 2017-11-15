<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ConsultController extends AppController
{
    public $uses = array('Consult');
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
     * コンサルトフォームページ
     */
    public function index()
    {
        $this->set('title', '相談役に依頼する');
        if($this->request->is('post') || $this->request->is('put')){
            $this->Consult->set($this->request->data);
            if($this->Consult->validates()){
                if($this->sendmail($this->request->data)){
                    $this->Session->setFlash('ご相談を受け付けました。ご返信まで今しばらくお待ちください。');
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
        if($this->Mail->consult($data, 'admin')){
            if($this->Mail->consult($data, 'user')){
                return true;
            }
        }
        return false;
    }

}