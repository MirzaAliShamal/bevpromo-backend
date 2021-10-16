<?php

class EntryMirView extends \Eloquent {

    protected $table = 'entries_mir_view';

    public static function getResultForDtModified($startDate,$endDate,$filters,$draw,$start,$length, $programId=null, $campaignId=null){

        $data = [];
        $data['draw'] = $draw;
        $limit = $start;        
        $offset = $length;

        // 0 represents `all`
        if($campaignId == '0') {

            // Add Filters
            if($filters==null){
                $filters = [];
            }

            if($programId != '0'){
                $arr = ["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }
            
            $data = EntryMirView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$programId,$campaignId);
            return $data;
        }

        // Campaign MIR and Program is all
        else if($campaignId == '1'){

            // Add Filters
            if($filters==null){
                $filters = [];
            }

            if($programId != '0'){
                $arr = ["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $data = EntryMirView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$programId,$campaignId);
            return $data;
            
        }

        // Campaign IRC
        else if($campaignId == '2'){
            // Add Filters Here
            if($filters==null){
                $filters = [];
            }
            if($programId != '0'){
                $arr = ["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            
            $data = EntryIrcView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length);
            return $data;
        }

        // Campaign DMIR and all Programs
        else if($campaignId == '3'){
           
            if($filters == null){
                $filters = [];
            }

            $arr = ["key"=> "campaign_type", "value" => $campaignId];
            array_push($filters, $arr);

            if($programId!=0){
                $arr = ["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $data = EntryMirView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$programId,$campaignId);
            return $data;
            
        }


        // Campaign SweepStakes and all Programs
        else if($campaignId == '4'){
            
            if($filters == null){
                $filters = [];
            }

            $arr = ["key"=> "campaign_type", "value" => $campaignId];
            array_push($filters, $arr);

            if($programId!=0){
                $arr = ["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $data = EntryMirView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$programId,$campaignId);
            return $data;
        }
        
       

        // $data['recordsTotal'] = $count;
        // $data['recordsFiltered'] = $count;
        // return $data;
    }

    
    public static function getResultForDt($startDate,$endDate,$filters,$draw,$start,$length, $programId=null, $campaignId=null) {
       
        $data = [];
        $data['draw'] = $draw;
        $limit = $start;        
        $offset = $length;

        if ($startDate == '' && $endDate == '' && count($filters) == 0){
            //No Filter            
            $count = EntryMirView::where('id', '!=', '')->count();
            $data['data'] = EntryMirView::where('id', '!=', '')->skip($limit)->take($offset)->select('id',
            'dollar_value',
            'retailer',
            'owner',
            'coupon',
            'coupon_expiry',
            'brand',
            'active',
            'first_name',
            'last_name',
            'address',
            'city',
            'state',
            'zip',
            'status',
            'campaign_type',
            'campaign_logo',
            'birth_date',
            'checkbox',
            'paid_status',
            'invoiced_date',
            'denial_reason_id',
            'created_at')->orderBy('created_at', 'DESC')->get();
            $data['data'] = CouponView::getCampaignText($data['data']);
        }
        else if($startDate != '' && $endDate != '' && count($filters) == 0) {
            
            //Date Exist only
            $count = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
            $data['data'] = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->skip($limit)->take($offset)->select('id',
            'dollar_value',
            'retailer',
            'owner',
            'coupon',
            'first_name',
            'last_name',
            'address',
            'coupon_expiry',
            'brand',
            'active',
            'city',
            'state',
            'zip',
            'status',
            'campaign_type',
            'campaign_logo',
            'checkbox',
            'paid_status',
            'birth_date',
            'invoiced_date',
            'denial_reason_id',
            'created_at')->orderBy('created_at', 'desc')->get();
            $data['data'] = CouponView::getCampaignText($data['data']);
        } else if(isset($filters[0]) && $filters[0] && isset($filters[0]['paid_status'])) {
            //Paid Status Exist only
            $status = $filters[0]['paid_status'];
            $countQeury = "SELECT COUNT(*) as total FROM entries_mir_view WHERE  status ='".$status."'";
            $sql = "SELECT id,dollar_value,paid_status,retailer,owner,coupon_expiry,brand,active
                    ,coupon,first_name,last_name,address,city,state,
                    campaign_type,campaign_logo,zip,status,birth_date,status,
                    invoiced_date,denial_reason_id,created_at FROM entries_mir_view WHERE status ='".$status."'";
            $total = DB::select($countQeury);
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at ASC LIMIT " . $offset . " OFFSET " . $limit . " ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            $data['data'] = CouponView::getCampaignText($data['data']);
        } else if($startDate == '' && $endDate == '' && count($filters) > 0) {
            //Filters Exist only
            $countQeury = "SELECT COUNT(*) as total FROM entries_mir_view WHERE id is not null ";
            $sql = "SELECT id,dollar_value,paid_status,retailer,owner,coupon_expiry,brand,active,coupon,first_name,last_name,address,city,state,campaign_type,campaign_logo,zip,status,birth_date,invoiced_date,denial_reason_id,created_at FROM entries_mir_view WHERE id is not null ";
            foreach ($filters as $key => $value) {
                if ($value['key'] == 'all') { 
                   
                    // dd($value['key']);
                    $columns = ['id','paid_status','dollar_value','retailer','owner','coupon_expiry','brand','active','coupon','first_name','last_name','address','city','state','campaign_type','campaign_logo','zip','status','birth_date','invoiced_date','denial_reason_id','created_at'];
                    foreach($columns as $key => $col){
                        if ($key == 0) {
                            $countQeury .= "AND " . $col . " LIKE '%" . $value['value'] . "%'";
                            $sql .= "AND " . $col . " LIKE '%" . $value['value'] . "%'";
                        } else {
                            $countQeury .= "OR " . $col . " LIKE '%" . $value['value'] . "%'";
                            $sql .= "OR " . $col . " LIKE '%" . $value['value'] . "%'";
                        }
                    }
                }
                
                else {
                        $countQeury .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                        $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                }
            }
            $total = DB::select($countQeury);
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at ASC LIMIT " . $offset . " OFFSET " . $limit . " ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            $data['data'] = CouponView::getCampaignText($data['data']);
        }
        else {
            //Date and Filters Both Exist
            $countQeury = "SELECT COUNT(*) as total FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            $sql = "SELECT id,paid_status,dollar_value,retailer,owner,coupon_expiry,brand,active,coupon,first_name,last_name,address,city,state,campaign_type,campaign_logo,zip,status,birth_date,invoiced_date,denial_reason_id,created_at FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            
            foreach ($filters as $key => $value) {
            

                if ($value['key'] == 'all') {
                    
                    ////////
                    // dd($value['key']);
                    $columns = ['id','paid_status','retailer','coupon','first_name','last_name','address','city','state','zip','status','created_at'];
                    $count_col = count($columns) - 1;

                    foreach($columns as $key1 => $col){
                                
                        if($key1 == 0) {

                            $countQeury .= " AND (" . $col . " LIKE '%" . $value['value'] . "%'";
                            $sql .= " AND (" . $col . " LIKE '%" . $value['value'] . "%'";
                        }
                        else if ($key1 == $count_col) {
                            $countQeury .= " OR " . $col . " LIKE '%" . $value['value'] . "%')";
                            $sql .= " OR " . $col . " LIKE '%" . $value['value'] . "%')";
                        }
                        else {
                            $countQeury .= " OR " . $col . " LIKE '%" . $value['value'] . "%'";
                            $sql .= " OR " . $col . " LIKE '%" . $value['value'] . "%'";
                        }
                    } 
                } else {
                            
                    $countQeury .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                }
                // $countQeury .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                // $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
            }
            $total = DB::select($countQeury);
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            $data['data'] = CouponView::getCampaignText($data['data']);
        }
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        return $data;
    }


    public static function exportDataModified($startDate,$endDate,$filters,$programId,$campaignId){
        // 0 represents `all`
        if($campaignId == '0') {

            // Add Filters
            if($filters==null){
                $filters = [];
            }

            if($programId != '0'){
               
                $arr = (object)["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
 
            }
            
            
                
            $table = EntryMirView::exportData($startDate,$endDate,$filters);
            return $table;
        }
        // Campaign MIR and Program is all
        else if($campaignId == '1'){

            // Add Filters
            if($filters==null){
                $filters = [];
            }

            if($programId != '0'){
                $arr = (object)["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $table = EntryMirView::exportData($startDate,$endDate,$filters);
            return $table;
            
        }

        // Campaign IRC
        else if($campaignId == '2'){
            // Add Filters Here
            if($filters==null){
                $filters = [];
            }
            if($programId != '0'){
                $arr = (object)["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }
        
            $table = EntryIrcView::exportData($startDate,$endDate,$filters);
            return $table;
        }

        // Campaign DMIR and all Programs
        else if($campaignId == '3'){
           
            if($filters == null){
                $filters = [];
            }

            $arr = (object)["key"=> "campaign_type", "value" => $campaignId];
            array_push($filters, $arr);

            if($programId!=0){
                $arr = (object)["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $table = EntryMirView::exportData($startDate,$endDate,$filters);
            return $table;
            
        }


        // Campaign SweepStakes and all Programs
        else if($campaignId == '4'){
            
            if($filters == null){
                $filters = [];
            }

            $arr = (object)["key"=> "campaign_type", "value" => $campaignId];
            array_push($filters, $arr);

            if($programId!=0){
                $arr = (object)["key"=> "coupon_type_id", "value" => $programId];
                array_push($filters, $arr);
            }

            $table = EntryMirView::exportData($startDate,$endDate,$filters);
            return $table;
        }
    }


    
    public static function exportData($startDate,$endDate,$filters) {
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {

            //No filters
            // $table = EntryMirView::select('id','dollar_value','retailer','coupon','coupon_id','coupon_type_id','owner','status','first_name','last_name','address','city','state','zip','campaign_type','campaign_logo','coupon_expiry','active','birth_date','brand','invoiced_date','is_invoiced','email','denial_reason_id','paid_status','created_at')->get();

            // $table = EntryMirView::where('id','<','25')->select('*')->get(); 
            $table = EntryMirView::select('*')->get(); 
    
        } else {
            //Apply Filters
            //Case1: Date Exisit only
            if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                $table = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            }
            //Case2: Filters Exist only
            else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                
                   
                
                $sql = "SELECT * FROM entries_mir_view WHERE id is not null";
                foreach ($filters as $key => $value) {

                    $sql .= " AND " . $value->key . " LIKE '%" . $value->value . "%'";

                    
                    
                    
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            //Case3: Date and Filters Both Exisit
            else {
                $sql = "SELECT * FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                foreach ($filters as $key => $value) {
                    
                    $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
        }
            return $table;
        }
}