<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<?php echo $this->element('mypage/mypage_project_menu', array('mode' => 'registered')) ?>

<h4><span class="el-icon-th"></span> 作成したプロジェクト</h4>

<div class="grid_container clearfix">
    <?php foreach($projects as $project): ?>
        <?php echo $this->element('project_box/project_box_for_mypage_registered', array('project' => $project)) ?>
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
</script>
<?php $this->end() ?>







