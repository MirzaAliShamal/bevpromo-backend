<?php

class AdminSettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adminsettings
	 *
	 * @return Response
	 */
	public function index()
	{
		$states = States::all();
		foreach($states as $state){
			$st[$state->state_code] = $state->state_code;
		}
		$validStates = States::where('valid',1)->get();
		$validStatesArr = array();
		foreach($validStates as $stateV){
			$validStatesArr[] = $stateV->state_code;
		}
		/* echo "<pre>";
        print_r($validStatesArr);
    echo "</pre>";
    die;  */
        return View::make('admin.settings.index')->with('states', $st)->with('validStates', $validStatesArr);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /adminsettings/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	public function statestore(){
		$states = States::all();
		$valid_states = Input::get('valid_states');
		foreach($states as $state){

			if(in_array($state->state_code,$valid_states)){
				$valid = 1;
			} else {
				$valid = 0;
			}
			DB::table('states')->where('state_code',$state->state_code)->update(array('valid' => $valid));

		}
		return Redirect::to('/admin/settings');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /adminsettings
	 *
	 * @return Response
	 */
	public function store()
	{
		$basePath = realpath(base_path() . '/..');
        $file = Input::file('file');
        if ($file) {
            $path = $basePath . '/static-assets';
            if (is_dir($path)) {
                $fileName = rand(100, 1000) . '-' . $file->getClientOriginalName();
                $file->move($path, $fileName);
            } else {
                mkdir($basePath . '/static-assets', 0777);
                $path = $basePath . '/static-assets';
                $fileName = rand(100, 1000) . '-' . $file->getClientOriginalName();
                $file->move($path, $fileName);
            }
            DB::table('settings')
                ->update(array('logo' => $fileName));
		}
		return Redirect::to('/admin/settings');
	}

	/**
	 * Display the specified resource.
	 * GET /adminsettings/{id}
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
	 * GET /adminsettings/{id}/edit
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
	 * PUT /adminsettings/{id}
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
	 * DELETE /adminsettings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}