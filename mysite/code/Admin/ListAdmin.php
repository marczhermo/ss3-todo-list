<?php

/**
 * Class ListAdmin
 *
 * An admin to manage TodoList objects
 */
class ListAdmin extends ModelAdmin {

	/**
	 * @var array
	 * @config
	 */
	private static $managed_models = array(
		'TodoList',
		// 'TodoTask',
	);

	/**
	 * @var string
	 * @config
	 */
	private static $menu_title = 'Todo Lists';

	/**
	 * @var string
	 * @config
	 */
	private static $url_segment = 'todos';

	/**
	 * @var int
	 * @config
	 */
	private static $menu_priority = 1;

	/**
	 * @var string
	 * @config
	 */
	private static $menu_icon = 'framework/admin/images/menu-icons/16x16/pencil.png';

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

		return $form;
	}

}
