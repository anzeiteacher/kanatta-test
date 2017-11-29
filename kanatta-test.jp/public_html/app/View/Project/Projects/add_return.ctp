<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>

<h4>支援パターンの追加</h4>

<p style="text-align:center;">プロジェクトを公開後に支援パターンの編集はできません。追加はできます。</p>

<?php echo $this->Form->create('Project', array(
    'inputDefaults' => array(
        'class' => 'form-control', 'div' => false
    )
)); ?>

<div class="max_backing_level_num">
    <div class="container">
        <div class="form-group">
            <?php echo $this->Form->input('Project.max_back_level', array(
                'id' => 'back_level', 'type' => 'hidden', 'default' => !empty($project['Project']['max_back_level']) ? $project['Project']['max_back_level'] : 0,
            )); ?>
        </div>
    </div>
</div>

<div class="container">
    <div id="blevel" class="clearfix">
        <?php if (isset($this->request->data['BackingLevel'])): ?>
            <?php $i = 0; ?>

            <?php foreach($this->request->data['BackingLevel'] as $level): ?>
                <div class="levels clearfix" index="<?php echo $i + 1; ?>">
                    <h4>支援パターン<?php echo $i + 1; ?></h4>
                    <br>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $this->Form->input('BackingLevel.'.($i).'.id', array('type' => 'hidden')); ?>
                            <?php echo $this->Form->input('BackingLevel.'.($i).'.name', array('type' => 'hidden')); ?>

                            <label>最低支援額</label>
                            <div class="input-group">
                                <?php echo $this->Form->input('BackingLevel.'.($i).'.invest_amount', array('disabled' => $disabled, 'label' => false)); ?>
                                <span class="input-group-addon">円</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>最大支援回数</label>
                            <div class="input-group">
                                <?php echo $this->Form->input('BackingLevel.'.($i).'.max_count', array('disabled' => $disabled, 'label' => false)) ?>
                                <span class="input-group-addon">回</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>リターン受け渡し手段</label>
                            <?php echo $this->Form->input('BackingLevel.'.($i).'.delivery', array(
                                'disabled' => $disabled, 'label' => false, 'type' => 'select', 'options' => Configure::read('DELIVERY')
                            )) ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <?php echo $this->Form->input('BackingLevel.'.($i).'.return_amount', array(
                                'type' => 'textarea', 'disabled' => $disabled, 'label' => 'リターン内容', 'rows' => 8
                        ));
                        ?>
                    </div>
                </div>
                <?php $i++; ?>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <div class="form-group">
        <div id="btn-edit-return" class="col-xs-offset-1 col-xs-10" style="margin-top:20px;">
            <?php echo $this->Form->submit('更新する', array(
                'class' => 'btn-block btn btn-primary',
            )) ?>
        </div>

        <div id="btn-add-return" class="col-xs-offset-1 col-xs-10" style="margin-top:20px;">
            <button class="btn-block btn btn-default">新しい支援パターンを追加する</button>
        </div>
    </div>
</div>

<?php $this->start('script') ?>
<script>
    var clone = '' +
            '<div class="levels clearfix" index="@">' +
            '<h4>支援パターン@</h4>' +
            '<br>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<?php echo $this->Form->input('BackingLevel.@.name', array(
                    'type' => 'hidden', 'value' => 'level '.'@'
            ));?>' +
            '<label>最低支援額</label>' +
            '<div class="input-group">' +
            '<?php echo $this->Form->input('BackingLevel.@.invest_amount', array(
                    'required' => 'required', 'label' => false
            ));
                    ?>' +
            '<span class="input-group-addon">円</span>' +
            '</div>' +
            '</div>' +

            '<div class="form-group">' +
            '<label>最大支援回数</label>' +
            '<div class="input-group">' +
            '<?php echo $this->Form->input('BackingLevel.@.max_count', array('label' => false)) ?>' +
            '<span class="input-group-addon">回</span>' +
            '</div>' +
            '</div>' +

            '<div class="form-group">' +
            '<label>リターン受け渡し手段</label>' +
            '<?php echo str_replace(array(
                    "\r\n", "\r", "\n"
            ), '', $this->Form->input('BackingLevel.@.delivery', array(
                    'label' => false, 'div' => false, 'type' => 'select', 'options' => Configure::read('DELIVERY')
            ))); ?>' +
            '</div>' +
            '</div>' +


            '<div class="col-md-8">' +
            '<?php echo $this->Form->input('BackingLevel.@.return_amount', array(
                    'type' => 'textarea', 'required' => 'required', 'label' => 'リターン内容', 'rows' => 8
            ));
                    ?>' +

            '</div></div>';

    $(document).ready(function () {
        var disabled = <?php echo $disabled ? 'true' : 'false'; ?>;
        if (disabled) {
            $('#btn-edit-return').css('display', 'none');
        }

        // max_back_level = 10
        var existing = parseInt($('div.levels').last().attr('index')) || 0;
        if (existing >= 10) {
            $('#btn-add-return').css('display', 'none');
        }

        $('#btn-add-return').click(function() {
             var existing = parseInt($('div.levels').last().attr('index')) || 0;
             if (existing >= 10) {
                 alert('支援パターンは最大10個までです。');
                 return false;
             }

             var count    = existing + 1;
             var row = clone.replace(/@@/g, existing);
             row = row.replace(/[@]/g, count);
             $('#blevel').append(row);

             // value of max_back_level
             $('#back_level').val(count);

             $(this).fadeOut();
             $('#btn-edit-return').fadeIn();
        });
    });
</script>

<?php $this->end(); ?>