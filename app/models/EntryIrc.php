<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EntryIrc extends \Eloquent {

    use SoftDeletingTrait;

    protected $table = 'entries_irc';

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'retailer_id',
            'coupon_id',
            'coupon_quantity',
            'payable',
            'shipping',
            'client_invoice',
            'clearinghouse_id',
            'campaign_type',
            'coupon_notes_ir'
        ];

}