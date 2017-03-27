<?php

/**
 * Class ListAdmin
 *
 * An admin to manage TodoList objects
 */
class TasksAdmin extends ModelAdmin {

	/**
	 * @var array
	 * @config
	 */
	private static $managed_models = [
		'TodoTask',
	];

	/**
	 * @var string
	 * @config
	 */
	private static $menu_title = 'Tasks Lists';

	/**
	 * @var string
	 * @config
	 */
	private static $url_segment = 'tasks';

	/**
	 * @var int
	 * @config
	 */
	private static $menu_priority = 1;

	/**
	 * @var string
	 * @config
	 */
	private static $menu_icon = 'framework/admin/images/menu-icons/16x16/db.png';

	public function getEditForm($id = null, $fields = null) {
		$form = parent::getEditForm($id, $fields);
		$gridField = $form->Fields()->first();
		$fieldConfig = $gridField->getConfig();
		if (ClassInfo::exists('GridFieldOrderableRows')) {
			$fieldConfig->addComponent(new GridFieldOrderableRows('Sort'));
		}
		if (ClassInfo::exists('GridFieldAddExistingSearchButton')) {
			$fieldConfig->addComponent(new GridFieldAddExistingSearchButton());
		}
		$fieldConfig->addComponent(new TaskGridFieldAction());

		return $form;
	}

}
