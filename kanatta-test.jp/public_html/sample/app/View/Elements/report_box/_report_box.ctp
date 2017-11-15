<?php if($report['Report']['open'] == 1): ?>
<div class="grid_report" onclick="location.href='<?php echo $this->Html->url(array(
        'controller' => 'projects', 'action' => 'view', $report['Report']['project_id'], 'report_view',
        $report['Report']['id']
)) ?>'">
    <?php else: ?>
    <div class="grid_report no_url">
        <?php endif ?>

        <?php echo $this->element('report_box/inner/_project_box_img', compact('report')) ?>

        <?php if(empty($opened)){
            $opened = null;
        } ?>

        <div class="report_box_header">
            <?php echo $this->element('report_box/inner/_project_box_string_head', array(
                    'report' => $report, 'opened' => $opened
            )) ?>
        </div>
        <div class="report_box_footer">
            <?php echo $this->element('report_box/inner/_project_box_footer', array(
                    'report' => $report, 'opened' => $opened
            )) ?>
        </div>
    </div>
