<?php

class Constant extends \Eloquent {
	protected $fillable = [];
    /**
     * In Database We are storing Constants Like 0, 1, 2, So Don't change Arragement. 
     * Instead change Text of your choice.
     */
    public static $campains = [
        '0' => 'N/A',
        '1' => 'MIR',
        '2' => 'IRC',
        '3' => 'DIGITAL MIR',
        '4' => 'SWEEPSTAKES'
        //'5' => 'GOLDEN CORK'
    ];
    public static $paid_status = [
        '' => '',
        'pending' => 'pending',
        'paid' => 'paid',
        'denied' => 'denied'
    ];
    
    public static $sweepstakes_have_generated_code_yes = 'Y';
    public static $sweepstakes_have_generated_code_no = 'N';
    
    public static $code_generator_limit = 15000;


    public static $assetLink = 'https://bevpromo-static-assets.serverdatahost.com/';
    //public static $assetLink = 'http://localhost/DINO/bevpromo/static-assets/';
    public static $frontEndUrl = 'https://bevpromo-frontend.serverdatahost.com/campaigns/';
    //public static $frontEndUrl = 'http://localhost:8080/campaigns/';
}