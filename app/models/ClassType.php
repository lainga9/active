<?php

class ClassType extends \Eloquent {
	protected $guarded = [];

	public static function findParent($classType)
	{
		if($classType->parent_id != 0)
		{
			return ClassType::find($parent_id);
		}

		return null;
	}

	public static function findChildren($classType)
	{
		return ClassType::whereParentId($classType->id)->get();
	}

	public static function printHTML($classTypes)
	{
		if(!$classTypes)
		{
			return 'No Classes';
		}

		$html = '<ul>';

		foreach( $classTypes as $classType )
		{
			if( $classType->parent_id == 0)
			{
				$html .= '<li>' . $classType->name . '</li>';
				$children = ClassType::whereParentId($classType->id)->get();
				if( count($children) )
				{
					$html .= '<ul>';

					foreach( $children as $child )
					{
						$html .= '<li>' . $child->name . '</li>';
 					}

 					$html .= '</ul>';
				}
			}
		}

		$html .= '</ul>';

		return $html;
	}

	public static function printFormHTML()
	{
		$classTypes = ClassType::all();
		if(!$classTypes)
		{
			return 'No Classes';
		}

		$html = '';

		foreach( $classTypes as $classType )
		{
			if( $classType->parent_id == 0)
			{
				$html .= '<h5>' . $classType->name . '</h5>';
				$children = ClassType::whereParentId($classType->id)->get();
				if( count($children) )
				{
					foreach( $children as $child )
					{
						$html .= '<label>' . $child->name . '</label>';
						$html .= Form::checkbox('class_type_id[]', $child->id);
 					}
				}
				else
				{
					$html .= '<p>There are no classes in this category.</p>';
				}
			}
		}

		$html .= '</ul>';

		return $html;	
	}
}