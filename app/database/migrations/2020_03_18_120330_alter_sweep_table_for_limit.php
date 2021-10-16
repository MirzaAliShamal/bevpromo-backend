<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSweepTableForLimit extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `sweepstake_program_details` ADD `promo_page` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `legal_disclaimer`, ADD `page_gap` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `promo_page`, ADD `prize_display` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `page_gap`, ADD `promo_ad` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `prize_display`, ADD `youtube_video` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `promo_ad`, ADD `youtube_video_url` VARCHAR(255) NULL AFTER `youtube_video`, ADD `slider` BOOLEAN NULL DEFAULT FALSE COMMENT '1=Active, 0=Inactive' AFTER `youtube_video_url`, ADD `daily_limit` INT NULL AFTER `slider`;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
