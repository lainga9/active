<?php namespace Services\Repositories;

use Services\Interfaces\UploadInterface;

class DefaultUpload implements UploadInterface {

	public function fire($file)
	{
		if( $file == false ) return null;

		$path 		= 'uploads/' . str_random(20);
		$filename 	= $file->getClientOriginalName();
		$upload 	= $file->move($path, $filename);

		if($upload)
		{
			return $upload;
		}
		else
		{
			throw new Exception('Problem Uploading File');
		}
	}

}