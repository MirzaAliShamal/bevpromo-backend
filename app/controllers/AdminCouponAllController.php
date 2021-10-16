<?php

class AdminCouponAllController extends \BaseController
{

    public $handle = '';
    public function index()
    {
        $programs = CouponType::orderBy('name')->get();
        $campaigns = Constant::$campains;
        $code_generator_limit = Constant::$code_generator_limit;
        if (isset($_GET['campaign'])) {
            $campaign = $_GET['campaign'];
        } else {
            $campaign = null;
        }
        return View::make('admin.coupons.all.list', compact('programs', 'campaigns', 'campaign', 'code_generator_limit'));
    }
    
    
    
    public function create()
    {
        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        $brands = Brand::where('irc_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');
        $types = CouponType::select('name','id')->where('active','=',1)->orderBy('name')->get();

        $programStatus = array('1' => 'Active', '0' => 'Non Active');

        $campaigns = Constant::$campains;

        $uploadType = array("1" => "Age Gate", "2" => "Promotional Page", "3" => "Promotional Ad", "4" => "Slider Images", "5" => "Web Entry Page");

        $statement = DB::select("SHOW TABLE STATUS LIKE 'sweepstake_program_details'");
        $ProgramNextId = $statement[0]->Auto_increment;

        // $states = array("AK", "AL", "AR", "AZ", "CA");
        $states = States::where('valid','=',1)->get();

        return View::make('admin.coupons.all.create')->with('users', $users)->with('brands', $brands)->with('campaigns', $campaigns)->with('uploadType', $uploadType)->with('types', $types)->with('programStatus', $programStatus)->with('states', $states)->with('ProgramNextId', $ProgramNextId);
    }

    public function deleteImage()
    {

        $imageID = Input::get('image_id');
        $imageName = ImageData::where('id', $imageID)->first();


        $basePath = realpath(base_path() . '/..');
        $image_path = $basePath . '/static-assets/' . $imageName->src;
@unlink($image_path);

        $res = ImageData::where('id', $imageID)->delete();

        if ($res) {
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false));
        }
    }

    public function store()
    {
        /*   echo "<pre>";
            print_r($_POST);
        die; */
        $valid_states = Input::get('valid_states');

        /*      echo "<pre>";
                print_r($valid_states);
            echo "</pre>";
            die; */
        $coupon = new Coupon;
        $coupon->fill(Input::all());
        $basePath = realpath(base_path() . '/..');
        $file = Input::file('campaign_logo');
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
            $coupon->campaign_logo = $fileName;
        }

        $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

        $start_date = date('Y-m-d H:i:s', strtotime(Input::get('start_date')));

        $coupon->start_date = $start_date;

        $coupon->expires = $expires;

        $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

        $coupon->receive_by = $receiveBy;
        $coupon->save();

        // SWEEPSTAKES

        if (Input::get('campaign_type') == '4') {

            $imageDataObj = new ImageData;
            $imageDataObj->fill(Input::all());

            $photo_position = Input::get('photo_position');
            $imageDataObj->position = $photo_position;
            $imageDataObj->coupon_id = $coupon->id;

            $basePath = realpath(base_path() . '/..');
            $files = Input::file('images');

            if (!empty($files)) {
                foreach ($files as $file) {

                    if (!empty($file)) {

                        $path = $basePath . '/static-assets';
                        $backgroundName = preg_replace('/\s+/', '', $file->getClientOriginalName());
                        if (is_dir($path)) {
                            $fileName = rand(100, 1000) . '-' . $backgroundName;
                            $file->move($path, $fileName);
                        } else {
                            mkdir($basePath . '/static-assets', 0777);
                            $path = $basePath . '/static-assets';
                            $fileName = rand(100, 1000) . '-' . $backgroundName;
                            $file->move($path, $fileName);
                        }
                        $imageDataObj->src = $fileName;
                        $imageDataObj->save();
                    }
                }
            }

            // SAVE PROGRAM DETAILS    

            $StProgramDetailsObj = new SweepsTakesProgramDetails;
            $StProgramDetailsObj->fill(Input::all());
            $StProgramDetailsObj->coupon_id = $coupon->id;
            $StProgramDetailsObj->name = Input::get('program_name');
            $StProgramDetailsObj->url = Input::get('program_url');
            $StProgramDetailsObj->admin_email = Input::get('admin_email');
            $StProgramDetailsObj->brand_landing_url = Input::get('brand_landing_url');
            $StProgramDetailsObj->start_date = date('Y-m-d', strtotime(Input::get('program_start_date')));
            $StProgramDetailsObj->end_date = date('Y-m-d', strtotime(Input::get('program_end_date')));
            $StProgramDetailsObj->status = Input::get('program_status');
            $StProgramDetailsObj->data_entry_limit = Input::get('daily_entry_limit');
            $StProgramDetailsObj->under_age_link  = Input::get('under_age_link');
            $StProgramDetailsObj->prize_info  = Input::get('prize_info');
            $StProgramDetailsObj->win_email  = Input::get('win_email');
            $StProgramDetailsObj->rules_info  = Input::get('rules_info');
            $StProgramDetailsObj->terms_conditions  = Input::get('terms_conditions');
            $StProgramDetailsObj->privacy_policy  = Input::get('privacy_policy');
            $StProgramDetailsObj->form_text_color  = Input::get('form_text_color');
            $StProgramDetailsObj->legal_disclaimer  = Input::get('legal_disclaimer');


            if (!empty(Input::get('rule_only_program'))) :
                $StProgramDetailsObj->rules  = 1;
            else :
                $StProgramDetailsObj->rules  = 0;
            endif;

            $StProgramDetailsObj->save();

            // COUPON STATE
            $valid_states = Input::get('valid_states');
            if (!empty($valid_states)) {

                foreach ($valid_states as $validState) {
                    $StatesObj = new CouponStates;
                    $StatesObj->coupon_id = $coupon->id;
                    $StatesObj->state_id = $validState;
                    $StatesObj->save();
                }
            }
        }

        $existingCoupon = Coupon::findOrFail($coupon->id);
        $str = Coupon::generateRandomString(12);
        $existingCoupon->url_str = $str . $coupon->id;
        $existingCoupon->save();
        return Redirect::to('/admin/coupons/all');
    }


    public function data()
    {
        $programType = Input::get('program-type');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = Input::get('filters');        
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');
        if ($programType == 'IRC') {
            $data = EntryIrcView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length);
            echo json_encode($data);
        } else if ($programType == 'Mail-In Rebate') {
            $data = EntryMirView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length);
            echo json_encode($data);
        } else if ($programType == 'all') {
            
            
            $program_id = 'all';
            $data = CouponView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length, $program_id);
            echo json_encode($data);
        } else {
            $program_id = Input::get('program-id');
            $data = CouponView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length, $program_id);
            echo json_encode($data);
        }
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $types = CouponType::select('name','id')->where('active','=',1)->orderBy('name')->get();

        $coupon->expires = date('m/d/Y', strtotime($coupon->expires));

        $coupon->receive_by = date('m/d/Y', strtotime($coupon->receive_by));

        //IMAGES GET 
        $getImageArr = array();
        $getImages = ImageData::where('coupon_id', $id)->get();
        if (!empty($getImages)) {
            foreach ($getImages as $getImage) {
                $imageId = $getImage->id;
                $getImageArr[$getImage->position][$imageId] = Constant::$assetLink . $getImage['src'];
            }
        }


        /*  echo "<pre>";
        print_r($getImageArr);
        echo "</pre>";
        die;  */

        $programDetails = SweepsTakesProgramDetails::where('coupon_id', $id)->first();
        $programDetails->start_date = date('d/m/Y', strtotime($programDetails->start_date));
        $programDetails->end_date = date('d/m/Y', strtotime($programDetails->end_date));
        // $programDetails->rule = date('d/m/Y',strtotime($programDetails->end_date));

        $uploadType = array("1" => "Age Gate", "2" => "Promotional Page", "3" => "Promotional Ad", "4" => "Slider Images", "5" => "Web Entry Page");

        $getStates = CouponStates::where('coupon_id', $id)->get();
        $couponStates = array();
        foreach ($getStates as $couponState) {
            $couponStates[] = $couponState->state_id;
        }


        $validStates = States::where('valid', 1)->get();
        $validStatesArr = array();
        foreach ($validStates as $stateV) {
            $validStatesArr[$stateV->state_code] = $stateV->state_code;
        }
        /*  echo "<pre>";
        print_r($validStatesArr);
        echo "</pre>";
        die;  */
        $programStatus = array('1' => 'Active', '0' => 'Non Active');

        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');
        $campaigns = Constant::$campains;
        $brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');
        $types = CouponType::lists('name', 'id');
        return View::make('admin.coupons.all.edit')->with('coupon', $coupon)->with('users', $users)->with('brands', $brands)->with('types', $types)
            ->with('imageArr', $getImageArr)
            ->with('programDetails', $programDetails)
            ->with('uploadType', $uploadType)
            ->with('allStates', $validStatesArr)
            ->with('couponStates', $couponStates)
            ->with('programStatus', $programStatus)
            ->with('campaigns', $campaigns);
    }

   public static function searchForField($field, $arr) {
        foreach ($arr as $key => $value) {
            if($value['default_field_name'] === $field) {
                return $key;
            }
        }
        return null;
    }

    public function ajax_add_edit($id)
    {
        $defualts = DefaultField::all()->toArray();
        $bp_text=$defualts[AdminCouponAllController::searchForField('bp_text',$defualts)]["default_field_data"];
        $subject=$defualts[AdminCouponAllController::searchForField('subject',$defualts)]["default_field_data"];
        $customize_email_message=$defualts[AdminCouponAllController::searchForField('customize_email_message',$defualts)]["default_field_data"];
        $terms_text=$defualts[AdminCouponAllController::searchForField('terms_text',$defualts)]["default_field_data"];
        $privacy_text=$defualts[AdminCouponAllController::searchForField('privacy_text',$defualts)]["default_field_data"];
        //$toc_text=$defualts[AdminCouponAllController::searchForField('toc_text',$defualts)]["default_field_data"];
        $welcome_message_text=$defualts[AdminCouponAllController::searchForField('welcome_message_text',$defualts)]["default_field_data"];
        $under_age_url=$defualts[AdminCouponAllController::searchForField('under_age_url',$defualts)]["default_field_data"];
        $email_subscription_text=$defualts[AdminCouponAllController::searchForField('email_subscription_text',$defualts)]["default_field_data"];
        
        $brands = Brand::where('irc_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');
        $types = CouponType::Where('active','=',1)->select('name','id')->orderBy('name')->get();
        
        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->select('email', 'id')->get();
        $campaigns = Constant::$campains;
        $brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();
        $programStatus = array('1' => 'Active', '0' => 'Non Active');
        $uploadType = array("1" => "Age Gate (1440 x 900)", "2" => "Promotional Page (1440 x 900)", "3" => "Promotional Ad (Same Size & Dimension)", "4" => "Slider Images (Same Size & Dimension)", "5" => "Web Entry Page (1440 x 900)");

        $statement = DB::select("SHOW TABLE STATUS LIKE 'sweepstake_program_details'");
        $ProgramNextId = $statement[0]->Auto_increment;

        // $states = array("AK", "AL", "AR", "AZ", "CA");
        $states = States::where('valid','=',1)->get();
        $campains_html = '';

        if ($id == 0) {
            //Create
            
                    $campains_html .= "<select class='form-control' id='campaignType' name='campaign_type'>";
                foreach ($campaigns as $key => $value) {
                    $campains_html .= "<option value='$key'>$value</option>";
                }
                $campains_html .= "</select>";
            
            
            $types = CouponType::select('name','id')->where('active','=',1)->orderBy('display_order')->get();
            
                $paragraph_size = "<div class='form-group' id='paragraphsize'>
                    <label for='paragraph_size' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Paragraph Size: <small>size:15px</small></label>
                    <div class='col-md-10'>
                        <input type='number' placeholder='Size in Pixel' name='paragraph_size' id='paragraph_size' class='form-control' required>
                    </div></div>";
                
                

                
            
            $programs_owner = '';
            foreach ($users as $key => $value) {
                $programs_owner .= '<option value=' . $value->id . '>' . $value->email . '</option>';
            }
            $brands_opt = '';
            foreach ($brands as $key => $value) {
                $brands_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
            $coupon_opt = '';
            foreach ($types as $key => $value) {
                
                    $coupon_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
                
            }
            $upload_type_opt = '';
            foreach ($uploadType as $key => $value) {
                $upload_type_opt .= '<option value=' . $key . '>' . $value . '</option>';
            }
            $states_opt = '';
            foreach ($states as $state) {
                $states_opt .= '<option value=' . $state->id . '>' . $state->state . '</option>';
            }
            $program_status_opt = '';
            foreach ($programStatus as $key => $value) {
                $program_status_opt .= '<option value=' . $key . '>' . $value . '</option>';
            }
            $sweepstakesHtml = '<div class="portlet-title sweeptakesPart" style="display:none">
                <div class="form-body">
                <h3>Image Uploader</h3>
                <div class="border col-sm-12">
                            <div class="form-group" style="margin-top:10px;">
                                <label for="photo_position" class="col-md-4 control-label">Select Photo Position:</label>
                                <div class="col-md-5">
                                    <select class="uploadTypeChange form-control" id="uploadType" data-id="1" name="photo_position[1][]">
                                        ' . $upload_type_opt . '
                                    </select>
                                </div>
                                
                            </div>
           
                            <div class="form-group parentImage" id="images_upload">
                                <label for="image_post" class="col-md-4 control-label">Select Image: </label>
                                <div class="col-md-6 imageCopy_1">
                                    <div id="sweep-upload" class="dropzone"></div>
                                </div>                                                  
                            </div>                         
                      
                        </div>
                <div id="uploaded_images"></div>
                </div>
                <div class="col-sm-12">
                <h3>Program Details</h3>
                </div>
       
                <div class="form-group">
                    <label for="program_no" class="col-md-3 control-label">Program No.: </label>
                    <div class="col-md-9 ">
                        <input class="form-control" autocomplete="off" disabled="disabled" name="program_no" type="text" value=' . $ProgramNextId . ' id="program_no">
                    </div>
                </div>
                <div class="form-group">
                    <label for="url" class="col-md-3 control-label">Program URL(without www.): <a href="#" title="Enter in a custom domain here where the program will be (dns must be changed for that domain) or leave blank to use default url"><img src="/assets/blue_question_mark.png" height="13px" style="margin-top:-13px;"/></a></label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="url" type="text" id="url">
                    </div>
                </div>
                <div class="form-group">
                    <label for="brand_landing_url" class="col-md-3 control-label">Brand URL: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="brand_landing_url" type="text" id="brand_landing_url">
                    </div>
                </div>
             
                <div class="form-group">
                    <label for="admin_email" class="col-md-3 control-label">Admin Email: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="admin_email" type="text" id="admin_email">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="daily_entry_limit" class="col-md-3 control-label">Total Entries/Person </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="daily_entry_limit" type="text" id="daily_entry_limit">
                    </div>
                </div>
                <div class="form-group">
                    <label for="daily_limit" class="col-md-3 control-label">Daily Limit: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="daily_limit" type="text" id="daily_limit">
                    </div>
                </div>
                <div class="form-group">
                    <label for="under_age_link" class="col-md-3 control-label">Under Age Link: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="under_age_link" type="text" id="under_age_link" value="'.$under_age_url.'"">
                    </div>
                </div>
                <div class="form-group">
                        <label for="headings_color" class="col-md-3 control-label">Headings Color: </label>
                        <div class="col-md-9">
                            <input type="color" id="headings_color" name="headings_color" class="form-control" value="#000000">
                        </div>
                    </div>
                <div class="form-group">
                    <label for="form_text_color" class="col-md-3 control-label">Form Text Color: </label>
                    <div class="col-md-9">
                        <input type="color" id="form_text_color" name="form_text_color" class="form-control" value="#000000">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Form Align: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" id="form_align_left" name="form_align" value="divAlignLeft"> 
                                <label for="form_align_left"> Left</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="form_align_center" name="form_align" value="divAlignCenter" checked> 
                                <label for="form_align_center"> Center</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" id="form_align_right" name="form_align" value="divAlignRight"> 
                                <label for="form_align_right"> Right</label>
                            </div> 
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label for="official_rule_entry_link" class="col-md-3 control-label">Official Rule Entry Link: </label>
                    <div class="col-md-9">
                        <input type="text" id="official_rule_entry_link" name="official_rule_entry_link" class="form-control" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="official_rule_entry_link_color" class="col-md-3 control-label">Official Rule Entry Link Color: </label>
                    <div class="col-md-9">
                        <input type="color" id="official_rule_entry_link_color" name="official_rule_entry_link_color" class="form-control" value="#000000">
                    </div>
                </div>
                <div class="form-group">
                    <label for="rule_only_program" class="col-md-3 control-label">Rules Only Program: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="rule_only_program" name="rule_only_program">
                    </div>
                </div>
                <div class="form-group">
                    <label for="promo_page" class="col-md-3 control-label">Activate Promo Page: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="promo_page" name="promo_page">
                    </div>
                </div>
                <div class="form-group">
                    <label for="prize_display" class="col-md-3 control-label">Activate Prize Display: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="prize_display" name="prize_display">
                    </div>
                </div>
                <div class="form-group">
                    <label for="page_gap" class="col-md-3 control-label">Activate Page Gap: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="page_gap" name="page_gap">
                    </div>
                </div>
                <div class="form-group">
                    <label for="promo_ad" class="col-md-3 control-label">Activate Promo Ad: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="promo_ad" name="promo_ad">
                    </div>
                </div>
                <div class="form-group">
                    <label for="youtube_video" class="col-md-3 control-label">Activate Youtube Video: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="youtube_video" name="youtube_video">
                    </div>
                </div>
                <div class="form-group">
                    <label for="youtube_video_url" class="col-md-3 control-label">Youtube Video URL: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="youtube_video_url" type="text" id="youtube_video_url">
                    </div>
                </div>
                <div class="form-group">
                    <label for="slider" class="col-md-3 control-label">Activate Slider: </label>
                    <div class="col-md-9" style="padding-top:0.8rem;">
                        <input type="checkbox" id="slider" name="slider">
                    </div>
                </div>
                <div class="form-group">
                    <label for="codes_per_email" class="col-md-3 control-label">Codes per email: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="codes_per_email" type="text" value="1" id="codes_per_email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="code_redeemed_message" class="col-md-3 control-label">Code redeemed message: </label>
                    <div class="col-md-9">
                        <input class="form-control" autocomplete="off" name="code_redeemed_message" type="text" value="This code has already been redeemed." id="code_redeemed_message">
                    </div>
                </div>
                <div class="form-group">
                    <label for="win_email" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Win Text/Email </label>
                    <div class="col-md-12">
                        <textarea class="ckeditor" cols="78" id="winEmail" name="win_email" rows="10"></textarea>               
                    </div>    
                        <script>
                        CKEDITOR.replace( "winEmail" );
                        </script>
                </div>
                <div class="form-group">
                <label for="prize_info" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Prize Information </label>
                    <div class="col-md-12">
                        <textarea class="ckeditor" cols="78" id="prizeInfo" name="prize_info" rows="10"></textarea>
                    </div>   
                    <script>
                    CKEDITOR.replace( "prizeInfo" );
                    </script>
                </div>
                <div class="form-group">
                <label for="rules" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Rules </label>
                <div class="col-md-12">
                    <textarea class="ckeditor" cols="78" id="rules" name="rules_info" rows="10"></textarea>
                </div>
                    <script>
                    CKEDITOR.replace( "rules" );
                    </script>
                </div>
                <div class="form-group">
                <label for="prize_info" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Terms and Conditions  </label>
                <div class="col-md-12">
                    <textarea class="ckeditor" cols="78" id="terms_conditions_sweep" name="terms_conditions_sweep" rows="10">'.$terms_text.'</textarea>
                </div>    
                    <script>
                    CKEDITOR.replace( "terms_conditions_sweep" );
                    </script>
                </div>
                <div class="form-group">
                <label for="privacy_policy" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Privacy Policy</label>
                <div class="col-md-12">
                    <textarea class="ckeditor" cols="78" id="privacy_policy_sweep" name="privacy_policy_sweep" rows="10">'.$privacy_text.'</textarea>
                </div>     
                    <script>
                    CKEDITOR.replace( "privacy_policy_sweep" );
                    </script>
                </div>
                <div class="form-group">
                <label for="legal_disclaimer" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Legal Disclaimer</label>
                <div class="col-md-12">
                    <textarea class="ckeditor" cols="78" id="legal_disclaimer" name="legal_disclaimer" rows="10"></textarea>
                </div>    
                    <script>
                        CKEDITOR.replace("legal_disclaimer" );
                    </script>
                </div>
                <div class="form-group" id="bptandc" >
                    <label for="bp_terms_conditions" style="text-align: left;" class="col-md-12 text-left control-label">BP Terms:
                    <a href="#" title="Default Terms Text Papulates Here">
                        <img src="/assets/blue_question_mark.png" height="13px"
                        style="margin-top:-13px;" />
                    </a>
                     </label>
                    <div class="col-md-12">
                        <textarea class="ckeditor" name="bp_terms_conditions" id="bp_terms_conditions" rows="2"
                            cols="20">'.$terms_text.'</textarea>
                        <script>
                            CKEDITOR.replace("bp_terms_conditions");
                        </script>
                    </div>
                </div>
                <div class="form-group">
                <label for="custom_css" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Custom CSS</label>
                    <div class="col-md-12">
                        <textarea cols="78" id="custom_css" name="custom_css" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                <label for="custom_js" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Custom Js</label>
                <div class="col-md-12">
                    <textarea cols="78" id="custom_js" name="custom_js" rows="10"></textarea>
                </div>
                </div>
            </div>';
            $digitalmirHtml='<div class="portlet-title digitalmirPart" style="display:none">
                    <div class="form-group" id="subject" >
                        <label for="campaign_logo" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Subject:
                        </label>
                        <div class="col-md-10">
                            <input type="text" name="subject" value="'. $subject . '" id="subject" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group" id="campaignLogo" >
                        <label for="campaign_logo" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Choose Campaign Logo:
                        </label>
                        <div class="col-md-10">
                            <input type="hidden" name="file_name" id="file_name" />
                            <input type="hidden" name="image_coupon_id" id="image_coupon_id" />
                            <div id="logo-upload" class="dropzone"></div>
                        </div>
                    </div>
                    <div class="form-group" id="tabTitle" >
                        <label for="tab_title" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Tab Title: </label>
                        <div class="col-md-10">
                            <input type="text" name="tab_title" id="tab_title" class="form-control" value="Bevpromo"></div>
                    </div>
                    <div class="form-group" id="campaignFavicon" ">
                        <label for="fav_icon" class="col-md-2 control-label">
                        <span style="color: #ff0000">*</span>
                        Choose Favicon: 
                        <small>size:16x16</small>
                        </label>
                        <div class="col-md-10">
                            <input type="hidden" name="fav_icon" id="fav_icon" />
                            <input type="hidden" name="fav_image_coupon_id" id="fav_image_coupon_id" />
                            <div id="favicon-upload" class="dropzone"></div>
                        </div>
                    </div>
                    <div class="form-group" id="states_valid" >
                        <label for="valid_states" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Valid States: </label>
                        <div class="col-md-10">
                            <select class="form-control" multiple="multiple" id="validStates" name="valid_states[]">
                                '. $states_opt .'
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="customUrl" >
                        <label for="custom_url" class="col-md-2 control-label"><span style="color: #ff0000">*</span>URL: <a href="#"
                                title="Enter in a custom domain here where the program will be (dns must be changed for that domain) or leave blank to use default url"><img
                                    src="/assets/blue_question_mark.png" height="13px" style="margin-top:-13px;" /></a></label>
                        <div class="col-md-10">
                            <input type="text" name="custom_url" id="custom_url" class="form-control"></div>
                    </div>
                    <div class="form-group" id="promoTitle" >
                        <label for="promotion_title" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Title:
                        </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="promotion_title" id="promotion_title" rows="2" cols="20"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="offerCode" >
                        <label for="offer_code" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Code: </label>
                        <div class="col-md-10">
                            <input type="text" name="offer_code" id="offer_code" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="tandc" >
                        <label for="terms_conditions" class="col-md-2 control-label">Offer Terms:<a href="#" title="Default BP Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                        style="margin-top:-13px;" /></a> </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="terms_conditions" id="terms_conditions" rows="2"
                                cols="20">'.$bp_text.'</textarea>
                            <script>
                                CKEDITOR.replace("terms_conditions");
                            </script>
                        </div>
                    </div>
                   
                    <div class="form-group" id="email_message" >
                        <label for="email_subscription_message" class="col-md-2 control-label">Subscription_message: </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="email_subscription_message" id="email_subscription_message" rows="2"
                                cols="20">'.$email_subscription_text.'</textarea>
                            <script>
                                CKEDITOR.replace("email_subscription_message");
                            </script>
                        </div>
                    </div>
                    <div class="form-group" id="customize_email_message" >
                        <label for="customize_email" class="col-md-2 control-label">Customize Email: </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="customize_email" id="customize_email" rows="2"
                                cols="20">'.$customize_email_message.'</textarea>
                            <script>
                                CKEDITOR.replace("customize_email");
                            </script>
                        </div>
                    </div>
                    <div class="form-group" id="brand_privacy_div">
                        <label for="brand_privacy" class="col-md-2 control-label">Brand Privacy:
                        </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="brand_privacy" id="brand_privacy" rows="2"
                                cols="20"></textarea>
                            <script>
                                CKEDITOR.replace("brand_privacy");
                            </script>
                        </div>
                    </div>
                    <div class="form-group" id="privacy" >
                        <label for="privacy_policy" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Privacy:<a href="#" title="Default Privacy Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                        style="margin-top:-13px;" /></a>
                        </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="privacy_policy" id="privacy_policy" rows="2"
                                cols="20">'.$privacy_text.'</textarea>
                            <script>
                                CKEDITOR.replace("privacy_policy");
                            </script>
                        </div>
                    </div>
                    
                    <div class="form-group" id="welcome" >
                        <label for="welcome_message" class="col-md-2 control-label">Welcome Message: </label>
                        <div class="col-md-10">
                            <textarea class="ckeditor" name="welcome_message" id="welcome_message" rows="2"
                                cols="20">'.$welcome_message_text.'</textarea>
                            <script>
                                CKEDITOR.replace("welcome_message");
                            </script>
                        </div>
                    </div>
                    <div class="form-group" id="copyright" >
                        <label for="copyright_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Copyright Text:
                        </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="copyright_text" id="copyright_text" rows="2" cols="20">&copy;</textarea>
                        </div>
                    </div>
                    <div class="form-group" id="footer" >
                        <label for="footer_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Footer Text: </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="footer_text" id="footer_text" rows="2" cols="20"></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="color_guide_dmir" >
                        <label for="color_guide" class="col-md-2 control-label"> Color Guide: </label>
                        <div class="col-md-10">
                            <a href="'.Constant::$assetLink.'guides/color-guide-dmir.docx" target="_blank" name="color_guide"
                                id="color_guide" class="form-control">Color Guide</a>
                        </div>
                    </div>
                    <div class="form-group" id="hrColor" >
                        <label for="line_hr_color" class="col-md-2 control-label"> Top Line Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="line_hr_color" id="line_hr_color" value="#000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="navColor" >
                        <label for="nav_color" class="col-md-2 control-label"> Nav Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="nav_color" id="nav_color" value="#b29042" onchange="spanColor(this)"
                                onkeyup="spanColor(this)" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="titleColor" >
                        <label for="title_color" class="col-md-2 control-label"> Title Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="title_color" id="title_color" value="#b29042" class="form-control">
                        </div>
                    </div>

                    <div class="form-group" id="linkColor" >
                        <label for="link_color" class="col-md-2 control-label"> Link Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="link_color" id="link_color" value="#b29042" class="form-control">
                        </div>
                    </div>

                    <div class="form-group" id="trackBoxBgColor" >
                        <label for="track_box_bg_color" class="col-md-2 control-label"> Track Box Bg Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="track_box_bg_color" id="track_box_bg_color" value="#0D223F" class="form-control">
                        </div>
                    </div>

                    <div class="form-group" id="bgColor" >
                        <label for="bg_color" class="col-md-2 control-label"> Background Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="bg_color" id="bg_color" value="#000000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="defaultColor" >
                        <label for="default_color" class="col-md-2 control-label"> Default Color: </label>
                        <div class="col-md-10">
                            <input type="color" name="default_color" id="default_color" value="#000000" class="form-control">
                        </div>
                    </div>
                    <div class="form-group" id="spanColor" >
                        <label for="field_span_color" class="col-md-2 control-label"></label>
                        <div class="col-md-10">
                            <input type="hidden" name="field_span_color" id="field_span_color" value="#b29042" class="form-control">
                        </div>
                    </div>
            </div>';


            $defualtfaqs = DefaultFaq::all()->toArray();        
                $faqs = Faq::where('coupon_id', '=', $id)->get();
                $digitalmirHtml .= '
                <div id="defaultfaqSection" style="display:none">
                    <div class="border faqs col-sm-12">
                        <h3>Enter Faqs:</h3>';
                        foreach ($defualtfaqs as $key => $value) {
                            $digitalmirHtml .= '
                                <div class="qaDiv">
                                    <div class="form-group">
                                        <label for="question" class="col-md-2 control-label">Question: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="question[]" class="form-control" value="' . $value['question'] . '">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="answer" class="col-md-2 control-label">Answer: </label>
                                        <div class="col-md-10">
                                            <textarea class="ckeditor" name="answer[]" id="answer' . $key . '" rows="2" cols="20">' . $value['answer'] . '</textarea>
                                            <script>
                                                CKEDITOR.replace("answer' . $key . '");
                                            </script>
                                        </div>
                                    </div>
                                    <div class="text-center" style="margin-bottom:5px;">
                                        <a class="removeFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            ';
                        }
                        $digitalmirHtml .= '
                    	<div class="form-group">
    			            <label for="question" class="col-md-2 control-label">Question: </label>
    			            <div class="col-md-10">
    			                <input type="text" name="question[]" class="form-control">
    			            </div>
    			        </div>
    			        <div class="form-group">
    			            <label for="answer" class="col-md-2 control-label">answer: </label>
    			            <div class="col-md-10">
    			                <textarea class="ckeditor" name="answer[]" id="answer" rows="2" cols="20"></textarea>
    			                <script>
    			                    CKEDITOR.replace("answer");
    			                </script>
    			            </div>
    			        </div>
    			        <div id="faqCopy"></div>
    			        <div class="text-center" style="margin-bottom:5px;">
    			            <a class="addFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
    			        </div>
                    </div>
                </div>
                    ';
                
            $coupon_html = '<div class="form-group sweep-remove">
                <label for="coupon_type_id" class="col-md-2 control-label">Coupon Type: </label>
                <div class="col-md-10">
                    <select class="form-control" id="coupon_type_id" name="coupon_type_id">
                        ' . $coupon_opt . '
                    </select>
                </div>
            </div>';
            $brand_html = '<div class="form-group">
                <label for="brand_id" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Brand: </label>
                <div class="col-md-8">
                <select class="form-control" id="brand_id" name="brand_id" required>
                    ' . $brands_opt . '
                </select>
                </div><a href="/admin/brands/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                <a class="btn red control-label" id="btnRefreshBrand" name="btnRefreshBrand" style="text-align: center;"><i class="fa fa-refresh"></i></a>
            </div>';
            $program_owner_html = '<div class="form-group">
                <label for="user_id" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Program Owner: </label>
                <div class="col-md-8">
                    <select class="form-control" id="user_id" name="user_id" required>
                        ' . $programs_owner . '
                    </select>
                    </div><a href="/admin/clients/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                    <a class="btn red control-label" id="btnRefreshOwner" name="btnRefreshOwner" style="text-align: center;"><i class="fa fa-refresh"></i></a>
            </div>';
            $coupon_name_html = '<div class="form-group">
                <label for="name" class="col-md-2 control-label" id="SweepstakesName"><span style="color: #ff0000">*</span>Coupon Name: </label>
                <div class="col-md-10">
                    <input class="form-control" name="name" type="text" id="name" >
                </div>
            </div>';
            $radio_html = '<div class="form-group">
                <label class="col-md-2 control-label">Active: </label>
                <div class="col-md-10" style="padding-top:0.8rem;">';
                $radio_html .= '
                <input checked="checked" name="active" type="radio" value="1"> Yes
                <input name="active" type="radio" value="0">
            No</div>';
                $html = "<div class='row'><div class='col-md-12'>
                        <form method='post' id='addEditCouponForm' enctype='multipart/form-data' role='form' autocomplete='off' class='form-horizontal'>
                        <input type='hidden' name='btnType' id='btnType' value=''>
                        <input type='hidden' name='id' id='id' value='0'>
                        <div class='form-body'>
                        
                            <div class='form-group' id='display_campaign_type'>
                                <label for='campaign_type' class='col-md-2 control-label'>Select Campaign Type:</label>
                                <div class='col-md-10'>
                                    $campains_html
                                </div>
                            </div>
                            
                    $coupon_html
                    
                    
                    
                    
                    $paragraph_size
                    
                   
                    $coupon_name_html
                    <div class='form-group sweep-remove'>
                    <label for='value' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Dollar Value: </label>
                    <div class='col-md-10'>
                        <input class='form-control' autocomplete='off' name='value' type='text' id='value'>
                    </div>
                    </div>
                    <div class='form-group sweep-remove'>
                    <label for='description' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Description: </label>
                    <div class='col-md-10'>
                        <input class='form-control' autocomplete='off' name='description' type='text' id='description'>
                    </div>
                    </div>
                    <div class='form-group'>
                    <label for='start_date' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Start Date: </label>
                    <div class='col-md-3'>
                    <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='start_date' type='text' id='start_date' required>
                    
                    

                    </div>
                    </div>
                        <div class='form-group'>
                        <label for='expires' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>End Date </label>
                        <div class='col-md-3'>
                        <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='expires' type='text' id='expires'>
                        </div>
                    </div>
                    <div class='form-group sweep-remove'>
                        <label for='receive_by' class='col-md-2 control-label'><span style='color: #ff0000'>*</span> Receive By: </label>
                        <div class='col-md-3'>
                            <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='receive_by' type='text' id='receive_by'>
                        </div>
                    </div>
                
                    <div class='form-group sweep-remove'>
                        <label for='circulation' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Circulation: </label>
                        <div class='col-md-10'>
                            <input class='form-control' autocomplete='off' name='circulation' type='text' id='circulation'>
                        </div>
                    </div>
                    $program_owner_html
                    $brand_html
                    $radio_html
                        </div>
                        
                        $sweepstakesHtml
                        $digitalmirHtml
                        </form>
                        </div>
                        </div>";
                echo json_encode($html);
        } else {
            $url = Request::fullUrl();
            $find = str_contains($url,'type');
                //Update
                $coupon = Coupon::findOrFail($id);
                $coupon_view = CouponView::where('coupon_id', '=', $id)->first();
                $url_link = Constant::$frontEndUrl . $coupon_view->campaign_url . '/' . $id;
                $final_url = "<div class='form-group' id='finalUrl' style='display: none'>
                    <label for='front_end_url' class='col-md-2 control-label'>Front End Url: </label>
                    <div class='col-md-10'>
                        <div style='margin-top:1rem;'><a href='" . $url_link . "' target='_blank'>Open</a></div>
                    </div></div>";
                $campains_html .= "<select class='form-control' id='campaignType' name='campaign_type'>";
                foreach ($campaigns as $key => $value) {
                    if ($key == $coupon->campaign_type) {
                        $campains_html .= "<option value='$key' selected='selected'>$value</option>";
                    } else {
                        $campains_html .= "<option value='$key'>$value</option>";
                    }
                }
                $campains_html .= "</select>";
                $types = CouponType::select('name', 'id')->where('active', '=', 1)->orderBy('name')->get();

                $favicon_src = Constant::$assetLink . 'entries/' . $coupon->id . '/' . $coupon->fav_icon;
                $logo_src = Constant::$assetLink . 'entries/' . $coupon->id . '/' . $coupon->campaign_logo;
                $digitalmirHtml = '<div class="portlet-title digitalmirPart" style="display:none">
                    <div class="form-group" id="tabTitle" ">
                        <label for="tab_title" class="col-md-2 control-label">Tab Title:<a href="#"
                                title="Enter in a Browswer Tab Title"><img src="/assets/blue_question_mark.png" height="13px"
                                    style="margin-top:-13px;" /></a> </label>
                        <div class="col-md-10">
                        <input type="text" name="tab_title" id="tab_title" class="form-control" value="' . $coupon->tab_title . '"></div>
                    </div>                                   
                    <div class="form-group" id="campaignFavicon">
                        <label for="fav_icon" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Choose Favicon: <small>size:16x16</small> </label>
                        <div class="col-md-10">
                            <input type="hidden" name="fav_icon" id="fav_icon" />
                            <input type="hidden" name="fav_image_coupon_id" id="fav_image_coupon_id" />
                            <div id="favicon-upload" class="dropzone"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fav_icon" class="col-md-2 control-label">Favicon: </label>
                        <div class="col-md-10">
                            <a target="_blank" href=' . $favicon_src . '><img style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px;" src=' . $favicon_src . ' alt="Favicon"></a>
                        </div>
                    </div>





                </div>';


                if ($coupon->campaign_type == 3) {
                    $subject = isset($coupon->subject) ? $coupon->subject : $subject;
                    if ($coupon->privacy_policy == '') {
                        $privacy = $privacy_text;
                    } else {
                        $privacy = $coupon->privacy_policy;
                    }
                    $digitalmirHtml .= '

                        <div class="form-group" id="subject" >
                            <label for="campaign_logo" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Subject:
                            </label>
                            <div class="col-md-10">
                                <input type="text" name="subject" value="'. $subject . '" id="subject" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group" id="campaignLogo">
                            <label for="campaign_logo" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Choose Campaign Logo:
                            </label>
                            <div class="col-md-10">
                                <input type="hidden" name="file_name" id="file_name" />
                                <input type="hidden" name="image_coupon_id" id="image_coupon_id" />
                                <div id="logo-upload" class="dropzone"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="campaign_logo" class="col-md-2 control-label">Logo: </label>
                            <div class="col-md-10">
                                <a target="_blank" href=' . $logo_src . '><img
                                        style="border: 1px solid #ddd; border-radius: 4px; padding: 5px; width: 150px;" src=' . $logo_src . '
                                        alt="Logo"></a>
                            </div>
                        </div>
                        <div class="form-group" id="customUrl">
                            <label for="custom_url" class="col-md-2 control-label"><span style="color: #ff0000">*</span>URL: <a href="#"
                                    title="Enter in a custom domain here where the program will be (dns must be changed for that domain) or leave blank to use default url"><img
                                        src="/assets/blue_question_mark.png" height="13px" style="margin-top:-13px;" /></a></label>
                            <div class="col-md-10">
                                <input type="text" name="custom_url" id="custom_url" value="' . $coupon->custom_url . '" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="promoTitle">
                            <label for="promotion_title" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Title:
                            </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="promotion_title" id="promotion_title" rows="2"
                                    cols="20">' . $coupon->promotion_title . '</textarea>
                            </div>
                        </div>
                        <div class="form-group" id="offerCode">
                            <label for="offer_code" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Code: </label>
                            <div class="col-md-10">
                                <input type="text" name="offer_code" id="offer_code" value="' . $coupon->offer_code . '" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="copyright">
                            <label for="copyright_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Copyright Text:
                            </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="copyright_text" id="copyright_text" rows="2"
                                    cols="20">' . $coupon->copyright_text . '</textarea>
                            </div>
                        </div>
                        <div class="form-group" id="footer">
                            <label for="footer_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Footer Text: </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="footer_text" id="footer_text" rows="2"
                                    cols="20">' . $coupon->footer_text . '</textarea>
                            </div>
                        </div>
                        <div class="form-group" id="color_guide_dmir" >
                            <label for="color_guide" class="col-md-2 control-label"> Color Guide: </label>
                            <div class="col-md-10">
                                <a href="' . Constant::$assetLink . 'guides/color-guide-dmir.docx" target="_blank" name="color_guide"
                                    id="color_guide" class="form-control">Color Guide</a>
                            </div>
                        </div>
                        <div class="form-group" id="hrColor">
                            <label for="line_hr_color" class="col-md-2 control-label"> Top Line Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="line_hr_color" id="line_hr_color" value="' . $coupon->line_hr_color . '"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="navColor">
                            <label for="nav_color" class="col-md-2 control-label"> Nav Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="nav_color" id="nav_color" value="' . $coupon->nav_color . '"
                                    onchange="spanColor(this)" onkeyup="spanColor(this)" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="titleColor" >
                            <label for="title_color" class="col-md-2 control-label"> Title Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="title_color" id="title_color" value="' . $coupon->title_color . '"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="linkColor">
                            <label for="link_color" class="col-md-2 control-label"> Link Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="link_color" id="link_color" value="' . $coupon->link_color . '" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="trackBoxBgColor">
                            <label for="track_box_bg_color" class="col-md-2 control-label"> Track Box Bg Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="track_box_bg_color" id="track_box_bg_color"
                                    value="' . $coupon->track_box_bg_color . '" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="bgColor">
                            <label for="bg_color" class="col-md-2 control-label"> Background Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="bg_color" id="bg_color" value="' . $coupon->bg_color . '" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="defaultColor">
                            <label for="default_color" class="col-md-2 control-label"> Default Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="default_color" id="default_color" value="' . $coupon->default_color . '"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="spanColor">
                            <label for="field_span_color" class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <input type="hidden" name="field_span_color" id="field_span_color" value="' . $coupon->field_span_color . '"
                                    class="form-control">
                            </div>
                        </div>



                    ';


                    if ($coupon->terms_conditions == '') {
                        $coupon->terms_conditions = $terms_text;
                    }
                    $digitalmirHtml .= '
                        <div class="form-group" id="tandc">
                            <label for="terms_conditions" class="col-md-2 control-label">Offer Terms </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="terms_conditions" id="terms_conditions" rows="2"
                                    cols="20">' . $coupon->terms_conditions . '</textarea>
                                <script>
                                    CKEDITOR.replace("terms_conditions");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="bptandc" >
                            <label for="bp_terms_conditions" class="col-md-2 control-label">BP Terms:<a href="#" title="Default Terms Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                            style="margin-top:-13px;" /></a> </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="bp_terms_conditions" id="bp_terms_conditions" rows="2"
                                    cols="20">' . $terms_text . '</textarea>
                                <script>
                                    CKEDITOR.replace("bp_terms_conditions");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="email_message" >
                            <label for="email_subscription_message" class="col-md-2 control-label">Subscription_message: </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="email_subscription_message" id="email_subscription_message" rows="2"
                                    cols="20">' . $email_subscription_text . '</textarea>
                                <script>
                                    CKEDITOR.replace("email_subscription_message");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="customize_email_message" >
                            <label for="customize_email" class="col-md-2 control-label">Customize Email: </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="customize_email" id="customize_email" rows="2"
                                    cols="20">' . $customize_email_message . '</textarea>
                                <script>
                                    CKEDITOR.replace("customize_email");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="privacy">
                            <label for="privacy_policy" class="col-md-2 control-label">Offer Privacy:<a href="#" title="Default Privacy Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                            style="margin-top:-13px;" /></a> </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="privacy_policy" id="privacy_policy" rows="2"
                                    cols="20">' . $privacy . '</textarea>
                                <script>
                                    CKEDITOR.replace("privacy_policy");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="brand_privacy">
                            <label for="brand_privacy" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Brand Privacy:
                            </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="brand_privacy" id="brand_privacy_policy" rows="2"
                                    cols="20">' . $coupon->brand_privacy . '</textarea>
                                <script>
                                    CKEDITOR.replace("brand_privacy_policy");
                                </script>
                            </div>
                        </div>
                        <div class="form-group sweep-remove" id="welcome" >
                            <label for="welcome_message" class="col-md-2 control-label">Welcome Message: </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="welcome_message" id="welcome_message" rows="2"
                                    cols="20">' . $coupon->welcome_message . '</textarea>
                                <script>
                                    CKEDITOR.replace("welcome_message");
                                </script>
                            </div>
                        </div>
                        
                        <div class="form-group" id="paragraphsize">
                            <label for="paragraph_size" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Paragraph Size:
                            <small>size:15px</small>
                            </label>
                            <div class="col-md-10">
                                <input type="number" placeholder="Size in Pixel" value="' . $coupon->paragraph_size . '" name="paragraph_size" id="paragraph_size" class="form-control"
                                    required>
                            </div>
                        </div>
                    ';


                    $faqs = Faq::where('coupon_id', '=', $id)->get();
                    $digitalmirHtml .= '<div id="defaultfaqSection" style="display:none"><div class="border faqs col-sm-12"><h3>Enter Faqs:</h3>';
                    foreach ($faqs as $key => $value) {
                        $digitalmirHtml .= '
                                <div class="qaDiv">
                                    <div class="form-group">
                                        <label for="question" class="col-md-2 control-label">Question: </label>
                                        <div class="col-md-10">
                                            <input type="text" name="question[]" class="form-control" value="' . $value['question'] . '">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="answer" class="col-md-2 control-label">Answer: </label>
                                        <div class="col-md-10">
                                            <textarea class="ckeditor" name="answer[]" id="answer' . $key . '" rows="2" cols="20">' . $value['answer'] . '</textarea>
                                            <script>
                                                CKEDITOR.replace("answer' . $key . '");
                                            </script>
                                        </div>
                                    </div>
                                    <div class="text-center" style="margin-bottom:5px;">
                                        <a class="removeFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            ';
                    }
                    $digitalmirHtml .= '
                        <div class="form-group">
                            <label for="question" class="col-md-2 control-label">Question: </label>
                            <div class="col-md-10">
                                <input type="text" name="question[]" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="answer" class="col-md-2 control-label">answer: </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="answer[]" id="answer" rows="2" cols="20"></textarea>
                                <script>
                                    CKEDITOR.replace("answer");
                                </script>
                            </div>
                        </div>
                        <div id="faqCopy"></div>
                        <div class="text-center" style="margin-bottom:5px;">
                            <a class="addFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                        </div>
                        </div>
                        </div>
                    ';

                } else {
                    $digitalmirHtml .= ' 
                        <div id="faqSection" class="border col-sm-12" style="display:none">
                            <h3>Enter Faqs:</h3>
                            <div class="form-group">
                            <label for="question" class="col-md-2 control-label">Question: </label>
                            <div class="col-md-10">
                            <input type="text" name="question[]" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="answer" class="col-md-2 control-label">answer: </label>
                        <div class="col-md-10">
                        <textarea class="ckeditor" name="answer[]" id="answer" rows="2" cols="20"></textarea>
                        <script>
                            CKEDITOR.replace("answer");
                        </script>
                            </div>
                        </div>
                        <div class="text-center" style="margin-bottom:5px;">
                            <a class="addFaq" href="javascript:void(0)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                        </div>
                        <div id="faqCopy"></div>
                        </div>
                        <div class="form-group" id="offerCode" >
                            <label for="offer_code" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Program Code: </label>
                            <div class="col-md-10">
                                <input type="text" name="offer_code" id="offer_code" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="campaignLogo" >
                            <label for="campaign_logo" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Choose Campaign Logo:
                            </label>
                            <div class="col-md-10">
                                <input type="hidden" name="file_name" id="file_name" />
                                <input type="hidden" name="image_coupon_id" id="image_coupon_id" />
                                <div id="logo-upload" class="dropzone"></div>
                            </div>
                        </div>
                        <div class="form-group" id="customUrl" >
                            <label for="custom_url" class="col-md-2 control-label"><span style="color: #ff0000">*</span>URL: </label> <a
                                href="#"
                                title="Enter in a custom domain here where the program will be (dns must be changed for that domain) or leave blank to use default url"><img
                                    src="/assets/blue_question_mark.png" height="13px" /></a>
                            <div class="col-md-10">
                                <input type="text" name="custom_url" id="custom_url" value="' . $coupon->custom_url . '" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="promoTitle" >
                            <label for="promotion_title" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Title:
                            </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="promotion_title" id="promotion_title" rows="2" cols="20"></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="copyright" >
                            <label for="copyright_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Copyright Text:
                            </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="copyright_text" id="copyright_text" rows="2" cols="20">&copy;</textarea>
                            </div>
                        </div>
                        <div class="form-group" id="footer" >
                            <label for="footer_text" class="col-md-2 control-label"> <span style="color: #ff0000">*</span>Footer Text: </label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="footer_text" id="footer_text" rows="2" cols="20"></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="color_guide_dmir" >
                            <label for="color_guide" class="col-md-2 control-label"> Color Guide: </label>
                            <div class="col-md-10">
                                <a href="' . Constant::$assetLink . 'guides/color-guide-dmir.docx" target="_blank" name="color_guide"
                                    id="color_guide" class="form-control">Color Guide</a>
                            </div>
                        </div>
                        <div class="form-group" id="hrColor" >
                            <label for="line_hr_color" class="col-md-2 control-label"> Top Line Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="line_hr_color" id="line_hr_color" value="#000" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="navColor" >
                            <label for="nav_color" class="col-md-2 control-label"> Nav Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="nav_color" id="nav_color" value="" onchange="spanColor(this)"
                                    onkeyup="spanColor(this)" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="titleColor" >
                            <label for="title_color" class="col-md-2 control-label"> Title Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="title_color" id="title_color" value="#b29042" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="linkColor" >
                            <label for="link_color" class="col-md-2 control-label"> Link Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="link_color" id="link_color" value="#b29042" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="trackBoxBgColor" >
                            <label for="track_box_bg_color" class="col-md-2 control-label"> Track Box Bg Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="track_box_bg_color" id="track_box_bg_color" value="#0D223F" class="form-control">
                            </div>
                        </div>

                        <div class="form-group" id="bgColor" >
                            <label for="bg_color" class="col-md-2 control-label"> Background Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="bg_color" id="bg_color" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="defaultColor" >
                            <label for="default_color" class="col-md-2 control-label"> Default Color: </label>
                            <div class="col-md-10">
                                <input type="color" name="default_color" id="default_color" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="spanColor" >
                            <label for="field_span_color" class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <input type="hidden" name="field_span_color" id="field_span_color" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group" id="tandc" >
                            <label for="terms_conditions" class="col-md-2 control-label">Offer Terms </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="terms_conditions" id="terms_conditions" rows="2" cols="20"></textarea>
                                <script>
                                    CKEDITOR.replace("terms_conditions");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="bptandc" >
                            <label for="bp_terms_conditions" class="col-md-2 control-label">BP Terms:<a href="#" title="Default Terms Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                            style="margin-top:-13px;" /></a> </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="bp_terms_conditions" id="bp_terms_conditions" rows="2"
                                    cols="20">' . $terms_text . '</textarea>
                                <script>
                                    CKEDITOR.replace("bp_terms_conditions");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="email_message" >
                            <label for="email_subscription_message" class="col-md-2 control-label">Subscription_message: </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="email_subscription_message" id="email_subscription_message" rows="2"
                                    cols="20">' . $email_subscription_text . '</textarea>
                                <script>
                                    CKEDITOR.replace("email_subscription_message");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="paragraphsize">
                            <label for="paragraph_size" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Paragraph Size:
                            <small>size:15px</small>
                            </label>
                            <div class="col-md-10">
                                <input type="number" placeholder="Size in Pixel" value="' . $coupon->paragraph_size . '" name="paragraph_size" id="paragraph_size" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="form-group" id="customize_email_message" >
                            <label for="customize_email" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Customize Email:
                            </label>
                            <div class="col-md-10">
                                <textarea class="ckeditor" name="customize_email" id="customize_email" rows="2"
                                    cols="20">' . $customize_email_message . '</textarea>
                                <script>
                                    CKEDITOR.replace("customize_email");
                                </script>
                            </div>
                        </div>
                        <div class="form-group" id="privacy" >
                            <label for="privacy_policy" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Offer Privacy:<a href="#" title="Default Privacy Text Papulates Here"><img src="/assets/blue_question_mark.png" height="13px"
                            style="margin-top:-13px;" /></a>
                            </label>
                            <div class="col-md-10">
                                <textarea class="form-control" class="ckeditor" name="privacy_policy" id="privacy_policy" rows="2"
                                    cols="20">' . $privacy_text . '</textarea>
                                <script>
                                    CKEDITOR.replace("privacy_policy");
                                </script>
                            </div>
                        </div>
    
                    ';


                }
                $sweepstakesHtml = '';

                if ($coupon->campaign_type == 4) {


                    $terms_cond = '';
                    $brand_privacy_html = '';
                    $existing_sweep = SweepsTakesProgramDetails::where('coupon_id', '=', $id)->first();
                    if ($existing_sweep->privacy_policy == '') {
                        $privacy = $privacy_text;
                    } else {
                        $privacy = $existing_sweep->privacy_policy;
                    }
                    if ($existing_sweep->terms_conditions == '') {
                        $terms_cond = $terms_text;
                    } else {
                        $terms_text = $existing_sweep->terms_conditions;
                    }
                    $upload_type_opt = '';
                    foreach ($uploadType as $key => $value) {
                        $upload_type_opt .= '<option value=' . $key . '>' . $value . '</option>';
                    }
                    $states_opt = '';
                    $programStates = CouponStates::where('coupon_id', '=', $id)->get();
                    $existing_states = [];
                    foreach ($programStates as $key => $value) {
                        array_push($existing_states, $value['state_id']);
                    }
                    foreach ($states as $state) {
                        if (in_array($state->id, $existing_states)) {
                            $states_opt .= '<option value=' . $state->id . ' selected="selected">' . $state->state . '</option>';
                        } else {
                            $states_opt .= '<option value=' . $state->id . ' >' . $state->state . '</option>';
                        }
                    }
                    $program_status_opt = '';
                    foreach ($programStatus as $key => $value) {
                        if ($existing_sweep->status = $value) {
                            $program_status_opt .= '<option value=' . $key . ' selected="selected">' . $value . '</option>';
                        } else {
                            $program_status_opt .= '<option value=' . $key . ' >' . $value . '</option>';
                        }
                    }
                    $sweep_rule_html = '';
                    if ($existing_sweep->rules == 1) {
                        $sweep_rule_html .= '<input type="checkbox" id="rule_only_program" name="rule_only_program" checked="checked">';
                    } else {
                        $sweep_rule_html .= '<input type="checkbox" id="rule_only_program" name="rule_only_program">';
                    }
                    $sweep_form_align_left = '';
                    if ($existing_sweep->form_align == "divAlignLeft") {
                        $sweep_form_align_left .= '<input type="radio" id="form_align_left" name="form_align" value="divAlignLeft" checked>';
                    } else {
                        $sweep_form_align_left .= '<input type="radio" id="form_align_left" name="form_align" value="divAlignLeft">';
                    }
                    $sweep_form_align_center = '';
                    if ($existing_sweep->form_align == "divAlignCenter") {
                        $sweep_form_align_center .= '<input type="radio" id="form_align_center" name="form_align" value="divAlignCenter" checked>';
                    } else {
                        $sweep_form_align_center .= '<input type="radio" id="form_align_center" name="form_align" value="divAlignCenter">';
                    }

                    $sweep_form_align_right = '';
                    if ($existing_sweep->form_align == "divAlignRight") {
                        $sweep_form_align_right .= '<input type="radio" id="form_align_right" name="form_align" value="divAlignRight" checked>';
                    } else {
                        $sweep_form_align_right .= '<input type="radio" id="form_align_right" name="form_align" value="divAlignRight">';
                    }
                    $slider = '';
                    if ($existing_sweep->slider == 1) {
                        $slider .= '<input type="checkbox" id="slider" name="slider" checked="checked">';
                    } else {
                        $slider .= '<input type="checkbox" id="slider" name="slider">';
                    }
                    $youtube_video = '';
                    if ($existing_sweep->youtube_video == 1) {
                        $youtube_video .= '<input type="checkbox" id="youtube_video" name="youtube_video" checked="checked">';
                    } else {
                        $youtube_video .= '<input type="checkbox" id="youtube_video" name="youtube_video">';
                    }
                    $promo_ad = '';
                    if ($existing_sweep->promo_ad == 1) {
                        $promo_ad .= '<input type="checkbox" id="promo_ad" name="promo_ad" checked="checked">';
                    } else {
                        $promo_ad .= '<input type="checkbox" id="promo_ad" name="promo_ad">';
                    }
                    $page_gap = '';
                    if ($existing_sweep->page_gap == 1) {
                        $page_gap .= '<input type="checkbox" id="page_gap" name="page_gap" checked="checked">';
                    } else {
                        $page_gap .= '<input type="checkbox" id="page_gap" name="page_gap">';
                    }
                    $prize_display = '';
                    if ($existing_sweep->prize_display == 1) {
                        $prize_display .= '<input type="checkbox" id="prize_display" name="prize_display" checked="checked">';
                    } else {
                        $prize_display .= '<input type="checkbox" id="prize_display" name="prize_display">';
                    }
                    $promo_page = '';
                    if ($existing_sweep->promo_page == 1) {
                        $promo_page .= '<input type="checkbox" id="promo_page" name="promo_page" checked="checked">';
                    } else {
                        $promo_page .= '<input type="checkbox" id="promo_page" name="promo_page">';
                    }
                    $youtube_video_url = '<div class="form-group">
                        <label for="youtube_video_url" class="col-md-3 control-label">Youtube Video URL: </label>
                        <div class="col-md-9">
                            <input class="form-control" autocomplete="off" name="youtube_video_url" type="text" id="youtube_video_url" value=' . $existing_sweep->youtube_video_url . '>
                        </div>
                    </div>';
                    $getImage = Functions::get_uploaded_images_html_sweep($id);
                    $sweepstakesHtml = '<div class="portlet-title sweeptakesPart" style="display:none">
                        <div class="form-body">
                        <h3>Image Uploader</h3>
                        <div class="border col-sm-12">
                                        <div class="form-group">
                                            <label for="photo_position" class="col-md-4 control-label">Select Photo Position:</label>
                                            <div class="col-md-5">
                                                <select class="uploadTypeChange form-control" id="uploadType" data-id="1" name="photo_position[1][]">
                                                    ' . $upload_type_opt . '
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="form-group parentImage" id="images_upload">
                                        <label for="image_post" class="col-md-4 control-label">Select Image: </label>
                                        <div class="col-md-6 imageCopy_1">
                                            <div id="sweep-upload" class="dropzone"></div>
                                        </div>                                                  
                                    </div>                       
                                    </div>
                        <div id="uploaded_images">' . $getImage . '</div>
                        </div>
                        <div class="col-sm-12">
                        <h3>Program Details</h3>
                        </div>
                            <div class="form-group">
                                <input type="hidden" name="sweep_id" value=' . $existing_sweep->id . '>
                                <label for="program_no" class="col-md-3 control-label">Program No.: </label>
                                <div class="col-md-9 ">
                                    <input class="form-control" autocomplete="off" disabled="disabled" name="program_no" type="text" value=' . $existing_sweep->id . ' id="program_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="url" class="col-md-3 control-label">Program URL(without www.): <a href="#" title="Enter in a custom domain here where the program will be (dns must be changed for that domain) or leave blank to use default url"><img src="/assets/blue_question_mark.png" height="13px" style="margin-top:-13px;"/></a></label>
                                <div class="col-md-9">
                                    <input class="form-control" autocomplete="off" name="url" type="text" id="url" value=' . $existing_sweep->url . '>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="brand_landing_url" class="col-md-3 control-label">Brand URL: </label>
                                <div class="col-md-9">
                                    <input class="form-control" autocomplete="off" name="brand_landing_url" type="text" id="brand_landing_url" value=' . $existing_sweep->brand_landing_url . '>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_email" class="col-md-3 control-label">Admin Email: </label>
                                <div class="col-md-9">
                                    <input class="form-control" autocomplete="off" name="admin_email" type="text" id="admin_email" value=' . $existing_sweep->admin_email . '>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="valid_states" class="col-md-3 control-label"><span style="color: #ff0000">*</span>Valid States: </label>
                                <div class="col-md-9">
                                <select class="form-control" multiple="multiple" id="validStates" name="valid_states[]" >
                                    ' . $states_opt . '
                                </select>
                                </div>
                            </div>

                            <div class="form-group" id="welcome" style="display: none">
                            <label for="welcome_message" class="col-md-2 control-label">Welcome Message: </label>
                            <div class="col-md-10">
                            <textarea class="ckeditor" name="welcome_message" id="welcome_message" rows="2" cols="20">' . $coupon->welcome_message . '</textarea>
                            <script>
                                CKEDITOR.replace("welcome_message");
                            </script>
                            </div></div>
                            
                            <div class="form-group">
                                <label for="daily_entry_limit" class="col-md-3 control-label">Total Entries/Person</label>
                                <div class="col-md-9">
                                    <input class="form-control" autocomplete="off" name="daily_entry_limit" type="text" id="daily_entry_limit" value=' . $existing_sweep->data_entry_limit . '>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="daily_limit" class="col-md-3 control-label">Daily Limit: </label>
                            <div class="col-md-9">
                                <input class="form-control" autocomplete="off" name="daily_limit" type="text" id="daily_limit" value=' . $existing_sweep->daily_limit . '>
                            </div>
                            </div>
                            <div class="form-group">
                                <label for="under_age_link" class="col-md-3 control-label">Under Age Link: </label>
                                <div class="col-md-9">
                                    <input class="form-control" autocomplete="off" name="under_age_link" type="text" id="under_age_link" value=' . $existing_sweep->under_age_link . '>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="headings_color" class="col-md-3 control-label">Headings Color: </label>
                                <div class="col-md-9">
                                    <input type="color" id="headings_color" name="headings_color" class="form-control" value="' . $existing_sweep->headings_color . '">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="form_text_color" class="col-md-3 control-label">Form Text Color: </label>
                                <div class="col-md-9">
                                    <input type="color" id="form_text_color" name="form_text_color" class="form-control" value="' . $existing_sweep->form_text_color . '">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Form Align: </label>
                                <div class="col-md-9" style="padding-top:0.8rem;">
                                    <div class="row">
                                        <div class="col-md-4">
                                            ' . $sweep_form_align_left . ' 
                                            <label for="form_align_left"> Left</label>
                                        </div>
                                        <div class="col-md-4">
                                            ' . $sweep_form_align_center . ' 
                                            <label for="form_align_center"> Center</label>
                                        </div>
                                        <div class="col-md-4">
                                            ' . $sweep_form_align_right . '
                                            <label for="form_align_right"> Right</label>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="official_rule_entry_link" class="col-md-3 control-label">Official Rule Entry Link: </label>
                                <div class="col-md-9">
                                    <input type="text" id="official_rule_entry_link" name="official_rule_entry_link" class="form-control" value="' . $existing_sweep->official_rule_entry_link . '">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="official_rule_entry_link_color" class="col-md-3 control-label">Official Rule Entry Link Color: </label>
                                <div class="col-md-9">
                                    <input type="color" id="official_rule_entry_link_color" name="official_rule_entry_link_color" class="form-control" value="' . $existing_sweep->official_rule_entry_link_color . '">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rule_only_program" class="col-md-3 control-label">Rules Only Program: </label>
                                <div class="col-md-9" style="padding-top:0.8rem;">
                                    ' . $sweep_rule_html . '
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="promo_page" class="col-md-3 control-label">Activate Promo Page: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                                ' . $promo_page . '
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="prize_display" class="col-md-3 control-label">Activate Prize Display: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                                ' . $prize_display . '
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_gap" class="col-md-3 control-label">Activate Page Gap: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                                ' . $page_gap . '
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="promo_ad" class="col-md-3 control-label">Activate Promo Ad: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                                ' . $promo_ad . '
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="youtube_video" class="col-md-3 control-label">Activate Youtube Video: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                                ' . $youtube_video . '
                            </div>
                        </div>
                        ' . $youtube_video_url . '
                        <div class="form-group">
                            <label for="slider" class="col-md-3 control-label">Activate Slider: </label>
                            <div class="col-md-9" style="padding-top:0.8rem;">
                            ' . $slider . '
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="codes_per_email" class="col-md-3 control-label">Codes per email: </label>
                            <div class="col-md-9">
                                <input class="form-control" autocomplete="off" name="codes_per_email" type="text" value="' . $existing_sweep->codes_per_email . '" id="codes_per_email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code_redeemed_message" class="col-md-3 control-label">Code redeemed message: </label>
                            <div class="col-md-9">
                                <input class="form-control" autocomplete="off" name="code_redeemed_message" type="text" value="' . $existing_sweep->code_redeemed_message . '" id="code_redeemed_message">
                            </div>
                        </div>
                            <div class="form-group">
                            <label for="win_email" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Win Text/Email </label>
                            <div class="col-md-12">
                                <textarea class="ckeditor" cols="78" id="winEmail" name="win_email" rows="10">' . $existing_sweep->win_email . '</textarea>               
                            </div>    
                                <script>
                                CKEDITOR.replace( "winEmail" );
                                </script>
                            </div>
                            <div class="form-group">
                            <label for="prize_info" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Prize Information </label>
                            <div class="col-md-12">
                                <textarea class="ckeditor" cols="78" id="prizeInfo" name="prize_info" rows="10">' . $existing_sweep->prize_info . '</textarea>               
                            </div>    
                                <script>
                                CKEDITOR.replace( "prizeInfo" );
                                </script>
                            </div>
                            <div class="form-group">
                            <label for="rules" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Rules </label>
                                <div class="col-md-12">
                                    <textarea class="ckeditor" cols="78" id="rules" name="rules_info" rows="10">' . $existing_sweep->rules_info . '</textarea>
                                
                                </div>
                                <script>
                                CKEDITOR.replace( "rules" );
                                </script>
                            </div>
                            <div class="form-group">
                            <label for="prize_info" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Terms and Conditions  </label>
                                <div class="col-md-12">
                                    <textarea class="ckeditor" cols="78" id="terms_conditions_sweep" name="terms_conditions_sweep" rows="10">' . $existing_sweep->terms_conditions . '</textarea>
                                </div>
                                <script>
                                CKEDITOR.replace( "terms_conditions_sweep" );
                                </script>
                            </div>
                            <div class="form-group">
                            <label for="privacy_policy" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Privacy Policy</label>
                                <div class="col-md-12">
                                    <textarea class="ckeditor" cols="78" id="privacy_policy_sweep" name="privacy_policy_sweep" rows="10">' . $privacy . '</textarea> 
                                
                                </div>
                                <script>
                                CKEDITOR.replace( "privacy_policy_sweep" );
                                </script>
                            </div>
                            <div class="form-group">
                            <label for="legal_disclaimer" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Legal Disclaimer</label>
                                <div class="col-md-12">
                                    <textarea class="ckeditor" cols="78" id="legal_disclaimer" name="legal_disclaimer" rows="10">' . $existing_sweep->legal_disclaimer . '</textarea>
                                </div>
                                <script>
                                CKEDITOR.replace( "legal_disclaimer" );
                                </script>
                            </div>
                            <div class="form-group">
                        <label for="custom_css" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Custom CSS</label>
                        <div class="col-md-12">
                            <textarea cols="78" id="custom_css" name="custom_css" rows="10">' . $coupon->custom_css . '</textarea>
                        </div>
                        </div>
                        <div class="form-group">
                        <label for="custom_js" class="col-md-12 control-label " style="text-align:left; margin-bottom:10px;">Custom Js</label>
                        <div class="col-md-12">
                            <textarea cols="78" id="custom_js" name="custom_js" rows="10">' . $coupon->custom_js . '</textarea>
                        </div>

                        </div>
                    </div>';
                }
                if ($coupon->campaign_type == 3) {
                    $states_opt = '';
                    $programStates = CouponStates::where('coupon_id', '=', $id)->get();
                    $existing_states = [];
                    foreach ($programStates as $key => $value) {
                        array_push($existing_states, $value['state_id']);
                    }
                    foreach ($states as $state) {
                        if (in_array($state->id, $existing_states)) {
                            $states_opt .= '<option value=' . $state->id . ' selected="selected">' . $state->state . '</option>';
                        } else {
                            $states_opt .= '<option value=' . $state->id . ' >' . $state->state . '</option>';
                        }
                    }
                }
                $programs_owner = '';
                foreach ($users as $key => $value) {
                    if ($value->id == $coupon->user_id) {
                        $programs_owner .= '<option value=' . $value->id . ' selected="selected">' . $value->email . '</option>';
                    } else {
                        $programs_owner .= '<option value=' . $value->id . '>' . $value->email . '</option>';
                    }
                }
                $brands_opt = '';
                foreach ($brands as $key => $value) {
                    if ($value->id == $coupon->brand_id) {
                        $brands_opt .= '<option value=' . $value->id . ' selected="selected">' . $value->name . '</option>';
                    } else {
                        $brands_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
                    }

                }
                $coupon_opt = '';
                foreach ($types as $key => $value) {
                    if (
                        $value->name == 'None' || $value->name == 'Die Cut Necker' || $value->name == 'Elastic Necker' || $value->name == 'On-Pack' || $value->name == 'Elastitag'
                        || $value->name == 'Tear Pad' || $value->name == 'Digital' || $value->name == 'Digital Print' || $value->name == 'Circular'
                    ) {
                        if ($value->id == $coupon->coupon_type_id) {
                            $coupon_opt .= '<option value=' . $value->id . ' selected="selected">' . $value->name . '</option>';
                        } else {
                            $coupon_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
                        }
                    }
                }
                $coupon_html = '<div class="form-group sweep-remove">
                    <label for="coupon_type_id" class="col-md-2 control-label">Coupon Type: </label>
                    <div class="col-md-10">
                        <select class="form-control" id="coupon_type_id" name="coupon_type_id">
                            ' . $coupon_opt . '
                        </select>
                    </div>
                </div>';
                $brand_html = '<div class="form-group">
                    <label for="brand_id" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Brand: </label>
                    <div class="col-md-8">
                    <select class="form-control" id="brand_id" name="brand_id" >
                        ' . $brands_opt . '
                    </select>
                    </div><a href="/admin/brands/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                    <a class="btn red control-label" id="btnRefreshBrand" name="btnRefreshBrand" style="text-align: center;"><i class="fa fa-refresh"></i></a>
                </div>';

                $program_owner_html = '<div class="form-group">
                    <label for="user_id" class="col-md-2 control-label"><span style="color: #ff0000">*</span>Program Owner: </label>
                    <div class="col-md-8">
                        <select class="form-control" id="user_id" name="user_id" >
                            ' . $programs_owner . '
                        </select>
                    </div><a href="/admin/admins/create" target="_blank" class="btn red control-label" role="button" style="text-align: center;"><i class="fa fa-plus"></i></a>&nbsp;
                    <a class="btn red control-label" id="btnRefreshOwner" name="btnRefreshOwner" style="text-align: center;"><i class="fa fa-refresh"></i></a>
                </div>';
                $coupon_name_html = '<div class="form-group">
                    <label for="name" class="col-md-2 control-label" id="SweepstakesName">Name: </label>
                    <div class="col-md-10">
                        <input class="form-control" name="name" type="text" value=' . $coupon->name . ' id="name">
                    </div>
                </div>';
                //$sweepstakesHtml='';
                $radio_html = '<div class="form-group">
                    <label class="col-md-2 control-label">Active: </label>
                    <div class="col-md-10" style="padding-top:0.8rem;">';
                if ($coupon->active == 1) {
                    $radio_html .= '
                        <input checked="checked" name="active" type="radio" value="1"> Yes
                        <input name="active" type="radio" value="0">
                        No</div>';
                } else {
                    $radio_html .= '
                        <input name="active" type="radio" value="1"> Yes
                        <input checked="checked" name="active" type="radio" value="0">
                        No</div>';
                }
                $expire_date = date('Y-m-d', strtotime($coupon->expires));
                $start_date = date('Y-m-d', strtotime($coupon->start_date));
                $rec_date = date('Y-m-d', strtotime($coupon->receive_by));
                $html = "<div class='row'><div class='col-md-12'>
                    <form method='post' id='addEditCouponForm' enctype='multipart/form-data' role='form' autocomplete='off' class='form-horizontal'>
                        <input type='hidden' name='id' id='id' value=" . $coupon->id . ">
                        <input type='hidden' name='btnType' id='btnType' value=''>
                    <div class='form-body'>

                        $coupon_name_html
                        $final_url
                        <div class='form-group' id='display_campaign_type'>
                            <label for='campaign_type' class='col-md-2 control-label'>Select Campaign Type:</label>
                            <div class='col-md-10'>
                                    $campains_html
                            </div>
                        </div>
                        $coupon_html
                        
                    <div class='form-group' id='states_valid' style='display:none;'>
                            <label for='valid_states' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Valid States: </label>
                            <div class='col-md-10'>
                            <select class='form-control' multiple='multiple' id='validStates' name='valid_states[]' >
                                " . $states_opt . "
                            </select>
                            </div>
                    </div>
                    
                    <div class='form-group sweep-remove'>
                                    <label for='value' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Dollar Value: </label>
                                    <div class='col-md-10'>
                                        <input class='form-control' autocomplete='off' name='value' type='text' value='" . $coupon->value . "' id='value' >
                                    </div>
                                </div>
                                <div class='form-group sweep-remove'>
                                    <label for='description' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Description: </label>
                                    <div class='col-md-10'>
                                        <input class='form-control' autocomplete='off' name='description' type='text' value='" . $coupon->description . "' id='description' >
                                    </div>
                                </div>
                                <div class='form-group'>
                        <label for='start_date' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Start Date: </label>
                        <div class='col-md-3'>
                        
                        <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='start_date' type='text' value='" . $start_date . "' id='start_date' required>
                        
                        </div>
                    </div>
                                <div class='form-group'>
                                    <label for='expires' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>End Date: </label>
                                    <div class='col-md-3'>
                                        <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='expires' type='text' value='" . $expire_date . "' id='expires' required>
                                    </div>
                                </div>
                                <div class='form-group sweep-remove'>
                                    <label for='receive_by' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Receive By: </label>
                                    <div class='col-md-3'>
                                        <input type='date' class='form-control form-control-inline input-medium date-picker' autocomplete='off' name='receive_by' type='text' value='" . $rec_date . "' id='receive_by'>
                                    </div>
                                </div>
                                <div class='form-group' id='barcodeDiv' style='display:none;'>
                                    <label for='barcode' class='col-md-2 control-label'>Barcode: </label>
                                    <div class='col-md-10'>
                                        <input class='form-control' autocomplete='off' name='barcode' type='text' value='" . $coupon->barcode . "' id='barcode'>
                                    </div>
                                </div>
                                <div class='form-group sweep-remove'>
                                    <label for='circulation' class='col-md-2 control-label'><span style='color: #ff0000'>*</span>Circulation: </label>
                                    <div class='col-md-10'>
                                        <input class='form-control' autocomplete='off' name='circulation' type='text' value='" . $coupon->circulation . "' id='circulation' >
                                    </div>
                                </div>

                        $sweepstakesHtml
                        $brand_html
                        $program_owner_html
                        </div>
                        
                        $digitalmirHtml
                        
                    
                    </form>
                    </div>
                    </div>";
                echo json_encode($html);
        }
    }

    // $program_owner_html
    // $brand_html
    // $radio_html
    // $digitalmirHtml
    public function ajax_store()
    {
        $id = Input::get('id');
        if ($id == 0) {
            //Create
            $coupon = new Coupon;
            $coupon->fill(Input::all());
            if($coupon->campaign_type == 3) {
//                $rules = array('custom_url' => 'unique:coupons');
//                $validator = Validator::make(Input::all(), $rules);
//                if ($validator->fails()) {
//                    $messages = "Domain Name Already Taken";
//                    $success = false;
//                    $data = array('success' => $success, 'messages' => $messages);
//                    echo json_encode($data);
//                    return;
//                }
            }

            if($coupon->campaign_type == 4) {
                if($coupon->value == '') {
                    $coupon->value = null;
                }
                if($coupon->circulation == '') {
                    $coupon->circulation = null;
                }
                $rules = array('url' => 'unique:sweepstake_program_details');
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    $messages = 'Program URL Already Taken';
                    $success = false;
                    $data = array('success' => $success, 'messages' => $messages);
                    echo json_encode($data);
                    return;
                }
            }

            $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

            $start_date = date('Y-m-d H:i:s', strtotime(Input::get('start_date')));

            $coupon->start_date = $start_date;

            $coupon->expires = $expires;

            
            $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

            $coupon->receive_by = $receiveBy;
            $coupon->title_color = Input::get('title_color');
            $coupon->link_color = Input::get('link_color');
            $coupon->track_box_bg_color = Input::get('track_box_bg_color');
            $coupon->bg_color = Input::get('bg_color');
            $coupon->default_color = Input::get('default_color');
            $coupon->tab_title = Input::get('tab_title');
            $coupon->save();
            
            $existingCoupon = Coupon::findOrFail($coupon->id);
            $str = Coupon::generateRandomString(16);
            $existingCoupon->url_str = $str;
            if ($coupon->campaign_type == 3) {
                $questions = Input::get('question');
                $answers = Input::get('answer');
                $file_name = Input::get('file_name');
                $image_coupon_id = Input::get('image_coupon_id');
                $fileName = Functions::move_image($file_name, $image_coupon_id, $coupon->id);
                $existingCoupon->campaign_logo = $fileName;
                foreach ($questions as $key => $value) {
                    $ques = $value;
                    $ans = $answers[$key];
                    if ($ques == '') {
                        continue;
                    }
                    if ($ans == '') {
                        continue;
                    }
                    $faq = new Faq();
                    $faq->question = $ques;
                    $faq->answer = $ans;
                    $faq->coupon_id = $coupon->id;
                    $faq->save();
                }

                // COUPON STATE
                $valid_states = Input::get('valid_states');
                if (!empty($valid_states)) {

                    foreach ($valid_states as $validState) {
                        $StatesObj = new CouponStates;
                        $StatesObj->coupon_id = $coupon->id;
                        $StatesObj->state_id = $validState;
                        $StatesObj->save();
                    }
                }
            }

            // Favicon save
            $fav_icon = Input::get('fav_icon');
            $fav_image_coupon_id = Input::get('fav_image_coupon_id');
            $favicon = Functions::move_image($fav_icon, $fav_image_coupon_id, $coupon->id);
            $existingCoupon->fav_icon = $favicon;
            //This is for Golder Cork type
            if (Input::get('btnType') == 2) {
                $existingCoupon->is_have_generated_codes = Constant::$sweepstakes_have_generated_code_yes;
            }
            $existingCoupon->save();

            $coupon_id = $existingCoupon->id;

            if ($coupon->campaign_type == 4) {
                $old_coupon = Input::get('id');
                $result = Functions::move_sweep_images($old_coupon, $coupon_id);
                // SAVE PROGRAM DETAILS    
                $StProgramDetailsObj = new SweepsTakesProgramDetails;
                $StProgramDetailsObj->fill(Input::all());
                $StProgramDetailsObj->coupon_id = $coupon->id;
                $StProgramDetailsObj->name = $coupon->name;
                $StProgramDetailsObj->url = Input::get('url');
                $StProgramDetailsObj->admin_email = Input::get('admin_email');
                $StProgramDetailsObj->brand_landing_url = Input::get('brand_landing_url');
                $StProgramDetailsObj->start_date = $coupon->start_date;
                $StProgramDetailsObj->end_date = $coupon->expires;
                $StProgramDetailsObj->status = $coupon->active;
                $StProgramDetailsObj->data_entry_limit = Input::get('daily_entry_limit');
                $StProgramDetailsObj->under_age_link  = Input::get('under_age_link');
                $StProgramDetailsObj->prize_info  = Input::get('prize_info');
                $StProgramDetailsObj->win_email  = Input::get('win_email');

                $StProgramDetailsObj->rules_info  = Input::get('rules_info');
                $StProgramDetailsObj->terms_conditions  = Input::get('terms_conditions_sweep');
                $StProgramDetailsObj->privacy_policy  = Input::get('privacy_policy_sweep');
                $StProgramDetailsObj->legal_disclaimer  = Input::get('legal_disclaimer');
                $StProgramDetailsObj->daily_limit  = Input::get('daily_limit');
                $StProgramDetailsObj->form_text_color  = Input::get('form_text_color');
                $StProgramDetailsObj->form_align  = Input::get('form_align');
                $StProgramDetailsObj->official_rule_entry_link  = Input::get('official_rule_entry_link');
                $StProgramDetailsObj->official_rule_entry_link_color  = Input::get('official_rule_entry_link_color');
                $StProgramDetailsObj->headings_color  = Input::get('headings_color');
                $StProgramDetailsObj->codes_per_email  = Input::get('codes_per_email');
                $StProgramDetailsObj->code_redeemed_message  = Input::get('code_redeemed_message');
                if ($StProgramDetailsObj->daily_limit == '') {
                    $StProgramDetailsObj->daily_limit = null;
                }
                $StProgramDetailsObj->youtube_video_url  = Input::get('youtube_video_url');

                if (!empty(Input::get('rule_only_program'))) :
                    $StProgramDetailsObj->rules  = 1;
                else :
                    $StProgramDetailsObj->rules  = 0;
                endif;

                if (!empty(Input::get('promo_page'))) :
                    $StProgramDetailsObj->promo_page  = 1;
                else :
                    $StProgramDetailsObj->promo_page  = 0;
                endif;

                if (!empty(Input::get('prize_display'))) :
                    $StProgramDetailsObj->prize_display  = 1;
                else :
                    $StProgramDetailsObj->prize_display  = 0;
                endif;

                if (!empty(Input::get('page_gap'))) :
                    $StProgramDetailsObj->page_gap  = 1;
                else :
                    $StProgramDetailsObj->page_gap  = 0;
                endif;

                if (!empty(Input::get('promo_ad'))) :
                    $StProgramDetailsObj->promo_ad  = 1;
                else :
                    $StProgramDetailsObj->promo_ad  = 0;
                endif;

                if (!empty(Input::get('youtube_video'))) :
                    $StProgramDetailsObj->youtube_video  = 1;
                else :
                    $StProgramDetailsObj->youtube_video  = 0;
                endif;

                if (!empty(Input::get('slider'))) :
                    $StProgramDetailsObj->slider  = 1;
                else :
                    $StProgramDetailsObj->slider  = 0;
                endif;

                $StProgramDetailsObj->save();

                // COUPON STATE
                $valid_states = Input::get('valid_states');
                if (!empty($valid_states)) {

                    foreach ($valid_states as $validState) {
                        $StatesObj = new CouponStates;
                        $StatesObj->coupon_id = $coupon->id;
                        $StatesObj->state_id = $validState;
                        $StatesObj->save();
                    }
                }
            }
            $success = true;
            $messages = '';
            $data = array('success' => $success, 'messages' => $messages, 'coupon_id' => $coupon_id);
            echo json_encode($data);
        } else {
            //Update
            $coupon = Coupon::findOrFail($id);
            $url = Input::get('custom_url');
            if($coupon->campaign_type == 3) {
                if ($coupon->custom_url != $url) {
                    $rules = array('custom_url' => 'unique:coupons');
                    $validator = Validator::make(Input::all(), $rules);
                    if ($validator->fails()) {
                        $messages = "Domain Name Already Taken";
                        $success = false;
                        $data = array('success' => $success, 'messages' => $messages);
                        echo json_encode($data);
                        return;
                    }
                }
            }
            if($coupon->campaign_type == 4) {
                $StProgramDetailsObj = SweepsTakesProgramDetails::findOrFail(Input::get('sweep_id'));
                $sweep_url = Input::get('url');
                if ($StProgramDetailsObj->url != $sweep_url) {
                    $rules = array('url' => 'unique:sweepstake_program_details');
                $validator = Validator::make(Input::all(), $rules);
                    if ($validator->fails()) {
                        $messages = 'Program URL Already Taken';
                        $success = false;
                        $data = array('success' => $success, 'messages' => $messages);
                        echo json_encode($data);
                        return;
                    }
                }
            }
            $logo = $coupon->campaign_logo;
            $coupon->fill(Input::all());
            $basePath = realpath(base_path() . '/..');
            $path = $basePath . '/static-assets/entries/' . $coupon->id . '/' . $coupon->campaign_logo;
            $file_name = Input::get('file_name');
            if ($file_name != '') {
                $image_coupon_id = Input::get('image_coupon_id');
                unlink($path);
                $fileName = Functions::move_image($file_name, $image_coupon_id, $coupon->id);
                $coupon->campaign_logo = $fileName;
            } else {
                $coupon->campaign_logo = $logo;
            }
            if($coupon->value == '') {
                $coupon->value = null;
            }
            if($coupon->circulation == '') {
                $coupon->circulation = null;
            }
            $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

            $coupon->expires = $expires;

            $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

            $coupon->receive_by = $receiveBy;
            //This is for Golder Cork type
            if (Input::get('btnType') == 2) {
                $coupon->is_have_generated_codes = Constant::$sweepstakes_have_generated_code_yes;
            }

            $coupon->welcome_message = Input::get('welcome_message');
            $coupon->brand_privacy = Input::get('brand_privacy');
            $coupon->title_color = Input::get('title_color');
            $coupon->link_color = Input::get('link_color');
            $coupon->track_box_bg_color = Input::get('track_box_bg_color');
            $coupon->bg_color = Input::get('bg_color');
            $coupon->default_color = Input::get('default_color');
            $coupon->tab_title = Input::get('tab_title');
            $coupon->subject = Input::get('subject');
            $fav_icon = Input::get('fav_icon');
            $fav_image_coupon_id = Input::get('fav_image_coupon_id');
            $favicon = Functions::move_image($fav_icon, $fav_image_coupon_id, $coupon->id);
            $coupon->fav_icon = $favicon;
            $coupon->save();
            if (Input::get('campaign_type') == '4') {

                $result = Functions::move_sweep_images(0, $id);
                // SAVE PROGRAM DETAILS
                $StProgramDetailsObj->coupon_id = $id;
                $StProgramDetailsObj->name = $coupon->name;
                $StProgramDetailsObj->url = Input::get('url');
                $StProgramDetailsObj->admin_email = Input::get('admin_email');
                $StProgramDetailsObj->brand_landing_url = Input::get('brand_landing_url');
                $StProgramDetailsObj->start_date = $coupon->start_date;
                $StProgramDetailsObj->end_date = $coupon->expires;
                $StProgramDetailsObj->status = $coupon->active;
                $StProgramDetailsObj->data_entry_limit = Input::get('daily_entry_limit');
                $StProgramDetailsObj->under_age_link  = Input::get('under_age_link');
                $StProgramDetailsObj->prize_info  = Input::get('prize_info');
                $StProgramDetailsObj->win_email  = Input::get('win_email');
                $StProgramDetailsObj->rules_info  = Input::get('rules_info');
                $StProgramDetailsObj->terms_conditions  = Input::get('terms_conditions_sweep');
                $StProgramDetailsObj->privacy_policy  = Input::get('privacy_policy_sweep');
                $StProgramDetailsObj->legal_disclaimer  = Input::get('legal_disclaimer');
                $StProgramDetailsObj->daily_limit  = Input::get('daily_limit');
                $StProgramDetailsObj->form_text_color  = Input::get('form_text_color');
                $StProgramDetailsObj->form_align  = Input::get('form_align');
                $StProgramDetailsObj->official_rule_entry_link  = Input::get('official_rule_entry_link');
                $StProgramDetailsObj->official_rule_entry_link_color  = Input::get('official_rule_entry_link_color');
                $StProgramDetailsObj->headings_color  = Input::get('headings_color');
                $StProgramDetailsObj->codes_per_email  = Input::get('codes_per_email');
                $StProgramDetailsObj->code_redeemed_message  = Input::get('code_redeemed_message');
                if ($StProgramDetailsObj->daily_limit == '') {
                    $StProgramDetailsObj->daily_limit = null;
                }
                $StProgramDetailsObj->youtube_video_url  = Input::get('youtube_video_url');

                if (!empty(Input::get('rule_only_program'))) :
                    $StProgramDetailsObj->rules  = 1;
                else :
                    $StProgramDetailsObj->rules  = 0;
                endif;

                if (!empty(Input::get('promo_page'))) :
                    $StProgramDetailsObj->promo_page  = 1;
                else :
                    $StProgramDetailsObj->promo_page  = 0;
                endif;

                if (!empty(Input::get('prize_display'))) :
                    $StProgramDetailsObj->prize_display  = 1;
                else :
                    $StProgramDetailsObj->prize_display  = 0;
                endif;

                if (!empty(Input::get('page_gap'))) :
                    $StProgramDetailsObj->page_gap  = 1;
                else :
                    $StProgramDetailsObj->page_gap  = 0;
                endif;

                if (!empty(Input::get('promo_ad'))) :
                    $StProgramDetailsObj->promo_ad  = 1;
                else :
                    $StProgramDetailsObj->promo_ad  = 0;
                endif;

                if (!empty(Input::get('youtube_video'))) :
                    $StProgramDetailsObj->youtube_video  = 1;
                else :
                    $StProgramDetailsObj->youtube_video  = 0;
                endif;

                if (!empty(Input::get('slider'))) :
                    $StProgramDetailsObj->slider  = 1;
                else :
                    $StProgramDetailsObj->slider  = 0;
                endif;

                $StProgramDetailsObj->save();

                CouponStates::where('coupon_id', $id)->delete();
                // COUPON STATE
                $valid_states = Input::get('valid_states');
                if (!empty($valid_states)) {
                    foreach ($valid_states as $validState) {
                        $StatesObj = new CouponStates;
                        $StatesObj->coupon_id = $id;
                        $StatesObj->state_id = $validState;
                        $StatesObj->save();
                    }
                }
            }
            if ($coupon->campaign_type == 3) {
                Faq::where('coupon_id', $id)->delete();
                $questions = Input::get('question');
                $answers = Input::get('answer');
                foreach ($questions as $key => $value) {
                    $ques = $value;
                    $ans = $answers[$key];
                    if ($ques == '') {
                        continue;
                    }
                    if ($ans == '') {
                        continue;
                    }
                    $faq = new Faq();
                    $faq->question = $ques;
                    $faq->answer = $ans;
                    $faq->coupon_id = $coupon->id;
                    $faq->save();
                }

                CouponStates::where('coupon_id', $id)->delete();
                // COUPON STATE
                $valid_states = Input::get('valid_states');
                if (!empty($valid_states)) {
                    foreach ($valid_states as $validState) {
                        $StatesObj = new CouponStates;
                        $StatesObj->coupon_id = $id;
                        $StatesObj->state_id = $validState;
                        $StatesObj->save();
                    }
                }
            }
            $success = true;
            $messages = '';
            $data = array('success' => $success, 'messages' => $messages, 'coupon_id' => $coupon->id);
            echo json_encode($data);
        }
    }

    public function upload_favicon()
    {
        $file = Input::file('file');
        if ($file) {
            $favicon = Functions::imageUpload($file, 0);
        } else {
            $favicon = null;
        }
        $success = true;
        $data = array('success' => $success, 'fav_icon' => $favicon, 'fav_image_coupon_id' => 0);
        echo json_encode($data);
    }

    public function upload_upc()
    {
        $customer_id = Input::get('customer_id');
        if($customer_id == 'undefined') {
            $customer_id = 0;
        }
        $file = Input::file('file');
        if ($file) {
            $imageData = Functions::upload_upc_image($file, $customer_id);
        }
        $success = true;
        $html = Functions::get_uploaded_upc_images_html($customer_id);
        $data = array('success' => $success, 'html' => $html, 'id' => $imageData->id);
        echo json_encode($data);
    }

    public function upload_rec()
    {
        $coupon_id = Input::get('customer_id');
        $file = Input::file('file');
        if($coupon_id == 'undefined') {
            $coupon_id = 0;
        }
        if ($file) {
            $imageData = Functions::upload_rec_image($file, $coupon_id);
        }
        $success = true;
        $html = Functions::get_uploaded_rec_images_html($coupon_id);
        $data = array('success' => $success, 'html' => $html, 'id' => $imageData->id);
        echo json_encode($data);
    }

    public function delete_upc()
    {
        $id = Input::get('id');
        $customer_id = Input::get('customer_id');
        $result = Functions::delete_upc_image($id, $customer_id);
        $html = Functions::get_uploaded_upc_images_html(0);
        $data = array('success' => $result, 'html' => $html);
        echo json_encode($data);
    }

    public function delete_rec()
    {
        $id = Input::get('id');
        $customer_id = Input::get('customer_id');
        $result = Functions::delete_rec_image($id, $customer_id);
        $html = Functions::get_uploaded_rec_images_html(0);
        $data = array('success' => $result, 'html' => $html);
        echo json_encode($data);
    }
    public function delete_favicon()
    {
        $fav_icon = Input::get('fav_icon');
        $fav_image_coupon_id = Input::get('fav_image_coupon_id');
        $response = Functions::delete_favicon($fav_icon, $fav_image_coupon_id);
        $data = array('success' => $response);
        return json_encode($data);
    }

    public function upload_dmir_logo()
    {
        $file = Input::file('file');
        if ($file) {
            $fileName = Functions::imageUpload($file, 0);
        } else {
            $fileName = null;
        }
        $success = true;
        $data = array('success' => $success, 'file_name' => $fileName, 'image_coupon_id' => 0);
        echo json_encode($data);
    }

    public function delete_dmir_logo()
    {
        $file_name = Input::get('file_name');
        $image_coupon_id = Input::get('image_coupon_id');
        $response = Functions::delete_dmir_logo($file_name, $image_coupon_id);
        $data = array('success' => $response);
        return json_encode($data);
    }

    public function upload_sweep_image()
    {
        $position = Input::get('position');
        $coupon_id = Input::get('coupon_id');
        $file = Input::file('file');
        if ($file) {
            $imageData = Functions::upload_sweep_image($file, $position, $coupon_id);
        }
        $success = true;
        $html = Functions::get_uploaded_images_html_sweep($coupon_id);
        $data = array('success' => $success, 'html' => $html, 'id' => $imageData->id);
        echo json_encode($data);
    }

    public function delete_sweep_image()
    {
        $id = Input::get('id');
        $coupon_id = Input::get('coupon_id');
        $result = Functions::delete_sweep_image($id, $coupon_id);
        $html = Functions::get_uploaded_images_html_sweep(0);
        $data = array('success' => $result, 'html' => $html);
        echo json_encode($data);
    }

    public function update($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->fill(Input::all());

        $basePath = realpath(base_path() . '/..');
        $path = $basePath . '/static-assets/entries/' . $coupon->id . $coupon->campaign_logo;
        $file = Input::file('campaign_logo');
        if ($file) {
            if (File::exists($path)) {
                File::delete($path);
            }
            $fileName = Functions::imageUpload($file, $coupon->id);
            $coupon->campaign_logo = $fileName;
        }
        $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

        $start_date = date('Y-m-d H:i:s', strtotime(Input::get('start_date')));

        $coupon->start_date = $start_date;

        $coupon->expires = $expires;

        $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

        $coupon->receive_by = $receiveBy;
        $coupon->save();


        // SWEEPSTAKES

        if (Input::get('campaign_type') == '4') {
            
                        
                    


            /*    $dataS =  Input::get('photo_position'); */
            /*  $dataS1 =  Input::file('images');
        echo "<pre>";
                print_r($dataS1);
        die; */

            $photo_position = Input::get('photo_position');


            $basePath = realpath(base_path() . '/..');
            $files = Input::file('images');

            if (!empty($files)) {
                foreach ($files as $position => $imagefile) {



                    foreach ($imagefile as $file) {
                        $imageDataObj = new ImageData;
                        $imageDataObj->fill(Input::all());
                        $imageDataObj->coupon_id = $id;
                        $imageDataObj->position = $position;

                        if (!empty($file)) {
                            $path = $basePath . '/static-assets';
                            echo $backgroundName = preg_replace('/\s+/', '', $file->getClientOriginalName());
                            if (is_dir($path)) {
                                $fileName = rand(100, 1000) . '-' . $backgroundName;
                                $file->move($path, $fileName);
                            } else {
                                mkdir($basePath . '/static-assets', 0777);
                                $path = $basePath . '/static-assets';
                                $fileName = rand(100, 1000) . '-' . $backgroundName;
                                $file->move($path, $fileName);
                            }
                            $imageDataObj->src = $fileName;
                            $imageDataObj->save();
                        }
                    }
                }
            }

            // SAVE PROGRAM DETAILS    

            $StProgramDetailsObj = SweepsTakesProgramDetails::findOrFail(Input::get('program_number'));
            $StProgramDetailsObj->coupon_id = $id;
            $StProgramDetailsObj->name = Input::get('program_name');
            $StProgramDetailsObj->url = Input::get('program_url');
            $StProgramDetailsObj->admin_email = Input::get('admin_email');
            $StProgramDetailsObj->brand_landing_url = Input::get('brand_landing_url');
            $StProgramDetailsObj->start_date = date('Y-m-d', strtotime(Input::get('program_start_date')));
            $StProgramDetailsObj->end_date = date('Y-m-d', strtotime(Input::get('program_end_date')));
            $StProgramDetailsObj->status = Input::get('program_status');
            $StProgramDetailsObj->data_entry_limit = Input::get('daily_entry_limit');
            $StProgramDetailsObj->under_age_link  = Input::get('under_age_link');
            $StProgramDetailsObj->prize_info  = Input::get('prize_info');
            $StProgramDetailsObj->win_email  = Input::get('win_email');
            $StProgramDetailsObj->rules_info  = Input::get('rules_info');
            $StProgramDetailsObj->terms_conditions  = Input::get('terms_conditions');
            $StProgramDetailsObj->privacy_policy  = Input::get('privacy_policy');
            $StProgramDetailsObj->legal_disclaimer  = Input::get('legal_disclaimer');
            $StProgramDetailsObj->daily_limit  = Input::get('daily_limit');
            $StProgramDetailsObj->form_text_color  = Input::get('form_text_color');
            $StProgramDetailsObj->youtube_video_url  = Input::get('youtube_video_url');

            if (!empty(Input::get('rule_only_program'))) :
                $StProgramDetailsObj->rules  = 1;
            else :
                $StProgramDetailsObj->rules  = 0;
            endif;

            if (!empty(Input::get('promo_page'))) :
                $StProgramDetailsObj->promo_page  = 1;
            else :
                $StProgramDetailsObj->promo_page  = 0;
            endif;

            if (!empty(Input::get('prize_display'))) :
                $StProgramDetailsObj->prize_display  = 1;
            else :
                $StProgramDetailsObj->prize_display  = 0;
            endif;

            if (!empty(Input::get('page_gap'))) :
                $StProgramDetailsObj->page_gap  = 1;
            else :
                $StProgramDetailsObj->page_gap  = 0;
            endif;

            if (!empty(Input::get('promo_ad'))) :
                $StProgramDetailsObj->promo_ad  = 1;
            else :
                $StProgramDetailsObj->promo_ad  = 0;
            endif;

            if (!empty(Input::get('youtube_video'))) :
                $StProgramDetailsObj->youtube_video  = 1;
            else :
                $StProgramDetailsObj->youtube_video  = 0;
            endif;

            if (!empty(Input::get('slider'))) :
                $StProgramDetailsObj->slider  = 1;
            else :
                $StProgramDetailsObj->slider  = 0;
            endif;

            $StProgramDetailsObj->save();

            CouponStates::where('coupon_id', $id)->delete();
            // COUPON STATE
            $valid_states = Input::get('valid_states');
            if (!empty($valid_states)) {
                foreach ($valid_states as $validState) {
                    $StatesObj = new CouponStates;
                    $StatesObj->coupon_id = $id;
                    $StatesObj->state_id = $validState;
                    $StatesObj->save();
                }
            }
        }





        return Redirect::to('/admin/coupons/all');
    }

    public function destroy($id)
    {
        //
    }

    public function get_code_generator_page()
    {
        $result_array = array();
        $result_array['status'] = 0;

        $coupon_id = Input::get('coupon_id');
        if (isset($coupon_id) && $coupon_id != '') {
            $programDetails = Coupon::where('id', $coupon_id)->first();
            $totalOnlinePurchaseCode = $totalOfflinePurchaseCode = $totalOnlinePurchaseCodeWinner = $totalOfflinePurchaseCodeWinner = $onlinePurchaseCodeWinnerPrice = $offlinePurchaseCodeWinnerPrice = 0;
            if (isset($programDetails) && $programDetails->reference_table != '') {
                $table_name = $programDetails->reference_table;
                $totalOnlinePurchaseCode = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "Y")->count();
                $totalOfflinePurchaseCode = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "N")->count();
                $totalOnlinePurchaseCodeWinner = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "Y")->where("is_winner", "Y")->count();
                $totalOfflinePurchaseCodeWinner = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "N")->where("is_winner", "Y")->count();
                $onlinePurchaseCodeWinnerPriceExist = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "Y")->where("is_winner", "Y")->first();
                $offlinePurchaseCodeWinnerPriceExist = DB::table($table_name)->where("coupon_id", $coupon_id)->where("is_online_only", "N")->where("is_winner", "Y")->first();
                if($onlinePurchaseCodeWinnerPriceExist){
                    $onlinePurchaseCodeWinnerPrice = $onlinePurchaseCodeWinnerPriceExist->win_amount;
                }else{
                    $onlinePurchaseCodeWinnerPrice = 0;
                }
                if($offlinePurchaseCodeWinnerPriceExist){
                    $offlinePurchaseCodeWinnerPrice = $offlinePurchaseCodeWinnerPriceExist->win_amount;
                }else{
                    $offlinePurchaseCodeWinnerPrice = 0;
                }
            }

            $content = View::make('admin.coupons.all.generate_code_form', compact('coupon_id', 'programDetails', 'totalOnlinePurchaseCode', 'totalOfflinePurchaseCode', 'totalOnlinePurchaseCodeWinner', 'totalOfflinePurchaseCodeWinner', 'onlinePurchaseCodeWinnerPrice', 'offlinePurchaseCodeWinnerPrice'))->render();

            $result_array['status'] = 1;
            $result_array['content'] = $content;
            $result_array['table_name'] = isset($table_name) ? $table_name : '';
        }
        echo json_encode($result_array);
    }


    public function generate_random_codes()
    {
        
        ini_set('memory_limit','2048M');
        $coupon_id = Input::get('coupon_id');
        $is_online_only = Input::get('is_online_only');
        $purchase_code_count = Input::get('purchase_code_count');
        $none_purchase_code_count = Input::get('none_purchase_code_count');
        $winning_purchase_code_count = Input::get('winning_purchase_code_count');
        $winning_none_purchase_code_count = Input::get('winning_none_purchase_code_count');
        /*$winning_purchase_code_price = Input::get('winning_purchase_code_price');
        $winning_none_purchase_code_price = Input::get('winning_none_purchase_code_price');*/

        $result_array = array();
        $result_array['status'] = 0;
        $result_array['is_finished'] = 0;

        if (isset($coupon_id) && $coupon_id != '') {

            //THis is to creat table
            $table_name = "campaign_generated_codes_" . $coupon_id;
            $createCouponCode = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `coupon_id` int(11) NOT NULL,
                                    `is_online_only` enum('Y','N') NOT NULL DEFAULT 'N',
                                    `coupon_code` varchar(30) NOT NULL,
                                    `entry_id` int(11) NOT NULL,
                                    `is_redeemed` enum('Y','N') NOT NULL DEFAULT 'N',
                                    `redeemed_date` datetime NULL DEFAULT NULL,
                                    `is_winner` enum('Y','N') NOT NULL DEFAULT 'N',
                                    `win_amount` int(11) NULL DEFAULT NULL,
                                        PRIMARY KEY (`id`),
                                         UNIQUE KEY `coupon_code` (`coupon_code`),
                                         KEY `coupon_code_2` (`coupon_code`)
                                   ) ENGINE=MyISAM DEFAULT CHARSET=latin1";

            DB::statement($createCouponCode);

            //This is to update table in coupen program
            $programDetails = Coupon::where('id', $coupon_id)->first();
            if ($programDetails->reference_table == '' || $programDetails->reference_table == null) {
                Coupon::where('id', $coupon_id)->update(array('reference_table' => $table_name));
            }

            $total_coupon = 0;
            $total_coupon = DB::table($table_name)->count();

            $total_online_coupon = 0;
            $total_online_coupon = DB::table($table_name)->where("is_online_only", "Y")->count();

            $total_offline_coupon = 0;
            $total_offline_coupon = DB::table($table_name)->where("is_online_only", "N")->count();

            $data_insert = array();
            
            //$i = 0;
            for($i = 1; $i<= Constant::$code_generator_limit; $i++)
            {
                //$code = 'BN'.$this->make_random_custom_string(7, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
                if((isset($is_online_only) && $is_online_only == 'Y' && $total_online_coupon+$i <= $purchase_code_count) || (isset($is_online_only) && $is_online_only == 'N' && $total_offline_coupon+$i <= $none_purchase_code_count))
                {
                    $total = $purchase_code_count + $winning_none_purchase_code_count;
                    $code = 'BN'.$this->custom_random_string($total_coupon+$i, $total);
                    
                    $code_array[] = $code;
                    $temp_array = array();
                    $temp_array['coupon_id'] = $coupon_id;
                    $temp_array['is_online_only'] = $is_online_only;
                    $temp_array['coupon_code'] = $code;
                    //$temp_array['coupon_code'] = $this->random_strings(9);
                    $temp_array['entry_id'] = "0";
                    $data_insert[] = $temp_array;
                }
            }
            
//            echo '<pre>';
//            print_r($data_insert);
//            die;
            
            if(!empty($data_insert))
            {
                if(CampaignGenerateCoupon::insert_bulk($table_name, $data_insert)){
                    
                    //This is to mark as winner
                    $total_online_coupon_without_winner = DB::table($table_name)->where("is_online_only", "Y")->where("is_winner", "N")->count();
                    $total_offline_coupon_without_winner = DB::table($table_name)->where("is_online_only", "N")->where("is_winner", "N")->count();

                    if ($total_online_coupon_without_winner == $purchase_code_count) {
                        $online_random_id = DB::table($table_name)->where('is_online_only', $is_online_only)->orderBy(DB::raw('RAND()'))->limit($winning_purchase_code_count)->get();
                        $online_random_ids = array();
                        foreach ($online_random_id as $key => $value) {
                            $online_random_ids[] = $value->id;
                        }
                        if (!empty($online_random_ids)) {
                            //DB::table($table_name)->where('is_online_only', $is_online_only)->whereIn('id', $online_random_ids)->update(array('is_winner' => "Y", "win_amount" => $winning_purchase_code_price));
                            DB::table($table_name)->where('is_online_only', $is_online_only)->whereIn('id', $online_random_ids)->update(array('is_winner' => "Y"));
                        }
                    }

                    if ($total_offline_coupon_without_winner == $none_purchase_code_count) {
                        $offline_random_id = DB::table($table_name)->where('is_online_only', $is_online_only)->orderBy(DB::raw('RAND()'))->limit($winning_none_purchase_code_count)->get();
                        $offline_random_ids = array();
                        foreach ($offline_random_id as $key => $value) {
                            $offline_random_ids[] = $value->id;
                        }
                        if (!empty($offline_random_ids)) {
                            //DB::table($table_name)->where('is_online_only', $is_online_only)->whereIn('id', $offline_random_ids)->update(array('is_winner' => "Y", "win_amount" => $winning_none_purchase_code_price));
                            DB::table($table_name)->where('is_online_only', $is_online_only)->whereIn('id', $offline_random_ids)->update(array('is_winner' => "Y"));
                        }
                    }
                    //This is to mark as winner
                    
                    //This is to check process is finished
                    $total_online_coupon_for_match = DB::table($table_name)->where("is_online_only", "Y")->count();
                    $total_offline_coupon_for_match = DB::table($table_name)->where("is_online_only", "N")->count();
                    if ($total_online_coupon_for_match == $purchase_code_count && $total_offline_coupon_for_match == $none_purchase_code_count) {
                        $result_array['is_finished'] = 1;
                    }
                    
                    $result_array['status'] = 1;
                    $result_array['total_online_code_count'] = $total_online_coupon_for_match;
                    $result_array['total_offline_code_count'] = $total_offline_coupon_for_match;
                }
            }
        }


        echo json_encode($result_array);
        exit;
    }


    public function export_generated_code_to_csv()
    {
        ini_set('memory_limit','2048M');
        $response_array = array();
        $response_array['status'] = 0;
        $response_array['is_finished'] = 0;
        
        $draw_value = Input::get('draw');
        $draw = isset($draw_value) && $draw_value!=''?$draw_value:0;
        $coupon_id = Input::get('coupon_id');
        $is_online_only = Input::get('is_online_only');
        if (isset($coupon_id) && $coupon_id != '') {
            $programDetails = Coupon::where('id', $coupon_id)->first();
            if(!empty($programDetails->reference_table) && $programDetails->reference_table!='')
            {
                
                $upload_path = public_path()."/assets/uploads/exported_codes/";
                if($is_online_only == 'Y'){
                    $filename = "Program_Online_Code_List_".$coupon_id.".csv";
                } else {
                    $filename = "Program_Offline_Code_List_" . $coupon_id . ".csv";
                }
                
                if(file_exists($upload_path.$filename)){
                    if($draw == 0){
                        unlink($upload_path.$filename);
                    }
                }
                
                //This is to read file and last row
                if(file_exists($upload_path.$filename))
                {
                    $handleRead = file($upload_path.$filename);
                    $last_row = array_pop($handleRead);
                    $data = str_getcsv($last_row);
                }
                
                $index = 1;
                $start = 0;
                $limit = 25000;
                if(!empty($data))
                {
                    if(isset($data[0]) && is_numeric($data[0])){
                        $index = $data[0]+1;
                    }
                    
                    if(isset($data[1]) && is_numeric($data[1])){
                        $start = $data[1];
                    }
                }
                
                $handle = fopen($upload_path.$filename, 'a+');
                if($start == 0){
                    fputcsv($handle, array('Index', 'CodeID', 'Code', 'Entry ID', 'Is Redeemed?', 'Redeeemed Date', 'Winner', 'Winner Amount'));
                }
        
                $table_name = $programDetails->reference_table;
                
                //This is to get last id 
                $last_record = DB::table($table_name)->where("is_online_only", $is_online_only)->orderBy('id', 'desc')->first();
                
                //DB::enableQueryLog();
                $last_processed_id = 0;
                
                $code_list = DB::table($table_name)->where("is_online_only", $is_online_only)->whereRaw("id > ".$start)->limit($limit)->get();
                
                /*$query = DB::getQueryLog();
                $query = end($query);
                print_r($query);
                exit;*/
                
                foreach($code_list as $code){
                    fputcsv($handle, array($index++, $code->id, $code->coupon_code, $code->entry_id, ($code->is_redeemed == 'Y')?'Yes':'No', $code->redeemed_date, ($code->is_winner == 'Y')?'Yes':'No', $code->win_amount));
                    $last_processed_id = $code->id;
                    //This is to check last record
                    if($code->id == $last_record->id){
                        $response_array['is_finished'] = 1;
                    }
                }
                $response_array['status'] = 1;
                $response_array['last_processed_id'] = $last_processed_id; 
                $response_array['last_record_id'] = $last_record->id;
                $response_array['filename'] = $filename;
                $response_array['file_path'] = $upload_path.$filename;
                $response_array['draw'] = intval($draw+1);
                $response_array['last_exported_id'] = $index-1;
                
                
                
                
                /*$code_list = array();
                DB::table($table_name)->where("is_online_only", $is_online_only)->chunk(12000, function ($codes) use ($handle, $is_online_only) {
                    foreach($codes as $code){
                        fputcsv($handle, array($code->id, $code->coupon_code, $code->entry_id, ($code->is_redeemed == 'Y')?'Yes':'No', $code->redeemed_date, ($code->is_winner == 'Y')?'Yes':'No', $code->win_amount));
                    }
                });*/
            }

            fclose($handle);
        }
        
        echo json_encode($response_array);exit;
    }
    
    public function download_exported_code_file()
    {
        $file_name = Input::get('file_name');
        $file_path = Input::get('file_path');
        if(isset($file_name) && $file_name!=''){
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($file_path, $file_name, $headers);
        }
    }


    public function make_random_custom_string($N, $alphabet)
    {
        $s = "";
        for ($i = 0; $i != $N; ++$i) {
            $s .= $alphabet[mt_rand(0, strlen($alphabet) - 1)];
        }
        return $s;
    }
    
    /*public function custom_random_string($current_count)
    {
        $total_possible_alphabet = pow(36, 7);
        $decrpt_str = $total_possible_alphabet - $current_count;
        $converted_string = base_convert($decrpt_str, 10, 36);
        return strtoupper(substr("0000{$converted_string}", -7));
    }*/
    
    public function custom_random_string($current_count, $total_codes)
    {
        $base_10_code = $current_count;
        $total_possible_alphabet = pow(36,7);
        $seperation = intval($total_possible_alphabet/$total_codes);
        $base_10_code = $base_10_code * $seperation;
        $converted_string = base_convert($base_10_code, 10,36);
        /*echo $base_10_code;
        echo "<br/>";*/
        //echo strtoupper(substr("0000{$converted_string}", -7));exit;
        return strtoupper(substr("0000{$converted_string}", -7));
    }
    
    public function get_code_configuration_page()
    {
        $result_array = array();
        $result_array['status'] = 0;

        $coupon_id = Input::get('coupon_id');
        if (isset($coupon_id) && $coupon_id != '') {
            
            $programDetails = Coupon::where('id', $coupon_id)->first();
            
            //This is to get reason fields
            $referenceList = GoldenCorkReference::where("coupon_id", $coupon_id)->get();
            
            $content = View::make('admin.coupons.all.code_configurations_model', compact('coupon_id', 'programDetails', 'referenceList'))->render();

            $result_array['status'] = 1;
            $result_array['content'] = $content;
            $result_array['table_name'] = isset($table_name) ? $table_name : '';
        }
        echo json_encode($result_array);
    }
    
    /*
     * This function to save code configuration
     * 
     */
    public function save_code_configuration()
    {
        $result_array = array();
        $result_array['status'] = 0;
        
        
        $coupon_id = Input::get('coupon_id');
        if (isset($coupon_id) && $coupon_id != '') {
            $sponsor_information = Input::get('sponsor_information');
            Coupon::where('id', $coupon_id)->update(array('sponsor_information' => $sponsor_information));
            
            $reasonsList = Input::get('reason');
            $reasonIdsList = Input::get('reason_id');
            
            if(!empty($reasonsList))
            {
                foreach($reasonsList as $key => $reason)
                {
                    if(isset($reasonIdsList[$key]) && $reasonIdsList[$key]!=''){
                        GoldenCorkReference::where("id", $reasonIdsList[$key])->update(["title" => $reason]);
                    } else {
                        $data = array();
                        $data['coupon_id'] = $coupon_id;
                        $data['title'] = $reason;
                        GoldenCorkReference::insert($data);
                    }
                }
                
                $result_array['status'] = 1;
                $result_array['message'] = "Configuration updates successfully.";
            }
        }
        echo json_encode($result_array);
    }
    
    /*
     * Function to delete reason
     */
    public function delete_code_reason()
    {
        $result_array = array();
        $result_array['status'] = 0;
        
        $coupon_id = Input::get('coupon_id');
        $id = Input::get('id');
        
        if(isset($id) && $id!='')
        {
            GoldenCorkReference::where('id', $id)->where('coupon_id', $coupon_id)->delete();
            
            $result_array['status'] = 1;
            $result_array['message'] = "Reference Deleted successfully.";
        }
        echo json_encode($result_array);exit;
    }

    public function upload_csv($id)
    {
        $coupon_id = $id;
        $table_name = "campaign_generated_codes_" . $coupon_id;
        $exists = DB::getSchemaBuilder()->hasTable($table_name);
        if($exists){
            DB::table($table_name)->truncate();
        }
        else{
            $createCouponCode = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `coupon_id` int(11) NOT NULL,
                            `is_online_only` enum('Y','N') NOT NULL DEFAULT 'N',
                            `coupon_code` varchar(30) NOT NULL,
                            `entry_id` int(11) NOT NULL,
                            `is_redeemed` enum('Y','N') NOT NULL DEFAULT 'N',
                            `redeemed_date` datetime NULL DEFAULT NULL,
                            `is_winner` enum('Y','N') NOT NULL DEFAULT 'N',
                            `win_amount` int(11) NULL DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                 UNIQUE KEY `coupon_code` (`coupon_code`),
                                 KEY `coupon_code_2` (`coupon_code`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=latin1";

            DB::statement($createCouponCode);
        }
        
        //This is to update table in coupen program
        $programDetails = Coupon::where('id', $coupon_id)->first();
        if ($programDetails->reference_table == '' || $programDetails->reference_table == null) {
            Coupon::where('id', $coupon_id)->update(array('reference_table' => $table_name));
        }

        $tmpName = $_FILES['file']['tmp_name'];
        $the_big_array = [];
        // $csvAsArray = array_map('str_getcsv', file($tmpName));
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 1;
            $temp_array = array();
            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if($row == 1){ $row++; continue; }
                DB::table($table_name)->insert([
                    'coupon_id' => $coupon_id,
                    'is_online_only' => $data[0],
                    'coupon_code' => $data[1],
                    'is_redeemed' => 'N',
                    'is_winner' => $data[2],
                ]);
            }
            fclose($handle);
        }

        $success = true;
        $messages = '';
        $data = array('success' => $success, 'messages' => $messages, 'coupon_id' => $coupon_id);
        echo json_encode($data);
    }
}