<?php

class AdminRetailersIrcController extends \BaseController {

    public function index()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.retailers.irc.list')->with('inline', $inline);
    }

    public function create()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.retailers.irc.create')->with('inline', $inline);
    }

    public function store()
    {
        $retailer = new Retailer;

        $retailer->fill(Input::all());

        $retailer->save();
        $inline = Input::get('inline');
        return Redirect::to('/admin/retailers/irc?inline='.$inline);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
        $retailer = Retailer::findOrFail($id);

        return View::make('admin.retailers.irc.edit')->with('retailer', $retailer)->with('inline', $inline);
    }

    public function update($id)
    {
        $retailer = Retailer::findOrFail($id);

        $retailer->fill(Input::all());

        $retailer->save();
        
        return Redirect::to('/admin/retailers/irc');
    }

    public function destroy($id)
    {
        //
    }

}