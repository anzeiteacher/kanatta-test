<?php echo $user['User']['nick_name'] ? h($user['User']['nick_name']) : h($user['User']['name']) ?> 様

いつも<?php echo !empty($setting['site_name']) ? h($setting['site_name']) : SITE_NAME ?>
をご利用いただき、ありがとうございます。

「<?php echo h($pj['Project']['project_name'])?>」の活動報告が新たに登録されました。
よろしければ、下記からご確認ください。

タイトル： <?php echo h($report['Report']['title'])."\n"?>
URL　　： <?php echo h($url)?>

