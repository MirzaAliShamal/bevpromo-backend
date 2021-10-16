<?php

class AdminEntriesIrcController extends \BaseController
{

    public function index()
    {
        return View::make('admin.entries.irc.list');
    }

    public function create()
    {
        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address', 'state')->get();

        $coupons = Coupon::where('active', '=', 1)->where('coupon_type_id', '!=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.entries.irc.create')->with('retailers', $retailers)->with('coupons', $coupons)->with('clearinghouses', $clearinghouses);
    }

    public function store()
    {
        $entryIrc = new EntryIrc;
        $entryIrc->fill(Input::all());
        $entryIrc->save();

        return Redirect::to('/admin/entries/irc-dt');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $entryIrc = EntryIrc::find($id);

        //$entryIrc->created_at = date('m/d/Y', strtotime($entryIrc->created_at));

        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address', 'state')->get();

        $coupons = Coupon::where('active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('admin.entries.irc.edit')->with('entryIrc', $entryIrc)->with('retailers', $retailers)->with('coupons', $coupons)->with('clearinghouses', $clearinghouses);
    }
    public function ajax_add_edit($id)
    {
        $retailers = Retailer::where('is_active', '=', 1)->orderBy('name', 'asc')->select('name', 'id', 'address', 'state')->get();

        $coupons = Coupon::where('active', '=', 1)->orderBy('name', 'asc')->select('name', 'id')->get();

        $clearinghouses = Clearinghouse::orderBy('name', 'asc')->select('name', 'id')->get();

        if ($id == 0) {
            //Create
            $retailers_opt = '';
            foreach ($retailers as $key => $item) {
                if ($item->address != null) {
                    $retailers_opt .= '<option value="' . $item->id . '">' . $item->name . ' ( ' . $item->address . ' ' . $item->state . ')</option>';
                }
            }
            $coupons_opt = '';
            foreach ($coupons as $key => $value) {

                $coupons_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
            }
            $clearinghouse_opt = '';
            foreach ($clearinghouses as $key => $value) {
                $clearinghouse_opt .= '<option value = ' . $value->id . '>' . $value->name . '</option>';
            }
            $html = '<div class="row">
        <div class="col-md-12">
                    <form method="POST" id="addEditIrcForm" enctype="multipart/form-data" role="form" autocomplete="off" class="form-horizontal">
                    <div class="form-body">
                            <div class="form-group">
                                    <label for="retailer_id" class="col-md-3 control-label">Retailer: </label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="retailer_id" name="retailer_id">' . $retailers_opt . '</select>
                                    </div>
                                </div>
                        <div class="form-group">
                            <label for="coupon_id" class="col-md-3 control-label">Program: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="coupon_id" name="coupon_id">' . $coupons_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="coupon_quantity" class="col-md-3 control-label">Quantity: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="coupon_quantity" type="text" id="coupon_quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payable" class="col-md-3 control-label">Payable: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="payable" type="text" id="payable">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shipping" class="col-md-3 control-label">Shipping: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="shipping" type="text" id="shipping">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_invoice" class="col-md-3 control-label">Client Invoice: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="client_invoice" type="text" id="client_invoice">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clearinghouse_id" class="col-md-3 control-label">Clearinghouse: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="clearinghouse_id" name="clearinghouse_id">' . $clearinghouse_opt . '</select>
                            </div>
                        </div>
                    </div>
                    </form>
        </div>
    </div>';
            echo json_encode($html);
        } else {
            //Update
            $entryIrc = EntryIrc::find($id);
            $retailers_opt = '';
            foreach ($retailers as $key => $item) {
                if ($item->id == $entryIrc->retailer_id) {
                    $retailers_opt .= '<option value="' . $item->id . '" selected="selected">' . $item->name . ' ( ' . $item->address . ' ' . $item->state . ' ) </option>';
                } else {
                    $retailers_opt .= '<option value="' . $item->id . '" >' . $item->name . ' ( ' . $item->address . ' )</option>';
                }
            }
            $coupons_opt = '';
            foreach ($coupons as $key => $value) {
                if ($value->id == $entryIrc->coupon_id) {
                    $coupons_opt .= '<option value=' . $value->id . ' selected="selected">' . $value->name . '</option>';
                } else {
                    $coupons_opt .= '<option value=' . $value->id . '>' . $value->name . '</option>';
                }
            }
            $clearinghouse_opt = '';
            foreach ($clearinghouses as $key => $value) {
                if ($value->id == $entryIrc->clearinghouse_id) {
                    $clearinghouse_opt .= '<option value = ' . $value->id . ' selected="selected">' . $value->name . '</option>';
                } else {
                    $clearinghouse_opt .= '<option value = ' . $value->id . '>' . $value->name . '</option>';
                }
            }
            $html = '<div class="row">
        <div class="col-md-12">
                    <form method="POST" id="addEditIrcForm" enctype="multipart/form-data" role="form" autocomplete="off" class="form-horizontal">
                    <input type="hidden" name="id" value=' . $entryIrc->id . '>
                    <div class="form-body">
                            <div class="form-group">
                                    <label for="retailer_id" class="col-md-3 control-label">Retailer: </label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="retailer_id" name="retailer_id">' . $retailers_opt . '</select>
                                    </div>
                                </div>
                        <div class="form-group">
                            <label for="coupon_id" class="col-md-3 control-label">Program: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="coupon_id" name="coupon_id">' . $coupons_opt . '</select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="coupon_quantity" class="col-md-3 control-label">Quantity: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="coupon_quantity" type="text" value="' . $entryIrc->coupon_quantity . '" id="coupon_quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payable" class="col-md-3 control-label">Payable: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="payable" type="text" value="' . $entryIrc->payable . '" id="payable">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shipping" class="col-md-3 control-label">Shipping: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="shipping" type="text" value="' . $entryIrc->shipping . '" id="shipping">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="client_invoice" class="col-md-3 control-label">Client Invoice: </label>
                            <div class="col-md-9">
                                <input class="form-control" name="client_invoice" type="text" value="' . $entryIrc->client_invoice . '" id="client_invoice">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clearinghouse_id" class="col-md-3 control-label">Clearinghouse: </label>
                            <div class="col-md-9">
                                <select class="form-control" id="clearinghouse_id" name="clearinghouse_id">' . $clearinghouse_opt . '</select>
                            </div>
                        </div>
                    </div>
                    </form>
        </div>
    </div>';
            echo json_encode($html);
        }
    }

    public function ajax_store()
    {
        $id = Input::get('id');
        if ($id == '') {
            //Create
            $entryIrc = new EntryIrc;

            $entryIrc->fill(Input::all());
            $entryIrc->save();
            $success = true;
            echo json_encode($success);
        } else {
            //Update
            $entryIrc = EntryIrc::find($id);

            $entryIrc->fill(Input::all());

            //$updatedAt = date('Y-m-d H:i:s', strtotime(Input::get('created_at')));

            //$entryIrc->created_at = $createdAt;

            $entryIrc->save();
            $success = true;
            echo json_encode($success);
        }
    }

    public function update($id)
    {
        $entryIrc = EntryIrc::find($id);

        $entryIrc->fill(Input::all());

        //$updatedAt = date('Y-m-d H:i:s', strtotime(Input::get('created_at')));

        //$entryIrc->created_at = $createdAt;

        $entryIrc->save();

        return Redirect::to('/admin/entries/irc-dt');
    }

    public function delete($id)
    {
        $entryIrc = EntryIrc::find($id);

        $entryIrc->delete();

        return Redirect::to('/admin/entries/irc');
    }
}
