<?php

class AdminCouponDefaultTextController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.coupons.defaults.text');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$text = DefaultField::findOrFail($id);
		$users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');
        return View::make('admin.coupons.defaults.editText')->with('text', $text)->with('users', $users);
		
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	
	public function update($id)
	{
		$text = DefaultField::findOrFail($id);

        $text->fill(Input::all());
		
		
		$text->save();
        return Redirect::to('/admin/coupons/default-text');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}