<?php echo $backer['User']['nick_name'] ? $backer['User']['nick_name'] : $backer['User']['name'] ?> 様

『<?php echo $project['Project']['project_name'] ?>』にご支援いただきありがとうございます！
<?php if($project['Project']['pay_pattern'] == ALL_OR_NOTHING):?>
プロジェクトの募集期間終了時に再度募集結果についてご連絡いたします。
<?php else:?>
リターン詳細についてプロジェクトオーナーからご連絡がありますので、今しばらくお待ちくださいませ。
<?php endif;?>

■ご支援内容
・日時: <?php echo date('Y年m月d日 H時i分', strtotime($backed_project['BackedProject']['created']))."\n" ?>
・金額： <?php echo number_format($backed_project['BackedProject']['invest_amount']) ?>円<?php
if($project['Project']['pay_pattern'] == MONTHLY){echo "／月\n";}else{echo "\n";}?>
・コメント：
<?php echo $backed_project['BackedProject']['comment']."\n\n" ?>

今後とも、宜しくお願いいたします。

