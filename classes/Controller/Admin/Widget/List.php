<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Widget_List extends Controller_Admin_Widget {

	public function action_index() {
		$view_data = array(
				'items' => Widget::get_all(),
		);
		$this->template->content = View::factory('admin/widget/list', $view_data);
	}

}
