<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->element('card/mypage_menu', array('mode' => 'monthly'))?>
<h4><span class="el-icon-credit-card"></span> 月額課金プロジェクトの支援一覧</h4>

<div class="container">
    <?php if(!empty($bps)):?>
        <table class="table table-bordered table-condensed table-striped">
            <tr>
                <th>プロジェクト</th>
                <th>料金</th>
                <th>前回課金</th>
                <th>結果</th>
                <th>次回課金</th>
                <th></th>
            </tr>
            <?php foreach($bps as $bp):?>
                <?php $p = $bp['Project']?>
                <?php $bp = $bp['BackedProject']?>
                <tr>
                    <td><?php echo h($p['project_name'])?></td>
                    <td><?php echo number_format(h($bp['invest_amount']))?>円／月</td>
                    <td><?php echo h($bp['old_charge_date'])?></td>
                    <td><?php echo h($bp['charge_result'])?></td>
                    <td><?php echo h($bp['next_charge_date'])?></td>
                    <td>
                        <?php
                        echo $this->Form->postLink(
                            '<button class="btn btn-danger btn-xs">課金をやめる</button>',
                            '/card/stop/'.$bp['id'],
                            array('class' => '', 'escape' => false),
                            '課金を中止しますか？'
                        );
                        ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
        <?php echo $this->element('base/pagination')?>
    <?php else:?>
        <p>まだ月額課金プロジェクトに支援されていません。</p>
    <?php endif;?>

</div>
