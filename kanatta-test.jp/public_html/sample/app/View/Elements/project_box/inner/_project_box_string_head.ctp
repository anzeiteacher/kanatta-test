<h2 class="grid_title">
    <?php if($project['Project']['opened'] == 1): ?>
        <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
            <?php echo h($project['Project']['project_name']); ?>
        </a>
    <?php else: ?>
        <?php echo h($project['Project']['project_name']); ?>
    <?php endif ?>
</h2>
