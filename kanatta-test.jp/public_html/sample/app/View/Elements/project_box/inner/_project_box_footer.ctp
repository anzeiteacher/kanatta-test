<div class="grid_footer clearfix">
    <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
        <?php if(empty($project['Project']['no_goal'])):?>
            ¥<?php echo number_format(h($project['Project']['collected_amount'])); ?>
        <?php endif;?>　
    <?php endif;?>
    <span class="el-icon-group"></span>
    <?php echo h($project['Project']['backers']); ?>人

    <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>　
        <?php if(empty($project['Project']['no_goal'])):?>
            <span class="el-icon-time"></span>
            <?php echo $this->Project->get_zan_day($project); ?>
        <?php endif;?>
    <?php endif;?>
</div>