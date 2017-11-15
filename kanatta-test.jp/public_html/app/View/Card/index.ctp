<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->element('card/mypage_menu', array('mode' => 'card'))?>
<h4><span class="el-icon-credit-card"></span> クレジットカードの登録</h4>

<div class="container card">
    <div class="col-md-4">
        <h5>登録済みカード</h5>
        <?php if(!empty($err['get_card_err'])):?>
            <div class="redbox">
                <p class="error-message"><?php echo h($err['get_card_err'])?></p>
            </div>
        <?php elseif(!empty($card_no)):?>
            下記のカードが登録されています。
            <div class="bluebox">
                <?php echo h($card_no)?>
            </div>
            <?php
            echo $this->Form->postLink(
                '<button class="btn btn-danger">カードを削除する</button>',
                '/card/delete',
                array('class' => '', 'escape' => false),
                '削除しますか？'
            );
            ?>
        <?php else:?>
            <div class="redbox">
                まだカードは登録されていません。
            </div>
        <?php endif;?>
    </div>
    <div class="col-md-8">
        <h5>新しくカードを登録する</h5>
        <p>クレジットカードはVISA、Masterがお使いいただけます。</p>
        <?php echo $this->Form->create('Card', array(
            'inputDefaults' => array('div' => false, 'class' => 'form-control', 'label' => false)
        )) ?>

        <div class="form-group clearfix">
            <label>カード番号<?php echo $this->Html->image('visa_master.png', array('height' => 20)) ?></label>
            <?php echo $this->Form->input('card_no', array('type' => 'text', 'required' => true))?>
            <?php if(!empty($err['card_no'])):?>
                <p class="error-message"><?php echo h($err['card_no'])?></p>
            <?php endif;?>
        </div>
        <div class="form-group clearfix">
            <label>有効期限</label><br>
            <?php echo $this->Form->input('month', array(
                'type' => 'select', 'class' => '', 'options' => $this->Card->expiration_month()
            ))?> 月
            ／
            <?php echo $this->Form->input('year', array(
                'type' => 'select', 'class' => '', 'options' => $this->Card->expiration_year()
            ))?> 年
            <?php if(!empty($err['expire'])):?>
                <p class="error-message"><?php echo h($err['expire'])?></p>
            <?php endif;?>
        </div>

        <div class="form-group clearfix">
            <div class="col-sm-offset-2 col-sm-8" style="margin-top:20px;">
                <?php $btn_str = !empty($card_no) ? 'カードを変更する' : 'カードを登録する'?>
                <?php echo $this->Form->submit($btn_str, array('class' => 'btn btn-primary btn-block card_button')) ?>
            </div>
        </div>
        <?php echo $this->Form->end()?>
    </div>
</div>