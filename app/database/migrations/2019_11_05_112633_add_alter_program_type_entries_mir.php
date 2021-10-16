<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlterProgramTypeEntriesMir extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('entries_mir', function($table) {
            $table->string('campaign_type')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('entries_mir', function($table) {
            $table->dropColumn('campaign_type');
        });
	}

}
