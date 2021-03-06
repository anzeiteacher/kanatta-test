<?php echo $this->element('base/header') ?>
<?php echo $this->element('base/menu') ?>
<?php echo $this->element('base/flash'); ?>
<div class="top_back"></div>

<?php echo $this->fetch('content'); ?>

<div class="tab_xs_footer">
<?php if(date('Y-m-d', strtotime($project['Project']['collection_end_date'])) > date('Y-m-d')): ?>
    <div class="like_btn_footer">
<?php else: ?>
    <div class="like_btn_footer">
<?php endif ?>
    <?php if(($auth_user && !$favourite) || !$auth_user):?>
        <a href="<?php echo $this->Html->url(array(
            'controller' => 'favourite_projects', 'action' => 'add', $project['Project']['id']
        ))?>">
            <span class="el-icon-heart"></span>
            追加
        </a>
    <?php else:?>
        <a href="<?php echo $this->Html->url(array(
            'controller' => 'favourite_projects', 'action' => 'delete', $project['Project']['id']
        ))?>">
            <span class="el-icon-heart-empty"></span>
            解除
        </a>
    <?php endif;?>
    </div>
    <?php if($pj_active):?>
        <div class="back_btn_footer">
            <a href="<?php echo $this->Html->url(array(
                'controller' => 'backing_levels', 'action' => 'index', $project['Project']['id']
            ))?>">
                <span class="el-icon-smiley-alt"></span>
                プロジェクトを支援する
            </a>
        </div>
    <?php else:?>
        <div class="back_btn_footer non_active">
            <p>
                <span class="el-icon-smiley-alt"></span>
                <?php echo h($reason_sp)?>
            </p>
        </div>
    <?php endif;?>
</div>

<?php echo $this->element('base/footer') ?>
<?php //echo $this->element('sql_dump');?>