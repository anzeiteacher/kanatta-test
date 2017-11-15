<div class="pickup_project clearfix">
    <div class="imgholder">
        <?php if($this->Label->url($project['Project']['pic'])): ?>
            <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                <?php echo $this->Label->image($project['Project']['pic'], array('class' => 'img img-responsive')) ?>
            </a>
        <?php endif; ?>
        <?php if($this->Project->get_backed_per($project) >= 100): ?>
            <div class="project_success"> SUCCESS!</div>
        <?php endif ?>
    </div>
    <div class="right">
        <h2 class="title">
            <?php if($project['Project']['opened'] == 1): ?>
                <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                    <?php echo h($project['Project']['project_name']); ?>
                </a>
            <?php else: ?>
                <?php echo h($project['Project']['project_name']); ?>
            <?php endif ?>
        </h2>
        <p class="description">
            <?php echo $this->Text->truncate(h($project['Project']['description']), 180, array('html' => false)); ?>
        </p>

        <div class="graph_footer">
            <?php if(empty($project['Project']['no_goal'])):?>
                <?php echo $this->element('project/graph', array('project' => $project)) ?>
            <?php endif;?>

            <div class="grid_footer clearfix">
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div>
                            ¥<?php echo number_format(h($project['Project']['collected_amount'])); ?>
                        </div>
                    <?php endif;?>
                <?php endif;?>
                <div>
                    <span class="el-icon-group"></span>
                    <?php echo h($project['Project']['backers']); ?>人
                </div>
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div>
                            <span class="el-icon-time"></span>
                            <?php echo $this->Project->get_zan_day($project); ?>
                        </div>
                    <?php endif;?>
                <?php endif;?>
            </div>
        </div>
    </div>

</div>
