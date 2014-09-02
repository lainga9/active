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

	public function Children()
	{
		return $this->hasMany('ClassType', 'parent_id');
	}

	public function isSelected()
	{
		if( isset($_GET['class_type_id']) )
		{
			foreach( $_GET['class_type_id'] as $id )
			{
				if( $id == $this->id )
				{
					return 'selected';
				}
			}
		}

		return '';
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

	public static function printFormHTML(Activity $activity = null)
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
						$checked = false;

						if($activity)
						{
							$checked = $activity->classTypes->contains($child->id) ? true : false;
						}
						else
						{
							$checked = Input::get('class_type_id') ? in_array($child->id, Input::get('class_type_id')) : null;
						}
				
						$html .= '<label>' . $child->name . '</label>';
						$html .= Form::checkbox('class_type_id[]', $child->id, $checked);
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