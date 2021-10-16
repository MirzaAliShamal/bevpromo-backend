<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Coupon extends \Eloquent {
    //use SoftDeletingTrait;
    protected $table = 'coupons';
    //protected $softDelete = true;
    protected $fillable = [
        'name',
        'coupon_type_id',
        'value',
        'description',
        'expires',
        'receive_by',
        'barcode',
        'circulation',
        'active',
        'user_id',
        'brand_id',
        'send_to_id',
        'invoice_id',
        'campaign_logo',
        'campaign_type',
        'custom_url',
        'promotion_title',
        'offer_code',
        'start_date',
        'terms_conditions',
        'bp_terms_conditions',
        'email_subscription_message',
        'paragraph_size',
        'customize_email',
        'privacy_policy',
        'copyright_text',
        'footer_text',
        'line_hr_color',
        'nav_color',
        'field_span_color',
        'custom_css',
        'custom_js',
        'brand_privacy',
        'welcome_message'
    ];

    public function invoiceIrc()
    {
        return $this->belongsTo('InvoiceIrc', 'invoice_id');
    }

    public function countEntries()
    {
        return EntryIrc::where('coupon_id', '=', $this->id)->sum('coupon_quantity');

    }

    public function calculateEntryValues()
    {
        $quantity =  EntryIrc::where('coupon_id', '=', $this->id)->sum('coupon_quantity');

        $value = $this->value;

        $total = $quantity * $value;

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

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}