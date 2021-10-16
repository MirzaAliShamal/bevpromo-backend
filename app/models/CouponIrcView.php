<?php

class CouponIrcView extends \Eloquent {
    protected $table = 'coupons_irc_view';

    public function getExpiresAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }

    public function getReceiveByAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }
}