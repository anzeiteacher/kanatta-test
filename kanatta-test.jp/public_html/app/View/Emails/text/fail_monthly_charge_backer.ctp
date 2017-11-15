<?php echo $backer['nick_name'] ? $backer['nick_name'] : $backer['name'] ?> 様

下記プロジェクトに対する、月額課金が失敗しました。

■プロジェクト概要
・プロジェクト名： 『<?php echo $pj['project_name'] ?>』
・URL:　<?php echo $pj['url']."\n"?>

■課金内容（失敗）
・課金日: <?php echo date('Y年m月d日', strtotime($result['old_charge_date']))."\n" ?>
・金額： <?php echo number_format($result['amount']) ?>円

恐れ入りますが、ご確認いただけますようお願いいたします。
クレジットカードを変更される場合は、ログインの上、下記URLからカードの変更手続きを行ってください。

<?php echo $result['url']."\n"?>

何卒、宜しくお願いいたします。

