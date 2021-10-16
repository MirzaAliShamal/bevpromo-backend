<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class AdminCouponIrcController extends \BaseController {

    public function index()
    {
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.coupons.irc.list')->with('inline',$inline);
    }

    public function create()
    {
        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        $brands = Brand::where('irc_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $types = CouponType::where('active', '=', 1)->orderBy('display_order','asc')->lists('name', 'id','display_order');
        if(isset($_GET['inline'])) {
            $inline = $_GET['inline'];
        }
        else {
            $inline = null;
        }
        return View::make('admin.coupons.irc.create')->with('users', $users)->with('brands', $brands)->with('types', $types)->with('inline',$inline);
    }

    public function store()
    {
        $coupon = new Coupon;

        $coupon->fill(Input::all());

        $expires = date('Y-m-d H:i:s', strtotime(Input::get('expires')));

        $coupon->expires = $expires;

        $receiveBy = date('Y-m-d H:i:s', strtotime(Input::get('receive_by')));

        $coupon->receive_by = $receiveBy;
        $coupon->campaign_type=2;
        $coupon->save();
        $inline = Input::get('inline');
        return Redirect::to('/admin/coupons/irc?inline='.$inline);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        //echo '<pre>'; print_r($coupon); exit;
        

        $coupon->expires = date('m/d/Y', strtotime($coupon->expires));

        $coupon->receive_by = date('m/d/Y', strtotime($coupon->receive_by));

        $users = User::where('active', '=', 1)->orderBy('email', 'asc')->lists('email', 'id');

        $brands = Brand::where('irc_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $types = CouponType::where('active', '=', 1)->lists('name', 'id');

        return View::make('admin.coupons.irc.edit')->with('coupon', $coupon)->with('users', $users)->with('brands', $brands)->with('types', $types);
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

        return Redirect::to('/admin/coupons/irc');
    }
   // use SoftDeletingTrait;
    public function destroy($id)
    {
        //echo '<pre>'; print_r($id); exit;
        
    
    
    }

    public function delete()
    {
        $id = Input::get('id');
        try {
            DB::table('coupons')->where('id', $id)->delete();
            DB::table('entries_irc')->where('coupon_id', $id)->delete();
            $data = array('success' => true);
            echo json_encode($data);
            return;
		} catch (Exception $ex) {
            echo $ex;
            return json_encode(array('success' => false));
		}
    }

}