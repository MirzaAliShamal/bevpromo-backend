<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', function()
{
    
    if (Auth::guest())
    {
        return Redirect::to('/login');
    }
    else {
        $id = Auth::id();

        $user = User::find($id);

        if ($user->hasRole(1)) {
            //return Redirect::to('/admin/dashboard');
            return Redirect::to('/admin/dashboard');
        } else if ($user->hasRole(2)) {
            return Redirect::to('/reporting/dashboard');
        }
    }
});

Route::resource('login', 'LoginController', array('only' => array('index', 'create', 'store', 'destroy')));

Route::get('logout', 'LoginController@destroy');

Route::get('reset/{id}', 'LoginController@resetPassword');

Route::post('/reset/{id}', array('as' => 'reset', 'uses' => 'LoginController@updatePassword'));

Route::get('/api/payments', 'ApiPaymentsController@store');

Route::get('/lookup', 'LookupController@search');

Route::post('/lookup/list', ['as' => 'lookup.list', 'uses'=> 'LookupController@postList']);

Route::get('/lookup/list', 'LookupController@getList');

Route::group(array('before' => 'admin'), function()
{
    Route::group(['prefix' => 'admin'], function()
    {
        Route::get('/migrations/alterCouponTable','AdminDbScriptController@runaltertable');
        Route::get('/migrations/createCouponView','AdminDbScriptController@create_coupon_view');
        Route::get('/migrations/recreateEtreisViews','AdminDbScriptController@recreate_etreis_views');
        //This is pending to be applied on Server
        Route::get('/migrations/alterCoupnForCustUrl','AdminDbScriptController@alter_coupon_table_cust_url');
        Route::get('/migrations/alterCoupon','AdminDbScriptController@alter_coupon');
        Route::get('/migrations/createCustomer','AdminDbScriptController@create_customer');
        Route::get('/migrations/createCustomerUpcImg','AdminDbScriptController@create_customer_ups_img');
        Route::get('/migrations/createCustomerRecImg','AdminDbScriptController@create_customer_rec_img');
        Route::get('/migrations/updateCustomer','AdminDbScriptController@update_customer');
        Route::get('/migrations/createCustomerView','AdminDbScriptController@create_customer_view');
        Route::get('/migrations/alterCustomerForPaupal','AdminDbScriptController@alter_customer_for_paypal');
        Route::get('/migrations/alterEntriesMirViewForFilter', 'AdminDbScriptController@alter_entries_mir_for_filter');
        Route::get('/migrations/alterTablesCouponCouponType', 'AdminDbScriptController@alter_tables_coupon_coupon_type');
        //End
        Route::get('/settings','AdminSettingsController@index');
        Route::post('/submit/form','AdminSettingsController@store');
        Route::post('/state/form',array('as' => 'admin.stateValidState', 'uses' => 'AdminSettingsController@statestore'));
        //Route::get('dashboard','AdminDashboardController@index');
        Route::get('dashboard','MainAdminDashboardController@index');
        Route::get('denial/reasons','MainAdminDashboardController@denailReasons');
        Route::get('mir/status','MainAdminDashboardController@mirStatus');
        Route::get('mir/status/add','MainAdminDashboardController@mirStatusAdd');
        Route::post('mir/status/store','MainAdminDashboardController@mirStatusStore');
        Route::get('edit/mir/status/{id}','MainAdminDashboardController@mirStatusEdit');
        Route::post('mir/status/update/{id}','MainAdminDashboardController@mirStatusUpdate');
        Route::get('denial/reasons/create','MainAdminDashboardController@denailReasonCreate');
        Route::post('denial/reasons/store','MainAdminDashboardController@denailReasonStore');
        Route::get('denial/reasons','MainAdminDashboardController@denailReasons');
        Route::get('edit/denial/reasons/{id}','MainAdminDashboardController@denailReasonsEdit');
        Route::post('denial/reasons/update/{id}','MainAdminDashboardController@denailReasonsUpdate');
        Route::get('entries/irc/{id}/ajax-add-edit', 'AdminEntriesIrcController@ajax_add_edit');
        Route::post('entries/irc/ajax-store','AdminEntriesIrcController@ajax_store');
        Route::resource('entries/irc',      'AdminEntriesIrcController');
        Route::resource('entries/irc-dt', 'AdminEntriesIrcDtController');
        Route::post('entries/irc-dt/delete','AdminEntriesIrcDtController@deleteRow');

        
        
        Route::get('entries/mir/details/{id}', 'AdminEntriesAllController@details');
        Route::get('entries/campaigns','AdminManageCampaignsController@index');
        Route::post('entries/campaigns/data','AdminManageCampaignsController@data');
        Route::post('entries/campaigns/export-csv','AdminManageCampaignsController@export_csv');
        Route::post('entries/campaigns/export-json','AdminManageCampaignsController@export_json');
        Route::post('entries/campaigns/export-pdf','AdminManageCampaignsController@export_pdf');
        Route::post('entries/irc-data','AdminEntriesIrcDtController@data');
        Route::post('entries/export-irc-csv','AdminEntriesIrcDtController@exportCsv');
        Route::post('report/export-irc-csv','ReportController@exportCsv');
        Route::post('entries/export-irc-json','AdminEntriesIrcDtController@exportJson');
        Route::post('entries/export-irc-pdf','AdminEntriesIrcDtController@exportPdf');
        Route::resource('entries/all', 'AdminEntriesAllController');
        Route::resource('entries/payment', 'AdminEntriesAllController@payment');
        Route::post('entries/data','AdminEntriesAllController@data');
        Route::post('all-coupons-opt','AdminEntriesAllController@coupons');
        Route::post('entries-all/export-csv','AdminEntriesAllController@exportCsv');
        Route::post('entries-all/export-json','AdminEntriesAllController@exportJson');
        Route::post('entries-all/export-pdf','AdminEntriesAllController@exportPdf');

        //10 record hack
        Route::resource('entries/irc10',      'AdminEntriesIrc10Controller');
        Route::get('entries/irc/{id}/delete', 'AdminEntriesIrcController@delete');
        Route::get('entries/mir/{id}/delete', 'AdminEntriesMirController@delete');
        Route::get('invoice/irc/invoice_all', 'AdminInvoiceIrcController@invoice_all');
        Route::get('invoice/irc/invoice_save', 'AdminInvoiceIrcController@invoice_save');
        Route::get('invoice/mir/invoice_all', 'AdminInvoiceMirController@invoice_all');
        Route::get('invoice/mir/invoice_save', 'AdminInvoiceMirController@invoice_save');
        Route::get('entries/mir/{id}/ajax-add-edit', 'AdminEntriesMirController@ajax_add_edit');
        Route::post('entries/mir/ajax-store','AdminEntriesMirController@ajax_store');
        Route::post('entries/mir/add/denial-reason','AdminEntriesMirController@addDenial');
        Route::resource('entries/mir',      'AdminEntriesMirController');
        Route::resource('entries/mir-dt','AdminEntriesMirDtController');
        Route::get('update/entry','AdminEntriesMirDtController@updateEntry');
        Route::post('update/full/page/checkbox','AdminEntriesMirDtController@updateFullPageCheckbox');
        Route::post('simple/status/update','AdminEntriesMirDtController@updateSStatus');
        Route::post('paid/status/update','AdminEntriesMirDtController@updatePStatus');
        Route::get('get/checked/data','AdminEntriesMirDtController@getCheckedData');
        Route::post('entries/mir-data','AdminEntriesMirDtController@data');
        Route::post('entries/export-mir-csv','AdminEntriesMirDtController@exportCsv');
        Route::post('entries/export-mir-json','AdminEntriesMirDtController@exportJson');
        Route::post('entries/export-mir-pdf','AdminEntriesMirDtController@exportPdf');
        Route::get('invoice_mir',           'AdminEntriesMirController@invoice_all');
        Route::resource('invoices/irc',     'AdminInvoiceIrcController');
        Route::resource('invoices/mir',     'AdminInvoiceMirController');
        Route::resource('coupons/irc',      'AdminCouponIrcController');
        Route::resource('coupons/mir',      'AdminCouponMirController');
        Route::resource('coupons/types',    'AdminCouponTypeController');
        Route::get('get/coupons',    'AdminCouponTypeController@getCoupons');
        Route::get('reorder/coupon/types',    'AdminCouponTypeController@reorderCoupons');
        Route::post('save/reorderList',    'AdminCouponTypeController@saveReorderList');
        Route::resource('coupons/all',      'AdminCouponAllController');
        Route::resource('coupons/default-faq',      'AdminCouponDefaultFaqController');
        Route::resource('coupons/default-text',      'AdminCouponDefaultTextController');
        //Route::get('/coupons/irc/{id}', 'AdminCouponIrcController@destroy');
        //Route::delete('coupons/irc/{id}','AdminCouponIrcController@destroy');
        Route::post('coupons/irc/delete','AdminCouponIrcController@delete');
        Route::post('coupons/mir/delete','AdminCouponMirController@delete');
        Route::get('coupons/{id}/ajax-add-edit','AdminCouponAllController@ajax_add_edit');
        Route::post('coupons/ajax-store','AdminCouponAllController@ajax_store');
        Route::post('coupons/upload-dmir-logo', 'AdminCouponAllController@upload_dmir_logo');
        Route::post('coupons/delete-dmir-logo', 'AdminCouponAllController@delete_dmir_logo');
        Route::post('coupons/upload-favicon', 'AdminCouponAllController@upload_favicon');
        Route::post('/upc-upload', 'AdminCouponAllController@upload_upc');
        Route::get('/get/upc/images','AdminEntriesMirController@getUpcImages');
        Route::post('/rec-upload', 'AdminCouponAllController@upload_rec');
        Route::post('delete-upc-image', 'AdminCouponAllController@delete_upc');
        Route::post('delete-rec-image', 'AdminCouponAllController@delete_rec');
        Route::post('coupons/delete-favicon', 'AdminCouponAllController@delete_favicon');
        Route::post('coupons/upload-sweep-image', 'AdminCouponAllController@upload_sweep_image');
        Route::post('coupons/delete-sweep-image', 'AdminCouponAllController@delete_sweep_image');
        Route::post('coupons/ajax-edit','AdminCouponAllController@ajax_edit_save');
        Route::post('coupons/data','AdminCouponAllController@data');
        Route::post('coupons/get_code_generator_page','AdminCouponAllController@get_code_generator_page');
        Route::post('coupons/generate_random_codes','AdminCouponAllController@generate_random_codes');
        Route::post('coupons/upload_csv/{id}','AdminCouponAllController@upload_csv');
        Route::post('coupons/export_generated_code/export-csv','AdminCouponAllController@export_generated_code_to_csv');
        Route::post('coupons/download_exported_code_file','AdminCouponAllController@download_exported_code_file');
        Route::post('coupons/get_code_configuration_page','AdminCouponAllController@get_code_configuration_page');
        Route::post('coupons/save_code_configuration','AdminCouponAllController@save_code_configuration');
        Route::post('coupons/delete_code_reason','AdminCouponAllController@delete_code_reason');
        Route::resource('brands',           'AdminBrandsController');
        Route::resource('suppliers',        'AdminSuppliersController');
        Route::resource('clearinghouses',   'AdminClearinghousesController');
        Route::resource('retailers/irc',    'AdminRetailersIrcController');
        Route::resource('retailers/mir',    'AdminRetailersMirController');
        Route::resource('clients',          'AdminClientsController');
        Route::resource('admins',           'AdminAdminsController');
        // SWEEPS TAKES
        Route::get('imageuploader',    'AdminAdminsController@imageuploader');
        Route::get('/updatebrand','AdminBrandsController@UpdateBrands');
        Route::get('/updateowner','AdminAdminsController@UpdateOwner');
        Route::get('/update/entries/retailer','AdminAdminsController@updateEntriesRetailer');
        Route::get('/update/entries/irc','AdminAdminsController@updateEntriesIRC');
        Route::get('/update/entries/irc/program','AdminAdminsController@updateProgram');
        Route::get('/update/entries/irc/clearning','AdminAdminsController@updateClearning');
        Route::get('/update/entries/mri/coupon','AdminAdminsController@updateMriCoupon');
        Route::get('/updateSupplier','AdminAdminsController@updateSupplier');
        Route::get('/update/dmir/danial/reasons','AdminAdminsController@updatedanialReasons');

        //report
        Route::get('/report-builder','ReportController@index');
        Route::post('/report-builder/search','ReportController@searchData');
        Route::post('/report-builder/save/search','ReportController@saveSearch');
        Route::post('/delete/save/search','ReportController@deleteSearch');
        Route::get('/report-builder/get/searchData','ReportController@getSaveSearch');
        Route::get('/report-builder/delete/filter/{id}','ReportController@deleteFilter');


        /* Route::post('imageUploaderStore', array('as' => 'admin.imageuploaderStore', 'uses' => 'AdminAdminsController@imageUploaderStore')); */

        Route::post('/delete/image','AdminCouponAllController@deleteImage');
       
    });
});
Route::group(array('before' => 'client'), function()
{
    Route::group(['prefix' => 'reporting'], function()
    {
        Route::get('dashboard',               	'ReportingDashboardController@index');
        Route::get('entries/irc',        		'ReportingEntryIrcController@index');
		Route::get('entries/irc/by_retailer', 	'ReportingEntryIrcByRetailerController@index');
        Route::resource('entries/mir',        	'ReportingEntryMirController');
        //Route::resource('invoices/irc',      'ReportingInvoiceIrcController');
        //Route::resource('invoices/mir',      'ReportingInvoiceMirController');
    });
});

Route::get('test', function()
{
    return View::make('layouts.test');
});

Route::get('/api/test', function()
{
    $ircEntries = DB::table('entries_irc_view')
        ->select('program', DB::raw('SUM(coupon_quantity) AS coupon_quantity'))
        ->groupBy('program')
        ->orderBy('coupon_quantity', 'desc')
        ->union
        ->get();

    return $ircEntries;
});

Route::get('clients_source', function()
{
    $columns = array(
        'id',
        'email',
        'password',
        'password_insecure',
        'remember_token',
        'active',
        'first_name',
        'last_name',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'first_name',
        'direction'   => 'asc',
        'max_results' => 100000,
    );

    $user = User::where('role_id', '=', 2)->get();

    return DataGrid::make($user, $columns, $settings);
});

Route::get('admins_source', function()
{
    $columns = array(
        'id',
        'email',
        'password',
        'password_insecure',
        'remember_token',
        'active',
        'first_name',
        'last_name',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'first_name',
        'direction'   => 'asc',
        'max_results' => 100000,
    );

    $user = User::where('role_id', '=', 1)->get();

    return DataGrid::make($user, $columns, $settings);
});

Route::get('retailers_source', function()
{
    $columns = array(
        'id',
        'name',
        'state',
        'is_active',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new Retailer, $columns, $settings);
});

Route::get('retailers_mir_source', function()
{
    $columns = array(
        'id',
        'name',
        'is_active',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new MirRetailer, $columns, $settings);
});

Route::get('clearinghouses_source', function()
{
    $columns = array(
        'id',
        'name',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new Clearinghouse, $columns, $settings);
});


Route::get('suppliers_source', function()
{
    $columns = array(
        'id',
        'name',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new Supplier, $columns, $settings);
});

Route::get('brands_source', function()
{
    $columns = array(
        'id',
        'name',
        'supplier',
        'irc_active',
        'mir_active',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new BrandView, $columns, $settings);
});

Route::get('coupon_irc_source', function()
{
    $columns = array(
        'id',
        'name',
        'expires',
        'receive_by',
        'barcode',
        'active',
        'user',
        'coupon_type',
        'brand',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'created_at',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new CouponIrcView, $columns, $settings);
});
Route::get('coupon_type', function()
{
    $columns = array(
        'id',
        'name',
        'active'
        
    );

    $settings = array(
        'sort'        => 'display_order',
        'direction'   => 'asc',
        
    );

    return DataGrid::make(new CouponType, $columns, $settings);
});
Route::get('denial_get_data', function()
{
    $columns = array(
        'id',
        'name',
        'active'

    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'asc',
    );

    return DataGrid::make(new MirDenialReason, $columns, $settings);
});
Route::get('mir_status_c', function()
{
    $columns = array(
        'id',
        'name',
        'active'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'asc',
    );

    return DataGrid::make(new MirStatus, $columns, $settings);
});
Route::get('default_faq_source', function()
{
    $columns = array(
        'id',
        'question',
        'answer'
        
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'asc',
        
    );

    return DataGrid::make(new DefaultFaq, $columns, $settings);
});
Route::get('default_text_source', function()
{
    $columns = array(
        'id',
        'default_field_name',
        'default_field_data'
        
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'asc',
        
    );

    return DataGrid::make(new DefaultField, $columns, $settings);
});
Route::get('coupon_mir_source', function()
{
    $columns = array(
        'id',
        'name',
        'expires',
        'receive_by',
        'active',
        'user',
        'coupon_type',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new CouponMirView, $columns, $settings);
});

Route::get('irc_entry_source', function()
{
    $columns = array(
        'id',
        'retailer',
        'retailer_state',
        'program',
        'client_id',
        'client_name',
        'brand',
        'clearinghouse',
        'is_invoiced',
        'coupon_quantity',
        'payable',
        'shipping',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 1000,
    );

    $userId = Auth::user()->id;

    $user = User::find($userId);
    if (!$user->hasRole(1))
    {
        $userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');
        $entries = EntryIrcView::whereIn('coupon_id', $userCoupons)
            ->select('id','retailer','program','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at')
            ->get();
        $entries->where('deleted_at', '=', 'hello');
    }

    else
    {
        $entries = EntryIrcView::where('deleted_at', '=', NULL)
            ->select('id','retailer','program','clearinghouse','is_invoiced','coupon_quantity','payable','shipping','created_at')
            ->get();
    }
    return DataGrid::make($entries, $columns, $settings);
});

Route::get('irc_entry_source10', function()
{
    $columns = array(
        'id',
        'retailer',
        'retailer_state',
        'program',
        'client_id',
        'client_name',
        'brand',
        'clearinghouse',
        'is_invoiced',
        'coupon_quantity',
        'payable',
        'shipping',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    $userId = Auth::user()->id;

    $user = User::find($userId);
           
    if (!$user->hasRole(1))
    {

        $userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');

        $entries = EntryIrcView::whereIn('coupon_id', $userCoupons)->get();

        $entries->where('deleted_at', '=', 'hello');
    }

    else
    {
        $entries = EntryIrcView::where('deleted_at', '=', NULL)->orderBy('created_at', 'desc')->take(10)->get();
    }

    return DataGrid::make($entries, $columns, $settings);
});

Route::get('mir_entry_source', function()
{
    //  $columns = array(
    //     'id',
    //     'dollar_value',
    //     'retailer',
    //     'owner',
    //     'coupon',
    //     'first_name',
    //     'last_name',
    //     'address',
    //     'city',
    //     'state',
    //     'zip',
    //     'status',
    //     'birth_date',
    //     'invoiced_date',
    //     'denial_reason_id',
    //     'created_at',
    //   //  'program_type',
    // );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new EntryMirView, $settings);
});

Route::get('invoices_irc_source', function()
{
    $columns = array(
        'id',
        'description',
        'invoice_status_id',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'created_at',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    return DataGrid::make(new InvoiceIrc, $columns, $settings);
});

Route::get('irc_entry_client_source', function()
{
    $columns = array(
        'id',
        'retailer',
        'retailer_state',
        'program',
        'client_id',
        'client_name',
        'brand',
        'clearinghouse',
        'is_invoiced',
        'coupon_quantity',
        'created_at',
        'updated_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    $userId = Auth::user()->id;

    $userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');

    $entries = EntryIrcView::whereIn('coupon_id', $userCoupons)->get();

    return DataGrid::make($entries, $columns, $settings);
});

Route::get('irc_entry_by_retaier_client_source', function()
{
    $columns = array(
        'month',
        'f_month',
        'retailer',
        'total'
    );

    $settings = array(
        'sort'        => 'month',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    $userId = Auth::user()->id;

    //$entries = IrcByRetailerView::whereIn('user_id', $userId)->get();
	$entries = DB::table('irc_by_retailer_view')->where('user_id', '=', $userId)->get();

    return DataGrid::make($entries, $columns, $settings);
});


Route::get('mir_entry_client_source', function()
{
    $columns = array(
        'id',
        'retailer',
        'dollar_value',
        'coupon',
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'zip',
        'status',
        'created_at'
    );

    $settings = array(
        'sort'        => 'id',
        'direction'   => 'desc',
        'max_results' => 100000,
    );

    $userId = Auth::user()->id;

    $userCoupons = Coupon::where('user_id', '=', $userId)->lists('id');

    $entries = EntryMirView::whereIn('coupon_id', $userCoupons)->get();

    return DataGrid::make($entries, $columns, $settings);
});

Route::get('/test', function()
{
	$entries = DB::table('irc_by_retailer_view')->where('user_id', '=', '68')->get();

    dd($entries);
	
});