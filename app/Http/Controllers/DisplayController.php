<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayController extends Controller
{
    // Dashboard Endpoint
    public function GetDashboard(Request $request)
    {
        $cases = DB::table('cases')->get();
        $agents = DB::table('agents')->get();
        $realAccounts = DB::table('account_details_updated__1_')->get();

        return response([

            'cases' => $cases,
            'agents' => $agents,
            'details' => $realAccounts
        ]);
    }

    // Case Management Endpoint
    public function GetCaseManagement(Request $request)
    {

        $cases = DB::table('cases')->get();
        $realAccounts = DB::table('account_details_updated__1_')->get();

        return response(['cases' => $cases, 'details' => $realAccounts]);
    }

    public function GetAccounts(Request $request)
    {
        $realAccounts = DB::table('account_details_updated__1_')->get();

        return response(['details' => $realAccounts]);
    }
}
