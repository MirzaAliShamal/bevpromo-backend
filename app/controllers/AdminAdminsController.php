<?php

class AdminAdminsController extends \BaseController {

    /**
     * Display a listing of the resource.
     * GET /adminusers
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin.admins.list');
    }
    public function UpdateOwner()
    {
        //echo '<pre>'; print_r("OK"); exit;
        
        $owner = User::orderBy('email', 'asc')->select('email', 'id')->get();
        
        $data = array('success' => true, 'record' => $owner);
        echo json_encode($data);
        return;
    }
    public function updateSupplier()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $suppliers = Supplier::orderBy('name', 'asc')->select('name','id')->get();

        $data = array('success' => true, 'record' => $suppliers);
        echo json_encode($data);
        return;
    }
    public function updateEntriesRetailer()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address','state')->get();

        $data = array('success' => true, 'record' => $retailers);
        echo json_encode($data);
        return;
    }
    public function updateEntriesIRC()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address', 'state')->get();

        $data = array('success' => true, 'record' => $retailers);
        echo json_encode($data);
        return;
    }
    public function updatedanialReasons()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $mirDenialReasons = MirDenialReason::orderBy('name')->where('active','=',1)->select('name', 'id')->get();

        $data = array('success' => true, 'record' => $mirDenialReasons);
        echo json_encode($data);
        return;
    }
    public function updateProgram()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $coupons = Coupon::where('active', '=', 1)->where('coupon_type_id', '!=', '17')->select('name', 'id')->get();

        $data = array('success' => true, 'record' => $coupons);
        echo json_encode($data);
        return;
    }
    public function updateClearning()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $clearinghouses = Clearinghouse::select('name', 'id')->get();

        $data = array('success' => true, 'record' => $clearinghouses);
        echo json_encode($data);
        return;
    }
    public function updateMriCoupon()
    {
        //echo '<pre>'; print_r("OK"); exit;

        $coupons = Coupon::where('active', '=', '1')->select('name', 'id')->get();

        $data = array('success' => true, 'record' => $coupons);
        echo json_encode($data);
        return;
    }

    /**
     * Show the form for creating a new resource.
     * GET /adminusers/create
     *
     * @return Response
     */
    public function create()
    {
        $suppliers = Supplier::lists('name', 'id');

        return View::make('admin.admins.create')->with('suppliers', $suppliers);
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

        $user->role_id = 1;

        $user->save();

        return Redirect::to('/admin/admins');
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

        $suppliers = Supplier::lists('name', 'id');

        return View::make('admin.admins.edit')->with('user', $user)->with('suppliers', $suppliers);
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

        return Redirect::to('/admin/admins');
    }

    //SWEEP TAKES

    public function imageuploader(){
        $uploadType = array("1"=>"Age Gate ","2"=>"Promotional Page","3"=>"Promotional Ad","4"=>"Slider Images","5"=>"Web Entry Page");
        return View::make('admin.imageuploader.create')->with('uploadType', $uploadType);
    }

    public function imageUploaderStore(){

        $imageDataObj = new ImageData;
        $imageDataObj->fill(Input::all());
        
        $photo_position = Input::get('photo_position');
        $imageDataObj->position = $photo_position;

        $basePath = realpath(base_path() . '/..');
        $files = Input::file('images');
        
        if (!empty($files)) {
            foreach($files as $file){

                if(!empty($file)){

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
                    $imageDataObj->src = $fileName;
                    $imageDataObj->save();
                }

            }
            
        }
       return Redirect::to('/admin/imageuploader');

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