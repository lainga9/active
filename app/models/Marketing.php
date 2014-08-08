<?php

class Marketing extends \Eloquent {
	
	public function download($view, $data, $filename)
	{
		$pdf = PDF::loadView($view, $data);
		return $pdf->download($fiename . '.pdf');
	}

}