<?php

class CouponView extends \Eloquent {
    protected $table = 'coupons_view';
    public static function getCampaignText($data) {
        foreach($data as $key=>$value) {
            if($value['campaign_type'] != 'Not Defined') {
                $const = $value['campaign_type'];
                $value = Constant::$campains[$const];
                $data[$key]['campaign_type'] = $value;
            }
        }
        return $data;
    }

    public static function getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$program_id) {        
        $data = [];
        $data['draw'] = $draw;
        $limit = $start;
        $offset = $length;
        if ($startDate == '' && $endDate == '' && count($filters) == 0){
            //No Filter

            if($program_id == 'all') {
                
                $count = CouponView::all()->count();
                
                
                $data['data'] = CouponView::skip($limit)->take($offset)->orderBy('created_at', 'desc')->get();
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
            else {
                $count = CouponView::where('coupon_type_id','=',$program_id)->count();
                $data['data'] = CouponView::where('coupon_type_id','=',$program_id)->skip($limit)->take($offset)->orderBy('created_at', 'desc')->get();
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
        }
        else if($startDate != '' && $endDate != '' && count($filters) == 0) {
            //Date Exist only
            if($program_id == 'all') {
                $count = CouponView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
                $data['data'] = CouponView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->skip($limit)->take($offset)->orderBy('created_at', 'desc')->get();
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
            else {
                $count = CouponView::where('coupon_type_id','=',$program_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
                $data['data'] = CouponView::where('coupon_type_id','=',$program_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->skip($limit)->take($offset)->orderBy('created_at', 'desc')->get();
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
        }
        else if($startDate == '' && $endDate == '' && count($filters) > 0) {
            //Filters Exist only
           ////////////

            if($program_id == 'all') {            
                
                $countQeury = "SELECT COUNT(*) as total FROM coupons_view WHERE id is not null";
                $sql = "SELECT * FROM coupons_view WHERE id is not null";
                $campaign_type = array();
                foreach ($filters as $key => $value) {
                    if($value['key'] == 'campaign_type')
                    {
                        $campaign_type[] = $value['value'];
                        $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                        $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                    }
                    elseif($value['key'] == 'all'){
                        // dd($value['key']);
                        $columns = ['coupon_id','name','campaign_url','user','expires','active','created_at'];
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
                    }
                    else {
                        $countQeury .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                        $sql .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    }
                }
                
                
                // if(!empty($campaign_type))
                // {
                //     $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                //     $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                // }
                
                
                $total = DB::select($countQeury);
                $count = $total[0]->total;
                $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
                
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $data['data'] = $resultArray;
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
            else {
                
                $countQeury = "SELECT COUNT(*) as total FROM coupons_view WHERE coupon_type_id = ". $program_id ."";
                $sql = "SELECT * FROM coupons_view WHERE coupon_type_id = ". $program_id ."";
                $campaign_type = array();
                foreach ($filters as $key => $value) {
                    if($value['key'] == 'campaign_type')
                    {
                        $campaign_type[] = $value['value'];
                    }
                    else {
                        $countQeury .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                        $sql .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    }
                }
                
                if(!empty($campaign_type))
                {
                    $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                    $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                }
                
                $total = DB::select($countQeury);
                $count = $total[0]->total;
                $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $data['data'] = $resultArray;
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
        }
        else {
            
            //Date and Filters Both Exist
            if($program_id == 'all') {
                
                $countQeury = "SELECT COUNT(*) as total FROM coupons_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                $sql = "SELECT * FROM coupons_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                
                $campaign_type = array();
               //////////////////
                foreach ($filters as $key => $value) {
                    if($value['key'] == 'campaign_type')
                    {
                        $campaign_type[] = $value['value'];
                        $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                        $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                    }
                    elseif($value['key'] == 'all'){
                        // dd($value['key']);
                        $columns = ['coupon_id','name','campaign_url','user','expires','active','created_at'];
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
                    }
                    else {
                        $countQeury .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                        $sql .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    }
                }
                
                if(!empty($campaign_type))
                {
                    $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                    $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                }
                
                $total = DB::select($countQeury);
                $count = $total[0]->total;
                $sql .= " LIMIT " . $offset . " OFFSET " . $limit . " ";
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $data['data'] = $resultArray;
                $data['data'] = CouponView::getCampaignText($data['data']);
            }
            else {
                $countQeury = "SELECT COUNT(*) as total FROM coupons_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' AND coupon_type_id = ". $program_id ." ";
                $sql = "SELECT * FROM coupons_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' AND coupon_type_id = ". $program_id ." ";
                
                $campaign_type = array();
                foreach ($filters as $key => $value) {
                    if($value['key'] == 'campaign_type')
                    {
                        $campaign_type[] = $value['value'];
                    }
                    else {
                        $countQeury .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                        $sql .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    }
                }
                
                if(!empty($campaign_type))
                {
                    $countQeury .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                    $sql .= " AND campaign_type IN (".implode(',', $campaign_type).")";
                }
                
                $total = DB::select($countQeury);
                $count = $total[0]->total;
                $sql .= " LIMIT " . $offset . " OFFSET " . $limit . " ";
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $data['data'] = $resultArray;
                $data['data'] =  CouponView::getCampaignText($data['data']);
            }
        }
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        return $data;
    }

    public static function exportData($startDate,$endDate,$filters,$program_id) {
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = CouponView::where('coupon_type_id','=',$program_id)->get();
        } 
        else if($startDate != '' && $endDate != '' && count($filters) == 0){
            //Apply Filters
            //Case1: Date Exisit only
                $table = CouponView::where('coupon_type_id','=',$program_id)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
        }
            //Case2: Filters Exist only
        else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
            $sql = "SELECT * FROM coupons_view WHERE coupon_type_id = ". $program_id ."";
            foreach ($filters as $key => $value) {
                    $sql .= " AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $table = $resultArray;
        }
            //Case3: Date and Filters Both Exisit
        else {
            $sql = "SELECT * FROM coupons_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' AND coupon_type_id = ". $program_id ." ";
            foreach ($filters as $key => $value) {
                    $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
            }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            return $table;
        }
}