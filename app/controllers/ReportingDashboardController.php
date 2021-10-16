<?php

class ReportingDashboardController extends \BaseController {

	public function index()
	{
		$userId = Auth::user()->id;

		$userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');

		//get irc current month count
		$monthlyIrcCount = EntryIrc::where( DB::raw('MONTH(created_at)'), '=', date('n') )->whereIn('coupon_id', $userCoupons)->sum('coupon_quantity');
		$monthlyIrcCount = number_format($monthlyIrcCount);

		//get irc current year count
		$yearlyIrcCount = EntryIrc::where( DB::raw('YEAR(created_at)'), '=', date('Y') )->whereIn('coupon_id', $userCoupons)->sum('coupon_quantity');
		$yearlyIrcCount = number_format($yearlyIrcCount);

		//get mir current month count
		$monthlyMirCount = EntryMir::where( DB::raw('MONTH(created_at)'), '=', date('n') )->whereIn('coupon_id', $userCoupons)->count();
		$monthlyMirCount = number_format($monthlyMirCount);

		//get mir current year count
		$yearlyMirCount = EntryMir::where( DB::raw('YEAR(created_at)'), '=', date('Y') )->whereIn('coupon_id', $userCoupons)->count();
		$yearlyMirCount = number_format($yearlyMirCount);

		return View::make('reporting.dashboard')->with('monthlyIrcCount', $monthlyIrcCount)->with('yearlyIrcCount', $yearlyIrcCount)->with('monthlyMirCount', $monthlyMirCount)->with('yearlyMirCount', $yearlyMirCount);
	}

	public function number_format($number)
	{

	}

}