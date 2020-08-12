<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Timesheet;
use DateTime;

class TimesheetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // We want to return all of the available timesheets - a user should only get theirs, while a manager should get all of their employees
        // $user = Auth::user();
        $timesheets = Timesheet::where('user_id', Auth::user()->id)->get();

        return view('timesheets.index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('timesheets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $t = Timesheet::create($request->all());
        $t->status()->attach(1);
        return redirect('/timesheet/' . $t->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timesheet = Timesheet::where('id', $id)->first();

        $day_after = new DateTime($timesheet->end .  ' +1 day');

        $timesheet->day_after = $day_after;


        return view('timesheets.edit',compact('timesheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
