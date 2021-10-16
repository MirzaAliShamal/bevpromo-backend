<?php

class AdminClearinghousesController extends \BaseController {

    public function index()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        
        return View::make('admin.clearinghouses.list')->with('inline',$inline);
    }

    public function create()
    { 
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        
        return View::make('admin.clearinghouses.create')->with('inline',$inline);
    }

    public function store()
    {
        $clearinghouse = new Clearinghouse;

        $clearinghouse->fill(Input::all());

        $clearinghouse->save();
        $inline = Input::get('inline');
        return Redirect::to('/admin/clearinghouses?inline='.$inline);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $clearinghouse = Clearinghouse::findOrFail($id);

        return View::make('admin.clearinghouses.edit')->with('clearinghouse', $clearinghouse);
    }

    public function update($id)
    {
        $clearinghouse = Clearinghouse::findOrFail($id);

        $clearinghouse->fill(Input::all());

        $clearinghouse->save();

        return Redirect::to('/admin/clearinghouses');
    }

    public function destroy($id)
    {
        //
    }

}