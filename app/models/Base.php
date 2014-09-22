<?php

class Base extends \Eloquent {
	
	public static $days = [
		1 => 'Monday', 
		2 => 'Tuesday',
		3 => 'Wednesday',
		4 => 'Thursday',
		5 => 'Friday',
		6 => 'Saturday',
		7 => 'Sunday'
	];

	public static function toSelect($collection, $key = null, $default = null)
	{
		if(empty($collection))
		{
			return null;
		}

		$key = $key ?: 'name';

		$collection = $collection->toArray();

		$output = [];

		if($default)
		{
			$output[''] = $default;
		}

		foreach($collection as $item)
		{
			$output[$item['id']] = $item[$key];
		}

		return $output;
	}

	public static function boolean($int)
	{
		return $int == 1 ? 'Yes' : 'No';
	}

	public static function toSlug($string)
	{
    	return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
	}

	public static function mainClass()
	{
		return 'col-md-9';
	}

	public static function sidebarClass()
	{
		return 'col-md-3';
	}

}