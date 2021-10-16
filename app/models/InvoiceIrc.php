<?php

class InvoiceIrc extends \Eloquent {

    protected $table = 'invoices';

    protected $fillable =
        [
            'invoice_status_id',
            'name',
            'description',
            'invoice_status_id',
            'user_id'
        ];

    public function coupons()
    {
        return $this->hasMany('Coupon', 'invoice_id');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function allCouponSum()
    {
        $coupons = Coupon::where('invoice_id', '=', $this->id)->get();

        $total = '';

        foreach ($coupons as $coupon)
        {
            $quantity =  EntryIrc::where('coupon_id', '=', $coupon->id)->sum('coupon_quantity');

            $value = $coupon->value;

            $calc = $quantity * $value;

            $total += $calc;

        }
        $f_total = $this->formatMoney($total, true);

        return $f_total;

    }

    public function formatMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

}