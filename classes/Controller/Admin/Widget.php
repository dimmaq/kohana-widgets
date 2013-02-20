<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Widget extends Controller_Admin {

	protected $mmenu_cur = 'widget';

	public function before()
	{
		parent::before();
		//---
		//Assets::css('admin_pages', '/static/css/admin/pages/main.css');
	}

}
