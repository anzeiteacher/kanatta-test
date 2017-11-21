<?php if(!$smart_phone): ?>
<div class="pickup_project_for_top clearfix">
    <div class="imgholder">
	    <figure id="fig-top_box">
	    <?php if($this->Label->url($project['Project']['pic'])): ?>
            <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                <?php echo $this->Label->image($project['Project']['pic'], array('class' => 'img img-responsive')) ?>
            </a>
        <?php endif; ?>
        <?php if($this->Project->get_backed_per($project) >= 100): ?>
            <div class="project_success"> SUCCESS!</div>
        <?php endif ?>
  			<figcaption>
    	    	<h3>
        	    	<?php if($project['Project']['opened'] == 1): ?>
                    <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                        <?php echo h($project['Project']['project_name']); ?>
                    </a>
                    <?php else: ?>
                        <?php echo h($project['Project']['project_name']); ?>
                    <?php endif ?>
            	</h3>
        		<p>
        		<?php
                    echo $this->Text->truncate(
                        h($project['Project']['description']),
                        100,
                        array(
                            'ellipsis' => '...',
                            'exact' => true,
                            'html' => false
                        )
                    );
                ?></p>
  			</figcaption>
		</figure>
    </div>

    <div class="right hidden-xs">
    <div class="top-kanako"><?php echo $this->Html->image('common/kanako3.png') ?></div>
        <div class="graph_footer">
            <div class="grid_footer clearfix">
                <h2 class="title">
                    <?php if($project['Project']['opened'] == 1): ?>
                        <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                            <?php echo h($project['Project']['project_name']); ?>
                        </a>
                    <?php else: ?>
                        <?php echo h($project['Project']['project_name']); ?>
                    <?php endif ?>
    	        </h2>
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div class="grid-txt1">
                            ¥ 集まっている額<br><span class="grid-txt2"><?php echo number_format(h($project['Project']['collected_amount'])); ?>円</span>
                        </div>
                    <?php endif;?>
                <?php endif;?>
                <div class="grid-txt1">
                	<span class="goal_amount">目標：<?php echo number_format(h($project['Project']['goal_amount'])); ?>円</span>
                </div>

                <?php if(empty($project['Project']['no_goal'])):?>
                    <?php echo $this->element('project/graph', array('project' => $project)) ?>
                <?php endif;?>

                <div class="grid-txt1">
                    <span class="el-icon-group"></span>
                    サポーター<span class="grid-txt2"><?php echo h($project['Project']['backers']); ?>人</span>
                </div>
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div>
                            <span class="el-icon-time"></span>
                            残り<span class="grid-txt2"><?php echo $this->Project->get_zan_day($project); ?></span>
                        </div>
                    <?php endif;?>
                <?php endif;?>
            </div>
        </div>
     </div>
</div>

<?php else: ?>
<div class="pickup_project_for_top clearfix">
    <div class="imgholder">
	    <figure id="fig-top_box_sm">
	    <?php if($this->Label->url($project['Project']['pic'])): ?>
            <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                <?php echo $this->Label->image($project['Project']['pic'], array('class' => 'img img-responsive')) ?>
            </a>
        <?php endif; ?>
        <?php if($this->Project->get_backed_per($project) >= 100): ?>
            <div class="project_success"> SUCCESS!</div>
        <?php endif ?>
  			<figcaption>
    	    	<h3>
        	    	<?php if($project['Project']['opened'] == 1): ?>
                    <a href="<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>">
                        <?php echo h($project['Project']['project_name']); ?>
                    </a>
                    <?php else: ?>
                        <?php echo h($project['Project']['project_name']); ?>
                    <?php endif ?>
            	</h3>
            	<div class="grid_footer clearfix">

                <?php if(empty($project['Project']['no_goal'])):?>
                    <?php echo $this->element('project/graph', array('project' => $project)) ?>
                <?php endif;?>

                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div class="grid-txt1">
                            ¥ <span class="grid-txt2"><?php echo number_format(h($project['Project']['collected_amount'])); ?>円</span>
                        </div>
                    <?php endif;?>
                <?php endif;?>

                <div class="grid-txt1">
                    <span class="el-icon-group"></span>
                    <span class="grid-txt2"><?php echo h($project['Project']['backers']); ?>人</span>
                </div>
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                    <?php if(empty($project['Project']['no_goal'])):?>
                        <div class="grid-txt1">
                            <span class="el-icon-time"></span>
                            <span class="grid-txt2"><?php echo $this->Project->get_zan_day($project); ?></span>
                        </div>
                    <?php endif;?>
                <?php endif;?>
            </div>
  			</figcaption>
		</figure>
    </div>
</div>

<?php endif ?>