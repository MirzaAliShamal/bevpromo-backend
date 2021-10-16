<?php

class TransactionTypes extends \Eloquent {

    protected $table = 'transaction_types';

    protected $fillable =
        [
            'name',
            'description'
        ];

}