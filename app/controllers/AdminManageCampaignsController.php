<?php 

class AdminManageCampaignsController extends \BaseController {
    public function index() {
        $programs = CouponType::all();
        $coupons = Coupon::all();
        $campaigns = Constant::$campains;
        return View::make('admin.campaigns.list',compact('programs','campaigns'));
    }

    public function data() {
        $campaigns = Input::get('campaign');
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = Input::get('filters');
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');
        $data = CustomerView::getResultForDt($campaigns,$startDate,$endDate,$filters,$draw,$start,$length);
        echo json_encode($data);
    }

    public function export_csv() {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $data = CustomerView::getResultForExport($startDate,$endDate,$filters);
        $table = $data['data'];
        $filename = "IrcEntries.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('customer_id', 'dob', 'gender', 'rebate_method', 'customer_name', 'company_name', 'phone_num', 'email', 'street_address','appartment_num','zip',
                'city','country','state','created_at','updated_at','id','coupon_id','name','expires','receive_by','coupon_type_id','barcode','active','campaign_type','campaign_url','campaign_logo','user','coupon_type','brand'));
            foreach ($table as $row) {
                if($row['campaign_logo'] != 'N/A') {
                    $logo_url = Constant::$assetLink;
                    $logo_url .= $row['campaign_logo'];
                }
                else {
                    $logo_url = 'N/A';
                }
                if($row['campaign_url'] != 'N/D') {
                    $camp_url = Constant::$frontEndUrl;
                    $camp_url .= $row['campaign_url'] . '/' . $row['id'];
                }
                else {
                    $camp_url = 'N/D';
                }
                fputcsv($handle, array($row['customer_id'], $row['dob'], $row['gender'], $row['rebate_method'], $row['customer_name'], $row['company_name'], $row['phone_num'], $row['email'], $row['street_address'],$row['appartment_num'],$row['zip'],
                $row['city'],$row['country'],$row['state'],$row['created_at'],$row['updated_at'],$row['id'],$row['coupon_id'],$row['coupon_id'],$row['name'],$row['expires'],$row['receive_by'],$row['coupon_type_id'],$row['barcode'],$row['campaign_type'],$camp_url,$logo_url,$row['user'],$row['coupon_type'],$row['brand']));
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'campaignEntries.csv', $headers);
    }
    public function export_json() {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $data = CustomerView::getResultForExport($startDate,$endDate,$filters);
        $table = $data['data'];
        $filename = "campaignEntries.json";
            $handle = fopen($filename, 'w+');
            $json_data = json_encode($table);
            file_put_contents($filename, $json_data);
            fclose($handle);
    
            $headers = array(
                'Content-Type' => 'text/json',
            );
            return Response::download($filename, 'campaignEntries.json', $headers);
    }

    public function export_pdf() {
        $html = '';
        $html .= '<html lang="en">';
        $html .= '<body>';
        $html .= '<table>';
        $html .= '<thead>';
        $html .= '<tr><th>ID</th><th>dob</th><th>gender</th><th>rebate_method</th><th>customer_name?</th><th>company_name</th><th>phone_num</th><th>email</th><th>street_address</th>';
        $html .= '<th>appartment_num</th><th>zip</th>city<th>country</th><th>state</th><th>created_at</th><th>updated_at</th><th>id</th><th>coupon_id</th><th>name</th><th>expires</th><th>receive_by</th><th>coupon_type_id</th>';
        $html .= '<th>barcode</th><th>active</th>campaign_type<th>campaign_url</th><th>campaign_logo</th><th>user</th><th>coupon_type</th><th>brand</th></tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        $data = CustomerView::getResultForExport($startDate,$endDate,$filters);
        $table = $data['data'];
        foreach ($table as $key => $row) {
            if($row['campaign_logo'] != 'N/A') {
                $logo_url = Constant::$assetLink;
                $logo_url .= $row['campaign_logo'];
            }
            else {
                $logo_url = 'N/A';
            }
            if($row['campaign_url'] != 'N/D') {
                $camp_url = Constant::$frontEndUrl;
                $camp_url .= $row['campaign_url'] . '/' . $row['id'];
            }
            else {
                $camp_url = 'N/D';
            }
            $html .= "<tr>";
            $html .= "<td>" . $row['customer_id'] ."</td>";
            $html .= "<td>" . $row['dob'] ."</td>";
            $html .= "<td>" . $row['gender']."</td>";
            $html .= "<td>" . $row['rebate_method'] ."</td>";
            $html .= "<td>" . $row['customer_name'] ."</td>";
            $html .= "<td>" . $row['company_name'] ."</td>";
            $html .= "<td>" . $row['phone_num'] ."</td>";
            $html .= "<td>" . $row['email'] ."</td>";
            $html .= "<td>" . $row['street_address'] ."</td>";
            $html .= "<td>" . $row['appartment_num'] ."</td>";
            $html .= "<td>" . $row['zip'] ."</td>";
            $html .= "<td>" . $row['city'] ."</td>";
            $html .= "<td>" . $row['country'] ."</td>";
            $html .= "<td>" . $row['state'] ."</td>";
            $html .= "<td>" . $row['created_at'] ."</td>";
            $html .= "<td>" . $row['updated_at'] ."</td>";
            $html .= "<td>" . $row['id'] ."</td>";
            $html .= "<td>" . $row['coupon_id'] ."</td>";
            $html .= "<td>" . $row['name'] ."</td>";
            $html .= "<td>" . $row['expires'] ."</td>";
            $html .= "<td>" . $row['receive_by'] ."</td>";
            $html .= "<td>" . $row['coupon_type_id'] ."</td>";
            $html .= "<td>" . $row['barcode'] ."</td>";
            $html .= "<td>" . $row['campaign_type'] ."</td>";
            $html .= "<td>" . $camp_url ."</td>";
            $html .= "<td>" . $logo_url ."</td>";
            $html .= "<td>" . $row['user'] ."</td>";
            $html .= "<td>" . $row['coupon_type'] ."</td>";
            $html .= "<td>" . $row['brand'] ."</td>";
            $html .= "</tr>";
            $html .= '</tbody></table></body></html>';
            $pdf = PDF::loadHTML($html);
            return $pdf->download('IrcData.pdf');
        }
    }
}