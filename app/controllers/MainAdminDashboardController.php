<?php

class MainAdminDashboardController extends \BaseController {


    public function mirStatus(){
        return View::make('admin.mirStatus.index');
    }
    public function mirStatusAdd(){
        return View::make('admin.mirStatus.create');
    }
    public function mirStatusStore(){
        MirStatus::create([
            'name' => Input::get('name'),
            'active' => Input::get('active')
        ]);
        return Redirect::to('/admin/mir/status');
    }
    public function mirStatusEdit($id){
        $status = MirStatus::where('id','=',$id)->first();
        return View::make('admin.mirStatus.edit',[
            'status' => $status
        ]);
    }
    public function mirStatusUpdate($id){
       MirStatus::where('id','=',$id)->update([
           'name' => Input::get('name'),
           'active' => Input::get('active')
       ]);
        return Redirect::to('/admin/mir/status');
    }

    public function denailReasons(){
        return View::make('admin.denial.index');
    }

    public function denailReasonCreate(){
        return View::make('admin.denial.create');
    }

    public function denailReasonStore(){
        MirDenialReason::create([
            'name' => Input::get('name'),
            'active' => Input::get('active'),
        ]);
        return Redirect::to('/admin/denial/reasons');
    }
    public function denailReasonsUpdate($id){
        MirDenialReason::where('id','=',$id)->update([
            'name' => Input::get('name'),
            'active' => Input::get('active'),
        ]);
        return Redirect::to('/admin/denial/reasons');
    }
    public function denailReasonsEdit($id){
        $data = MirDenialReason::where('id','=',$id)->first();
        return View::make('admin.denial.edit',[
           'data' => $data
        ]);
    }

	/**
	 * Display a listing of the resource.
	 * GET /admindashboard
	 *
	 * @return Response
	 */
	public function index()
	{
        //get irc current month count
		$monthlyIrcCount = EntryIrc::where( DB::raw('MONTH(created_at)'), '=', date('n') )->sum('coupon_quantity');
		$monthlyIrcCount = number_format($monthlyIrcCount);

		//get irc current year count
		$yearlyIrcCount = EntryIrc::where( DB::raw('YEAR(created_at)'), '=', date('Y') )->sum('coupon_quantity');
		$yearlyIrcCount = number_format($yearlyIrcCount);

		//get mir current month count
		$monthlyMirCount = EntryMir::where( DB::raw('MONTH(created_at)'), '=', date('n') )->count();
		$monthlyMirCount = number_format($monthlyMirCount);

		//get mir current year count
		$yearlyMirCount = EntryMir::where( DB::raw('YEAR(created_at)'), '=', date('Y') )->count();
		$yearlyMirCount = number_format($yearlyMirCount);

		return View::make('admin.dashboard1')->with('monthlyIrcCount', $monthlyIrcCount)->with('yearlyIrcCount', $yearlyIrcCount)->with('monthlyMirCount', $monthlyMirCount)->with('yearlyMirCount', $yearlyMirCount);
	}

	public function number_format($number)
	{

	}

}