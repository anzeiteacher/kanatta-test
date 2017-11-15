<?php echo $user['User']['nick_name'] ? $user['User']['nick_name'] : $user['User']['name'] ?> 様

ご支援いただいた下記プロジェクトの募集期間が終了し、プロジェクトは成功しました！

■プロジェクト概要
・プロジェクト名： 『<?php echo $pj['Project']['project_name'] ?>』
・目標金額： <?php echo number_format($pj['Project']['goal_amount']) ?>円
・支援総額： <?php echo number_format($pj['Project']['collected_amount']) ?>円
・支援人数： <?php echo number_format($pj['Project']['backers']) ?>人

■ご支援いただいた内容
・支援日時: <?php echo date('Y年m月d日 H時i分', strtotime($bp['BackedProject']['created']))."\n" ?>
・支援金額： <?php echo number_format($bp['BackedProject']['invest_amount']) ?>円
・支援コメント：
<?php echo $bp['BackedProject']['comment']."\n" ?>

ご支援いただきまして、ありがとうございました！
今後とも、宜しくお願いいたします。

