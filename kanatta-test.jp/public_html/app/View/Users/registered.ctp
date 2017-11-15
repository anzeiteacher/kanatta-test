<?php echo $this->Html->css('profile', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<?php echo $this->element('profile/profile_sub_menu') ?>

<div class="grid_container clearfix">
    <?php foreach($projects as $project): ?>
        <?php echo $this->element('project_box/project_box_for_normal', array('project' => $project)) ?>
    <?php endforeach; ?>
    <?php if(!$projects): ?>
      	<div class="empty"><div class="e-filter"><div class="none-pjt">プロジェクトは<br>ありません</div></div></div>
    <?php endif;?>
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
