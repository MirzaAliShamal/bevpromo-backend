<?php

class MirStatus extends \Eloquent {

    protected $table = 'mir_statuses';

    const active = 1;
    const in_active = 0;

    protected $fillable =
        [
            'name',
            'active'
        ];

}