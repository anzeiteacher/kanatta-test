<div class="sub_menu_wrap">
    <div class="sub_menu <?php echo ($mode == 'profile') ? 'active' : ''?>" onclick="location.href='<?php echo $this->Html->url('/users/edit')?>';">
        プロフィール編集
    </div>
    <div class="sub_menu <?php echo ($mode == 'pass') ? 'active' : ''?>" onclick="location.href='<?php echo $this->Html->url('/users/change_password')?>';">
        パスワード変更
    </div>
    <div class="sub_menu <?php echo ($mode == 'social') ? 'active' : ''?>" onclick="location.href='<?php echo $this->Html->url('/social')?>';">
        ソーシャル連携
    </div>
</div>