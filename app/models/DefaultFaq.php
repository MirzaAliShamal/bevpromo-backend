<?php

class DefaultFaq extends \Eloquent {
    protected $table = 'default_faqs';
    protected $fillable =
        [
            'question',
            'answer',
        ];
}