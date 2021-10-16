<?php

class ApiPaymentsController extends \BaseController {


    public function store()
    {
		
		$import = Import::firstOrNew(array('id' => Input::get('id')));
		
		$import->fill(Input::all());
		
		$import->save();

    }
}