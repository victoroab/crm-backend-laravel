<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hcase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
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

    // Get all the closed cases
    public function ClosedCases(Request $request)
    {
        $cases = DB::table('cases')->where('status', 'closed')->get();

        return response(['data' => $cases]);
    }

    // Get particular case by id
    public function GetCase(Request $request)
    {
        $case = DB::table('cases')->where('id', $request->id)->first();
        return response([$case]);
    }

    // Add a case
    public function AddCase(Request $request)
    {
        try {
            DB::table('cases')->insertGetId([
                'id' => $request->id,
                'accountNumber' => $request->accountNumber,
                'category' => $request->category,
                'date' => $request->date,
                'dateClosed' => " ",
                'details' => $request->details,
                'status' => $request->status,
                'agent' => $request->agent,
            ]);

            return response(['msg' => 'Successful']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Update status of a case
    public function UpdateCaseStatus(Request $request)
    {
        DB::table('cases')
            ->where('id', $request->id)
            ->update(['status' => $request->status]);

        $case = DB::table('cases')->where('id', $request->id)->first();

        return ([$case]);
    }

    // Update date closed of a case
    public function UpdateClosed(Request $request)
    {
        DB::table('cases')
            ->where('id', $request->id)
            ->update(['status' => $request->status, 'dateClosed' => $request->dateClosed]);

        $case = DB::table('cases')->where('id', $request->id)->first();

        return ([$case]);
    }

    // Register
    public function Register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);

        $hashedPwd = Hash::make($request->password);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $hashedPwd
        ]);

        return response(['data' => [$request->username, $hashedPwd]]);
    }

    // Login
    public function Login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response([
            'authToken' => $user->createToken($request->email)->plainTextToken,
            'username' => $user->name
        ]);
    }

    //Logout
    public function Logout(Request $request)
    {
    }
}
