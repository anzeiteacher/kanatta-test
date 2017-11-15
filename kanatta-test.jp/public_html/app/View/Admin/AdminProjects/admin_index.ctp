<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<div class="bread">
    <?php echo $this->Html->link('プロジェクト', '/admin/admin_projects/') ?> &gt; プロジェクト一覧
</div>
<div class="setting_title">
    <h2>プロジェクト一覧</h2>
</div>

<?php echo $this->element('admin/setting_project_main_menu', array('mode' => 'index')) ?>

<div class="grid_container clearfix">
    <?php foreach($projects as $project): ?>
        <?php echo $this->element('project_box/project_box_for_setting', array('project' => $project)) ?>
    <?php endforeach; ?>
</div>
<div class="container">
    <?php echo $this->element('base/pagination') ?>
</div>

<?php $this->start('script') ?>
<script>
    $(document).ready(function () {
        all_grid_position();
    });
    window.onresize = function () {
        all_grid_position();
    };
</script>
<?php $this->end() ?>
