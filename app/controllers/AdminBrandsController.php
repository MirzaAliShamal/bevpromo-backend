<?php

use Illuminate\Http\Response;

class AdminBrandsController extends \BaseController {

    public function index()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.brands.list')->with('inline', $inline);
    }
    public function UpdateBrands()
    {
        //echo '<pre>'; print_r("OK"); exit;
        
        $brands = Brand::orderBy('name', 'asc')->select('name', 'id')->get();
        
        $data = array('success' => true, 'record' => $brands);
        echo json_encode($data);
        return;
    }

    public function create()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        $suppliers = Supplier::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.brands.create')->with('suppliers', $suppliers)->with('inline', $inline);
    }

    public function store()
    {
        $brand = new Brand;

        $brand->fill(Input::all());

        $brand->save();
        $inline = Input::get('inline');
        return Redirect::to('/admin/brands?inline='.$inline);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        $suppliers = Supplier::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.brands.edit')->with('brand', $brand)->with('suppliers', $suppliers);;
    }

    public function update($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->fill(Input::all());

        $brand->save();

        return Redirect::to('/admin/brands');
    }

    public function destroy($id)
    {
        //
    }

}