<?php

class AdminCouponMirController extends \BaseController {

    public function index()
    {
        return View::make('admin.coupons.mir.list');
    }

    public function create()
    {
        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        $brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $types = CouponType::where('active', '=', 1)->orderBy('display_order','asc')->lists('name', 'id','display_order');

        return View::make('admin.coupons.mir.create')->with('users', $users)->with('brands', $brands)->with('types', $types);
    }


    public function delete()
    {
        $id = Input::get('id');
        try {
            DB::table('coupons')->where('id', $id)->delete();
            DB::table('entries_mir')->where('coupon_id', $id)->delete();
            $data = array('success' => true);
            echo json_encode($data);
            return;
		} catch (Exception $ex) {
            echo $ex;
            return json_encode(array('success' => false));
		}
    }








    public function store()
    {
        $coupon = new Coupon;

        $coupon->fill(Input::all());

        $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

        $coupon->expires = $expires;

        $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

        $coupon->receive_by = $receiveBy;
        $coupon->campaign_type=1;
        // $coupon->coupon_type_id = 17;
        $coupon->save();

        return Redirect::to('/admin/entries/mir-dt');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->expires = date('m/d/Y', strtotime($coupon->expires));

        $coupon->receive_by = date('m/d/Y', strtotime($coupon->receive_by));

        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        $brands = Brand::where('mir_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $types = CouponType::where('active', '=', 1)->lists('name', 'id');

        return View::make('admin.coupons.mir.edit')->with('coupon', $coupon)->with('users', $users)->with('brands', $brands)->with('types', $types);;
    }

    public function update($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->fill(Input::all());

        $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

        $coupon->expires = $expires;

        $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

        $coupon->receive_by = $receiveBy;

        $coupon->save();

        return Redirect::to('/admin/coupons/mir');
    }

    public function destroy($id)
    {
        //
    }

}