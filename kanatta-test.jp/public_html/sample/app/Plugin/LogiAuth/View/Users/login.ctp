<?php if(empty($setting)){
    echo $this->Html->css('admin/fundee_login', null, array('inline' => false));
}else{
    echo $this->Html->css('login', null, array('inline' => false));
} ?>

<div class="login_box_wrap">
    <div class="login_box clearfix">
        <h3>ログイン</h3>
        <?php echo $this->Form->create('User', array(
                'inputDefaults' => array(
                        'label' => false, 'div' => false, 'class' => 'form-control'
                )
        )) ?>
        <div class="form-group clearfix">
            <div class="col-sm-offset-1 col-sm-10">
                <?php echo $this->Form->input('email', array(
                        'placeholder' => 'メールアドレス', 'value' => ''
                )) ?>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-sm-offset-1 col-sm-10">
                <?php echo $this->Form->input('password', array(
                        'placeholder' => 'パスワード', 'value' => ''
                )) ?>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-sm-offset-2 col-sm-8 clearfix">
                <?php echo $this->Form->submit('ログイン', array('class' => 'btn btn-success form-control')) ?>
            </div>
        </div>
        <p class="forgot_pass">
            <?php echo $this->Html->link('パスワードを忘れた方', '/forgot_pass') ?><br>
            <?php echo $this->Html->link('まだアカウントをお持ちでない方', '/mail_auth') ?>
        </p>
        <?php echo $this->Form->end() ?>

        <hr>

        <div class="col-sm-offset-1 col-sm-10 clearfix">

            <?php if(!empty($facebook_login_url)): ?>
                <div class="clearfix" style="margin-bottom:30px;">
                    <?php echo $this->Html->link(__('<span class="el-icon-facebook"></span> Facebookでログイン'), $facebook_login_url, array(
                            'escape' => false, 'class' => 'btn btn-primary btn-block'
                    )); ?>
                </div>
            <?php endif ?>

            <div class="clearfix">
                <a href="<?php echo $this->Html->url('/tw_login') ?>" class="btn btn-info btn-block">
                    <span class="el-icon-twitter"></span>
                    Twitterでログイン
                </a>
            </div>
        </div>
    </div>
</div>




