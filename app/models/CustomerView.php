<?php

class CustomerView extends \Eloquent
{
    protected $table = 'customers_view';

    public static function getResultForDt($campaign, $startDate, $endDate, $filters, $draw, $start, $length)
    {
        $data = [];
        $data['draw'] = $draw;
        $limit = $start;
        $offset = $length;
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No Filter
            $count = CustomerView::count();
            $data['data'] = CustomerView::skip($limit)->take($offset)
                ->select('customer_id', 'customer_name', 'dob', 'gender', 'rebate_method', 'company_name', 'phone_num', 'email', 'street_address', 'state', 'created_at','coupon_id')
                ->orderBy('created_at', 'DESC')->get();
            foreach ($data['data'] as $key => $value) {
                $customer_upc_images = CustomerUpcImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_upc_images) > 0) {
                    $arr_image = array();
                    foreach ($customer_upc_images as $key_upc => $value_upc) {
                        array_push($arr_image, $value_upc['image']);
                    }
                    $value->setAttribute('upc_images', $arr_image);
                }
                else {
                    $value->setAttribute('upc_images', 'N/D');
                }
                $customer_rec_images = CustomerReceiptImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_rec_images) > 0) {
                    $rec_image = array();
                    foreach ($customer_rec_images as $key_rec => $value_rec) {
                        array_push($rec_image, $value_upc['image']);
                    }
                    $value->setAttribute('rec_images', $rec_image);
                }
                else {
                    $value->setAttribute('rec_images', 'N/D');
                }
            }
        } else if ($startDate != '' && $endDate != '' && count($filters) == 0) {
            //Just Date Filter
            $count = CustomerView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
            $data['data'] = CustomerView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->skip($limit)->take($offset)
                ->select('customer_id', 'customer_name', 'dob', 'gender', 'rebate_method', 'company_name', 'phone_num', 'email', 'street_address', 'state', 'created_at','coupon_id')
                ->orderBy('created_at', 'DESC')->get();
            foreach ($data['data'] as $key => $value) {
                $customer_upc_images = CustomerUpcImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_upc_images) > 0) {
                    $arr_image = array();
                    foreach ($customer_upc_images as $key_upc => $value_upc) {
                        array_push($arr_image, $value_upc['image']);
                    }
                    $value->setAttribute('upc_images', $arr_image);
                } else {
                    $value->setAttribute('upc_images', 'N/D');
                }
                $customer_rec_images = CustomerReceiptImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_rec_images) > 0) {
                    $rec_image = array();
                    foreach ($customer_rec_images as $key_rec => $value_rec) {
                        array_push($rec_image, $value_upc['image']);
                    }
                    $value->setAttribute('rec_images', $rec_image);
                } else {
                    $value->setAttribute('rec_images', 'N/D');
                }
            }
        } else if ($startDate != '' && $endDate != '' && count($filters) > 0) {
            //Date and Filters both exist
            $countQeury = "SELECT COUNT(*) as total FROM customers_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            $sql = "SELECT customer_id,customer_name,dob,gender,rebate_method,company_name,phone_num,email,street_address,state,created_at,coupon_id FROM customers_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            foreach ($filters as $key => $value) {
                $countQeury .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
            }
            $total = DB::select($countQeury);
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            foreach ($data['data'] as $key => $value) {
                $customer_upc_images = CustomerUpcImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_upc_images) > 0) {
                    $arr_image = array();
                    foreach ($customer_upc_images as $key_upc => $value_upc) {
                        array_push($arr_image, $value_upc['image']);
                    }
                    $data['data'][$key]['upc_images'] = $arr_image;
                } else {
                    $data['data'][$key]['upc_images'] = 'N/D';
                }
                $customer_rec_images = CustomerReceiptImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_rec_images) > 0) {
                    $rec_image = array();
                    foreach ($customer_rec_images as $key_rec => $value_rec) {
                        array_push($rec_image, $value_upc['image']);
                    }
                    $data['data'][$key]['rec_images'] = $rec_image;
                } else {
                    $data['data'][$key]['rec_images'] = 'N/D';
                }
            }
        } else {
            //Just Filters Exist
            $countQeury = "SELECT COUNT(*) as total FROM customers_view WHERE id is NOT NULL ";
            $sql = "SELECT customer_id,customer_name,dob,gender,rebate_method,company_name,phone_num,email,street_address,state,created_at,coupon_id FROM customers_view WHERE id IS NOT NULL ";
            foreach ($filters as $key => $value) {
                $countQeury .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
                $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
            }
            $total = DB::select($countQeury);
            $count = $total[0]->total;
            $sql .= " ORDER BY created_at DESC LIMIT " . $offset . " OFFSET " . $limit . " ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
            foreach ($data['data'] as $key => $value) {
                $customer_upc_images = CustomerUpcImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_upc_images) > 0) {
                    $arr_image = array();
                    foreach ($customer_upc_images as $key_upc => $value_upc) {
                        array_push($arr_image, $value_upc['image']);
                    }
                    $data['data'][$key]['upc_images'] = $arr_image;
                } else {
                    $data['data'][$key]['upc_images'] = 'N/D';
                }
                $customer_rec_images = CustomerReceiptImage::where('customer_id', '=', $value['customer_id'])->get();
                if (count($customer_rec_images) > 0) {
                    $rec_image = array();
                    foreach ($customer_rec_images as $key_rec => $value_rec) {
                        array_push($rec_image, $value_upc['image']);
                    }
                    $data['data'][$key]['rec_images'] = $rec_image;
                } else {
                    $data['data'][$key]['rec_images'] = 'N/D';
                }
            }
        }
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        return $data;
    }

    public static function getResultForExport($startDate, $endDate, $filters)
    {
        $data = [];
        if ($startDate == '' && $endDate == '' && count($filters) == 0) {
            //No Filter
            $data['data'] = CustomerView::orderBy('created_at', 'DESC')->get();
        } else if ($startDate != '' && $endDate != '' && count($filters) == 0) {
            //Just Date Filter
            $data['data'] = CustomerView::where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->orderBy('created_at', 'DESC')->get();
        } else if ($startDate != '' && $endDate != '' && count($filters) > 0) {
            //Date and Filters both exist
            $sql = "SELECT * FROM customers_view WHERE created_at >= '" . $startDate . "' AND created_at <= '" . $endDate . "' ";
            foreach ($filters as $key => $value) {
                $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
            }
            $sql .= " ORDER BY created_at DESC ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
        } else {
            //Just Filters Exist
            $sql = "SELECT * FROM customers_view WHERE id IS NOT NULL ";
            foreach ($filters as $key => $value) {
                $sql .= "AND " . $value['key'] . " LIKE '%" . $value['value'] . "%'";
            }
            $sql .= " ORDER BY created_at DESC ";
            $result = DB::select($sql);
            $resultArray = json_decode(json_encode($result), true);
            $data['data'] = $resultArray;
        }
        return $data;
    }
}
