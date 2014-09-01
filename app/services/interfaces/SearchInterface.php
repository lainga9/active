<?php namespace Services\Interfaces;

interface SearchInterface {

	public function activities($input);
	public function users($input);
	public function organisations($input);

}