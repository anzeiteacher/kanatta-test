<div class="header_menu">
    <div class="menu-contents" onclick="location.href='<?php echo $this->Html->url('/projects/view/'.$project['Project']['id']) ?>';">
        <span class="el-icon-website"></span><span class="hidden-xs"> 詳細</span>
    </div>
    <div class="menu-contents" onclick="location.href='<?php echo $this->Html->url('/projects/view/'.$project['Project']['id'].'/report') ?>';">
        <span class="el-icon-bullhorn"></span><span class="hidden-xs"> 活動報告</span>
        <span class="label label-default hidden-xs">
			<?php echo number_format(h($project['Project']['report_cnt'])) ?>
		</span>
    </div>
    <div class="menu-contents" onclick="location.href='<?php echo $this->Html->url('/projects/view/'.$project['Project']['id'].'/backers') ?>';">
        <span class="el-icon-group"></span><span class="hidden-xs"> サポーター</span>
        <span class="label label-default hidden-xs">
			<?php echo number_format(h($project['Project']['backers'])) ?>
		</span>
    </div>
    <div class="menu-contents" onclick="location.href='<?php echo $this->Html->url('/projects/view/'.$project['Project']['id'].'/comment') ?>';">
        <span class="el-icon-comment"></span><span class="hidden-xs"> コメント</span>
        <span class="label label-default hidden-xs">
			<?php echo number_format(h($project['Project']['comment_cnt'])) ?>
		</span>
    </div>
</div>

<script>

</script>


<style>
.right .clearfix.sub{
    position: relative;
}
.heart-on, .heart-off{
  display: inline-block;
  vertical-align: middle;
  width: 25px;
  height: 25px;
  background-position: 0 0;
  cursor: pointer;
}
.heart-on{
  background: url(../../../img/common/heart_on.png) no-repeat;
}
.heart-off{
  background: url(../../../img/common/heart_off.png) no-repeat;
}
.btn-like{
    position: absolute;
    right: 0;
    top: -25px;
}
.btn-favorite.like{
    border: none;
    background-color: rgba(255, 255, 255, 0);
    color: #333;
    text-shadow: none;
    outline:none;
}

#contents .btn-favorite:hover {
    color: #757575;
}
#contents .btn-favorite.like-add:hover{
    color: #868686;
}
.project_header .header_menu div{
    background-color: #fff;
}

/* ハートアニメーション
.heart {
  display: inline-block;
  vertical-align: middle;
  width: 100px;
  height: 100px;
  background: url(../../../img/common/heart_animation.png) no-repeat;
  background-position: 0 0;
  cursor: pointer;
}
.heart:hover {
  background-position: -2900px 0;
  -webkit-transition: background 1s steps(28);
  transition: background 1s steps(28);
}
.btn-like{
    position: absolute;
    right: 0;
}
.btn-primary.like{
    border: none;
    background-color: #fff;
    color: #333;
    text-shadow: none;
}
*/

</style>
