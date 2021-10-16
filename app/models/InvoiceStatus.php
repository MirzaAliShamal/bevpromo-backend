<?php

class InvoiceStatus extends \Eloquent {

    protected $table = 'invoice_statuses';

    protected $fillable =
        [
            'name'
        ];

}