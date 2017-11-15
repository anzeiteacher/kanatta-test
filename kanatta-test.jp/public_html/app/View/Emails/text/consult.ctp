<?php echo h($data['Consult']['name']) ?> 様

Kanatta事務局です。

コンサルタントへのご相談を承りました。

下記内容について、確認の上、返信いたしますので、
今しばらくお待ちください。

何卒、宜しくお願いいたします。


◇◇ご相談内容◇◇～*～*～*～*～*～*～*～*～

[お名前]：<?php echo h($data['Consult']['name'])."\n\n" ?>
[メールアドレス]：<?php echo h($data['Consult']['mail'])."\n\n" ?>
[電話番号]：<?php echo h($data['Consult']['phone'])."\n\n" ?>

[プロジェクト概要]
<?php echo h($data['Consult']['overview'])."\n\n" ?>

[ご相談内容]
<?php echo h($data['Consult']['content'])."\n" ?>

～*～*～*～*～*～*～*～*～～*～*～*～*～*～*～

