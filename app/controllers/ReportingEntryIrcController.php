<?php

class ReportingEntryIrcController extends \BaseController {

	public function index()
	{
		return View::make('reporting.entries.irc.list');
	}

}