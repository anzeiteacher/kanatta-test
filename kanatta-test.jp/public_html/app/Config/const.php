<?php
//ユーザ権限
define('ADMIN_ROLE', 1); //管理者
define('USER_ROLE', 2); //通常ユーザ

//プロジェクトの決済パターン
define('ALL_OR_NOTHING', 1);
define('ALL_IN', 2);
define('MONTHLY', 3);
Configure::write('PAY_PATTERN', array(
    ALL_OR_NOTHING => 'All or Nothing',
    ALL_IN => 'All In',
    MONTHLY => '月額課金'
));
//決済パターン毎の説明文
define('ALL_OR_NOTHING_MSG', 'このプロジェクトは目標金額が達成した場合に限り、プロジェクトの成立（売買契約の成立）となります。');
define('ALL_IN_MSG', 'このプロジェクトは目標金額の達成有無にかかわらず、支援者がプロジェクトに支援を申し込んだ時点でプロジェクトの成立（売買契約の成立）となります。');
define('MONTHLY_MSG', 'このプロジェクトは目標金額の達成有無にかかわらず、支援者がプロジェクトに支援を申し込んだ時点でプロジェクトの成立（売買契約の成立）となります。またこのプロジェクトは月額課金型になります。');

//決済ステータス
define('STATUS_KARIURIAGE', 1); //仮売上状態
define('STATUS_KAKUTEI', 2); //売上確定
define('STATUS_FAIL', 3); //プロジェクト失敗
define('STATUS_MONTHLY', 4); //月額課金中
define('STATUS_CANCEL', 5); //キャンセル済
define('STATUS_STOP', 6); //サービス停止中（月額払いエラーを想定）
Configure::write('STATUSES', array(
    STATUS_KARIURIAGE => '仮売上',
    STATUS_KAKUTEI => '売上確定',
    STATUS_FAIL => 'プロジェクト失敗',
    STATUS_MONTHLY => '月額課金中',
    STATUS_CANCEL => '課金キャンセル',
    STATUS_STOP => 'サービス停止中'
));
define('CHARGE_OK', 1); //課金成功
define('CHARGE_NG', 2); //課金失敗
Configure::write('CHARGE_RESULTS', array(
    CHARGE_OK => '成功',
    CHARGE_NG => '失敗'
));
//リターン受け渡し手法
Configure::write('DELIVERY', array(1 => 'メール', 2 => '郵送', 3 => '対面'));

//事業者の法人or個人
Configure::write('COMPANY_TYPE', array(1 => '法人', 2 => '個人'));

//エラー文
define('OSORE', '恐れ入りますが再度お試しください。');
define('KESSAI_NETWORK_ERROR', '決済サービスとの通信に失敗しました。大変恐れ入りますが、しばらく経ってから再度お試しください。');
//twitter画像登録時に使う（ユーザプロフィール画像のフィールド名）
define('USER_IMG_FIELD_NAME', 'img');