<?php

class MirDenialReason extends \Eloquent {

    protected $table = 'mir_denial_reasons';

    const active = 1;
    const in_active = 0;

    protected $fillable =
        [
            'name',
            'active'
        ];

}