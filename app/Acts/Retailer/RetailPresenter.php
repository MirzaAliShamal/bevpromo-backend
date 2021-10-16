<?php namespace Acts\Retailer;

use McCool\LaravelAutoPresenter\BasePresenter;

class RetailerPresenter extends BasePresenter
{
    public function __construct(Retailer $retailer)
    {
        $this->wrappedObject = $retailer;
    }

    public function name()
    {
        return strtoupper($this->wrappedObject->name);
    }
}