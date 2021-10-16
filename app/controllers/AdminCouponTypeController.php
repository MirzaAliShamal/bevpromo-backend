<?php

class AdminCouponTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.coupons.couponType');
	}

	public function reorders(){
	    $coupons = Coupon::where('active','=',1)->get();
        return View::make('admin.coupons.reorders.index',[
            'coupons' => $coupons
        ]);
    }

	public function getCoupons(){
	    $coupons = Coupon::where('active','=',1);
        $data['recordsTotal'] = $coupons->count();
        $data['recordsFiltered'] = $coupons->count();
        $data['data'] = $coupons->get();
        echo json_encode($data);
    }

	public function reorderCoupons(){
        $couponsCount = CouponType::where('active','=',1)->count();
        $coupons = CouponType::where('active','=',1)->whereNull('display_order')->get();
        if($couponsCount == count($coupons)) {
            $coupons = CouponType::where('active','=',1)->orderBy('name')->get();
        } else {
            $coupons = CouponType::where('active','=',1)->orderBy('display_order')->get();
        }
        return View::make('admin.coupons.reorders.reorder',[
            'coupons' => $coupons
        ]);
    }

	public function saveReorderList(){
        $couponsOrdersList = Input::get('coupons');
        $i = 0;
        foreach ($couponsOrdersList as $list) {
            CouponType::where('id', '=', $list)->update([
                'display_order' => $i
            ]);
            $i++;
        }
        return Redirect::to('/admin/reorder/coupon/types');
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        
        return View::make('admin.coupons.createCouponType')->with('users', $users);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$couponType = new CouponType;
        $couponType->fill(Input::all());
        
        $couponType->save();
        
        return Redirect::to('/admin/coupons/types');
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
		$couponType = CouponType::findOrFail($id);
		$users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');
        return View::make('admin.coupons.editCouponType')->with('couponType', $couponType)->with('users', $users);
		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$couponType = CouponType::findOrFail($id);

        $couponType->fill(Input::all());
		
		$couponType->save();
        return Redirect::to('/admin/coupons/types');
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