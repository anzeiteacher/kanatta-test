<?php
class AddFieldNoGoalToProjects extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'areas' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'order' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'comment' => '表示順'),
				),
				'attachments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false),
					'file_size' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false),
				),
				'backed_projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'プロジェクトID'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザID'),
					'backing_level_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => '支援パターンID'),
					'pay_pattern' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'unsigned' => false),
					'status' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'unsigned' => false, 'comment' => '決済ステータス'),
					'charge_result' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1, 'unsigned' => false, 'comment' => '課金結果'),
				),
				'backing_levels' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'プロジェクトID'),
					'max_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'unsigned' => false, 'comment' => '最大支援数'),
					'now_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'unsigned' => false, 'comment' => '現在の支援数'),
					'delivery' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => 'リターン方法'),
				),
				'banks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザID'),
				),
				'categories' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'order' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'unsigned' => false, 'comment' => '表示順'),
				),
				'comments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザID'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'favourite_projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザID'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'mail_auths' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => 'ユーザID'),
				),
				'message_pairs' => array(
					'last_sender_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'comment' => '最後の送信者'),
					'last_receiver_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'comment' => '最後の受信者'),
				),
				'messages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'from_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'comment' => '送信者ID'),
					'to_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'comment' => '受信者ID'),
				),
				'news' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
				),
				'project_content_orders' => array(
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'key' => 'primary', 'comment' => 'プロジェクトID'),
				),
				'project_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => 'プロジェクトID'),
					'open' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'unsigned' => false, 'comment' => '公開ステータス'),
				),
				'projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'pay_pattern' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false),
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'カテゴリ１ID'),
					'area_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => 'エリアID'),
					'goal_amount' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9, 'unsigned' => false, 'comment' => '目標金額'),
					'goal_backers' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 8, 'unsigned' => false),
					'collection_term' => array('type' => 'integer', 'null' => false, 'default' => '60', 'length' => 2, 'unsigned' => false, 'comment' => '募集期間（日）'),
					'thumbnail_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => 'サムネイル種別'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザID'),
					'backers' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false, 'comment' => '支援者数'),
					'comment_cnt' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'unsigned' => false, 'comment' => 'コメント数'),
					'report_cnt' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'unsigned' => false, 'comment' => '活動報告数'),
					'collected_amount' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'unsigned' => false, 'comment' => '現在の支援総額'),
					'site_fee' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2, 'unsigned' => false, 'comment' => 'サイト手数料率'),
					'site_price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'comment' => 'サイト手数料'),
					'project_owner_price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'unsigned' => false, 'comment' => 'プロジェクト起案者への支払額'),
				),
				'report_content_orders' => array(
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'key' => 'primary', 'comment' => '活動報告ID'),
				),
				'report_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'key' => 'primary'),
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => '活動報告ID'),
				),
				'reports' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'sessions' => array(
					'expires' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false),
				),
				'settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'unsigned' => false, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => 'ユーザID'),
					'fee' => array('type' => 'integer', 'null' => false, 'default' => '20', 'length' => 2, 'unsigned' => false, 'comment' => 'サイト手数料'),
					'company_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => '法人or個人'),
					'toppage_pickup_project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'unsigned' => false, 'comment' => 'ピックアッププロジェクト'),
					'top_alpha' => array('type' => 'integer', 'null' => false, 'default' => '80', 'length' => 2, 'unsigned' => false, 'comment' => 'トップの透明度'),
					'top_box_black' => array('type' => 'integer', 'null' => false, 'default' => '60', 'length' => 2, 'unsigned' => false, 'comment' => 'トップ上段の黒の透明度'),
					'top_box_height' => array('type' => 'integer', 'null' => false, 'default' => '500', 'length' => 3, 'unsigned' => false, 'comment' => 'トップ上段の高さ'),
					'top_box_content_num' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => 'トップ上段のコンテンツ数'),
					'cat_type_num' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false, 'comment' => '利用するカテゴリ種類数'),
				),
				'users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'unsigned' => false, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'unsigned' => false, 'comment' => 'ユーザ権限'),
					'login_try_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'unsigned' => false, 'comment' => 'ログイン試行回数'),
				),
			),
			'create_field' => array(
				'projects' => array(
					'no_goal' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'pay_pattern'),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'areas' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'order' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'comment' => '表示順'),
				),
				'attachments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'model_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'file_size' => array('type' => 'integer', 'null' => false, 'default' => NULL),
				),
				'backed_projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'プロジェクトID'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザID'),
					'backing_level_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => '支援パターンID'),
					'pay_pattern' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1),
					'status' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'comment' => '決済ステータス'),
					'charge_result' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1, 'comment' => '課金結果'),
				),
				'backing_levels' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'プロジェクトID'),
					'max_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 5, 'comment' => '最大支援数'),
					'now_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 5, 'comment' => '現在の支援数'),
					'delivery' => array('type' => 'integer', 'null' => true, 'default' => '1', 'length' => 1, 'comment' => 'リターン方法'),
				),
				'banks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザID'),
				),
				'categories' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'order' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 2, 'comment' => '表示順'),
				),
				'comments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザID'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'プロジェクトID'),
				),
				'favourite_projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザID'),
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'プロジェクトID'),
				),
				'mail_auths' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'ユーザID'),
				),
				'message_pairs' => array(
					'last_sender_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '最後の送信者'),
					'last_receiver_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '最後の受信者'),
				),
				'messages' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'from_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '送信者ID'),
					'to_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '受信者ID'),
				),
				'news' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
				),
				'project_content_orders' => array(
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'comment' => 'プロジェクトID'),
				),
				'project_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'comment' => 'プロジェクトID'),
					'open' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => '公開ステータス'),
				),
				'projects' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'pay_pattern' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1),
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'カテゴリ１ID'),
					'area_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'エリアID'),
					'goal_amount' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9, 'comment' => '目標金額'),
					'goal_backers' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 8),
					'collection_term' => array('type' => 'integer', 'null' => false, 'default' => '60', 'length' => 2, 'comment' => '募集期間（日）'),
					'thumbnail_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => 'サムネイル種別'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザID'),
					'backers' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => '支援者数'),
					'comment_cnt' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'コメント数'),
					'report_cnt' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3, 'comment' => '活動報告数'),
					'collected_amount' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'comment' => '現在の支援総額'),
					'site_fee' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2, 'comment' => 'サイト手数料率'),
					'site_price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'サイト手数料'),
					'project_owner_price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => 'プロジェクト起案者への支払額'),
				),
				'report_content_orders' => array(
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary', 'comment' => '活動報告ID'),
				),
				'report_contents' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'comment' => '活動報告ID'),
				),
				'reports' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'プロジェクトID'),
				),
				'sessions' => array(
					'expires' => array('type' => 'integer', 'null' => true, 'default' => NULL),
				),
				'settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 1, 'key' => 'primary'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'comment' => 'ユーザID'),
					'fee' => array('type' => 'integer', 'null' => false, 'default' => '20', 'length' => 2, 'comment' => 'サイト手数料'),
					'company_type' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => '法人or個人'),
					'toppage_pickup_project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'ピックアッププロジェクト'),
					'top_alpha' => array('type' => 'integer', 'null' => false, 'default' => '80', 'length' => 2, 'comment' => 'トップの透明度'),
					'top_box_black' => array('type' => 'integer', 'null' => false, 'default' => '60', 'length' => 2, 'comment' => 'トップ上段の黒の透明度'),
					'top_box_height' => array('type' => 'integer', 'null' => false, 'default' => '500', 'length' => 3, 'comment' => 'トップ上段の高さ'),
					'top_box_content_num' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => 'トップ上段のコンテンツ数'),
					'cat_type_num' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'comment' => '利用するカテゴリ種類数'),
				),
				'users' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'group_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'ユーザ権限'),
					'login_try_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'comment' => 'ログイン試行回数'),
				),
			),
			'drop_field' => array(
				'projects' => array('no_goal',),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
