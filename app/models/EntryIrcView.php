<?php

class EntryIrcView extends \Eloquent {

    protected $table = 'entries_irc_view';

    public static function getResultForDt($startDate,$endDate,$filters,$draw,$start,$length, $search='') {
        $data = [];
        $data['draw'] = $draw;
        $limit = $start;
        $offset = $length;
        

        if ($startDate == '' && $endDate == '' && count($filters) == 0) { 
            //No Filter
            $count = EntryIrcView::where('deleted_at', '=', NULL);
            $data['data'] = EntryIrcView::where('deleted_at', '=', NULL)->skip($limit)->take($offset)
            ->select('id','retailer','program','owner','coupon_expiry','barcode','active','brand','campaign_type','coupon_id','campaign_logo','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at')
            ->orderBy('created_at', 'DESC');
            if($search != '') {
                //Search Exist
                $columns = ['id','retailer','program','owner','coupon_expiry','barcode','active','brand','campaign_type','coupon_id','campaign_logo','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at'];
                foreach($columns as $column){
                    $data['data']->orWhere($column, 'LIKE', '%' . $search . '%');
                    $count->orWhere($column, 'LIKE', '%' . $search . '%');
                }
            }
            
            $data['data'] = $data['data']->get();
            $count = $count->count();
            $data['data'] = CouponView::getCampaignText($data['data']);
        }
        else if($startDate != '' && $endDate != '' && count($filters) == 0) {
            //Just Date Filter
            $count = EntryIrcView::where('deleted_at', '=', NULL)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
            $data['data'] = EntryIrcView::where('deleted_at', '=', NULL)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->skip($limit)->take($offset)
                        ->select('id', 'retailer','owner','coupon_expiry','barcode','active','brand','program','campaign_type','coupon_id','campaign_logo' ,'clearinghouse', 'is_invoiced', 'coupon_quantity', 'payable', 'shipping', 'created_at')
                        ->orderBy('created_at', 'DESC')->get();
            $data['data'] = CouponView::getCampaignText($data['data']);
        }

        else if($startDate == '' && $endDate == '' && count($filters) > 0){
            
          
            //Just Filters Exist
            $countQeury = "SELECT COUNT(*) as total FROM entries_irc_view WHERE id IS NOT NULL ";
            $sql = "SELECT id,retailer,program,owner,coupon_expiry,barcode,active,brand,campaign_type,campaign_logo,coupon_id,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at FROM entries_irc_view WHERE deleted_at IS NULL ";
            
            foreach ($filters as $key => $value) {
                if ($value['key'] == 'all') {
                    
                    
                    // dd($value['key']);
                    $columns = ['id','retailer','program','clearinghouse','is_invoiced','coupon_quantity','payable','created_at'];
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
                       
                    $countQeury .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                    $sql .= " AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                }
            }
            $total = DB::select($countQeury);
                           
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
            // echo '<pre>'; print_r($sql); exit;
             
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            $data['data'] = CouponView::getCampaignText($data['data']);
        }

        else if($startDate != '' && $endDate != '' && count($filters) > 0){
            
            //Date and Filters both exist
            /////////////
            $countQeury = "SELECT COUNT(*) as total FROM entries_irc_view WHERE deleted_at IS NULL AND created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            $sql = "SELECT id,retailer,program,owner,coupon_expiry,barcode,active,brand,campaign_type,coupon_id,campaign_logo,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at FROM entries_irc_view WHERE deleted_at IS NULL AND created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            foreach ($filters as $key => $value) {
            

                if ($value['key'] == 'all') {
                    
                    
                    // dd($value['key']);
                    $columns = ['id','retailer','program','clearinghouse','is_invoiced','coupon_quantity','payable','created_at'];
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
    public static function exportData($startDate,$endDate,$filters) {
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = EntryIrcView::where('deleted_at', '=', NULL)
                ->select('id','retailer','program','owner','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                ->get();
    
        } else {
            //Apply Filters
            //Case1: Date Exist only
            if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                $table = EntryIrcView::where('deleted_at', '=', NULL)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)
                    ->select('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                    ->get();
            }
            //Case2: Filters Exist only
            else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                $sql = "SELECT id,retailer,retailer_state, program,client_id,client_name,brand,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at,updated_at FROM entries_irc_view WHERE deleted_at IS NULL ";
                foreach ($filters as $key => $value) {
                    $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            //Case3: Date and Filters Both Exisit
            else {
                $sql = "SELECT id,retailer,retailer_state, program,client_id,client_name,brand,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at,updated_at FROM entries_irc_view WHERE deleted_at IS NULL AND created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
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