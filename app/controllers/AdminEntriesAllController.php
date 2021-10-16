<?php


class AdminEntriesAllController extends \BaseController {

    public function index() {
        if(isset($_GET['campaign'])) {
            $campaign = $_GET['campaign'];
        }
        else {
            $campaign = null;
        }
        if(isset($_GET['program'])) {
            $program = $_GET['program'];
        }
        else {
            $program = null;
        }
        $programs = CouponType::all();
        $coupons = Coupon::all();
        $campaigns = Constant::$campains;
        $paid_status = Constant::$paid_status;
        return View::make('admin.entries.irc-dt.all', compact('programs', 'campaigns','campaign','program'));
    }
    
    
        /**
         * Gets the value of an environment variable. Supports boolean, empty and null.
         *
         * @param  string  $key
         * @param  mixed   $default
         * @return mixed
         */
    public function paypal_data()
    {
        define('SANDBOX_CLIENT_ID','AfjfjLBkKT2jDXgfcuWFFmdVrRyxm_eBs7gvRSTiH3R3qhu9WxTjc-quLRCAnD6ASilEz-0y5w9mA6zE');
        define('SANDBOX_SECRET_ID','EAyBFDHyQ87UMUzRsaTANKi5RSFEl2tfvDJK1UV5yiL3dmFR0yFeqiCHp4YWaYwjlhhxBY7-Gr8LG90l');
        define('CLIENT_ID','AfjfjLBkKT2jDXgfcuWFFmdVrRyxm_eBs7gvRSTiH3R3qhu9WxTjc-quLRCAnD6ASilEz-0y5w9mA6zE');
        define('SECRET_ID','EAyBFDHyQ87UMUzRsaTANKi5RSFEl2tfvDJK1UV5yiL3dmFR0yFeqiCHp4YWaYwjlhhxBY7-Gr8LG90l');
        define('IS_SANDBOX',true);
        define('SANDBOX_URL','api.sandbox.paypal.com');
        define('LIVE_URL','api.paypal.com');
    }
    

    public function payment() {
        
        $paypal_constant = $this->paypal_data();
        if(IS_SANDBOX) {
            $client_id = SANDBOX_CLIENT_ID;
            $secret_id = SANDBOX_SECRET_ID;
            $paypal_url = SANDBOX_URL;
        } else {
            $client_id = CLIENT_ID;
            $secret_id = SECRET_ID;
            $paypal_url = LIVE_URL;
        }
        

        $row_id = '';
        $amount = 0;
        if (isset($_POST['row_id']) && $_POST['row_id'] != '') {
            $row_id = $_POST['row_id'];
        }
        if (isset($_POST['amount']) && $_POST['amount'] != '') {
            $amount = $_POST['amount'];
        }
        
        //$row_id = 1;
        //$amount = 10;

        $data = DB::table('customers')
                ->select('*')
                ->where('coupon_id', '=', $row_id)
                ->get();

        if (!empty($data)) {
            $customer_paypal_email = $data[0]->paypal_email; //'mapatel90_personal@gmail.com'; 
            if ($customer_paypal_email != '') {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://'.$paypal_url.'/v1/oauth2/token');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
                curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $secret_id);

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Accept-Language: en_US';
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                $response = json_decode($result, 1);


                if (isset($response['access_token']) && $response['access_token'] != '') {
                    $access_token = $response['access_token'];
                    $time = time();
                    $json = '{
                "sender_batch_header": {
                  "sender_batch_id": "Payouts_2020_'.$time.'",
                  "email_subject": "You have a payout!",
                  "email_message": "You have received a payout! Thanks for using our service!"
                },
                "items": [
                  {
                    "recipient_type": "EMAIL",
                    "amount": {
                      "value": "' . $amount . '",
                      "currency": "USD"
                    },
                    "note": "Thanks for your patronage!",
                    "sender_item_id": "201403140001",
                    "receiver": "' . $customer_paypal_email . '"
                  }
                ]
              }';

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://'.$paypal_url.'/v1/payments/payouts');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    $headers = array();
                    $headers[] = 'Content-Type: application/json';
                    $headers[] = 'Authorization: Bearer ' . $access_token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);

                    $response = json_decode($result, 1);

                    if (isset($response['batch_header']['payout_batch_id']) && $response['batch_header']['payout_batch_id'] != '') {
                        $payout_batch_id = $response['batch_header']['payout_batch_id'];
                        $values = array('coupon_id' => 1,'payment_data' => json_encode($response),'batch_id'=>$payout_batch_id,'created_date'=>date("Y-m-d H:i:s"));
                        DB::table('paypal_payment')->insert($values);
                        echo json_encode(array('status' => 1, 'batch_id' => $payout_batch_id,'msg'=>"Payment sent successfully"));
                    } else {
                        $message = $response['details'][0]['issue'];
                        echo json_encode(array('status' => 0, 'msg' => $message));
                    }
                } else {
                    echo json_encode(array('status' => 0, 'msg' => "Something went wrong"));
                }
                die;
            } else {
                echo json_encode(array('status' => 0, 'msg' => "Paypal email is missing"));
            }
        } else {
            echo json_encode(array('status' => 0, 'msg' => "Paypal email is missing"));
        }



        //echo $access_token; die;
    }

    public function data() {
        $programType = Input::get('program-type');  
         
        // Modified Code
        $program = Input::get('program-id');
        $campaign = Input::get('campaign-id'); 
        // end of Modified code

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
            $data = EntryMirView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length, $program, $campaign);
            echo json_encode($data);
        }else{
            // Modified else
            $data = EntryMirView::getResultForDtModified($startDate, $endDate, $filters, $draw, $start, $length, $program, $campaign);
            echo json_encode($data);
        }
        // else {
        //     $data = EntryMirView::getResultForDt($startDate, $endDate, $filters, $draw, $start, $length, $program, $campaign);
        //     echo json_encode($data);
        // }   
       
    }

    public function details($id) {
        $customer = Customer::where('entry_mir_id','=',$id)->first();
        if($customer) {
            $customerUpcImg = CustomerUpcImage::where('customer_id','=',$customer->id)->get();   
            $customerRecImg = CustomerReceiptImage::where('customer_id','=', $customer->id)->get();
            $html = '';
            $genderHtml = '';
            if($customer->gender == 'male') {
                $genderHtml = '<b>Male</b>';
            }
            else if($customer->gender == 'female') {
                $genderHtml = '<b>Female</b>';
            }
            else {
                $genderHtml = '<b>Female</b>';
            }
            if($customer->rebate_method == 'check') {
                $rebate_html = '<b>Check</b>';
            }
            else {
                $rebate_html = '<b>Paypal</b>';
            }
            $upcImgHtml = '';
            foreach ($customerUpcImg as $key => $value) {
                $url = Constant::$assetLink;
                $url .= 'entries/' . $customer->coupon_id . '/' . $value['image'];
                $upcImgHtml .= '<li><a href='.$url.' target="_blank">Image</a></li>';
            }
            $recImgHtml = '';
            foreach ($customerRecImg as $key => $value) {
                $url = Constant::$assetLink;
                $url .= 'entries/' . $customer->coupon_id . '/' . $value['image'];
                $recImgHtml .= '<li><a href='.$url.' target="_blank">Image</a></li>';
            }
            $customerHtml = '<fieldset>
            <legend>Personal Information:</legend>
            <div class="row">
                <div class="col-md-4">
                <lable>First Name</lable>
                    <input type="text" class="form-control" readonly value='.$customer->first_name.'>
                </div>
                <div class="col-md-4">
                <lable>Last Name</lable>
                    <input type="text" class="form-control" readonly value='.$customer->last_name.'>
                </div>
                <div class="col-md-4">
                <lable>DOB</lable>
                    <input type="text" class="form-control" readonly value='.$customer->dob.'>
                </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                <lable>Gender:</lable>
                     '.$genderHtml.'
                </div>
               
                <div class="col-md-4">
                <lable>Phone Number</lable>
                    <input type="text" class="form-control" readonly value='.$customer->phone_num.'>
                </div>
                </div>
                <div class="row">
                
                <div class="col-md-4">
                <lable>Street Address</lable>
                    <input type="text" class="form-control" readonly value='.$customer->street_address.'>
                </div>
                <div class="col-md-4">
                <lable>Appartment Num</lable>
                    <input type="text" class="form-control" readonly value='.$customer->appartment_num.'>
                </div>
                <div class="col-md-4">
                <lable>Zip</lable>
                    <input type="text" class="form-control" readonly value='.$customer->zip.'>
                </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                <lable>City</lable>
                    <input type="text" class="form-control" readonly value='.$customer->city.'>
                </div>
                <div class="col-md-4">
                <lable>State</lable>
                    <input type="text" class="form-control" readonly value='.$customer->state.'>
                </div>
               
                </div>
                <div class="row">
                <div class="col-md-4">
                <lable>Email</lable>
                    <input type="text" class="form-control" readonly value='.$customer->email.'>
                </div>
                <div class="col-md-4">
                <lable>Paypal Email</lable>
                    <input type="text" class="form-control" readonly value='.$customer->paypal_email.'>
                </div>
                <div class="col-md-4">
                <lable>Tracking Id</lable>
                    <input type="text" class="form-control" readonly value='.$customer->tracking_id.'>
                </div>
                </div>
                </fieldset>
                <fieldset>
                <legend>Other Information:</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Rebate Method:</label>
                            '.$rebate_html.'
                        </div>
                        <div class="col-md-4">
                        <lable>UPC Images</lable>
                            <ul>
                                '.$upcImgHtml.'
                            </ul>
                        </div>
                        <div class="col-md-4">
                        <lable>Rec Images</lable>
                            <ul>
                                '.$recImgHtml.'
                            </ul>
                        </div>
                    </div>
                </fieldset>
                ';
            echo json_encode($customerHtml);
        }
        else {
            $message = '<h1 style="text-align:center;">No Customer Defined For the Entry # '.$id.'</h1>';
            echo json_encode($message);
        }
    }

    public function coupons() {
        $term = Input::get('term');
       
        if ($term['_type'] == 'query') {
            $data = Coupon::where('name', 'like', '%' . $term['term'] . '%')->select('id', 'name')->get();
            echo json_encode($data);
        }
    }

    public function exportCsv() {
        $programType = Input::get('program-type');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $program = Input::get('program-id');
        $campaign = Input::get('campaign-id');

        
    
        if ($programType == 'IRC') {
            $table = EntryIrcView::exportData($startDate, $endDate, $filters);
            $filename = "Entries.csv";
            $handle = fopen($filename, 'w+');
        fputcsv($handle, array('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at'));

        foreach ($table as $row) {
            fputcsv($handle, array($row['id'], $row['retailer'], $row['retailer_state'], $row['program'], $row['client_id'], $row['client_name'], $row['brand'], $row['clearinghouse'], $row['is_invoiced'],$row['coupon_quantity'],$row['payable'],$row['shipping'],$row['created_at'],$row['updated_at']));
        }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'Entries.csv', $headers);
        } else if ($programType == 'Mail-In Rebate') {
            
            $table = EntryMirView::exportData($startDate, $endDate, $filters);
            
            $filename = "Entries.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('id','dollar_value','retailer','owner','coupon','first_name','last_name','address','city','state','zip','status','birth_date','invoiced_date','denial_reason_id','created_at'));
            foreach ($table as $row) {
                fputcsv($handle, array($row['id'],$row['dollar_value'], $row['retailer'],$row['owner'], $row['coupon'], $row['first_name'], $row['last_name'], $row['address'], $row['city'], $row['state'], $row['zip'], $row['status'], $row['birth_date'],$row['invoiced_date'],$row['denial_reason_id'],$row['created_at']));
            }
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'Entries.csv', $headers);
        } else {

            $table = EntryMirView::exportDataModified($startDate, $endDate, $filters,$program,$campaign);
            

            if($campaign == '2'){
 
                $filename = "Entries.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, array('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at'));

                foreach ($table as $row) {
                fputcsv($handle, array($row['id'], $row['retailer'], $row['retailer_state'], $row['program'], $row['client_id'], $row['client_name'], $row['brand'], $row['clearinghouse'], $row['is_invoiced'],$row['coupon_quantity'],$row['payable'],$row['shipping'],$row['created_at'],$row['updated_at']));
                }
                fclose($handle);
                $headers = array(
                    'Content-Type' => 'text/csv',
                );
                return Response::download($filename, 'Entries.csv', $headers);
            }
            else{
                $filename = "Entries.csv";
                $handle = fopen($filename, 'w+');

                fputcsv($handle, array('id','dollar_value','retailer','owner','coupon','first_name','last_name','address','city','state','zip','status','birth_date','invoiced_date','denial_reason_id','created_at'));
                foreach ($table as $row) {
                    fputcsv($handle, array($row['id'],$row['dollar_value'], $row['retailer'],$row['owner'], $row['coupon'], $row['first_name'], $row['last_name'], $row['address'], $row['city'], $row['state'], $row['zip'], $row['status'], $row['birth_date'],$row['invoiced_date'],$row['denial_reason_id'],$row['created_at']));
                }

                fclose($handle);

                $headers = array(
                    'Content-Type' => 'text/csv',
                );
                return Response::download($filename, 'Entries.csv', $headers);
            }
        }
    }

    public function exportJson() {
        $programType = Input::get('program-type');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $program = Input::get('program-id');
        $campaignId = Input::get('campaign-id');


        if ($programType == 'IRC') {
            $table = EntryIrcView::exportData($startDate, $endDate, $filters);
            $filename = "Entries.json";
            $handle = fopen($filename, 'w+');
            $json_data = json_encode($table);
            file_put_contents($filename, $json_data);
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/json',
            );
            return Response::download($filename, 'Entries.json', $headers);
        } else if ($programType == 'Mail-In Rebate') {
            $table = EntryMirView::exportData($startDate, $endDate, $filters);
            $filename = "Entries.json";
            $handle = fopen($filename, 'w+');
            $json_data = json_encode($table);
            file_put_contents($filename, $json_data);
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/json',
            );
            return Response::download($filename, 'Entries.json', $headers);
        } 

        else {

            $table = EntryMirView::exportDataModified($startDate, $endDate, $filters,$program,$campaignId);

            if($campaignId == '2'){
                $filename = "Entries.json";
                $handle = fopen($filename, 'w+');
                $json_data = json_encode($table);
                file_put_contents($filename, $json_data);
                fclose($handle);

                $headers = array(
                    'Content-Type' => 'text/json',
                );
                return Response::download($filename, 'Entries.json', $headers);

            }
            else{

            $filename = "Entries.json";
            $handle = fopen($filename, 'w+');
            $json_data = json_encode($table);
            file_put_contents($filename, $json_data);
            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/json',
            );
            return Response::download($filename, 'Entries.json', $headers);
        }
    }
        
        // else {
        //     $table = EntryMirView::exportData($startDate, $endDate, $filters);
        //     $filename = "Entries.json";
        //     $handle = fopen($filename, 'w+');
        //     $json_data = json_encode($table);
        //     file_put_contents($filename, $json_data);
        //     fclose($handle);

        //     $headers = array(
        //         'Content-Type' => 'text/json',
        //     );
        //     return Response::download($filename, 'Entries.json', $headers);
        // }
    }

    public function exportPdf() {
        $programType = Input::get('program-type');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $programId = Input::get('program-id');
        $campaignId = Input::get('campaign-id');

        if ($programType == 'IRC') {
            $table = EntryIrcView::exportData($startDate, $endDate, $filters);
            $html = '';
            $html .= '<html lang="en">';
            $html .= '<body>';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr><th>ID</th><th>Retailer</th><th>retailer_state</th><th>program</th><th>client_id</th><th>client_name</th><th>brand</th><th>clearinghouse</th><th>is_invoiced</th><th>coupon_quantity</th><th>payable</th><th>shipping</th><th>created_at</th><th>updated_at</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($table as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value['id'] ."</td>";
                $html .= "<td>" . $value['retailer'] ."</td>";
                $html .= "<td>" . $value['retailer_state'] ."</td>";
                $html .= "<td>" . $value['program'] ."</td>";
                $html .= "<td>" . $value['client_id'] ."</td>";
                $html .= "<td>" . $value['client_name'] ."</td>";
                $html .= "<td>" . $value['brand'] ."</td>";
                $html .= "<td>" . $value['clearinghouse'] ."</td>";
                $html .= "<td>" . $value['is_invoiced'] ."</td>";
                $html .= "<td>" . $value['coupon_quantity'] ."</td>";
                $html .= "<td>" . $value['payable'] ."</td>";
                $html .= "<td>" . $value['shipping'] ."</td>";
                $html .= "<td>" . $value['created_at'] ."</td>";
                $html .= "<td>" . $value['updated_at'] ."</td>";
                $html .= "</tr>";
            }
            $html .= '</tbody></table></body></html>';
            $pdf = PDF::loadHTML($html);
            return $pdf->download('Entries.pdf');
        } else if ($programType == 'Mail-In Rebate') {
            $table = EntryMirView::exportData($startDate, $endDate, $filters);
            $html = '';
            $html .= '<html lang="en">';
            $html .= '<body>';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr><th>ID</th><th></th>dollar_value<th>Retailer</th><th>owner</th><th>Coupon</th><th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Status</th><th>birth_date</th><th>invoiced_date</th><th>denial_reason_id</th><th>Created</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($table as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value['id'] ."</td>";
                $html .= "<td>" . $value['dollar_value'] ."</td>";
                $html .= "<td>" . $value['retailer'] ."</td>";
                $html .= "<td>" . $value['owner'] ."</td>";
                $html .= "<td>" . $value['coupon'] ."</td>";
                $html .= "<td>" . $value['first_name'] ."</td>";
                $html .= "<td>" . $value['last_name'] ."</td>";
                $html .= "<td>" . $value['address'] ."</td>";
                $html .= "<td>" . $value['city'] ."</td>";
                $html .= "<td>" . $value['state'] ."</td>";
                $html .= "<td>" . $value['zip'] ."</td>";
                $html .= "<td>" . $value['status'] ."</td>";
                $html .= "<td>" . $value['birth_date'] ."</td>";
                $html .= "<td>" . $value['invoiced_date'] ."</td>";
                $html .= "<td>" . $value['denial_reason_id'] ."</td>";
                $html .= "<td>" . $value['created_at'] ."</td>";
                $html .= "</tr>";
            }
            $html .= '</tbody></table></body></html>';
            $pdf = PDF::loadHTML($html);
            return $pdf->download('Entries.pdf');
        } else {
            $table = EntryMirView::exportDataModified($startDate, $endDate, $filters,$programId, $campaignId);
            
            if($campaignId == '2'){
                $html = '';
            $html .= '<html lang="en">';
            $html .= '<body>';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr><th>ID</th><th>Retailer</th><th>retailer_state</th><th>program</th><th>client_id</th><th>client_name</th><th>brand</th><th>clearinghouse</th><th>is_invoiced</th><th>coupon_quantity</th><th>payable</th><th>shipping</th><th>created_at</th><th>updated_at</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($table as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value['id'] ."</td>";
                $html .= "<td>" . $value['retailer'] ."</td>";
                $html .= "<td>" . $value['retailer_state'] ."</td>";
                $html .= "<td>" . $value['program'] ."</td>";
                $html .= "<td>" . $value['client_id'] ."</td>";
                $html .= "<td>" . $value['client_name'] ."</td>";
                $html .= "<td>" . $value['brand'] ."</td>";
                $html .= "<td>" . $value['clearinghouse'] ."</td>";
                $html .= "<td>" . $value['is_invoiced'] ."</td>";
                $html .= "<td>" . $value['coupon_quantity'] ."</td>";
                $html .= "<td>" . $value['payable'] ."</td>";
                $html .= "<td>" . $value['shipping'] ."</td>";
                $html .= "<td>" . $value['created_at'] ."</td>";
                $html .= "<td>" . $value['updated_at'] ."</td>";
                $html .= "</tr>";
            }
            $html .= '</tbody></table></body></html>';
            $pdf = PDF::loadHTML($html);
            return $pdf->download('Entries.pdf');
            
            }
            
            else{

                $html = '';
                $html .= '<html lang="en">';
                $html .= '<body>';
                $html .= '<table>';
                $html .= '<thead>';
                $html .= '<tr><th>ID</th><th></th>dollar_value<th>Retailer</th><th>owner</th><th>Coupon</th><th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Status</th><th>birth_date</th><th>invoiced_date</th><th>denial_reason_id</th><th>Created</th></tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                foreach ($table as $key => $value) {
                    $html .= "<tr>";
                    $html .= "<td>" . $value['id'] ."</td>";
                    $html .= "<td>" . $value['dollar_value'] ."</td>";
                    $html .= "<td>" . $value['retailer'] ."</td>";
                    $html .= "<td>" . $value['owner'] ."</td>";
                    $html .= "<td>" . $value['coupon'] ."</td>";
                    $html .= "<td>" . $value['first_name'] ."</td>";
                    $html .= "<td>" . $value['last_name'] ."</td>";
                    $html .= "<td>" . $value['address'] ."</td>";
                    $html .= "<td>" . $value['city'] ."</td>";
                    $html .= "<td>" . $value['state'] ."</td>";
                    $html .= "<td>" . $value['zip'] ."</td>";
                    $html .= "<td>" . $value['status'] ."</td>";
                    $html .= "<td>" . $value['birth_date'] ."</td>";
                    $html .= "<td>" . $value['invoiced_date'] ."</td>";
                    $html .= "<td>" . $value['denial_reason_id'] ."</td>";
                    $html .= "<td>" . $value['created_at'] ."</td>";
                    $html .= "</tr>";
                }
                $html .= '</tbody></table></body></html>';
                $pdf = PDF::loadHTML($html);
                return $pdf->download('Entries.pdf');
            }
        }
    }

    public function create() {
        
    }

    public function store() {
        
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
    }

    public function update($id) {
        
    }

    public function delete($id) {
        
    }

}