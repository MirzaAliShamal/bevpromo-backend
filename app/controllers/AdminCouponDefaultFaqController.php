<?php

class AdminCouponDefaultFaqController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.coupons.defaults.faq');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        
        return View::make('admin.coupons.defaults.createFaq')->with('users', $users);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$faq = new DefaultFaq;
        $faq->fill(Input::all());
        $faq->save();
        return Redirect::to('/admin/coupons/default-faq');
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
		$faq = DefaultFaq::findOrFail($id);
		$users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');
        return View::make('admin.coupons.defaults.editFaq')->with('faq', $faq)->with('users', $users);
		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$faq = DefaultFaq::findOrFail($id);

        $faq->fill(Input::all());
		
		$faq->save();
        return Redirect::to('/admin/coupons/default-faq');
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