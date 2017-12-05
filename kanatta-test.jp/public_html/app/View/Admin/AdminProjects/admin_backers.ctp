<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<div class="container-fluid">
    <div class="bread">
        <?php echo $this->Html->link('プロジェクト', '/admin/admin_projects/') ?> &gt;
        <?php echo $this->Html->link('支援の管理', '/admin/admin_projects/open_projects') ?> &gt; 支援者一覧
    </div>
    <div class="setting_title">
        <h2>『
            <?php echo h($project['Project']['project_name']) ?>』の支援者一覧</h2>
    </div>
    <?php echo $this->element('admin/setting_project_main_menu', array('mode' => 'back')) ?>
    <br>
    <div class="clearfix">
        <div class="col-md-8" style="font-size:18px;font-weight:bold;">
            <p>　支援者数：
                <?php echo number_format(h($project['Project']['backers'])) ?>人</p>
        </div>
        <div class="col-md-4">
            <a href="<?php echo $this->Html->url('/admin/admin_projects/csv_backers/'.h($project['Project']['id'])) ?>" class="btn btn-primary">
            CSVダウンロード
        </a>
            <a href="<?php echo $this->Html->url('/admin/admin_projects/edit_level/'.h($project['Project']['id'])) ?>" class="btn btn-info" target="_blank">
            支援パターン一覧
        </a>
        </div>
    </div>
    <br>

    <div class="table-responsive">
        <table class="table table-bordered" style="text-align:center; width:1700px;">
            <tr style="background:#3bd;color:#000;font-weight:bold;">
                <td>支援日</td>
                <td>支援方法</td>
                <td>決済ID</td>
                <td>決済の状態</td>
                <td>支援金額</td>
                <?php if($project['Project']['pay_pattern'] == MONTHLY):?>
                <td>前回課金日</td>
                <td>前回課金結果</td>
                <td>次回課金日</td>
                <?php endif;?>
                <td>ユーザー名</td>
                <td>氏名</td>
                <td>メールアドレス</td>
                <td>住所</td>
                <td>支援パターン</td>
                <td>支援コメント</td>
            </tr>
            <?php foreach($backers as $b): ?>
            <tr>
                <td>
                    <?php echo date('Y/m/d', strtotime(h($b['BackedProject']['created']))) ?>
                </td>
                <td>
                    <?php if($b['BackedProject']['manual_flag']):?> 手動
                    <?php
                    echo $this->Form->postLink(
                        '<button class="btn btn-danger btn-xs">削除</button>',
                        '/admin/admin_projects/del_bp/'.$b['BackedProject']['id'],
                        array( 'class' => '',
                               'escape' => false),
                        '削除しますか？'
                    );
                    ?>
                        <?php else:?> カード
                        <?php endif;?>
                </td>
                <td>
                    <?php if($project['Project']['pay_pattern'] == MONTHLY):?>
                    <?php echo h($b['BackedProject']['recurring_id'])?>
                    <?php else:?>
                    <?php echo h($b['BackedProject']['orderId'])?>
                    <?php endif;?>
                </td>
                <td>
                    <?php echo $statuses[$b['BackedProject']['status']]?>
                </td>
                <td>
                    <?php echo number_format(h($b['BackedProject']['invest_amount'])) ?>円
                </td>
                <?php if($project['Project']['pay_pattern'] == MONTHLY):?>
                <td>
                    <?php if(!empty($b['BackedProject']['old_charge_date'])){
                        echo date('Y/m/d', strtotime(h($b['BackedProject']['old_charge_date'])));
                    }?>
                </td>
                <td>
                    <?php if(!empty($b['BackedProject']['charge_result'])){
                        echo $charge_results[h($b['BackedProject']['charge_result'])];
                    }?>
                </td>
                <td>
                    <?php if(!empty($b['BackedProject']['next_charge_date'])){
                        echo date('Y/m/d', strtotime(h($b['BackedProject']['next_charge_date'])));
                    }?>
                </td>
                <?php endif;?>
                <td>
                    <?php echo h($b['User']['nick_name']) ?>
                </td>
                <td>
                    <?php echo h($b['User']['name']) ?>
                </td>
                <td>
                    <?php echo h($b['User']['email']) ?>
                </td>
                <td>
                    <?php echo h($b['User']['receive_address'].$b['User']['receive_address2']) ?>
                </td>
                <td>
                    <?php echo str_replace('level', '支援パターン', h($b['BackingLevel']['name'])) ?>
                </td>
                <td>
                    <?php echo h($b['BackedProject']['comment']) ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="container">
    <?php echo $this->element('base/pagination') ?>
</div>
