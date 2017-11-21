<?php $this->start('ogp') ?>
<meta property="og:title" content="<?php echo h($setting['site_title']) ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo $this->Html->url('/', true) ?>"/>
<meta property="og:image"
      content="<?php echo ($this->Label->link($setting['facebook_img'])) ? $this->Label->url($setting['facebook_img'], true) : '' ?>"/>
<meta property="og:site_name" content="<?php echo h($setting['site_name']) ?>"/>
<meta property="og:description" content="<?php echo h($setting['site_description']) ?>"/>
<?php $this->end() ?>

<?php echo $this->Html->css('top', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid_report', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>

<?php if($smart_phone): ?>
    <?php echo $this->Html->css('sp/grid_sp', null, array('inline' => false)) ?>
<?php endif ?>

<div class="toppage">
    <div class="top_box">
    	<div class="top_box-pjt">
		    <?php echo $this->element('project_box/pickup_project_for_top', array('project' => $pickup_pj)) ?>
		</div>
        <div class="content1">
            <?php $this->Setting->display_content($setting, 1); ?>
        </div>
        <?php if($setting['top_box_content_num'] == 2): ?>
            <div class="content2">
                <?php $this->Setting->display_content($setting, 2); ?>
            </div>
        <?php endif ?>
    </div>

    <div class="lets-start">
        <div class="wrap-s">
        	<p class="p1">はじめよう！わたしのプロジェクト</p>
        	<a href="<?php echo $this->Html->url('/select') ?>"><span class="lets-try s1">やってみる！</span></a><a href="<?php echo $this->Html->url('/about') ?>" class="a-about"><span class="lets-about s1">プロジェクトって？</span></a>
        	<span class="lets-kanako1"><?php echo $this->Html->image('common/kanako1.png') ?></span>
    	</div>
    </div>

    <div class="top_content" name="0">
            <h3><span class="el-icon-th"></span> オススメ</h3>
            <div class="clearfix grid_container">
                <?php foreach($pjs as $idx => $project): ?>
                    <?php if(isset($project['Project'])): ?>
                        <?php echo $this->element('project_box/project_box_for_normal', compact('project')) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    </div>

	<div class="lets-support">
        <div class="wrap-s">
            <span class="lets-kanako2"><?php echo $this->Html->image('common/kanako2.png') ?></span>
            <div class="lets-start">
            	<p class="p1">みんなで達成！女性のアイディアをサポート</p>
            	<a href="<?php echo $this->Html->url('/projects') ?>"><span class="lets-try s1">プロジェクトを探す</span></a><a href="<?php echo $this->Html->url('/about') ?>" class="a-about"><span class="lets-about s1">応援するには？</span></a>
            </div>
        </div>
	</div>
    <?php if(!empty($pjs_by_cat)):?>
    <?php foreach($pjs_by_cat as $idx => $pjs):?>
        <div class="top_content" name="<?php echo $idx+1 ?>">
                <h3><span class="el-icon-tag"></span> <?php echo h($pjs['name'])?></h3>
                <div class="clearfix grid_container">
                    <?php foreach($pjs['pj'] as $project):?>
                        <?php echo $this->element('project_box/project_box_for_normal', compact('project')) ?>
                    <?php endforeach;?>
                </div>
        </div>
    <?php endforeach;?>
    <?php endif;?>

    <?php if(!empty($reports)): ?>
        <div class="reports top_content">
            <h3><span class="el-icon-bullhorn"></span> 活動報告</h3>

            <div id="grid_container_report" class="clearfix">
                <?php foreach($reports as $report): ?>
                    <div class="grid_wrap_report">
                        <?php echo $this->element('report_box/report_box_opened', array('report' => $report)) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <br><br>
    <?php endif; ?>

</div>

<?php $this->start('script') ?>
<script>
    $(document).ready(function () {
        top_box_position();
        all_grid_position();
        top_report_position();
    });

    function top_box_position() {
        <?php if($setting['top_box_content_num'] == 1):?>
        $('.content1').css('display', 'table-cell');
        $('.content1').css('padding-bottom', '0px');
        $('.content1').width('100%');
        <?php else:?>
        if ($(window).width() > 780) {
            $('.content1').css('display', 'table-cell');
            $('.content1').css('padding-bottom', '0px');
            $('.content2').css('display', 'table-cell');
            $('.content2').css('padding-top', '40px');
            $('.content2').css('padding-bottom', '0px');
            $('.content1').width('50%');
            $('.content2').width('50%');
        } else {
            $('.content1').css('display', 'block');
            $('.content1').css('padding-bottom', '0');
            $('.content2').css('display', 'block');
            $('.content2').css('padding-top', '10px');
            $('.content2').css('padding-bottom', '25px');
            $('.content1').width('100%');
            $('.content2').width('100%');
        }
        <?php endif?>

        resize_movie(350);
        resize_img();
    }

    function resize_img() {
        $('.top_box_img:visible').css('max-width', '95%');
        if ($('.top_box_img:visible').width() > 350) $('.top_box_img:visible').width(350);
    }
</script>
<?php $this->end() ?>
