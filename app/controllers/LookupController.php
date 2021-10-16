<?php

class LookupController extends \BaseController {

    public function search()
    {
        return View::make('lookup.search');
    }

    public function postList()
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::to('/lookup');
        }
        else {

            $entry = new EntryMirView;

            $entries = $entry->where('first_name', '=', Input::get('first_name'))->where('last_name', '=', Input::get('last_name'))->get();

            $import = new Import;

            $imports = $import->where('payee', 'LIKE', Input::get('first_name') . '%')->where('payee', 'LIKE', '%' . Input::get('last_name'))->get();

            return View::make('/lookup/list')->with('entries', $entries)->with('imports', $imports);
        }


    }

}