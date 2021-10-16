<?php

class AdminEntriesMirDtController extends \BaseController
{

    public function index()
    {
        return View::make('admin.entries.mir-dt.list');
    }

    public function updateEntry(){
        $value = Input::get('checked');
        if($value == 'true') {
            $val = 1;
        }
        if($value == 'false'){
            $val = 0;
        }
        $data = EntryMir::where('id','=',Input::get('id'))->update([
            'active'=> $val
        ]);

        echo json_encode($data);
    }

    public function updateFullPageCheckbox(){
        $value = Input::get('array');
        $valueCheck = Input::get('value');
        $value = json_decode($value);
        foreach ($value as $k => $item) {
            EntryMir::where('id', '=', $item->id)->update([
                'active' => $valueCheck
            ]);
        }
        echo json_encode(true);
    }

    public function updateSStatus(){
        $value = Input::get('array');
        $valueCheck = Input::get('value');
        $value = json_decode($value);
        foreach ($value as $k => $item) {
            EntryMir::where('id', '=', $item->id)->update([
                'mir_status_id' => $valueCheck,
                'active' => 0
            ]);
        }
        echo json_encode(true);
    }
    public function getCheckedData(){
        $data = EntryMir::where('active', '=', 1)->get();
        echo json_encode($data);
    }

    public function updatePStatus(){
        $value = Input::get('array');
        $valueCheck = Input::get('value');
        $value = json_decode($value);
        foreach ($value as $k => $item) {
            EntryMir::where('id', '=', $item->id)->update([
                'paid_status' => $valueCheck,
                'active' => 0
            ]);
        }
        echo json_encode(true);
    }

    public function data()
    {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = Input::get('filters');
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');
        $data = EntryMirView::getResultForDt($startDate,$endDate,$filters,$draw,$start,$length);
        echo json_encode($data);
    }

    public function exportCsv()
    {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = EntryMirView::all();
        } else {
            //Apply Filters
            //Case1: Date Exisit only
            if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                $table = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            }
            //Case2: Filters Exist only
            else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                $sql = "SELECT * FROM entries_mir_view WHERE id is not null";
                foreach ($filters as $key => $value) {
                    $sql .= " AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            //Case3: Date and Filters Both Exisit
            else {
                $sql = "SELECT * FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                foreach ($filters as $key => $value) {
                    $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
        }
        $filename = "MirEntries.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('id','dollar_value','retailer','owner','coupon','first_name','last_name','address','city','state','zip','status','birth_date','invoiced_date','denial_reason_id','created_at'));
        foreach ($table as $row) {
            fputcsv($handle, array($row['id'],$row['dollar_value'], $row['retailer'],$row['owner'], $row['coupon'], $row['first_name'], $row['last_name'], $row['address'], $row['city'], $row['state'], $row['zip'], $row['status'], $row['birth_date'],$row['invoiced_date'],$row['denial_reason_id'],$row['created_at']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'MirEntries.csv', $headers);
    }

    public function exportJson() {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = EntryMirView::all();
        } else {
            //Apply Filters
            //Case1: Date Exisit only
            if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                $table = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            }
            //Case2: Filters Exist only
            else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                $sql = "SELECT * FROM entries_mir_view WHERE id is not null";
                foreach ($filters as $key => $value) {
                    $sql .= " AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            //Case3: Date and Filters Both Exisit
            else {
                $sql = "SELECT * FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                foreach ($filters as $key => $value) {
                    $sql .= "AND " . $value->key  . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
        }
        $filename = "MirEntries.json";
        $handle = fopen($filename, 'w+');
        $json_data = json_encode($table);
        file_put_contents($filename, $json_data);
        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/json',
        );
        return Response::download($filename, 'MirEntries.json', $headers);
    }

    public function exportPdf() 
    {
        $startDate = Input::get('startDate');
        $endDate = Input::get('endDate');
        $filters = json_decode(Input::get('filters'));
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No filters
            $table = EntryMirView::all();
        } else {
            //Apply Filters
            //Case1: Date Exisit only
            if ($startDate != '' && $endDate != '' && count($filters) == 0) {
                $table = EntryMirView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            }
            //Case2: Filters Exist only
            else if ($startDate == '' && $endDate == '' && count($filters) > 0) {
                $sql = "SELECT * FROM entries_mir_view WHERE id is not null";
                foreach ($filters as $key => $value) {
                    $sql .= " AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
            //Case3: Date and Filters Both Exisit
            else {
                $sql = "SELECT * FROM entries_mir_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
                foreach ($filters as $key => $value) {
                    $sql .= "AND " . $value->key . " LIKE '%" . $value->value . "%'";
                }
                $result = DB::select($sql);
                $resultArray = json_decode(json_encode($result), true);
                $table = $resultArray;
            }
        }
        $html = '';
            $html .= '<html lang="en">';
            $html .= '<body>';
            $html .= '<table>';
            $html .= '<thead>';
            $html .= '<tr><th>ID</th><th></th>dollar_value<th>Retailer</th><th>owner</th><th>Coupon</th><th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Status</th><th>birth_date</th><th>invoiced_date</th><th>denial_reason_id</th><th>Created</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($table as $key => $value) {
                $html .= "<tr>";
                $html .= "<td>" . $value['id'] ."</td>";
                $html .= "<td>" . $value['dollar_value'] ."</td>";
                $html .= "<td>" . $value['retailer'] ."</td>";
                $html .= "<td>" . $value['owner'] ."</td>";
                $html .= "<td>" . $value['coupon'] ."</td>";
                $html .= "<td>" . $value['first_name'] ."</td>";
                $html .= "<td>" . $value['last_name'] ."</td>";
                $html .= "<td>" . $value['address'] ."</td>";
                $html .= "<td>" . $value['city'] ."</td>";
                $html .= "<td>" . $value['state'] ."</td>";
                $html .= "<td>" . $value['zip'] ."</td>";
                $html .= "<td>" . $value['status'] ."</td>";
                $html .= "<td>" . $value['birth_date'] ."</td>";
                $html .= "<td>" . $value['invoiced_date'] ."</td>";
                $html .= "<td>" . $value['denial_reason_id'] ."</td>";
                $html .= "<td>" . $value['created_at'] ."</td>";
                $html .= "</tr>";
            }
            $html .= '</tbody></table></body></html>';
            $pdf = PDF::loadHTML($html);
            return $pdf->download('MirData.pdf');
    }
    public function create()
    {

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $coupons = Coupon::where('active', '=', '1')->where('coupon_type_id', '=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $mirStatuses = MirStatus::lists('name', 'id');

        $mirDenialReasons = MirDenialReason::orderBy('name')->lists('name', 'id');

        $mirConstants = Constant::$compains;
        return View::make('admin.entries.mir.create')->with('mirConstants', $mirConstants)->with('retailers', $retailers)->with('coupons', $coupons)->with('mirStatuses', $mirStatuses)->with('mirDenialReasons', $mirDenialReasons);
    }

    public function store()
    {
        $entryMir = new EntryMir;

        $entryMir->fill(Input::all());

        $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));

        $arr = Constant::$programs[$entryMir->program_type];

        $entryMir->program_type = $arr;

        $entryMir->birth_date = $birthDate;

        $entryMir->save();

        return Redirect::to('/admin/entries/mir');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->birth_date = date('m/d/Y', strtotime($entryMir->birth_date));

        $retailers = MirRetailer::where('is_active', '=', 1)->orderBy('name', 'asc')->lists('name', 'id');

        $coupons = Coupon::where('active', '=', '1')->where('coupon_type_id', '=', '17')->orderBy('name', 'asc')->lists('name', 'id');

        $mirStatuses = MirStatus::lists('name', 'id');

        $mirDenialReasons = MirDenialReason::orderBy('name')->lists('name', 'id');

        $mirConstants = Constant::$programs;

        return View::make('admin.entries.mir.edit')->with('program_type', $entryMir->program_type)->with('mirConstants', $mirConstants)->with('entryMir', $entryMir)->with('retailers', $retailers)->with('coupons', $coupons)->with('mirStatuses', $mirStatuses)->with('mirDenialReasons', $mirDenialReasons);
    }

    public function update($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->fill(Input::all());

        $arr = Constant::$programs[$entryMir->program_type];

        $entryMir->program_type = $arr;

        $birthDate = date('Y-m-d H:i:s', strtotime(Input::get('birth_date')));

        $entryMir->birth_date = $birthDate;

        $entryMir->save();

        return Redirect::to('/admin/entries/mir');
    }

    public function destroy($id)
    {
        //
    }

    public function invoice_all()
    {
        DB::update(DB::raw('UPDATE entries_mir SET mir_status_id = 5, invoiced_date = now() WHERE mir_status_id = 1'));

        return Redirect::to('/admin/entries/mir');
    }

    public function delete($id)
    {
        $entryMir = EntryMir::find($id);

        $entryMir->delete();

        return Redirect::to('/admin/entries/mir');
    }
}