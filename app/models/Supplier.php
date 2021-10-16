<?php

class Supplier extends \Eloquent {
	protected $fillable = ['name'];

    public function user()
    {
        return $this->hasMany('Users');
    }
}