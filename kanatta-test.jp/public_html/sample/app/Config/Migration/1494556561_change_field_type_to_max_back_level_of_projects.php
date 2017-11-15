<?php
class ChangeFieldTypeToMaxBackLevelOfProjects extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'change_field_type_to_max_back_level_of_projects';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'projects' => array(
					'max_back_level' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 2, 'unsigned' => false, 'comment' => '支援パターン数'),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'projects' => array(
					'max_back_level' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_unicode_ci', 'comment' => '支援パターン数', 'charset' => 'utf8'),
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
