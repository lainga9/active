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

	// Checks if the classtype is selected when using jQuery chosen multiselect. Activity variable used for when editing an activity
	public function isSelected($activity = null)
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

		if( $activity )
		{
			if( $activity->classTypes )
			{
				foreach( $activity->classTypes as $classType )
				{
					if( $classType->id == $this->id)
					{
						return 'selected';
					}
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
}