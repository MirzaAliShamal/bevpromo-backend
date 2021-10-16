<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminEntriesMirController extends \BaseController
{

    public function index()
    {
        return View::make('admin.entries.mir.list');
    }

    public function addDenial(){
        MirDenialReason::create([
           'name' => Input::get('name'),
           'active' => Input::get('value'),
        ]);
        echo json_encode('denial reason addded successfully');
    }

    public function create()
    {

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address','state')->get();

        $coupons = Coupon::where('active', '=', '1')->where('coupon_type_id', '=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $mirStatuses = MirStatus::where('active','=',MirStatus::active)->lists('name', 'id');

        $mirDenialReasons = MirDenialReason::where('active','=',MirDenialReason::active)->orderBy('name')->lists('name', 'id');


        return View::make('admin.entries.mir.create')->with('retailers', $retailers)->with('coupons', $coupons)->with('mirStatuses', $mirStatuses)->with('mirDenialReasons', $mirDenialReasons);
    }

    public function store()
    {
        $entryMir = new EntryMir;
        $entryMir->fill(Input::all());

        $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));

        $entryMir->birth_date = $birthDate;

        $entryMir->save();

        return Redirect::to('/admin/entries/mir-dt');
    }

    public function show($id)
    {
        //
    }
    public function ajax_add_edit($id) {

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address','state')->get();

        $coupons = Coupon::where('active', '=', '1')->orderBy('name', 'asc')->select('name', 'id')->get();

        $mirStatuses = MirStatus::select('name', 'id')->where('active','=',1)->get();
        $mirDenialReasons = MirDenialReason::orderBy('name')->where('active','=',1)->select('name', 'id')->get();
        if($id == 0) {
            //Create
        $retailers_opt = '';
        foreach ($retailers as $key => $item) {            
                $retailers_opt .= '<option value="' . $item->id . '">' . $item->name . ' ( ' . $item->address . ' ' .$item->state. ')</option>';
        }
        $coupons_opt = '';
        foreach ($coupons as $key => $value) {
                $coupons_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
        }
        $status_opt = '';
        foreach ($mirStatuses as $key => $value) {
                $status_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
        }
        $denial_reason_opt = '';
        foreach ($mirDenialReasons as $key => $value) {
                $denial_reason_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
        }
        $paid_status = '';
            $statuses = Constant::$paid_status;
            foreach ($statuses as $key => $value) {
                $paid_status .= '<option value = ' . $key . '>' . ucwords($value) . '</option>';
            }
        if(Input::get('campaign') == 'sweepstakes') {
            $html = '<div class="row">
        <div class="col-md-12">
                    <form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal" role="form" id="addEditMirForm">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="mir_retailer_id" class="col-md-3 control-label">Retailer: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_retailer_id" name="mir_retailer_id">' . $retailers_opt . '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="coupon_id" class="col-md-3 control-label">Program: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="coupon_id" name="coupon_id">' . $coupons_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="dollar_value" class="col-md-3 control-label">Dollar Value: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="dollar_value" type="text" id="dollar_value">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label">First Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="first_name" id="first_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label">Last Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="last_name" id="last_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label">Address: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="address" id="address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-3 control-label">City: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="city" type="text" id="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-3 control-label">State: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="state" type="text" id="state">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-md-3 control-label">Zip: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="zip" type="text" id="zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="email" type="text" id="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birth_date" class="col-md-3 control-label">Birth Date: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control form-control-inline input-medium date-picker" autocomplete="off" name="birth_date" type="text" id="birth_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mir_status_id" class="col-md-3 control-label">Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_status_id" name="mir_status_id">' . $status_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="denial_reason_id" class="col-md-3 control-label">Denial Reason: </label>
                            <div class="col-md-8">
                                <select class="form-control" id="denial_reason_id" name="denial_reason_id">' . $denial_reason_opt . '</select>
                                </div>
                                <a onclick="openDenialReasonPoPup()" target="_blank" style="height:30px;width: 30px;" class="btn red control-label" role="button" style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-plus"></i></a>
                                <a class="btn red control-label" style="height:30px;width: 30px;" id="btnRefreshDEntriesMri" name="btnRefreshDEntriesMri"
                                   style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-refresh"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Paid Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="paid_status" name="paid_status">' . $paid_status . '</select>
                                </div>
                        </div>
                    </div>
                    </form>
        </div>
    </div>';
        } elseif(Input::get('campaign') == 'dmir') {
            $html = '<div class="row">
        <div class="col-md-12">
                    <form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal" role="form" id="addEditMirForm">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="mir_retailer_id" class="col-md-3 control-label">Retailer: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_retailer_id" name="mir_retailer_id">' . $retailers_opt . '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="coupon_id" class="col-md-3 control-label">Program: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="coupon_id" name="coupon_id">' . $coupons_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="dollar_value" class="col-md-3 control-label">Dollar Value: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="dollar_value" type="text" id="dollar_value">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label">First Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="first_name" id="first_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label">Last Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="last_name" id="last_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label">Address: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="address" id="address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-md-3 control-label">City: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="city" type="text" id="city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-3 control-label">State: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="state" type="text" id="state">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-md-3 control-label">Zip: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="zip" type="text" id="zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="email" type="text" id="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birth_date" class="col-md-3 control-label">Birth Date: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control form-control-inline input-medium date-picker" autocomplete="off" name="birth_date" type="text" id="birth_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mir_status_id" class="col-md-3 control-label">Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_status_id" name="mir_status_id">' . $status_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Email: </label>
                            <div class="col-md-9">
                            <textarea cols="6" rows="4" name="email_body" class="form-control"></textarea>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="denial_reason_id" class="col-md-3 control-label">Denial Reason: </label>
                            <div class="col-md-8">
                                <select class="form-control" id="denial_reason_id" name="denial_reason_id">' . $denial_reason_opt . '</select>
                                </div>
                                <a onclick="openDenialReasonPoPup()" target="_blank" style="height:30px;width: 30px;" class="btn red control-label" role="button" style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-plus"></i></a>
                                <a class="btn red control-label" style="height:30px;width: 30px;" id="btnRefreshDEntriesMri" name="btnRefreshDEntriesMri"
                                   style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-refresh"></i></a>
                        </div>
                        <div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Paid Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="paid_status" name="paid_status">' . $paid_status . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-3 control-label">Address: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="address" type="text" id="address" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Phone Number: </label>
                            <div class="col-md-9">
                                <input class="form-control" id="phone_num" value="" name="phone_num" />
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Gender: </label>
                            <div class="col-md-9">
                                <select class="form-control" name="gender">
                                    <option value="female">female</option>       
                                    <option value="male">male</option>       
                                </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Appartment Number: </label>
                            <div class="col-md-9">
                                <input type="text" name="appartment_num" class="form-control" value="" />
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Notes: </label>
                            <div class="col-md-9">
                                    <textarea cols="6" rows="2" name="coupon_notes_mir" class="form-control"></textarea>
                                </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-group parentImage" id="images_upload">
                                    <label for="image_post" class="col-md-3 control-label">Choose UPC Image: </label>
                                    <div class="col-md-9 imageCopy_1">
                                        <div id="upc-upload1" class="dropzone"></div>
                                    </div>                                                  
                                </div>
                            </div>
                            <div id="upc_uploaded_images1"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-group parentImage" id="images_upload">
                                    <label for="image_post" class="col-md-3 control-label">Choose Rec Image: </label>
                                    <div class="col-md-9 imageCopy_1">
                                        <div id="rec-upload1" class="dropzone"></div>
                                    </div>                                                  
                                </div>
                            </div>
                            <div id="rec_uploaded_images1"></div>
                        </div>
                    </div>
                    </form>
        </div>
    </div>';
        }

    echo json_encode($html);
        }
        else {
            //Update

        $entryMir = EntryMir::find($id);
        $customer = Customer::where('coupon_id','=',$entryMir->coupon_id)->first();
        if(is_null($customer)) {
            $customer = '';
        }
        $entryMir->birth_date = date('m/d/Y', strtotime($entryMir->birth_date));

        $dob = date('Y-m-d', strtotime($entryMir->birth_date));
        $retailers_opt = '';
        foreach ($retailers as $key => $item) {
            if ($item->address != null)
                $retailers_opt .= '<option value="' . $item->id . '">' . $item->name . ' ( ' . $item->address . ' ' .$item->state. ')</option>';
            if ($item->id == $entryMir->retailer_id) {
                $retailers_opt .= '<option value="' . $item->id . '" selected="selected">' . $item->name . ' ( ' . $item->address . ' ' .$item->state. ' )</option>';
            } else {
                $retailers_opt .= '<option value="' . $item->id . '" selected="selected">' . $item->name . ' ( ' . $item->address . ' ' .$item->state. ' )</option>';
            }
        }
        $coupons_opt = '';
        foreach ($coupons as $key => $value) {
            if ($value->id == $entryMir->coupon_id) {
                $coupons_opt .= '<option value="' . $value->id . '" selected="selected">' . $value->name . '</option>';
            } else {
                $coupons_opt .= '<option value="' . $value->id . '">' . $value->name . '</option>';
            }
        }
        $status_opt = '';
        foreach ($mirStatuses as $key => $value) {
            if ($value->id == $entryMir->mir_status_id) {
                $status_opt .= '<option value=' . $value->id . ' selected="selected">' . $value->name . '</option>';
            } else {
                $status_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
        }
        $denial_reason_opt = '';
        foreach ($mirDenialReasons as $key => $value) {
            if ($value->id == $entryMir->denial_reason_id) {
                $denial_reason_opt .= '<option value=' . $value->id . ' selected="selected">' . $value->name . '</option>';
            } else {
                $denial_reason_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
        }
        $paid_status = '';
        $statuses = Constant::$paid_status;
        foreach ($statuses as $key => $value) {
            if($value == $entryMir->paid_status) {
                $paid_status .= '<option value = ' . $key . ' selected="selected">' . ucwords($value) . '</option>';
            }
            else {
                $paid_status .= '<option value = ' . $key . '>' . ucwords($value) . '</option>';
            }
        }
        $coupon = Coupon::find($entryMir->coupon_id);
        if($customer != '') {
            $gender = $customer->gender;
            if($gender == 'female') {
                $genderHtml = '<option value="'.$gender.'">'.$gender.'</option><option value="male">male</option>';
            } else {
                $genderHtml = '<option value="'.$gender.'">'.$gender.'</option><option value="female">female</option>';
            }
            $customerId = '<input type="hidden" name="customer_id" id="customer_id" value='.$customer->id.'>';
            $customerAddress = '<div class="form-group">
                            <label for="address" class="col-md-3 control-label">Address: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="address" type="text" id="address" value="' . $customer->street_address . '">
                            </div>
                        </div>';
            $customerPhone = '<div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Phone Number: </label>
                            <div class="col-md-9">
                                <input class="form-control" id="phone_num" value="' . $customer->phone_num . '" name="phone_num" />
                                </div>
                        </div>';
            $upcImages = '<div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-group parentImage" id="images_upload">
                                    <label for="image_post" class="col-md-3 control-label">Choose UPC Image: </label>
                                    <div class="col-md-9 imageCopy_1">
                                        <div id="upc-upload" class="dropzone"></div>
                                    </div>                                                  
                                </div>
                            </div>
                            <div id="upc_uploaded_images"></div>
                        </div>';
            $recImages = '<div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-group parentImage" id="images_upload">
                                    <label for="image_post" class="col-md-3 control-label">Choose Rec Image: </label>
                                    <div class="col-md-9 imageCopy_1">
                                        <div id="rec-upload" class="dropzone"></div>
                                    </div>                                                  
                                </div>
                            </div>
                            <div id="rec_uploaded_images"></div>
                        </div>';
            $gender = '<div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Gender: </label>
                            <div class="col-md-9">
                                <select class="form-control" name="gender">
                                    '.$genderHtml.'       
                                </select>
                                </div>
                        </div>';
            $appartment_num = '<div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Appartment Number: </label>
                            <div class="col-md-9">
                                <input type="text" name="appartment_num" class="form-control" value="'.$customer->appartment_num.'" />
                                </div>
                        </div>';
            $notes = '<div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Notes: </label>
                            <div class="col-md-9">
                                    <textarea cols="6" rows="2" name="coupon_notes_mir" class="form-control">'.$entryMir->coupon_notes_mir.'</textarea>
                                </div>
                        </div>';
            $emailbody = '<div class="form-group">
                            <label for="appartment_num" class="col-md-3 control-label">Email: </label>
                            <div class="col-md-9">
                            <textarea cols="6" rows="4" name="email_body" class="form-control"></textarea>
                                </div>
                        </div>';
            $customerEmail = '<input type="hidden" name="customer_email" value="'.$customer->email.'" />';
        } else {
            $customerId = '';
            $customerAddress = '';
            $customerPhone = '';
            $upcImages = '';
            $recImages = '';
            $gender = '';
            $appartment_num = '';
            $notes = '';
            $emailbody = '';
            $customerEmail = '';
        }
        $html = '<div class="row">
        <div class="col-md-12">
                    <form method="POST" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal" role="form" id="addEditMirForm">
                    <input type="hidden" name="id" value='.$entryMir->id.'>
                    '.$customerId.'
                    '.$customerEmail.'
                    <div class="form-body">
                        <div class="form-group">
                            <label for="mir_retailer_id" class="col-md-3 control-label">Retailer: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_retailer_id" name="mir_retailer_id">' . $retailers_opt . '</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dollar_value" class="col-md-3 control-label">Campaign Type: </label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" id="campaign_type" readonly="readonly" value="' . Constant::$campains[$coupon->campaign_type] . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dollar_value" class="col-md-3 control-label">Dollar Value: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="dollar_value" id="dollar_value" type="text" value="' . $entryMir->dollar_value . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name" class="col-md-3 control-label">First Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="first_name" type="text" id="first_name" value="' . $entryMir->first_name . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-3 control-label">Last Name: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="last_name" type="text" id="last_name" value="' . $entryMir->last_name . '">
                            </div>
                        </div>
                        '.$customerAddress.'
                        <div class="form-group">
                            <label for="city" class="col-md-3 control-label">City: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="city" type="text" id="city" value="' . $entryMir->city . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-md-3 control-label">State: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="state" type="text" id="state" value="' . $entryMir->state . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-md-3 control-label">Zip: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="zip" type="text" id="zip" value="' . $entryMir->zip . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birth_date" class="col-md-3 control-label">Birth Date: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control form-control-inline input-medium date-picker" autocomplete="off" name="birth_date" id="birth_date" type="text" value="' . $dob . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mir_status_id" class="col-md-3 control-label">Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="mir_status_id" name="mir_status_id">' . $status_opt . '</select>
                                </div>
                        </div>
                        '.$emailbody.'
                        <div class="form-group">
                            <label for="denial_reason_id" class="col-md-3 control-label">Denial Reason: </label>
                            <div class="col-md-8">
                                <select class="form-control" id="denial_reason_id" name="denial_reason_id">' . $denial_reason_opt . '</select>
                                </div>
                                <a onclick="openDenialReasonPoPup()" target="_blank" style="height:30px;width: 30px;" class="btn red control-label" role="button" style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-plus"></i></a>
                                <a class="btn red control-label" style="height:30px;width: 30px;" id="btnRefreshDEntriesMri" name="btnRefreshDEntriesMri"
                                   style="text-align: center;"><i style="position:relative;right:4px;bottom: 2px;" class="fa fa-refresh"></i></a>
                        </div>
                        '.$gender.'
                        '.$appartment_num.'
                        '.$notes.'
                        <div class="form-group">
                            <label for="paid_status" class="col-md-3 control-label">Paid Status: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="paid_status" name="paid_status">' . $paid_status . '</select>
                                </div>
                        </div>
                        '.$customerPhone.'
                        '.$upcImages.'
                        '.$recImages.'
                    </div>
                    </form>
        </div>
    </div>';
    echo json_encode($html);
        }
    }

    public function ajax_store() {
        $id = Input::get('id');
        if($id == '') {
            //Create
            $entryMir = new EntryMir;
            $customer = new Customer();
            $entryMir->fill(Input::all());
            $arr = Constant::$paid_status[$entryMir->paid_status];
            if($arr != '') {
                $entryMir->paid_status = $arr;
            }
            else {
                $entryMir->paid_status = null;
            }
            $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));
            $customer->coupon_id = Input::get('coupon_id');
            $customer->appartment_num = Input::get('appartment_num');
            $customer->phone_num = Input::get('phone_num');
            $customer->zip = Input::get('zip');
            $customer->state = Input::get('state');
            $customer->dob = Input::get('birth_date');
            $customer->email = Input::get('email');
            $customer->last_name = Input::get('last_name');
            $customer->first_name = Input::get('first_name');
            $customer->street_address = Input::get('address');
            $customer->city = Input::get('city');
            $customer->gender = Input::get('gender');
            $str = Str::random(12);
            $customer->tracking_id = $str;
            $entryMir->birth_date = $birthDate;
            $entryMir->save();
            $customer->entry_mir_id = $entryMir->id;
            $customer->save();
            if(Input::get('email_body')) {
                // Create the Transport
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                    ->setUsername('chatads056@gmail.com') //default credentionals
                    ->setPassword('indiapunjab44g'); //default credentionals

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $body = Input::get('email_body');
                $email = Input::get('email');
                $message = (new Swift_Message('Your Rebate Status'))
                    ->setFrom(['chatads056@gmail.com' => 'Rebate Status'])
                    ->setTo([$email => $customer->first_name])
                    ->setBody($body);
                // Send the message
                $result = $mailer->send($message);
            }
            $success = true;
            echo json_encode($success);
        }
        else {
            $entryMir = EntryMir::find($id);
            $id = Input::get('customer_id');
            $customer = Customer::find($id);
            $entryMir->fill(Input::all());
    
            $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));
    
            $entryMir->birth_date = $birthDate;
            $arr = Constant::$paid_status[$entryMir->paid_status];
            $entryMir->paid_status = $arr;
            $entryMir->save();
            $customer->phone_num = Input::get('phone_num');
            $customer->gender = Input::get('gender');
            $customer->appartment_num = Input::get('appartment_num');
            $customer->save();
            if(Input::get('email_body')) {
                // Create the Transport
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                    ->setUsername('chatads056@gmail.com') //default credentionals
                    ->setPassword('indiapunjab44g'); //default credentionals

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $body = Input::get('email_body');
                $email = Input::get('customer_email');
                $message = (new Swift_Message('Your Rebate Status'))
                    ->setFrom(['chatads056@gmail.com' => 'Rebate Status'])
                    ->setTo([$email => $customer->first_name])
                    ->setBody($body);
                // Send the message
                $result = $mailer->send($message);
            }

            $success = true;
            echo json_encode($success);
        }
    }

    public function edit($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->birth_date = date('m/d/Y', strtotime($entryMir->birth_date));

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address', 'state')->get();

        $coupons = Coupon::where('active', '=', '1')->where('coupon_type_id', '=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $mirStatuses = MirStatus::where('active','=',MirStatus::active)->lists('name', 'id');

        $mirDenialReasons = MirDenialReason::orderBy('name')->where('active','=',MirDenialReason::active)->lists('name', 'id');

        return View::make('admin.entries.mir.edit')->with('campaign_type', $entryMir->campaign_type)->with('entryMir', $entryMir)->with('retailers', $retailers)->with('coupons', $coupons)->with('mirStatuses', $mirStatuses)->with('mirDenialReasons', $mirDenialReasons);
    }

    public function update($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->fill(Input::all());

        $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));

        $entryMir->birth_date = $birthDate;

        $entryMir->save();

        return Redirect::to('/admin/entries/mir-dt');
    }

    public function destroy($id)
    {
        //
    }

    public function invoice_all()
    {
        DB::update(DB::raw('UPDATE entries_mir SET mir_status_id = 5, invoiced_date = now() WHERE mir_status_id = 1'));

        return Redirect::to('/admin/entries/mir');
    }

    public function delete($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->delete();

        return Redirect::to('/admin/entries/mir-dt');
    }
}