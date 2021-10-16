<?php

class CampaignGenerateCoupon extends \Eloquent {
    
    public $timestamps = false;

    public static function insert_bulk($table, $data)
    {
        try{
            // insert the entry
            DB::table($table)->insert($data);
        }
        catch(QueryException $e) {
           if ($this->isDuplicateEntryException($e)) {
            throw new DuplicateEntryException('Duplicate Entry');
           }

           throw $e;

        }
        return true;
    }
    
    public static function get_coupons_list($table)
    {
        return DB::table($table)->get();
    }
}