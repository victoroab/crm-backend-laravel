<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentsController extends Controller
{
    // Agents Endpoint
    public function GetAgents(Request $request)
    {
        $agents = DB::table('agents')
            ->select('firstname', 'lastname', 'email')
            ->get(); // fname, lname and email
        $agentsId = User::select('name', 'email')
            ->where('name', '!=', 'admin')
            ->get(); // email and name
        return response([
            'agents' => $agents,
            'agentsId' => $agentsId
        ]);
    }
}
