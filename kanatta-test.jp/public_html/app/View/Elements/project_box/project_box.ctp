<div class="grid">
	<?php if($this->Project->get_backed_per($project) >= 100): ?>
		<div class="project_success">
			<?php echo $this->element('project_box/inner/_project_box_img', array('project' => $project)) ?>
		<p><span>SUCCESS!</span></p></div>
	<?php else: ?>
 		<?php echo $this->element('project_box/inner/_project_box_img', array('project' => $project)) ?>
    <?php endif ?>

    <div class="grid_string">
        <?php echo $this->element('project_box/inner/_project_box_string_head', array('project' => $project)) ?>

		<div class="grid_footer clearfix">
            <table>
    	        <?php echo $this->element('project_box/inner/_project_box_footer', array('project' => $project)) ?>
            </table>
        </div>
    </div>
</div>