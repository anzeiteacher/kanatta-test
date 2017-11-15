<?php echo $this->element('project/project_user') ?>
<?php if(!empty($project['BackingLevel'])): ?>
    <div class="backing_levels">
	    <p class="backing_levels_pattern"><?php echo $this->Project->msg_of_pay_pattern($project['Project']['pay_pattern']);?></p>
        <p>サポートするコースを選ぶ</p>
        <div class="backing_contents zero-support">
            <div class="clearfix">
                <div class="col-xs-6">
                    <p class="return_price">
                        0円からできる支援
                    </p>
                </div>
                <div style="margin: auto; width: 50%;">
                    	<div class="social_btn social_btn_project">
                            <table>
                                <tr>
                                    <td class="tw">
                                        <a href="https://twitter.com/share" class="twitter-share-button"
                                           data-url="<?php echo $this->Html->url(array(
                                                   'controller' => 'projects', 'action' => 'view', $project['Project']['id']
                                           ), true) ?>"
                                           data-text="<?php echo h($project['Project']['project_name']) ?> - <?php echo h($setting['site_name']) ?>"
                                           data-lang="ja">ツイート</a>
                                        <script>!function (d, s, id) {
                                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                                if (!d.getElementById(id)) {
                                                    js = d.createElement(s);
                                                    js.id = id;
                                                    js.src = p + '://platform.twitter.com/widgets.js';
                                                    fjs.parentNode.insertBefore(js, fjs);
                                                }
                                            }(document, 'script', 'twitter-wjs');</script>
                                    </td>
                                    <td class="fb" style="padding-left:10px;">
                                        <div class="fb-like" data-href="<?php echo $this->Html->url(array(
                                                'controller' => 'projects', 'action' => 'view', $project['Project']['id']
                                        ), true) ?>"
                                             data-send="false" data-layout="button_count" data-width="200" data-show-faces="true"
                                             data-font="arial"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <?php foreach($project['BackingLevel'] as $backingLevel): ?>
    	<div class="backing_contents">
            <div class="clearfix">
                <div class="col-xs-6">
                    <p class="return_price">
                        <?php echo number_format($backingLevel['BackingLevel']['invest_amount']); ?> 円コース
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
                                サポーター：<?php echo number_format($backingLevel['BackingLevel']['now_count']) ?>人
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

            <?php if($pj_active): ?>
                <div class="backing_level btn-backing" onclick="location.href='<?php echo $this->Html->url(array(
                         'controller' => 'backed_projects', 'action' => 'add', $backingLevel['BackingLevel']['id'],
                         $project['Project']['id']))?>'">このコースを選択</div>
            <?php else: ?>
                <div class="backing_level btn-backing finish"></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.backing_contents.zero-support{
    padding: 0.5em 0.5em;
    margin: 2em 0;
    color: #565656;
    background: #ffe7ec;
    box-shadow: 0px 0px 0px 6px #ffe7ec;
    border: dashed 2px #e78da0;
}
</style>
