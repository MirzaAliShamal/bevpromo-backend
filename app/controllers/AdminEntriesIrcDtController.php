<?php

class AdminEntriesIrcDtController extends \BaseController
{

    public function index()
    {
        return View::make('admin.entries.irc-dt.list');
    }
    public static function deleteDataFromTableAndView($id)
    {
            DB::table('entries_irc')->where('id', $id)->delete();
            DB::statement("DROP VIEW entries_irc_view");

            DB::statement("CREATE OR REPLACE VIEW `entries_irc_view`  AS  select `e`.`id` AS `id`,`r`.`name` AS `retailer`,`r`.`state` AS `retailer_state`,`c`.`name` AS `program`,`c`.`id` AS `coupon_id`,`ch`.`name` AS `clearinghouse`,concat_ws(' ',`u`.`first_name`,`u`.`last_name`) AS `owner`,(case when (`e`.`is_invoiced` <> 0) then 'Yes' else 'No' end) AS `is_invoiced`,`e`.`client_invoice` AS `client_invoice`,`e`.`coupon_quantity` AS `coupon_quantity`,`e`.`payable` AS `payable`,(case when isnull(`c`.`campaign_type`) then 'Not Defined' else `c`.`campaign_type` end) AS `campaign_type`,(case when isnull(`c`.`campaign_logo`) then 'N/A' else `c`.`campaign_logo` end) AS `campaign_logo`,`c`.`expires` AS `coupon_expiry`,`c`.`coupon_type_id` AS `coupon_type_id`,(case when (`c`.`active` <> 0) then 'Yes' else 'No' end) AS `active`,`c`.`barcode` AS `barcode`,`e`.`shipping` AS `shipping`,`u`.`id` AS `client_id`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `client_name`,`b`.`name` AS `brand`,`e`.`created_at` AS `created_at`,`e`.`updated_at` AS `updated_at`,`e`.`deleted_at` AS `deleted_at` from (((((`entries_irc` `e` left join `retailers` `r` on((`e`.`retailer_id` = `r`.`id`))) left join `coupons` `c` on((`e`.`coupon_id` = `c`.`id`))) left join `clearinghouses` `ch` on((`e`.`clearinghouse_id` = `ch`.`id`))) join `users` `u` on((`c`.`user_id` = `u`.`id`))) join `brands` `b` on((`c`.`brand_id` = `b`.`id`)))");
            
    }
    public function deleteRow()
    {
        $id = Input::get('id');
        try {
            //DB::table('coupons')->where('id', $id)->delete();
            self::deleteDataFromTableAndView($id);
            $data = array('success' => true);
            echo json_encode($data);
            return;
		} catch (Exception $ex) {
            echo $ex;
            return json_encode(array('success' => false));
		}
    }
    
    public function data()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = Input::get('filters');
        $draw = Input::get('draw');
        $search = Input::get('search.value');
        $start = Input::get('start');
        $length = Input::get('length');
        if (!$user->hasRole(1)) {

            $userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');
            $data = [];
            $count = EntryIrc::where('coupen_id', $userCoupons)->count();
            $data['draw'] = Input::get('draw');
            $data['recordsTotal'] = $count;
            $data['recordsFiltered'] = $count;
            $limit = Input::get('start');
            $offset = Input::get('length');
            $entries = EntryIrcView::whereIn('coupon_id', $userCoupons)->skip($limit)->take($offset)
                ->select('id', 'retailer', 'program','coupon_expiry','barcode','active','brand','clearinghouse', 'is_invoiced', 'coupon_quantity', 'payable', 'shipping', 'created_at')
                ->get();
            $data['data'] = $entries;
            echo json_encode($data);
        } else {
            
            $data = EntryIrcView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length,$search);
            echo json_encode($data);
        }
    }

    public function exportCsv()
    {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = EntryIrcView::where('deleted_at', '=', NULL)
                ->select('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                ->get();
        } else {
            //Apply Filters
            //Case1: Date Exisit only
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
        $filename = "IrcEntries.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at'));

        foreach ($table as $row) {
            fputcsv($handle, array($row['id'], $row['retailer'], $row['retailer_state'], $row['program'], $row['client_id'], $row['client_name'], $row['brand'], $row['clearinghouse'], $row['is_invoiced'],$row['coupon_quantity'],$row['payable'],$row['shipping'],$row['created_at'],$row['updated_at']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'IrcEntries.csv', $headers);
    }

    public function exportJson() {
        {
            $startDate = Input::get('startDate');
            $endDate = Input::get('endDate');
            $filters = json_decode(Input::get('filters'));
            if ($startDate == '' && $endDate == '' && count($filters) == 0) {
                //No filters
                $table = EntryIrcView::where('deleted_at', '=', NULL)
                    ->select('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                    ->get();
            } else {
                //Apply Filters
                //Case1: Date Exisit only
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
                    $sql = "SELECT id,retailer,retailer_state,program,client_id,client_name,brand,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at,updated_at FROM entries_irc_view WHERE deleted_at IS NULL AND created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                    foreach ($filters as $key => $value) {
                        $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                    }
                    $result = DB::select($sql);
                    $resultArray = json_decode(json_encode($result), true);
                    $table = $resultArray;
                }
            }
            $filename = "IrcEntries.json";
            $handle = fopen($filename, 'w+');
            $json_data = json_encode($table);
            file_put_contents($filename, $json_data);
            fclose($handle);
    
            $headers = array(
                'Content-Type' => 'text/json',
            );
            return Response::download($filename, 'IrcEntries.json', $headers);
        }
    }

    public function exportPdf() {
        $startDate = Input::get('startDate');
            $endDate = Input::get('endDate');
            $filters = json_decode(Input::get('filters'));
            if ($startDate == '' && $endDate == '' && count($filters) == 0) {
                //No filters
                $table = EntryIrcView::where('deleted_at', '=', NULL)
                    ->select('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                    ->get();
            } else {
                //Apply Filters
                //Case1: Date Exisit only
                if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                    $table = EntryIrcView::where('deleted_at', '=', NULL)->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)
                        ->select('id','retailer','retailer_state', 'program','client_id','client_name','brand','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at','updated_at')
                        ->get();
                }
                //Case2: Filters Exist only
                else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                    $sql = "SELECT id,retailer,retailer_state,program,client_id,client_name,brand,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at,updated_at FROM entries_irc_view WHERE deleted_at IS NULL ";
                    foreach ($filters as $key => $value) {
                        $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                    }
                    $result = DB::select($sql);
                    $resultArray = json_decode(json_encode($result), true);
                    $table = $resultArray;
                }
                //Case3: Date and Filters Both Exisit
                else {
                    $sql = "SELECT id,retailer,retailer_state,program,client_id,client_name,brand,clearinghouse,is_invoiced,coupon_quantity,payable,shipping,created_at,updated_at FROM entries_irc_view WHERE deleted_at IS NULL AND created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                    foreach ($filters as $key => $value) {
                        $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                    }
                    $result = DB::select($sql);
                    $resultArray = json_decode(json_encode($result), true);
                    $table = $resultArray;
                }
            }
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
            return $pdf->download('IrcData.pdf');
    }
    public function create()
    {
        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $coupons = Coupon::where('active', '=', 1)->where('coupon_type_id', '!=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.entries.irc.create')->with('retailers', $retailers)->with('coupons', $coupons)->with('clearinghouses', $clearinghouses);
    }

    public function store()
    {
        $entryIrc = new EntryIrc;

        $entryIrc->fill(Input::all());

        $entryIrc->save();

        return Redirect::to('/admin/entries/irc');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $entryIrc = EntryIrc::find($id);

        //$entryIrc->created_at = date('m/d/Y', strtotime($entryIrc->created_at));

        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $coupons = Coupon::where('active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->lists('name', 'id');


        return View::make('admin.entries.irc.edit')->with('entryIrc', $entryIrc)->with('retailers', $retailers)->with('coupons', $coupons)->with('clearinghouses', $clearinghouses);
    }

    public function update($id)
    {
        $entryIrc = EntryIrc::find($id);

        $entryIrc->fill(Input::all());

        //$updatedAt = date('Y-m-d H:i:s', strtotime(Input::get('created_at')));

        //$entryIrc->created_at = $createdAt;

        $entryIrc->save();

        return Redirect::to('/admin/entries/irc');
    }

    public function delete($id)
    {
        $entryIrc = EntryIrc::find($id);

        $entryIrc->delete();

        return Redirect::to('/admin/entries/irc');
    }
}