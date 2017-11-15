<?php echo $this->Html->css('search', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>
<?php if($smart_phone): ?>
    <?php echo $this->Html->css('sp/grid_sp', null, array('inline' => false)) ?>
<?php endif ?>

<h3 class="title"><span class="el-icon-tag"></span> <?php echo h($category_name)?></h3>
<div class="grid_container clearfix ">
    <?php foreach($projects as $idx => $project): ?>
        <?php echo $this->element('project_box/project_box_for_normal', array('project' => $project)) ?>
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