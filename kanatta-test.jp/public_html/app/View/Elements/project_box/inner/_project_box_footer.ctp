    <tr>
        <td>
        	<tr class="hidden-xs">
        	<td>
            <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
            	<?php if(empty($project['Project']['no_goal'])):?>
            		¥集まっている金額
        			</td>
        			<td class="td-act" id="act1">
	        		<?php echo number_format(h($project['Project']['collected_amount'])); ?>円
    			<?php endif;?>　
    		<?php endif;?>
    		</td>
    		</tr>
    		<tr class="hidden-lg hidden-md hidden-sm">
    		<td class="td-act" id="act1">
                <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>
                	<?php if(empty($project['Project']['no_goal'])):?>
                		<?php echo number_format(h($project['Project']['collected_amount'])); ?>円
        			<?php endif;?>　
        		<?php endif;?>
    		</td>
    		</tr>
        </td>
	</tr>
	<tr>
	        <td class="td-progress-bar" colspan="2">
	        <?php if(empty($project['Project']['no_goal'])):?>
    	        <?php echo $this->element('project/graph', array('project' => $project)) ?>
            <?php endif;?>
            </td>
     </tr>
     <tr>
    	<td>
        	<span class="el-icon-group"></span>
        		サポーター<?php echo h($project['Project']['backers']); ?>人
    	</td>
       	<td id="act2">
            <?php if(empty($project['Project']['pay_pattern']) || $project['Project']['pay_pattern'] != MONTHLY):?>　
    	        <?php if(empty($project['Project']['no_goal'])):?>
        			<span class="el-icon-time"></span>
        			残り<?php echo $this->Project->get_zan_day($project); ?>
    		    <?php endif;?>
        	<?php endif;?>
        </td>
    </tr>