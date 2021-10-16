<?php

class Import extends \Eloquent {
    protected $fillable = [
        'id',
        'status_id',
        'status_name',
        'status',
        'timestamp',
        'transaction_id',
        'payee'
    ];

}