<?php

class DefaultField extends \Eloquent {
    protected $table = 'default_fields';
    protected $fillable =
        [
            'default_field_name',
            'default_field_data',
        ];
}