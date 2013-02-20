<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Widget_Item extends Controller_Admin_Widget {

	private function _add_edit($action) {
		Assets::css('admin-form-add-edit', '/static/css/admin/form-add-edit.css');
		Assets::add_redactor();
		//---
		$id = $this->request->param('id', NULL);
		$data = array();
		$errors = array();
		$form = array();
		//---
		if ('add' == $action)
		{
			$this->template->title[] = 'Добавить блок';
			$id = NULL;
		}
		elseif ('edit' == $action)
		{
			$this->template->title[] = 'Редактировать блок';
		}
		//---
		// отправлены данные формы
		if (isset($_POST['submit']))
		{
			$form['name'] = Arr::get($_POST, 'name');
			$form['text'] = Arr::get($_POST, 'text');
			//---
			$item = array();
			$item['name'] = $form['name'];
			$item['text'] = $form['text'];
			//---
			$_errors = Widget::save($item, $id);
			if (is_array($_errors))
			{
				$errors += $_errors;
			}
			else
			{
				$this->redirect(_ar('widget'));
				return;
			}
		}
		elseif ($id)
		{
			$item = Widget::load($id);
			if ($item)
			{
				$form['name'] = $item['name'];
				$form['text'] = View::factory(Widget::get_file_by_id($id));
			}
			else
			{
				$this->redirect(_ar('widget'));
			}
		}
		//---
		$view_data = array(
				'form' => $form,
				'action' => $action,
				'errors' => $errors,
		);
		//---
		$this->template->content = View::factory('admin/widget/item', $view_data);
	}

	public function action_add()
	{
		$this->_add_edit('add');
	}

	public function action_edit()
	{
		$this->_add_edit('edit');
	}

}
