<?php

class AdminRetailersMirController extends \BaseController {

    public function index()
    {
        return View::make('admin.retailers.mir.list');
    }

    public function create()
    {
        return View::make('admin.retailers.mir.create');
    }

    public function store()
    {
        $retailer = new MirRetailer;

        $retailer->fill(Input::all());

        $retailer->save();

        return Redirect::to('/admin/retailers/mir');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $retailer = MirRetailer::findOrFail($id);

        return View::make('admin.retailers.mir.edit')->with('retailer', $retailer);
    }

    public function update($id)
    {
        $retailer = MirRetailer::findOrFail($id);

        $retailer->fill(Input::all());

        $retailer->save();

        return Redirect::to('/admin/retailers/mir');
    }

    public function destroy($id)
    {
        //
    }

}