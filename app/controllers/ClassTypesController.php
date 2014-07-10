<?php

class ClassTypesController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $classType;

	public function __construct(ClassType $classType)
	{
		$this->classType = $classType;
	}

	/**
	 * Display a listing of the resource.
	 * GET /classtypes
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /classtypes/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$classTypes = $this->classType->whereParentId(0)->get();

		$data = [
			'classTypes'		=> $classTypes
		];

		$this->layout->content = View::make('classTypes.create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /classtypes
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = new Services\Validators\ClassType;

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withInput()
			->withErrors($validation->errors);
		}

		$classType = $this->classType->create(Input::all());

		return Redirect::back()
		->with('success', 'Class type added successfully');
	}

	/**
	 * Display the specified resource.
	 * GET /classtypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /classtypes/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /classtypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /classtypes/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}