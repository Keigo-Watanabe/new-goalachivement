<?php

namespace App\Http\Controllers;

use App\Models\ScheduleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleCategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule_category = new ScheduleCategory();

        $schedule_category->user_id = Auth::id();
        $schedule_category->category = $request->input('category');
        $schedule_category->color = $request->input('color');

        $schedule_category->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScheduleCategory  $scheduleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule_category = ScheduleCategory::find($id);

        $schedule_category->category = $request->input('category');
        $schedule_category->color = $request->input('color');

        $schedule_category->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScheduleCategory  $scheduleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule_category = ScheduleCategory::find($id);

        $schedule_category->delete();

        return redirect()->back();
    }
}
