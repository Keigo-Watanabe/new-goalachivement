<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();

        $schedules = Schedule::where('user_id', $user_id)->get();
        $schedule_categories = ScheduleCategory::where('user_id', $user_id)->get();

        return Inertia::render('Calendar', ['schedules' => $schedules, 'schedule_categories' => $schedule_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule();

        $schedule->user_id = Auth::id();
        $schedule->title = $request->input('title');

        // カテゴリーが追加されたら保存
        if ($request->input('schedule_category_id')) {
          $schedule->schedule_category_id = $request->input('schedule_category_id');
        } else {
          // カテゴリーが追加されなかったら0を登録
          $schedule->schedule_category_id = 0;
        }

        $start_time = $request->input('date').' '.$request->input('datetime_start');
        $schedule->start_time = $start_time;

        if ($request->input('datetime_end')) {
          $end_time = $request->input('date').' '.$request->input('datetime_end');
          $schedule->end_time = $end_time;
        } else {
          $schedule->end_time = null;
        }

        $schedule->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->user_id = Auth::id();
        $schedule->title = $request->input('title');

        // カテゴリーが追加されたら保存
        if ($request->input('schedule_category_id')) {
          $schedule->schedule_category_id = $request->input('schedule_category_id');
        } else {
          // カテゴリーが追加されなかったら0を登録
          $schedule->schedule_category_id = 0;
        }

        $start_time = $request->input('date').' '.$request->input('datetime_start');
        $schedule->start_time = $start_time;

        if ($request->input('datetime_end')) {
          $end_time = $request->input('date').' '.$request->input('datetime_end');
          $schedule->end_time = $end_time;
        } else {
          $schedule->end_time = null;
        }

        $schedule->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();

        return redirect()->back();
    }
}
