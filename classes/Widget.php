<?php defined('SYSPATH') or die('No direct script access.');

class Widget {

	const TABLE_NAME = 'widgets';
	const VIEW_PATH = 'widgets/';

	static $_labels = array(
			'name' => 'имя',
			'text' => 'текст',
	);

	static $_rules = array(
			'name' => array(
					array('not_empty'),
					array('max_length', array(':value', 255)),
			),
	);

	private static function validate($data)
	{
		$check = Validation::factory($data);
//		$check->labels(self::$_labels);
		foreach(self::$_rules as $key => $value)
			$check->rules($key, $value);
		if ($check->check())
			return TRUE;
		else
			return $check->errors('');
	}

	public static function get_all()
	{
		return DB::select()->from(self::TABLE_NAME)->order_by('name')->execute()->as_array();
	}

	private static function get_id_by_name($name)
	{
		$res = DB::select('id')->from(self::TABLE_NAME)->where('name', '=', $name)->limit(1)->execute();
		return $res->get('id');;
	}

	public static function save($data, $id = NULL)
	{
		$errors = self::validate($data);
		if ($errors !== TRUE)
			return $errors;
		//---
		$text = $data['text'];
		unset($data['text']);
		unset($data['id']);
		try
		{
			if ($id)
			{
				DB::update(self::TABLE_NAME)->set($data)->where('id', '=', $id)->limit(1)->execute();
			}
			else
			{
				$res = DB::insert(self::TABLE_NAME, array_keys($data))->values(array_values($data))->execute();
				$id = $res[0];
			}
		}
		catch (Database_Exception $E) {
			if ($E->getCode() == 1062)
			{
				return array('name' => 'имя уже существует');
			}
			else
			{
				throw $E;
			}
		}
		catch (Exception $E) {
			throw $E;
		}
		$file = Widget::get_file_by_id($id);
		$efile .= '.raw';
		$xfile .= EXT;
		@rename($efile, $file . '.bak');
		@file_put_contents($efile, $text);
		@file_put_contents($xfile, Redactor::html2php($text));
		//---
		return TRUE;
	}

	public static function load($id)
	{
		$res = DB::select()->from(self::TABLE_NAME)->where('id', '=', $id)->limit(1)->execute()->as_array();
		if (!$res)
			return FALSE;
		//---
		$item = $res[0];
		$item['text'] = @file_get_contents(Widget::get_file_by_id($item['id']) . '.raw');
		return $item;
	}

	public static function get_view_by_id($id)
	{
		return self::VIEW_PATH . $id;
	}

	public static function get_file_by_id($id)
	{
		return APPPATH . 'views/' . self::get_view_by_id($id);
	}

	public static function factory($name, $data = NULL)
	{
		return View::factory(self::get_view_by_id(self::get_id_by_name($name)), $data);
	}


}
