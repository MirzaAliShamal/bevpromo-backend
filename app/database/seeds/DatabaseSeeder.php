<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		$this->call('UserTableSeeder');
        $this->command->info('users table seeded!');

        $this->call('RoleTableSeeder');
        $this->command->info('roles table seeded!');

        $this->call('SupplierTableSeeder');
        $this->command->info('suppliers table seeded!');

        $this->call('BrandTableSeeder');
        $this->command->info('brands table seeded!');

        $this->call('RetailerTableSeeder');
        $this->command->info('retailers table seeded!');

        $this->call('MirRetailerTableSeeder');
        $this->command->info('mir_retailers table seeded!');

        $this->call('ClearinghouseTableSeeder');
        $this->command->info('clearinghouses table seeded!');

        $this->call('CouponTypeTableSeeder');
        $this->command->info('coupon_types table seeded!');

        $this->call('CouponTableSeeder');
        $this->command->info('coupons table seeded!');

        $this->call('MirDenialReasonTableSeeder');
        $this->command->info('mir_denial_reasons table seeded!');

        $this->call('MirStatusTableSeeder');
        $this->command->info('mir_statuses table seeded!');

        $this->call('TransactionTypesTableSeeder');
        $this->command->info('transaction_types table seeded!');

        $this->call('EntriesIrcTableSeeder');
        $this->command->info('entries_irc table seeded!');

        $this->call('EntriesMirTableSeeder');
        $this->command->info('entries_mir table seeded!');

        $this->call('InvoiceTableSeeder');
        $this->command->info('invoices table seeded!');
		
		$this->call('ImportTableSeeder');
        $this->command->info('imports table seeded!');

	}

}
