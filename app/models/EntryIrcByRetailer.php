<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EntryIrcByRetailer extends \Eloquent {

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
            'clearinghouse_id'
        ];

    public function retailer()
    {
        return $this->hasOne('Retailer');
    }

}