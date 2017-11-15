<?php echo $this->Html->css('pay', null, array('inline' => false)) ?>

<?php echo $this->element('pay/pay_header') ?>

<div class="pay add">

    <div class="pay_content clearfix">
        <?php if($this->Project->chk_pay_monthly($pj)):?>
            <h3>応援コメントを入力してください</h3>
        <?php else:?>
            <h3>リターンをお選びください</h3>
        <?php endif;?>

        <?php echo $this->Form->create('BackedProject', array(
                'inputDefaults' => array(
                        'div' => false, 'class' => 'form-control'
                )
        )) ?>
        <?php if($this->Project->chk_pay_monthly($pj)):?>
        <?php else:?>
        	<div class="form-group">
            <label>リターンを選ぶ</label>
        	</div>
        <?php endif;?>

        <?php if($this->Project->chk_pay_monthly($pj)):?>
            <div class="form-group">
            <label>支援額を入力してください</label>
                    <br>
                    <h4>
                        <?php echo number_format(h($backing_level['BackingLevel']['invest_amount']))?>円／月
                    </h4>
            </div>
        <?php else:?>
            <div class="form-group">
                <label>支援額を入力してください</label>
                <div class="input-group">
                    <?php echo $this->Form->input('invest_amount', array(
                            'value' => $backing_level['BackingLevel']['invest_amount'], 'label' => false,
                    )) ?>
                    <span class="input-group-addon">円</span>
                </div>

                <span class="<?php echo !empty($error) ? 'error-message' : '' ?>">
                ※ <?php echo number_format($backing_level['BackingLevel']['invest_amount']) ?>
                    円以上を入力してください
                </span>
                <p style="margin-top:15px;,color:red;,font-weight:bolder;">上乗せ支援をしてもリターンの内容には変更はありません。</p>
            </div>
        <?php endif;?>

        <div class="form-group">
            <?php echo $this->Form->input('comment', array(
                    'type' => 'textarea', 'rows' => 4, 'label' => '応援コメント'
            )) ?>
        </div>

        <?php if($backing_level['BackingLevel']['delivery'] == 2): ?>
            <div class="form-group">
                <?php echo $this->Form->input('User.name', array('label' => '氏名'))?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->input('User.receive_address', array(
                        'type' => 'textarea', 'rows' => 4, 'label' => 'リターン配送先住所',
                )) ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8" style="margin-top:20px;">
                <?php echo $this->Form->submit('次へ', array('class' => 'btn btn-success btn-block')) ?>
            </div>
        </div>

        <?php echo $this->Form->end() ?>
    </div>
</div>
