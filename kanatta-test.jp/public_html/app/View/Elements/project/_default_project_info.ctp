<div class="project_info">

    <?php if(!$project['Project']['no_goal']):?>
    <div class="data">
        <div class="price">
            <?php if(!$this->Project->chk_pay_monthly($project)):?>
                <p class="title">
                    <span class="el-icon-smiley-alt"></span>
                    現在の支援金額
                </p>
                <p class="big_number">
                    <?php echo number_format(h($project['Project']['collected_amount'])); ?> 円
                </p>
                <?php echo $this->element('project/graph', array('project' => $project)) ?>

                <div class="goal_amount">
                    目標：<?php echo number_format(h($project['Project']['goal_amount'])); ?> 円
                </div>
            <?php else:?>
                <?php if(!$pj_active):?>
                    <div class="service_fin">
                        <?php echo h($reason)?>
                    </div>
                <?php endif;?>
                <p class="title">
                    <span class="el-icon-smiley-alt"></span>
                    現在の支援人数
                </p>
                <p class="big_number">
                    <?php echo number_format(h($project['Project']['backers'])); ?> 人
                </p>
                <?php echo $this->element('project/graph', array('project' => $project)) ?>

                <div class="goal_amount">
                    目標：<?php echo number_format(h($project['Project']['goal_backers'])); ?> 人
                </div>
            <?php endif;?>
        </div>

        <?php if(!$this->Project->chk_pay_monthly($project)):?>
            <div class="clearfix">
                <div class="backer">
                    <p class="title">
                        <span class="el-icon-group"></span>
                        支援者
                    </p>
                    <p class="big_number">
                        <?php echo h($project['Project']['backers']); ?>人
                    </p>
                </div>

                <div class="time">
                    <p class="title">
                        <span class="el-icon-time"></span>
                        残り時間
                    </p>
                    <p class="big_number">
                        <?php echo $this->Project->get_zan_day($project, true); ?>
                    </p>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php endif;?>

    <?php echo $this->element('project/project_user') ?>

    <?php if($pj_active): ?>
        <div>
            <button class="back_btn btn btn-success"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'backing_levels', 'action' => 'index', $project['Project']['id']
                    )) ?>'">
                <span class="el-icon-smiley-alt"></span>
                プロジェクトを支援する！
            </button>
        </div>
    <?php endif; ?>
    <div>
        <?php if($auth_user && $favourite): ?>
            <button class="btn btn-danger btn-block like"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'favourite_projects', 'action' => 'delete', $project['Project']['id']
                    )) ?>'">

                <span class="el-icon-heart"></span> お気に入り解除
            </button>
        <?php else: ?>
            <button class="btn btn-primary btn-block like"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'favourite_projects', 'action' => 'add', $project['Project']['id']
                    )) ?>'">

                <span class="el-icon-heart"></span> お気に入りを追加
            </button>
        <?php endif; ?>
    </div>

</div>
