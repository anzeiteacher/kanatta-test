<?php echo $owner['nick_name'] ? $owner['nick_name'] : $owner['name'] ?> 様

下記プロジェクトに対する、<?php echo $backer['name'] ? $backer['name'] : $backer['nick_name'] ?>
様の月額課金が失敗しました。

■プロジェクト概要
・プロジェクト名： 『<?php echo $pj['project_name'] ?>』
・URL:　<?php echo $pj['url']."\n"?>

■課金内容（失敗）
・課金日: <?php echo date('Y年m月d日', strtotime($result['old_charge_date']))."\n" ?>
・金額： <?php echo number_format($result['amount']) ?>円

何卒、宜しくお願いいたします。

