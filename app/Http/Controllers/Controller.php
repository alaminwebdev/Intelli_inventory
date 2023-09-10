<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// public function __construct(){
	// 	dd(auth()->user());
	// 		DB::listen(function ($query) {
	// 			$raw_sql = $query->sql;
	// 			$replacements = $query->bindings;

	// 			$foundKeywords = array_filter(['insert', 'update', 'drop', 'alter', 'truncate'], function ($keyword) use ($raw_sql) {
	// 				return strpos($raw_sql, $keyword) !== false;
	// 			});

	// 			if (count($foundKeywords) > 0) {
	// 				$to_raw_sql = preg_replace_callback('/\?/', function ($matches) use (&$replacements) {
	// 					return array_shift($replacements);
	// 				}, $raw_sql);
	// 				\Log::channel('sql_query_log')->info('execution time: ' . $query->time . ' | sql: ' . $to_raw_sql);
	// 			}
	// 		});
	// }
}
