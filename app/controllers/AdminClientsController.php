<?php

class AdminClientsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminusers
	 *
	 * @return Response
	 */
	public function index()
	{
		if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.clients.list')->with('inline', $inline);;
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /adminusers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
		$suppliers = Supplier::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.clients.create')->with('suppliers', $suppliers)->with('inline', $inline);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminusers
	 *
	 * @return Response
	 */
	public function store()
	{
        $user = new User;

        $user->fill(Input::all());

        $user->password = Hash::make($user->password);

        $user->role_id = 2;

        $user->save();
		$inline = Input::get('inline');
        return Redirect::to('/admin/clients?inline='.$inline);
	}

	/**
	 * Display the specified resource.
	 * GET /adminusers/{id}
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
	 * GET /adminusers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = User::findOrFail($id);

		$suppliers = Supplier::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.clients.edit')->with('user', $user)->with('suppliers', $suppliers);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $user = User::findOrFail($id);

        $user->fill(Input::all());

        $user->save();

        return Redirect::to('/admin/clients');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /adminusers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}