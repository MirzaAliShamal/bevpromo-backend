<?php

class AdminInvoiceIrcController extends \BaseController {

	public function index()
	{
        return View::make('admin.invoices.irc.list');
	}

	public function create()
	{
        $coupons = Coupon::where('invoice_id', '=', 0)->lists('name', 'id');

        $user = User::where('role_id', '=', 2)->lists('email');

        $statuses = InvoiceStatus::lists('name', 'id');

        return View::make('admin.invoices.irc.create')
            ->with('coupons', $coupons)
            ->with('statuses', $statuses)
            ->with('user', $user);
    }

	public function store()
	{
        $invoiceIrc = new InvoiceIrc;

        $invoiceIrc->fill(Input::all());

        $invoiceIrc->save();

        $insertedId = $invoiceIrc->id;

        $couponIds = Input::get('coupons');

        $coupons = Coupon::find($couponIds);

        foreach ($coupons as $coupon)

        {
            $invoice = InvoiceIrc::find($insertedId);

            $coupon->invoiceIrc()->associate($invoice);

            $coupon->save();
        }

        return Redirect::to('/admin/invoices/irc');
	}

	public function show($id)
	{
        $invoiceIrc = InvoiceIrc::find($id);

        $user = InvoiceIrc::find($id)->user;

        $supplierId = $user->supplier_id;

        $supplier = Supplier::find($supplierId);

        $statusId = $invoiceIrc->invoice_status_id;

        $status = InvoiceStatus::find($statusId);

        $coupons = InvoiceIrc::find($id)->coupons;


        $quantityEntered = '';

        return View::make('admin.invoices.irc.show')
            ->with('invoiceIrc', $invoiceIrc)
            ->with('user', $user)
            ->with('supplier', $supplier)
            ->with('status', $status)
            ->with('coupons', $coupons);
	}

	public function edit($id)
	{
        $invoiceIrc = InvoiceIrc::find($id);

        $statuses = InvoiceStatus::lists('name', 'id');

        $coupons = Coupon::whereIn('invoice_id', [0, $id])
            ->lists('name', 'id');

        $associatedCoupons = Coupon::where('invoice_id', '=', $id)->lists('id');

        $user = User::where('role_id', '=', 2)->lists('email', 'id');

        return View::make('admin.invoices.irc.edit')
            ->with('invoiceIrc', $invoiceIrc)
            ->with('statuses', $statuses)
            ->with('coupons', $coupons)
            ->with('associatedCoupons', $associatedCoupons)
            ->with('user', $user);

    }

	public function update($id)
	{
        $invoiceIrc = InvoiceIrc::find($id);

        $invoiceIrc->fill(Input::all());

        $invoiceIrc->save();

        $beforeCoupons = Coupon::where('invoice_id', '=', $id)->lists('id');

        if (Input::get('coupons'))
        {
            $afterCoupons = Input::get('coupons');
        }
        else
        {
            $afterCoupons = [];
        }

        $removeCoupons = array_diff($beforeCoupons, $afterCoupons);

        $addCoupons = array_diff($afterCoupons, $beforeCoupons);

        foreach ($removeCoupons as $removeCoupon)
        {
                Coupon::where('invoice_id', '=', $removeCoupon)->update(array('invoice_id' => 0));
        }

        foreach ($addCoupons as $addCoupon)
        {
            $coupon = Coupon::find($addCoupon);

            $invoice = InvoiceIrc::find($id);

            $coupon->invoiceIrc()->associate($invoice);

            $coupon->save();
        }

        return Redirect::to('/admin/invoices/irc');
	}

	public function destroy($id)
	{
		//
	}

    public function invoice_all()
    {
        return View::make('admin.invoices.irc.invoice_all');
    }

    public function invoice_save()
    {
        DB::update(DB::raw('UPDATE entries_irc SET is_invoiced = 1 WHERE is_invoiced = 0'));

        return Redirect::to('/admin/entries/irc');
    }

}