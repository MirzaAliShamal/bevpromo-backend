<?php

class ReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $saveSearch = SaveSearch::where('user_id','=',\Auth::user()->id)->get();
	    $arr = [];
	    foreach($saveSearch as $data){
	        $jsonData = json_decode($data['search'],true);
	        $a = array(
	            'id' => $data['id'],
	            'name' => $data['name'],
                'data' => $jsonData
            );
	        array_push($arr,$a);
        }
        return View::make('admin.report.report-builder.index',[
            'search_data' => $arr
        ]);
	}

	function deleteFilter($id){
	    SaveSearch::where('id','=',$id)->delete();
        $saveSearch = SaveSearch::where('user_id','=',\Auth::user()->id)->get();
        $arr = [];
        foreach($saveSearch as $data){
            $jsonData = json_decode($data['search'],true);
            $a = array(
                'id' => $data['id'],
                'name' => $data['name'],
                'data' => $jsonData
            );
            array_push($arr,$a);
        }
        echo json_encode($arr);
    }

	public function getSaveSearch(){
        $saveSearch = SaveSearch::where('user_id','=',\Auth::user()->id)->get();
        $arr = [];
        foreach($saveSearch as $data){
            $jsonData = json_decode($data['search'],true);
            $a = array(
                'id' => $data['id'],
                'name' => $data['name'],
                'data' => $jsonData
            );
            array_push($arr,$a);
        }
        echo json_encode($arr);
    }

	public function deleteSearch(){
	    $search = Input::get('search');
	    SaveSearch::where('user_id','=',\auth::user()->id)->delete();
        return Redirect::to('/admin/report-builder');
    }

	public function saveSearch(){
        $user_id = \Auth::user()->id;
        $search = Input::get('search_data');
        $name = Input::get('filter_name');
        $check = SaveSearch::where('name','=',$name)->first();
        if(is_null($check)) {
            SaveSearch::create([
                'name' => $name,
                'user_id' => $user_id,
                'search' => $search,
            ]);
        } else {
            echo json_encode('this name filter already exists');
        }

        $saveSearch = SaveSearch::where('user_id','=',\Auth::user()->id)->get();
        $arr = [];
        foreach($saveSearch as $data){
            $jsonData = json_decode($data['search'],true);
            $a = array(
                'id' => $data['id'],
                'name' => $data['name'],
                'data' => $jsonData
            );
            array_push($arr,$a);
        }
        echo json_encode($arr);
    }


	public function searchData(){
//        $startDate = Input::get('startDate');
//        $endDate = Input::get('endDate');
        $filters = Input::get('filters');
        $draw = Input::get('draw');
        $search = Input::get('search.value');
        $start = Input::get('start');
        $length = Input::get('length');
        $data = [];
        $data1 = [];
        $data2 = [];
        $count = [];
        $count1 = [];
        $count2 = [];
        $data['draw'] = $draw;
        $limit = $start;
        $offset = $length;
        if(count($filters) <= 0) {
            return 'no filter selected';
        }
        foreach($filters as $filter) {
            if($filter['db'] == 'entries_irc_view') {
                $entriesIrc = EntryIrcView::skip($limit)->take($offset)
                    ->select('id','retailer','created_at','clearinghouse','owner')
                    ->orderBy('created_at', 'DESC');
                foreach ($filter['key'] as $key => $value) {
                    $dbKeyValue = $value['key'];
                    $columns = $filter['column'][$key];
                    $value = $filter['value'][$key];
                    if($columns['column'] == 'all' || $columns['column'] == 'none') {
                        $data['data'] = $entriesIrc->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'equals') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'=',$value['value'])->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'does-not-equal') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=',$value['value'])->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'contains') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'ends-with') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, RIGHT (retailer, "' .$value['value']. '") as first_char')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'begins-with') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, LEFT (retailer, "' .$value['value']. '") as first_char')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'is-empty') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=','')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns['column'] == 'is-not-empty') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=','')->get();
                        $count['count'] = $entriesIrc->count();
                    } else {
                        $data['data'] = $entriesIrc->get();
                        $count['count'] = $entriesIrc->count();
                    }
                }
            } else if($filter['db'] == 'coupons_view') {
                $coupons = CouponView::skip($limit)->take($offset)
                    ->select('id','name','created_at','coupon_type' ,'supplier_name','brand','active','value','receive_by','barcode','circulation')
                    ->orderBy('created_at', 'DESC');
                foreach ($filter['key'] as $key => $value) {
                    $dbKeyValue = $value['key'];
                    $columns = $filter['column'][$key];
                    $value = $filter['value'][$key];
                    if($columns['column'] == 'all' || $columns['column'] == 'none') {
                        $data1['data'] = $coupons->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'equals') {
                        $data1['data'] = $coupons->where($dbKeyValue,'=',$value['value'])->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'equals' && $columns['column'] == 'does-not-equal') {
                        $data1['data'] = $coupons->where($dbKeyValue,'=',$value['value'])->where($dbKeyValue,'!=',$value['value'])->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'does-not-equal') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=',$value['value'])->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'contains') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'ends-with') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, RIGHT (name, "' .$value['value']. '") as first_char')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'begins-with') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, LEFT (name, "' .$value['value']. '") as first_char')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'is-empty') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=','')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'is-not-empty') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=','')->get();
                        $count1['count1'] = $coupons->count();
                    } else {
                        $data1['data'] = $coupons->get();
                        $count1['count1'] = $coupons->count();
                    }
                }
            } else if($filter['db'] == 'entries_mir_view') {
                $entriesMIr = EntryMirView::skip($limit)->take($offset)
                    ->select('id','retailer','created_at','dollar_value','first_name','last_name','address','city','state','zip','email','birth_date','status','denial_reason_id')
                    ->orderBy('created_at', 'DESC');

                foreach ($filter['key'] as $key => $value) {
                    $dbKeyValue = $value['key'];
                    $columns = $filter['column'][$key];
                    $value = $filter['value'][$key];
                    if($columns['column'] == 'all' || $columns['column'] == 'none') {
                        $data2['data'] = $entriesMIr->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'equals') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'=',$value['value'])->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'equals' && $columns['column'] == 'does-not-equal') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'=',$value['value'])->where($dbKeyValue,'!=',$value['value'])->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'does-not-equal') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=',$value['value'])->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'contains') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'ends-with') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, RIGHT (retailer, "' .$value['value']. '") as first_char')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'begins-with') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value['value'] . '%')->selectRaw('*, LEFT (retailer, "' .$value['value']. '") as first_char')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'is-empty') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=','')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'is-not-empty') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=','')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else {
                        $data2['data'] = $entriesMIr->get();
                        $count2['count2'] = $entriesMIr->count();
                    }
                }
            }
        }
        $count = $count+$count1+$count2;
        $data = $data+$data1+$data2;
        $count1 = isset($count['count1']) ? $count['count1'] : '';
        $count2 = isset($count['count2']) ? $count['count2'] : '';
        $count = isset($count['count']) ? $count['count'] : '';
        $count = $count + $count2 + $count1;
        $results = array_merge($data,$data1,$data2);
        $results['recordsTotal'] = $count;
        $results['recordsFiltered'] = $count;
        echo json_encode($results);
    }

    public function exportCsv(){
        $filters = Input::get('filters');
        $draw = Input::get('draw');
        $search = Input::get('search.value');
        $start = Input::get('start');
        $length = Input::get('length');
        $data = [];
        $data1 = [];
        $data2 = [];
        $count = [];
        $count1 = [];
        $count2 = [];
        $data['draw'] = $draw;
        $limit = $start;
        $offset = $length;
        if(count($filters) <= 0) {
            return 'no filter selected';
        }
        $filters = json_decode($filters);
        foreach($filters as $filter) {
            if($filter->db == 'entries_irc_view') {
                $entriesIrc = EntryIrcView::orderBy('created_at', 'DESC');
                foreach ($filter->key as $key => $value) {
                    $dbKeyValue = $value->key;
                    $columns = $filter->column[$key];
                    $value = $filter->value[$key];
                    if($columns->column == 'all' || $columns->column == 'none') {
                        $data['data'] = $entriesIrc->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'equals') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'=',$value->value)->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'does-not-equal') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=',$value->value)->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'contains') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'ends-with') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, RIGHT (retailer, "' .$value->value. '") as first_char')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'begins-with') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, LEFT (retailer, "' .$value->value. '") as first_char')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'is-empty') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=','')->get();
                        $count['count'] = $entriesIrc->count();
                    } else if($columns->column == 'is-not-empty') {
                        $data['data'] = $entriesIrc->where($dbKeyValue,'!=','')->get();
                        $count['count'] = $entriesIrc->count();
                    } else {
                        $data['data'] = $entriesIrc->get();
                        $count['count'] = $entriesIrc->count();
                    }
                }
            } else if($filter['db'] == 'coupons_view') {
                $coupons = CouponView::orderBy('created_at', 'DESC');
                foreach ($filter['key'] as $key => $value) {
                    $dbKeyValue = $value['key'];
                    $columns = $filter['column'][$key];
                    $value = $filter['value'][$key];
                    if($columns['column'] == 'all' || $columns->column == 'none') {
                        $data1['data'] = $coupons->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'equals') {
                        $data1['data'] = $coupons->where($dbKeyValue,'=',$value->value)->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns['column'] == 'equals' && $columns->column == 'does-not-equal') {
                        $data1['data'] = $coupons->where($dbKeyValue,'=',$value->value)->where($dbKeyValue,'!=',$value->value)->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'does-not-equal') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=',$value->value)->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'contains') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'ends-with') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, RIGHT (name, "' .$value->value. '") as first_char')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'begins-with') {
                        $data1['data'] = $coupons->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, LEFT (name, "' .$value->value. '") as first_char')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'is-empty') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=','')->get();
                        $count1['count1'] = $coupons->count();
                    } else if($columns->column == 'is-not-empty') {
                        $data1['data'] = $coupons->where($dbKeyValue,'!=','')->get();
                        $count1['count1'] = $coupons->count();
                    } else {
                        $data1['data'] = $coupons->get();
                        $count1['count1'] = $coupons->count();
                    }
                }
            } else if($filter['db'] == 'entries_mir_view') {
                $entriesMIr = EntryMirView::orderBy('created_at', 'DESC');

                foreach ($filter['key'] as $key => $value) {
                    $dbKeyValue = $value['key'];
                    $columns = $filter['column'][$key];
                    $value = $filter['value'][$key];
                    if($columns['column'] == 'all' || $columns->column == 'none') {
                        $data2['data'] = $entriesMIr->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'equals') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'=',$value->value)->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns['column'] == 'equals' && $columns->column == 'does-not-equal') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'=',$value->value)->where($dbKeyValue,'!=',$value->value)->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'does-not-equal') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=',$value->value)->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'contains') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'ends-with') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, RIGHT (retailer, "' .$value->value. '") as first_char')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'begins-with') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'LIKE', '%' . $value->value . '%')->selectRaw('*, LEFT (retailer, "' .$value->value. '") as first_char')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'is-empty') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=','')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else if($columns->column == 'is-not-empty') {
                        $data2['data'] = $entriesMIr->where($dbKeyValue,'!=','')->get();
                        $count2['count2'] = $entriesMIr->count();
                    } else {
                        $data2['data'] = $entriesMIr->get();
                        $count2['count2'] = $entriesMIr->count();
                    }
                }
            }
        }
        $results = array_merge($data,$data1,$data2);
        $filename = "Report.csv";
        $handle = fopen($filename, 'w+');
        $entriesIrcViews = array('id','retailer','retailer_state','program',
            'coupon_id','clearinghouse','owner','is_invoiced','client_invoice',
            'coupon_quantity','payable','campaign_type','campaign_logo','coupon_expiry',
            'coupon_type_id','active','barcode','shipping','client_id','client_name','brand','created_at','updated_at');
        $couponViews = array('id','value','circulation','coupon_id','name','expires',
            'receive_by','coupon_type_id','barcode','active','campaign_type','campaign_url',
            'campaign_logo','offer_code','start_date','promotion_title','user','coupon_type','brand','supplier_name','created_at','updated_at');
        $entriesMirViews = array('id','dollar_value','retailer','coupon','coupon_id','coupon_type_id',
            'owner','status','first_name','last_name','address','city','state','zip','campaign_type',
            'campaign_logo','coupon_expiry','active','birth_date','brand','invoiced_date','is_invoiced',
            'email','denial_reason_id','paid_status','created_at','updated_at');
        $array = $entriesIrcViews+$couponViews+$entriesMirViews;
        fputcsv($handle,$array);
//        fputcsv($handle, array('id','name','retailer','supplier_name','brand','active','value','receive_by','barcode','circulation','dollar_value',
//            'first_name','last_name','address','city','state','zip','email',
//            'birth_date','status','denial_reason_id','clearinghouse','owner'));
        foreach ($results['data'] as $row) {
            fputcsv($handle, array($row['id'], $row['retailer'], $row['retailer_state'], $row['program'],
                $row['coupon_id'],$row['clearinghouse'],$row['owner'],$row['is_invoiced'],
                $row['client_invoice'],$row['coupon_quantity'],$row['payable']
                ,$row['campaign_type'],$row['campaign_logo'],$row['coupon_expiry'],$row['coupon_type_id'],
                $row['active'],$row['barcode'],$row['shipping'],$row['client_id']
                ,$row['client_name'],$row['brand'],$row['value'],$row['circulation'],$row['name'],
                $row['expires'],$row['receive_by'],$row['campaign_url'],$row['offer_code'],$row['start_date']
                ,$row['promotion_title'],$row['user'],$row['coupon_type'],$row['supplier_name'],
                $row['dollar_value'],$row['coupon'],$row['status'],$row['first_name'],$row['last_name']
                ,$row['address'],$row['city'],$row['state'],$row['zip'],$row['birth_date'],$row['invoiced_date']
                ,$row['email'],$row['denial_reason_id'],$row['paid_status'],$row['created_at'],$row['updated_at']
            ));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'Report.csv', $headers);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
