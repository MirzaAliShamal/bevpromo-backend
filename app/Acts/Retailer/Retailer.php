<?php namespace Acts\Retailer;

use McCool\LaravelAutoPresenter\HasPresenter;

class Retailer extends \Eloquent implements HasPresenter
{
    protected $table = 'retailers';

    protected $fillable = ['name', 'state', 'irc_active', 'mir_active'];

    public function getPresenterClass()
    {
        return \Acts\Retailer\RetailerPresenter::class;
    }
}