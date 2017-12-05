<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<div class="bread">
    <?php echo $this->Html->link('プロジェクト', '/admin/admin_projects/') ?> &gt; 支援の管理
</div>
<div class="setting_title">
    <h2>支援の管理</h2>
</div>
<?php echo $this->element('admin/setting_project_main_menu', array('mode' => 'back')) ?>

<div class="container-fluid">
    <h2>公開中プロジェクト一覧</h2>
    <br>
    <div class="search_box">
        <?php echo $this->Form->create('Project', array('inputDefaults' => array('class' => 'form-control')))?>
        <div class="form-group">
            <?php echo $this->Form->input('id', array('type' => 'text', 'label' => 'ID'))?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('pay_pattern',
            array('type' => 'select', 'options' => Configure::read('PAY_PATTERN'),
                  'label' => '決済パターン', 'empty' => '-----'))?>
        </div>
        <button type="submit" class="btn btn-info">検索</button>
        <?php echo $this->Form->end()?>
    </div>
    <br>
    <?php if(!empty($projects)): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>決済タイプ</th>
                <th>募集終了</th>
                <th>締め日</th>
                <th>目標金額</th>
                <th>現在金額</th>
                <th>起案者への支払額</th>
                <th>支援者</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach($projects as $p): ?>
            <?php $p = $p['Project']?>
            <tr>
                <td>
                    <?php echo h($p['id']) ?>
                </td>
                <td>
                    <a href="<?php echo $this->Html->url('/projects/view/'.$p['id']) ?>" target="_blank">
                        <?php echo h($p['project_name']) ?>
                    </a>
                </td>
                <td>
                    <?php echo $pay_patterns[h($p['pay_pattern'])]?>
                </td>
                <td>
                    <?php if($p['pay_pattern'] == MONTHLY):?>
                    <?php echo ($p['active'] == 1) ? '募集中' : 'サービス終了'?>
                    <?php elseif($p['no_goal']):?>
                    <?php echo ($p['active'] == 1) ? '募集中' : 'サービス終了'?>
                    <?php else:?>
                    <?php echo date('Y/m/d', strtotime(h($p['collection_end_date']))) ?>
                    <?php endif;?>
                </td>
                <td>
                    <?php if(date('Ymd', strtotime(h($p['collection_end_date']))) < date('Ymd') ):?>
                    <?php echo date('Y/m/d', strtotime(h($p['closing_date'])))?>
                    <?php endif;?>
                </td>
                <td>
                    <?php if($p['pay_pattern'] != MONTHLY && !$p['no_goal']):?>
                    <?php echo '¥'.number_format(h($p['goal_amount'])) ?>
                    <?php endif;?>
                </td>
                <td>
                    <?php echo '¥'.number_format(h($p['collected_amount']))?>
                    <?php if($p['pay_pattern'] == MONTHLY):?> ／月
                    <?php endif;?>
                </td>
                <td>
                    <?php echo '¥'.number_format(h($p['project_owner_price']))?>
                    <?php if($p['pay_pattern'] == MONTHLY):?> ／月
                    <?php endif;?>
                </td>
                <td>
                    <?php echo number_format(h($p['backers'])) ?>人</td>
                <td>
                    <a href="<?php echo $this->Html->url('/admin/admin_projects/backers/'.$p['id']) ?>" class="btn btn-success btn-sm">支援者一覧
                        </a>
                    <?php if(!($p['pay_pattern'] == MONTHLY && $p['active'] != 1)):?>
                    <a href="<?php echo $this->Html->url('/admin/admin_backed_projects/add_back/'.$p['id'])?>" class="btn btn-primary btn-sm">
                            支援を追加
                        </a>
                    <?php endif;?>
                    <?php if($p['pay_pattern'] == MONTHLY && $p['active'] == 1):?>
                    <?php echo $this->Form->postLink(
                                '<button class="btn btn-danger btn-sm">サービス終了</button>',
                                '/admin/admin_projects/stop_monthly_service/'.$p['id'],
                                array('class' => '', 'escape' => false),
                                'サービスを終了すると、このプロジェクトの全ての決済がキャンセルされます。サービスを終了しますか？'
                            );?>
                    <?php endif;?>
                </td>
                <td>
                    <a href="<?php echo $this->Html->url('/admin/admin_projects/statement_pdf/'.$p['id'])?>" class="btn btn-danger btn-sm">プロジェクト明細出力</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php echo $this->element('base/pagination') ?>
    <?php endif; ?>
</div>
