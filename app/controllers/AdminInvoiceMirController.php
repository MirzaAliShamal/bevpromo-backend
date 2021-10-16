<?php

class AdminInvoiceMirController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admininvoicemir
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admininvoicemir/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admininvoicemir
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /admininvoicemir/{id}
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
	 * GET /admininvoicemir/{id}/edit
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
	 * PUT /admininvoicemir/{id}
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
	 * DELETE /admininvoicemir/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function invoice_all()
	{
		return View::make('admin.invoices.mir.invoice_all');
	}

	public function invoice_save()
	{
		DB::update(DB::raw('UPDATE entries_mir SET invoiced_date = NOW(), mir_status_id = 5 WHERE mir_status_id = 1'));

		return Redirect::to('/admin/entries/mir');
	}

}