<?php

class ReportingEntryMirController extends \BaseController {

	public function index()
	{
		return View::make('reporting.entries.mir.list');
	}

}