<?php
class AddIndex extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_index';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'backed_projects' => array(
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'プロジェクトID'),
				),
				'comments' => array(
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'プロジェクトID'),
				),
				'favourite_projects' => array(
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'ユーザID'),
				),
				'project_contents' => array(
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'key' => 'index', 'comment' => 'プロジェクトID'),
				),
				'projects' => array(
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'カテゴリ１ID'),
				),
				'report_contents' => array(
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'key' => 'index', 'comment' => '活動報告ID'),
				),
				'users' => array(
					'email' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'comment' => 'メールアドレス', 'charset' => 'utf8'),
				),
			),
			'create_field' => array(
				'backed_projects' => array(
					'indexes' => array(
						'forPjView' => array('column' => array('project_id', 'status', 'manual_flag', 'created'), 'unique' => 1),
					),
				),
				'comments' => array(
					'indexes' => array(
						'pjId_created' => array('column' => array('project_id', 'created'), 'unique' => 0),
					),
				),
				'favourite_projects' => array(
					'indexes' => array(
						'userId_pjId' => array('column' => array('user_id', 'project_id'), 'unique' => 1),
					),
				),
				'project_contents' => array(
					'indexes' => array(
						'pjId_open' => array('column' => array('project_id', 'open'), 'unique' => 0),
					),
				),
				'projects' => array(
					'indexes' => array(
						'search' => array('column' => array('category_id', 'area_id', 'collection_end_date', 'opened', 'collected_amount', 'created', 'stop'), 'unique' => 1),
					),
				),
				'report_contents' => array(
					'indexes' => array(
						'report_id' => array('column' => 'report_id', 'unique' => 0),
					),
				),
				'users' => array(
					'indexes' => array(
						'email' => array('column' => 'email', 'unique' => 0),
					),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'backed_projects' => array(
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'comments' => array(
					'project_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'favourite_projects' => array(
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'ユーザID'),
				),
				'project_contents' => array(
					'project_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'comment' => 'プロジェクトID'),
				),
				'projects' => array(
					'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'カテゴリ１ID'),
				),
				'report_contents' => array(
					'report_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => false, 'comment' => '活動報告ID'),
				),
				'users' => array(
					'email' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => 'メールアドレス', 'charset' => 'utf8'),
				),
			),
			'drop_field' => array(
				'backed_projects' => array('indexes' => array('forPjView')),
				'comments' => array('indexes' => array('pjId_created')),
				'favourite_projects' => array('indexes' => array('userId_pjId')),
				'project_contents' => array('indexes' => array('pjId_open')),
				'projects' => array('indexes' => array('search')),
				'report_contents' => array('indexes' => array('report_id')),
				'users' => array('indexes' => array('email')),
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
