<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->Html->script('client_resize', array('inline' => false)) ?>
<?php echo $this->Html->script('jquery-ui.min', array('inline' => false)) ?>
<?php echo $this->Html->script('pj_contents', array('inline' => false)) ?>

<div class="progressbar">
    <ul>
        <li class="active">プロジェクト作成</li>
        <li>支援パターン追加</li>
        <li>確認</li>
        <li>完了</li>
    </ul>
</div>

<h4>プロジェクト作成</h4>

<p style="text-align:center;">作成したいプロジェクトの概要を入力してください。<br>確認の上、担当から連絡させていただきます。</p>

<div class="content clearfix">
    <div class="project_box img-rounded">
        <?php echo $this->Form->create('Project', array(
            'type'          => 'file',
            'inputDefaults' => array('class' => 'form-control'),
        )); ?>
        <div class="clearfix">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $this->Form->input('project_name', array('label' => 'プロジェクト名 <span class="label label-danger">必須</span>')) ?>
                    <div class="error-message" id="error-project_name"></div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('pic', array(
                            'type' => 'file', 'class' => 'client_resize', 'label' => '画像 <span class="label label-danger">必須</span>',
                            'onchange' => "client_resize($(this), event, 750, 500, 'preview_pic', 'pic');"
                    )); ?>

                    <div id="preview_pic" style="max-width:400px; margin-top:10px; margin:0 auto; ">
                       <?php if (!empty($this->request->data['Project']['pic'])): ?>
                           <?php echo $this->Label->image($this->request->data['Project']['pic'], array(
                                'style' => 'width: 90%;'
                            )); ?>
                       <?php endif; ?>
                    </div>

                    <div class="error-message" id="error-pic"></div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('category_id', array('label' => $setting['cat1_name'].' <span class="label label-danger">必須</span>')); ?>
                    <div class="error-message" id="error-category"></div>
                </div>
                <?php if($setting['cat_type_num'] == 2):?>
                    <div class="form-group">
                        <?php echo $this->Form->input('area_id', array('label' => $setting['cat2_name'].' <span class="label label-danger">必須</span>')); ?>
                        <div class="error-message" id="error-area"></div>
                    </div>
                <?php endif;?>
                <div class="form-group">
                    <?php echo $this->Form->input('pay_pattern', array(
                        'label' => '決済パターン <span class="label label-danger">必須</span>', 'type' => 'select', 'options' => Configure::read('PAY_PATTERN'))); ?>
                    <div class="error-message" id="error-pay_pattern"></div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('goal_amount', array('label' => '目標金額')); ?>
                    ※決済パターンがAll or Nothingか、All Inの場合は必須入力<br>
                    ※カンマなし
                    <div class="error-message" id="error-goal_amount"></div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('goal_backers', array('label' => '目標人数')); ?>
                    ※決済パターンが月額課金の場合は必須入力
                    <div class="error-message" id="error-goal_backers"></div>
                </div>

                <div class="form-group">
                    <?php echo $this->Form->input('contact', array(
                            'type' => 'textarea', 'rows' => 5, 'label' => '連絡先 <span class="label label-danger">必須</span>'
                    )) ?>
                    <div class="error-message" id="error-contact"></div>
                </div>
            </div>
        </div>

        <!-- プロジェクト詳細 -->
        <div class="col-md-12">
            <label>プロジェクト詳細</label>
            <?php echo $this->element('project_contents/text_btn_menu') ?>
            <div class="form-group">
                <?php echo $this->Form->hidden('ProjectContent.0.type', array('value' => 'text')); ?>
                <?php echo $this->Form->input('ProjectContent.0.txt_content', array(
                    'type' => 'textarea', 'rows' => 5, 'label' => false, 'class' => 'form-control text_content',
                )) ?>
                <div class="error-message" id="error-contact"></div>
            </div>
            <div class="form-group" style="margin-left:20px;">
                <div class="checkbox">
                    <?php echo $this->Form->input('rule', array(
                        'type' => 'checkbox', 'label' => false, 'class' => '', 'div' => false,
                    )) ?>
                    <?php echo $this->Html->link('規約', '/rule', array('target' => '_blank')) ?>に同意する <span class="label label-danger">必須</span><br>
                    <div class="error-message" id="error-rule"></div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-8 col-md-offset-2" style="margin-top:20px;">
            <input type="submit"
                onclick="save_form_data_redirect($(this), event, '<?php echo $this->Html->url(array('action' => 'add')) ?>', '<?php echo $this->Html->url(array('action' => 'add_return')) ?>', 1); return false;"
                class="btn btn-primary btn-block" value="次へ">
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>