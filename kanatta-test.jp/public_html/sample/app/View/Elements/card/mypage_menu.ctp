<div class="sub_menu_wrap">
    <div class="sub_menu <?php echo ($mode == 'card') ? 'active' : ''?>" onclick="location.href='<?php echo $this->Html->url('/card')?>';">
        クレジットカード登録
    </div>
    <div class="sub_menu <?php echo ($mode == 'monthly') ? 'active' : ''?>" onclick="location.href='<?php echo $this->Html->url('/card/monthly')?>';">
        月額課金PJの支援一覧
    </div>
</div>