<?php defined('SYSPATH') or die('No direct script access.');

function widget($name, $data = NULL)
{
	echo Widget::factory($name, $data);
}