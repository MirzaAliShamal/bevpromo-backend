<?php

class EntryMir extends \Eloquent {

    protected $table = 'entries_mir';

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'mir_retailer_id',
            'coupon_id',
            'dollar_value',
            'first_name',
            'last_name',
            'address',
            'city',
            'state',
            'zip',
            'email',
            'tax_id',
            'birth_date',
            'received_date',
            'mir_status_id',
            'denial_reason_id',
            'campaign_type',
            'paid_status',
            'coupon_notes_mir',
            'active'
        ];

}