<?php

class ImageData extends \Eloquent {
    protected $table = 'images_data';
    protected $fillable =
        [
          'src',
          'position',
        ];
}