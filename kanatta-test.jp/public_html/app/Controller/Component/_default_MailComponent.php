<?php
App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Class MailComponent
 * Mail共有コンポーネント
 */
class MailComponent extends Component
{
    public $setting = null;
    public function __construct($collection, $settings = array())
    {
        parent::__construct($collection, $settings);
        if(!empty($settings)){
            $this->setting = $settings;
        }
    }

    public function startup(Controller $controller)
    {
        $this->controller = $controller;
        if(!empty($this->controller->setting)){
            $this->setting = $this->controller->setting;
        }
    }

    /**
     * お問い合わせメール 送信関数
     */
    public function contact($data, $type)
    {
        return $this->mail('contact', compact('data'), $type, $data['Contact']['mail']);
    }

    /**
     * メール作成送信関数
     * @param string $template  メールテンプレート名（定数、フィールド名も同じ）小文字
     * @param array  $vars      (viewに渡す変数)
     * @param string $mail_type ('admin' or 'user')
     * @param string $email     ('typeがadminの場合不要')
     * @return bool
     */
    public function mail($template, $vars, $mail_type, $email = null)
    {
        if($this->setting){
            $from    = $this->setting['from_mail_address'];
            $subject = $this->setting['site_name'].' - '.constant(strtoupper($template).'_SUBJECT');
            if($mail_type == 'admin'){
                $email   = $this->setting['admin_mail_address'];
                $subject = '[管理] '.$subject;
            }
            $vars['setting'] = $this->setting;
            if($this->send_mail($email, $template, $from, $subject, $vars)){
                return true;
            }
        }
        return false;
    }

    /**
     * メール送信関数
     */
    public function send_mail($email, $template, $from, $subject, $viewVars)
    {
        Configure::write('debug', 0);
        try{ //ユーザ向け
            $Email = new CakeEmail();
            $Email->to($email);
            $Email->template($template);
            $Email->from($from);
            $Email->subject($subject);
            $Email->viewVars($viewVars);
            $Email->send();
        }catch(Exception $e){
            $this->log('error : send_mail');
            $this->log($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * メールアドレス認証用メール 送信関数
     */
    public function confirm_mail_address($email, $url)
    {
        return $this->mail('confirm_mail_address', compact('url'), 'user', $email);
    }

    /**
     * ユーザ登録完了メール　送信関数
     */
    public function registered($user, $type)
    {
        return $this->mail('registered', compact('user'), $type, $user['User']['email']);
    }

    /**
     * パスワード忘れメール　送信関数
     */
    public function forgot_pass($user, $url)
    {
        return $this->mail('forgot_pass', compact('user', 'url'), 'user', $user['User']['email']);
    }

    /**
     * アカウントロック解除メール　送信関数
     */
    public function reset_lock($email, $url)
    {
        return $this->mail('reset_lock', compact('email', 'url'), 'user', $email);
    }

    /**
     * パスワード再設定完了メール　送信関数
     */
    public function reset_pass_complete($user)
    {
        return $this->mail('reset_pass_complete', compact('user'), 'user', $user['User']['email']);
    }

    /**
     * 支援完了メール（管理者・プロジェクトオーナー向け）　送信関数
     */
    public function back_complete_owner($owner, $backer, $project, $backed_project, $type)
    {
        return $this->mail('back_complete_owner', compact('owner', 'backer', 'project', 'backed_project'), $type, $owner['User']['email']);
    }

    /**
     * 支援完了メール（支援者向け）　送信関数
     */
    public function back_complete_backer($backer, $project, $backed_project)
    {
        return $this->mail('back_complete_backer', compact('backer', 'project', 'backed_project'), 'user', $backer['User']['email']);
    }

    /**
     * メッセージ送信通知関数
     */
    public function messaged($to_user, $from_user, $msg, $url)
    {
        return $this->mail('messaged', compact('to_user', 'from_user', 'msg', 'url'), 'user', $to_user['email']);
    }

    /**
     * プロジェクト作成申し込み通知
     */
    public function pj_create($user, $pj, $type)
    {
        return $this->mail('pj_create', compact('user', 'pj'), $type, $user['User']['email']);
    }

    /**
     * 活動報告投稿通知メール
     */
    public function create_report($user, $pj, $report, $url)
    {
        return $this->mail('create_report', compact('user', 'pj', 'report', 'url'), 'user', $user['User']['email']);
    }

    /**
     * All or Nothingの決済確定通知メール（支援者向け）
     */
    public function exec_complete($pj, $bp, $user)
    {
        return $this->mail('exec_complete', compact('pj', 'bp', 'user'), 'user', $user['User']['email']);
    }

    /**
     * All or Nothingの決済キャンセル通知メール（支援者向け）
     */
    public function cancel_complete($pj, $bp, $user)
    {
        return $this->mail('cancel_complete', compact('pj', 'bp', 'user'), 'user', $user['User']['email']);
    }

    /**
     * All or Nothingのプロジェクト終了通知メール（PJオーナー・管理者向け）
     */
    public function project_fin($pj ,$user, $ok_ng, $type)
    {
        return $this->mail('project_fin', compact('pj', 'user', 'ok_ng'), $type, $user['User']['email']);
    }

    /**
     * 月額課金成功通知メール（支援者向け）
     */
    public function success_monthly_charge($backer, $pj, $result)
    {
        return $this->mail('success_monthly_charge', compact('backer', 'pj', 'result'), 'user', $backer['email']);
    }

    /**
     * 月額課金失敗通知メール（オーナー・管理者向け）
     */
    public function fail_monthly_charge_owner($backer, $owner, $pj, $result, $type)
    {
        return $this->mail('fail_monthly_charge_owner', compact('backer', 'owner', 'pj', 'result'), $type, $owner['email']);
    }

    /**
     * 月額課金失敗通知メール（支援者向け）
     */
    public function fail_monthly_charge_backer($backer, $pj, $result)
    {
        return $this->mail('fail_monthly_charge_backer', compact('backer', 'pj', 'result'), 'user', $backer['email']);
    }

    /**
     * 月額課金PJ 途中キャンセル通知メール（オーナー・管理者向け）
     */
    public function cancel_monthly($bp, $pj, $user, $type)
    {
        return $this->mail('cancel_monthly', compact('bp', 'pj', 'user'), $type, $user['email']);
    }

}