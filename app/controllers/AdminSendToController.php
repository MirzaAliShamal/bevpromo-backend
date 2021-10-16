<?php

class AdminSendToController extends \BaseController {

    public function index()
    {
        return View::make('admin.send-to.list');
    }

    public function create()
    {
        $clearinghouses = Clearinghouse::lists('name', 'id');
        return View::make('admin.send-to.create')->with('clearinghouses', $clearinghouses);
    }

    public function store()
    {
        $sendTo = new SendTo;

        $sendTo->fill(Input::all());

        $sendTo->save();

        return Redirect::to('/admin/send-to');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sendTo = SendTo::findOrFail($id);
        $clearinghouses = Clearinghouse::lists('name', 'id');

        return View::make('admin.send-to.edit')->with('sendTo', $sendTo)->with('clearinghouses', $clearinghouses);;
    }

    public function update($id)
    {
        $sendTo = SendTo::findOrFail($id);

        $sendTo->fill(Input::all());

        $sendTo->save();

        return Redirect::to('/admin/send-to');
    }

    public function destroy($id)
    {
        //
    }

}