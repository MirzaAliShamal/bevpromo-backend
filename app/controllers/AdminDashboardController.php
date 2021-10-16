<?php

class AdminDashboardController extends \BaseController {

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

		return View::make('admin.dashboard')->with('monthlyIrcCount', $monthlyIrcCount)->with('yearlyIrcCount', $yearlyIrcCount)->with('monthlyMirCount', $monthlyMirCount)->with('yearlyMirCount', $yearlyMirCount);
	}

	public function number_format($number)
	{

	}

}