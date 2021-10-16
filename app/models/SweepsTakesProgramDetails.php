<?php

class SweepsTakesProgramDetails extends \Eloquent {

    protected $table = 'sweepstake_program_details'; 

    protected $fillable = [
        'coupon_id',
        'name',
        'url',
        'admin_email',
        'brand_landing_url',
        'start_date',
        'end_date',
        'status',
        'data_entry_limit',
        'under_age_link',
        'rules',
        'promo_page',
        'prize_display',
        'page_gap',
        'promo_ad',
        'youtube_video',
        'youtube_video_url',
        'slider',
        'daily_limit',
    ];

      
}