<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("DROP VIEW customers_view");

		DB::statement("CREATE VIEW customers_view AS select cu.id AS customer_id, cu.dob as dob, cu.gender as gender, cu.rebate_method as rebate_method, concat(cu.first_name, ' ', cu.last_name) AS customer_name,cu.company_name as company_name,cu.phone_num as phone_num,cu.email as email,cu.paypal_email as paypal_email,cu.street_address as street_address,cu.appartment_num as appartment_num, cu.zip as zip, cu.city as city,cu.country as country, cu.state as state, cu.created_at as created_at, cu.updated_at as updated_at, cu.tracking_id as tracking_id, c.id AS id,c.id AS coupon_id,c.name AS name,c.expires
		AS expires,
		c.receive_by AS receive_by,c.coupon_type_id AS coupon_type_id,c.barcode AS barcode,(case when (c.active <> 0) then 'Yes' else 'No' end) AS active,(case when (c.campaign_type is null) then 'Not Defined' else c.campaign_type end) AS campaign_type,(case when (c.url_str is null) then 'N/D' else c.url_str end) AS campaign_url,(case when (c.campaign_logo is null) then 'N/A' else c.campaign_logo end) AS campaign_logo,
		concat(u.first_name,'  ',u.last_name) AS user,ct.name AS coupon_type,b.name AS brand from customers cu join coupons c on cu.coupon_id = c.id join brands b on c.brand_id = b.id join coupon_types ct on c.coupon_type_id = ct.id join users u on c.user_id = u.id");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
