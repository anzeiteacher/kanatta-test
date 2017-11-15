<?php echo $this->element('base/header') ?>
<?php echo $this->element('base/menu') ?>
<?php echo $this->element('base/flash'); ?>
<div class="top_back"></div>


<div class="project clearfix">
    <div class="container">
        <h1><?php echo h($project['Project']['project_name']); ?></h1>
    </div>
    <div class="project_content clearfix">
        <div class="left">
            <?php echo $this->element('project/project_thumbnail', array(
                    'project' => $project, 'mode' => $mode
            )) ?>
            <div class="clearfix sub">
                <a href="<?php echo $this->Html->url(array(
                            'controller' => 'users', 'action' => 'view', $project['User']['User']['id']
                    )) ?>">
                        <?php echo $this->User->get_user_img_md($project['User'], 20) ?>
                        <?php echo h($project['User']['User']['nick_name']) ?>
                    </a>
                    　
                    　<span class="el-icon-tag"></span>
                    <?php echo $this->Html->link(h($project['Category']['name']), '/categories/'.$project['Category']['id'])?>
                    <?php if($setting['cat_type_num'] == 2):?>
                        <?php echo $this->Html->link(h($project['Area']['name']), '/categories2/'.$project['Area']['id'])?>
                    <?php endif;?>
                <?php echo $this->element('project/social_btn', array('project' => $project)) ?>
            </div>
        </div>
        <div class="right">
            <?php echo $this->element('project/project_info') ?>
        </div>
    </div>

    <div class="project_header">
        <?php echo $this->element('project/project_header') ?>
    </div>

    <div class="project_content clearfix content_detail">
        <div class="left">
	        <?php echo $this->fetch('content'); ?>
	        <?php if(!$mode):?>
                <?php echo $this->element('project/project_detail', array(
                        'project' => $project, 'mode' => $mode
                )) ?>
            <?php endif;?>
        </div>
        <div class="right">
            <?php echo $this->element('project/backing_levels', array('project' => $project)) ?>
        </div>
    </div>
</div>


<?php echo $this->element('base/footer') ?>
<?php //echo $this->element('sql_dump');?>

