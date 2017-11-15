<?php if(!empty($project['BackingLevel'])): ?>
    <div class="backing_levels">
        <p><?php echo $this->Project->msg_of_pay_pattern($project['Project']['pay_pattern']);?></p>
        <?php foreach($project['BackingLevel'] as $backingLevel): ?>
            <?php if($pj_active): ?>
                <div class="backing_level" onclick="location.href='<?php echo $this->Html->url(array(
                         'controller' => 'backed_projects', 'action' => 'add', $backingLevel['BackingLevel']['id'],
                         $project['Project']['id']))?>'">
            <?php else: ?>
                <div class="backing_level finish">
            <?php endif; ?>
            <div class="clearfix">
                <div class="col-xs-6">
                    <p class="return_price">
                        <?php echo number_format($backingLevel['BackingLevel']['invest_amount']); ?> 円
                        <?php if($this->Project->chk_pay_monthly($project)):?>
                            ／月
                        <?php endif;?>
                    </p>
                </div>
                <div class="col-xs-6" style="text-align:right;">
                    <?php if(!empty($backingLevel['BackingLevel']['max_count'])): ?>
                        <p>
                            <?php echo $this->Project->get_zan_back_label($backingLevel['BackingLevel']) ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="clearfix">
                <div class="col-xs-12">
                    <div class="clearfix">
                        <?php if(!$project['Project']['no_goal'] && !$this->Project->chk_pay_monthly($project)):?>
                        <div style="float:left; padding-right:30px;">
                            <p>
                                <span class="el-icon-group"></span>
                                支援者：<?php echo number_format($backingLevel['BackingLevel']['now_count']) ?>人
                            </p>
                        </div>
                        <?php endif;?>
                        <div style="float:left;">
                            <p>
                                <?php $delivery = Configure::read('DELIVERY') ?>
                                <span class="el-icon-gift"></span>
                                配送方法：<?php echo $delivery[h($backingLevel['BackingLevel']['delivery'])] ?>
                            </p>
                        </div>
                    </div>

                    <?php echo nl2br($backingLevel['BackingLevel']['return_amount']); ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
