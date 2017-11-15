<?php echo $user['nick_name'] ? $user['nick_name'] : $user['name'] ?> 様

『<?php echo h($pj['project_name']) ?>』のキャンセルが発生しました。

■キャンセルされた内容
・支援金額：<?php echo h(number_format($bp['invest_amount']))?>円／月
・課金開始日：<?php echo $bp['charge_start_date']."\n"?>
・前回課金日：<?php echo $bp['old_charge_date']."\n"?>
・前回結果：<?php echo $bp['charge_result']."\n"?>

■キャンセル日
<?php echo date('Y/m/d')?>

ご確認の程、宜しくお願いいたします。