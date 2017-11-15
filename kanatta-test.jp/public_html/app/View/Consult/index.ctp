<?php echo $this->Html->css('login', null, array('inline' => false))?>

<div class="login_box_wrap">
    <div class="login_box">
        <h3>相談役に依頼する</h3>

        <?php echo $this->Form->create('Consult', array(
                'inputDefaults' => array('div' => false, 'class' => 'form-control')
        )) ?>
        <div class="clearfix">
            <div class="form-group required">
                <?php echo $this->Form->input('name', array(
                    'label' => 'お名前',
                    'example' => '例）叶 かなこ'
                )) ?>
            </div>
            <div class="form-group required">
                <?php echo $this->Form->input('mail', array(
                    'label' => 'メールアドレス',
                    'example' => '例）ladys@kanatta-lady.jp'
                )) ?>
            </div>
            <div class="form-group required">
                <?php echo $this->Form->input('phone', array(
                    'label' => '電話番号(ハイフンなし)',
                    'example' => '例）0368683910'
                )) ?>
            </div>
            <div class="form-group required">
                <?php echo $this->Form->input('overview', array(
                    'type' => 'textarea', 'label' => 'プロジェクト概要（いつ・どこで・だれが・何をするのか）',
                    'example' => '例）今年7月の一般販売を目指して、弊社の看板商品であるiPhone用スピーカーの最新型を現在開発中です。スピーカーはシルバーとゴールドの2色を展開予定です。'
                )) ?>
            </div>
            <div class="form-group required">
                <?php echo $this->Form->input('content', array(
                    'type' => 'textarea', 'label' => 'ご相談内容',
                    'example' => '例）2色のうち、どちらのモデルがより人気があるか発売前に把握したいのですが、テストマーケティングを目的としたクラウドファンディングの利用は可能でしょうか。'
                )) ?>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-10">
                    <?php echo $this->Form->submit('送信', array('class' => 'btn btn-success btn-block')) ?>
                </div>
            </div>
        </div>

        <?php echo $this->Form->end() ?>
    </div>
</div>

