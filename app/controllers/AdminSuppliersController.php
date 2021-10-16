<?php

class AdminSuppliersController extends \BaseController {

    public function index()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.suppliers.list')->with('inline', $inline);
    }

    public function create()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.suppliers.create')->with('inline', $inline);
    }

    public function store()
    {
        $supplier = new Supplier;

        $supplier->fill(Input::all());

        $supplier->save();
        $inline = Input::get('inline');
        return Redirect::to('/admin/suppliers?inline='.$inline);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return View::make('admin.suppliers.edit')->with('supplier', $supplier);
    }

    public function update($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->fill(Input::all());

        $supplier->save();

        return Redirect::to('/admin/suppliers');
    }

    public function destroy($id)
    {
        //
    }

}