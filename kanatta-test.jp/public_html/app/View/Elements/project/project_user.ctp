<div class="user_info">
    <div class="content">
        <a href="<?php echo $this->Html->url(array(
                'controller' => 'users', 'action' => 'view', $project['User']['User']['id']
        )) ?>">
            <?php echo $this->User->get_user_img($project['User']) ?>
        </a>
        <div class="name">
            <a href="<?php echo $this->Html->url(array(
                    'controller' => 'users', 'action' => 'view', $project['User']['User']['id']
            )) ?>">
                <?php echo h($project['User']['User']['nick_name']) ?>
            </a>
        </div>
        <div class="address">
            <?php if(!empty($project['User']['User']['address'])): ?>
                <span class="el-icon-map-marker"></span>
                <?php echo h($project['User']['User']['address']) ?>
            <?php endif; ?>
            <?php if(!empty($project['User']['User']['birth_area']) && $this->Setting->can_d_area($setting)): ?>
                <br>出身地：
                <?php echo h($project['User']['User']['birth_area']) ?>
            <?php endif; ?>
            <?php if(!empty($project['User']['User']['school']) && $this->Setting->can_d_school($setting)): ?>
                <br>出身校：
                <?php echo h($project['User']['User']['school']) ?>
            <?php endif; ?>
        </div>
        <br>
        <?php echo $this->element('project/user_social_info')?>
    </div>
</div>