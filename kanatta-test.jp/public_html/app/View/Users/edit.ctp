<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->Html->script('client_resize', array('inline' => false)) ?>

<?php echo $this->element('user/mypage_menu', array('mode' => 'profile'))?>

<h4><span class="el-icon-user"></span> プロフィール編集</h4>

<div class="content clearfix">
    <div class="row">
        <?php echo $this->Form->create('User', array(
                'type' => 'file', 'inputDefaults' => array(
                        'class' => 'form-control', 'div' => false
                )
        )); ?>
        <div class="col-md-6">

            <div class="form-group">
                <?php echo $this->Form->input('img', array(
                        'type' => 'file', 'label' => 'プロフィール画像', 'class' => 'client_resize',
                        'onchange' => "client_resize($(this), event, 400, 400, 'preview_img', 'img');"
                )); ?>
                <br>
                <div style="text-align: center;" id="preview_img">
                    <?php echo $this->User->get_user_img($auth_user) ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('nick_name', array('label' => 'ニックネーム')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('name', array('label' => '氏名')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('email', array('label' => 'メールアドレス')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('address', array('label' => '住まい')); ?>
            </div>
            <?php if($this->Setting->can_d_area($setting)):?>
            <div class="form-group">
                <?php echo $this->Form->input('birth_area', array('label' => '出身地', 'type' => 'select', 'options' => configure::read('PREFECTURES'), 'empty' => '-----')); ?>
            </div>
            <?php endif;?>
            <?php if($this->Setting->can_d_school($setting)):?>
            <div class="form-group">
                <?php echo $this->Form->input('school', array('label' => '出身校')); ?>
            </div>
            <?php endif;?>
            <div class="form-group">
                <?php echo $this->Form->input('self_description', array('label' => '自己紹介')); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php echo $this->Form->input('url1', array('label' => 'URL1')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('url2', array('label' => 'URL2')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('url3', array('label' => 'URL3')); ?>
            </div>

            <div class="form-group">
                <?php echo $this->Form->input('receive_address', array('label' => 'リターン先住所')); ?>
            </div>
            <hr>
            <h3>プロジェクトオーナー様向け</h3>
            <p>公開したプロジェクトのプロジェクト詳細にツイッターのタイムライン、ご自分のFacebookへのリンクを掲載したい場合は、
            Twitterのスクリーンネームと、Facebookのユーザネームを登録してください。</p>
            <div class="form-group">
                <?php echo $this->Form->input('tw_screen_name', array('label' => 'Twitterタイムライン表示')); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('fb_name', array('label' => 'Facebookリンク表示')); ?>
            </div>
        </div>
        <div class="col-xs-6 col-xs-offset-3">
            <br>
            <input type="submit"
                   onclick="save_form_data($(this), event, '<?php echo $this->Html->url(array('action' => 'edit')) ?>'); return false;"
                   class="btn btn-primary btn-block" value="更新">
            <br>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

    <hr>
    <div class="col-xs-6 col-xs-offset-3">
        <br>
        <?php
        echo $this->Form->postLink('<button class="btn btn-danger btn-block">退会</button>', '/users/delete/'
                                                                                           .$auth_user['User']['id'], array(
                'class' => '', 'escape' => false
        ), '本当に退会しますか？');
        ?>
        <br>
    </div>


</div>

