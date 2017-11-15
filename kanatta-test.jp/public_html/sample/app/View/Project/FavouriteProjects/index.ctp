<?php echo $this->Html->css('mypage', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

    <h4><span class="el-icon-heart"></span> お気に入り</h4>
    <div class="grid_container clearfix">
        <?php foreach($projects as $project): ?>
            <?php echo $this->element('project_box/project_box_for_favourite', array('project' => $project)) ?>
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