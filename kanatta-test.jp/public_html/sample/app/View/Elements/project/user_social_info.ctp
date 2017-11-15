<?php if(!empty($project['User']['User']['fb_name'])):?>
    <div style="margin:10px 0">
        <a href="https://www.facebook.com/<?php echo h($project['User']['User']['fb_name'])?>" class="btn btn-primary btn-sm" target="_blank">
            <span class="el-icon-facebook"></span> Facebook
        </a>
    </div>
<?php endif;?>
<?php if(!empty($project['User']['User']['tw_screen_name'])):?>
    <a class="twitter-timeline" data-height="300" href="https://twitter.com/<?php echo h($project['User']['User']['tw_screen_name'])?>"></a>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php endif;?>