<?php
class AddDisplayUserBirthSchoolEtcToSettings extends CakeMigration {

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
			'create_field' => array(
				'settings' => array(
					'display_user_birth_school' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'google_analytics'),
					'display_user_birth_area' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'after' => 'display_user_birth_school'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'settings' => array('display_user_birth_school', 'display_user_birth_area',),
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
