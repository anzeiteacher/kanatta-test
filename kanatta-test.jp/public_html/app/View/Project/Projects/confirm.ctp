<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->Html->script('client_resize', array('inline' => false)) ?>
<?php echo $this->Html->script('jquery-ui.min', array('inline' => false)) ?>
<?php echo $this->Html->script('pj_contents', array('inline' => false)) ?>

<div class="progressbar">
    <ul>
        <li>プロジェクト作成</li>
        <li>支援パターン追加</li>
        <li class="active">確認</li>
        <li>完了</li>
    </ul>
</div>

<h4>確認</h4>

<?php echo $this->Form->create('Project'); ?>

<div class="content clearfix">
    <h5>プロジェクト概要</h5>
    <table class="confirm-project" style="width:100%;">
        <tr>
            <th>プロジェクトタイトル</th>
            <td><?php echo $project['Project']['project_name']; ?></td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
            <?php echo $this->Label->image($project['Project']['pic'], array(
                'style' => 'max-width: 240px; margin-top: 10px;',
            )); ?>
            </td>
        </tr>
        <tr>
            <th>カテゴリ</th>
            <td><?php echo isset($categories[$project['Project']['category_id']]) ? $categories[$project['Project']['category_id']] : '?'; ?></td>
        </tr>
        <tr>
            <th>決済パターン</th>
            <?php $pay_patterns = Configure::read('PAY_PATTERN'); ?>
            <td><?php echo isset($pay_patterns[$project['Project']['pay_pattern']]) ? $pay_patterns[$project['Project']['pay_pattern']] : '?'; ?></td>
        </tr>
        <tr>
            <th>目標金額</th>
            <td><?php echo !empty($project['Project']['goal_amount']) ? $project['Project']['goal_amount'] . ' 円': '---'; ?></td>
        </tr>
        <tr>
            <th>目標人数</th>
            <td><?php echo !empty($project['Project']['goal_backers']) ? $project['Project']['goal_backers'] . ' 人': '---'; ?> 人</td>
        </tr>
        <tr>
            <th>プロジェクト概要</th>
            <td><?php echo $project['Project']['description']; ?></td>
        </tr>
        <tr>
            <th>リターン概要</th>
            <td><?php echo $project['Project']['return']; ?></td>
        </tr>
        <tr>
            <th>連絡先</th>
            <td><?php echo $project['Project']['contact']; ?></td>
        </tr>
    </table>

    <h5>プロジェクト詳細</h5>
    <table class="confirm-project">
        <?php foreach ($project['ProjectContent'] as $content): ?>
        <tr>
            <td><?php echo $content['txt_content']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h5>支援パターン</h5>
    <table class="confirm-project">
        <?php foreach ($project['BackingLevel'] as $i => $return): ?>
        <tr>
            <th colspan=2 style="background: #ddd;">支援パターン<?php echo $i + 1; ?></th>
        </tr>
        <tr>
            <th>最低支援額</th>
            <td><?php echo !empty($return['invest_amount']) ? $return['invest_amount'] . ' 円': '---'; ?></td>
        </tr>
        <tr>
            <th>最大支援回数</th>
            <td><?php echo !empty($return['max_count']) ? $return['max_count'] . ' 回': '---'; ?></td>
        </tr>
        <tr>
            <th>リターン受け渡し方法</th>
            <?php $deliveries = Configure::read('DELIVERY'); ?>
            <td><?php echo isset($deliveries[$return['delivery']]) ? $deliveries[$return['delivery']] : '?'; ?></td>
        </tr>
        <tr>
            <th>リターン内容</th>
            <td><?php echo $return['return_amount']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<div class="col-xs-offset-1 col-xs-10" style="margin-top: 20px;">
    <?php echo $this->Form->submit('登録する', array(
        'class' => 'btn-block btn btn-primary',
    )); ?>
</div>

</div>

<style>
table.confirm-project {
  width: 100%;
}
table.confirm-project th {
  width: 25%;
  min-width: 100px;
}
</style>