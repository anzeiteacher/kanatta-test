<?php echo $this->Html->css('pay', null, array('inline' => false)) ?>

<?php echo $this->element('pay/pay_header') ?>

<div class="pay clearfix">

    <div class="pay_content">
        <?php if(!empty($card_no)):?>
            <h3>支援内容を確認して、支援確定ボタンを押すと決済が確定します。</h3>
        <?php else:?>
            <h3>支援内容を確認して、クレジットカード情報を入力してください！<br>支援確定ボタンを押すと決済が確定します。</h3>
        <?php endif;?>

        <div class="col-md-5">
            <h4>支援金額</h4>
            <div class="confirm_box">
			<span style="font-size:20px; font-weight:bold;">
				<?php echo number_format(h($backed_project['amount'])) ?> 円
                <?php if($pay_pattern == MONTHLY) echo '／月'?>
			</span>
            </div>

            <h4>支援コメント</h4>
            <div class="confirm_box">
                <?php echo !empty($backed_project['comment']) ? nl2br(h($backed_project['comment'])) : '入力なし' ?>
            </div>
            <hr>

            <h4>リターン内容</h4>
            <div class="pay_return">
                <?php echo nl2br($backing_level['BackingLevel']['return_amount']); ?>
            </div>
            <br>
        </div>

        <div class="col-md-7">
            <?php if(!empty($card_no)):?>
            <div class="now_card_box clearfix">
                <h3><span class="el-icon-credit-card"></span> 登録しているカードを使う</h3>
                <p>登録済みの下記カードを使って決済を確定します。</p>
                <div class="greenbox"><?php echo h($card_no)?></div>
                <?php echo $this->Form->create('Card', array())?>
                <?php echo $this->Form->hidden('now_card', array('value' => 1))?>
                <div class="col-sm-offset-2 col-sm-8" style="margin-top:20px;">
                    <?php echo $this->Form->submit('支援確定！', array('class' => 'btn btn-success btn-block now_card_btn')) ?>
                </div>
                <?php echo $this->Form->end()?>
            </div>
            <?php endif;?>

            <div class="card_input_box clearfix">
                <?php if(!empty($card_no)):?>
                    <h3><span class="el-icon-credit-card"></span> 別のカードを使う</h3>
                <?php else:?>
                    <h3><span class="el-icon-credit-card"></span> クレジットカード情報入力</h3>
                <?php endif;?>

                <p>クレジットカードはVISA、Masterがお使いいただけます。</p>
                <?php if(!empty($error)): ?>
                    <div class="error-message" style="padding:10px 0; font-weight:bold;">
                        <?php foreach($error as $e): ?>
                            エラー： <?php echo $e.'<br>' ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php echo $this->Form->create('BackedProject', array(
                    'inputDefaults' => array(
                        'div' => false, 'class' => 'form-control', 'label' => false
                    )
                ))?>

                <div class="form-group clearfix">
                    <label>カード番号<?php echo $this->Html->image('visa_master.png', array('height' => 20)) ?></label>
                    <?php echo $this->Form->input('card_no', array('type' => 'text', 'required' => true))?>
                </div>
                <div class="form-group clearfix">
                    <label>有効期限</label><br>
                    <?php echo $this->Form->input('month', array(
                            'type' => 'select', 'class' => '', 'options' => $this->Card->expiration_month()
                    )) ?> 月
                    ／
                    <?php echo $this->Form->input('year', array(
                            'type' => 'select', 'class' => '', 'options' => $this->Card->expiration_year()
                    )) ?> 年
                </div>
                <div class="form-group clearfix">
                    <label>セキュリティコード</label>
                    <div style="width: 50%;">
                        <?php echo $this->Form->input('code', array('type' => 'text', 'required' => true))?>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-sm-offset-2 col-sm-8" style="margin-top:20px;">
                        <?php echo $this->Form->submit('支援確定！', array('class' => 'btn btn-primary btn-block card_btn')) ?>
                    </div>
                </div>

                <?php echo $this->Form->end() ?>
            </div>
        </div>

    </div>
</div>
