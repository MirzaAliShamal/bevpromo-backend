<?php

class AdminEntriesIrc10Controller extends \BaseController {

    public function index()
    {
        return View::make('admin.entries.irc.list10');
    }

    public function create()
    {
        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $coupons = Coupon::where('active', '=', 1)->where('coupon_type_id', '!=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.entries.irc.create10')->with('retailers', $retailers)->with('coupons', $coupons)->with('clearinghouses', $clearinghouses);
    }

    public function store()
    {
        $entryIrc = new EntryIrc;

        $entryIrc->fill(Input::all());

        $entryIrc->save();

        return Redirect::to('/admin/entries/irc10');
    }
}