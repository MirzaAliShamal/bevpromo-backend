<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SaveSearch extends \Eloquent {
    //use SoftDeletingTrait;
    protected $table = 'save_searchs';
    //protected $softDelete = true;
    protected $fillable = [
        'user_id',
        'search',
        'name'
    ];
}