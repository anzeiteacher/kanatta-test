<?php echo $this->Html->css('search', null, array('inline' => false)) ?>
<?php echo $this->Html->css('grid', null, array('inline' => false)) ?>
<?php echo $this->Html->script('grid_position', array('inline' => false)) ?>
<?php if($smart_phone): ?>
    <?php echo $this->Html->css('sp/grid_sp', null, array('inline' => false)) ?>
<?php endif ?>
<?php echo $this->Form->create('Project', array(
    'inputDefaults' => array(
            'class' => 'form-control', 'label' => false, 'div' => false
    )
)) ?>

<div class="search_box_wrap clearfix">
    <div class="clearfix">
        <div class="search_box">
            <div class="form-group category">
                <?php echo $this->Form->input('category_id', array(
                    'options' => $categories, 'empty' => $setting['cat1_name'],
                )); ?>
            </div>
            <?php if($setting['cat_type_num'] == 2):?>
                <div class="form-group category">
                    <?php echo $this->Form->input('area_id', array(
                        'options' => $areas, 'empty' => $setting['cat2_name'],
                    )); ?>
                </div>
            <?php endif;?>
        </div>
        <div class="search_box">
            <?php if($this->Setting->can_d_area($setting)):?>
                <div class="form-group category">
                    <?php echo $this->Form->input('birth_area', array(
                        'options' => Configure::read('PREFECTURES'), 'empty' => '出身地',
                    )); ?>
                </div>
            <?php endif;?>
            <?php if($this->Setting->can_d_school($setting)):?>
                <div class="form-group category">
                    <?php echo $this->Form->input('school', array('type' => 'text',
                        'placeholder' => '出身校')); ?>
                </div>
            <?php endif;?>
        </div>
        <div class="search_box">
            <div class="form-group sort">
                <?php echo $this->Form->input('order', array(
                    'options' => array(
                        '1' => '支援金額が多い順', '2' => '新着順', '3' => '募集終了が近い順'
                    ),
                    'empty' => 'ソート',
                )); ?>
            </div>
        </div>
    </div>
    <div class="search_submit_wrap">
        <?php echo $this->Form->submit('検索', array('class' => 'btn btn-primary btn-sm search_submit')); ?>
    </div>
</div>

<?php echo $this->Form->end(); ?>

    <h3 class="title"><span class="el-icon-search"></span> 検索結果</h3>
    <div class="grid_container clearfix ">
        <?php foreach($projects as $idx => $project): ?>
            <?php echo $this->element('project_box/project_box_for_normal', array('project' => $project)) ?>
        <?php endforeach; ?>
    </div>

    <div class="container">
        <?php echo $this->element('base/pagination') ?>
    </div>

<?php $this->start('script') ?>
    <script>
        $(document).ready(function () {
            all_grid_position();
        });
    </script>
<?php $this->end() ?>