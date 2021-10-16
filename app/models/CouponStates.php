<?php

class CouponStates extends \Eloquent {
    protected $table = 'coupon_states';

    public $timestamps = false;

    protected $fillable = [
        'state_id'      
    ];
}