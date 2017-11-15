<div class="clearfix sub">
	<div class="btn-like">
        <?php if($auth_user && $favourite): ?>
            <button class="btn-favorite like like-release"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'favourite_projects', 'action' => 'delete', $project['Project']['id']
                    )) ?>'">
				<div class="heart-on"></div>お気に入り解除

            </button>
        <?php else: ?>
            <button class="btn-favorite like like-add"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'favourite_projects', 'action' => 'add', $project['Project']['id']
                    )) ?>'">
				<div class="heart-off"></div>お気に入りを追加
            </button>
        <?php endif; ?>
    </div>
</div>

<div class="project_info">
    <?php if(!$project['Project']['no_goal']):?>
    <div class="data">
        <div class="price">
            <?php if(!$this->Project->chk_pay_monthly($project)):?>
                <p class="title">
                    <span class="el-icon-smiley-alt"></span>
                    集まっている金額
                </p>
                <p class="big_number">
                    <?php echo number_format(h($project['Project']['collected_amount'])); ?> 円
                </p>
                <div class="goal_amount">
                    目標：<?php echo number_format(h($project['Project']['goal_amount'])); ?> 円
                </div>

                <?php echo $this->element('project/graph', array('project' => $project)) ?>

            <?php else:?>
                <?php if(!$pj_active):?>
                    <div class="service_fin">
                        <?php echo h($reason)?>
                    </div>
                <?php endif;?>
                <p class="title">
                    <span class="el-icon-smiley-alt"></span>
                    現在のサポーター人数
                </p>
                <p class="big_number">
                    <?php echo number_format(h($project['Project']['backers'])); ?> 人
                </p>
                <div class="goal_amount">
                    目標：<?php echo number_format(h($project['Project']['goal_backers'])); ?> 人
                </div>

                <?php echo $this->element('project/graph', array('project' => $project)) ?>

            <?php endif;?>
        </div>

        <?php if(!$this->Project->chk_pay_monthly($project)):?>
            <div class="clearfix">
                <div class="backer">
                    <p class="title">
                        <span class="el-icon-group"></span>
                        サポーター
                    </p>
                    <p class="big_number">
                        <?php echo h($project['Project']['backers']); ?>人
                    </p>
                </div>

                <div class="time">
                    <p class="title">
                        <span class="el-icon-time"></span>
                        残り
                    </p>
                    <p class="big_number">
                        <?php echo $this->Project->get_zan_day($project, true); ?>
                    </p>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php endif;?>

    <?php if($pj_active): ?>
        <div style="margin-top: 50px;">
            <button class="back_btn btn btn-success btn-support"
                    onclick="location.href='<?php echo $this->Html->url(array(
                            'controller' => 'backing_levels', 'action' => 'index', $project['Project']['id']
                    )) ?>'">
                <span class="el-icon-smiley-alt"></span>
                プロジェクトを支援する！
            </button>
        </div>
    <?php endif; ?>
</div>
