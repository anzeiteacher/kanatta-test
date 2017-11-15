<?php echo $backer['nick_name'] ? $backer['nick_name'] : $backer['name'] ?> 様

下記プロジェクトに対する月額課金が完了しました。
ご利用いただき誠にありがとうございます。
引き続き、宜しくお願いいたします。

■プロジェクト概要
・プロジェクト名： 『<?php echo $pj['project_name'] ?>』
・URL:　<?php echo $pj['url']."\n"?>

■課金内容
・課金日: <?php echo date('Y年m月d日', strtotime($result['old_charge_date']))."\n" ?>
・金額： <?php echo number_format($result['amount']) ?>円

