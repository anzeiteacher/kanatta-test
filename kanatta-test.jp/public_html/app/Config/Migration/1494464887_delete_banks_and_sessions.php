<?php
class DeleteBanksAndSessions extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'delete_banks_and_sessions';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'drop_table' => array(
				'banks', 'sessions'
			),
		),
		'down' => array(
			'create_table' => array(
				'banks' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
					'bank_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '銀行名', 'charset' => 'utf8'),
					'bank_branch' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '支店名', 'charset' => 'utf8'),
					'bank_type' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '口座種類', 'charset' => 'utf8'),
					'bank_user_name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '氏名', 'charset' => 'utf8'),
					'bank_account_no' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '口座番号', 'charset' => 'utf8'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'ユーザID'),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'データ作成日時'),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'データ更新日時'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB'),
				),
				'sessions' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'data' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
					'expires' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
