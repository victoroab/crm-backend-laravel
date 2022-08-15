<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CasesController extends Controller
{
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


    // Get particular case by id
    public function GetCase(Request $request)
    {
        $case = DB::table('cases')->where('id', $request->id)->first();
        return response([$case]);
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


    // Get all the closed cases
    public function ClosedCases(Request $request)
    {
        $cases = DB::table('cases')->where('status', 'closed')->get();

        return response(['data' => $cases]);
    }
}
