<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $goals = Goal::where('user_id', $user_id)->get();
        $tasks = Task::where('user_id', $user_id)->get();

        // 現在の日付
        $time = new Carbon();
        $now = $time->format('Y-m-d');

        // 進行中のタスクと完了済みのタスクの配列を作成
        $tasks_progress = [];
        $tasks_complete = [];

        foreach ($tasks as $task) {
          // 進行中のタスク
          if ($task->start_date <= $now && $task->complete == 0) {
            $tasks_progress[] = $task;
          }

          // 完了済みのタスク
          if ($task->complete == 1) {
            $tasks_complete[] = $task;
          }
        }

        return Inertia::render('Goal', ['goals' => $goals, 'tasks' => $tasks, 'tasks_progress' => $tasks_progress, 'tasks_complete' => $tasks_complete]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goal = new Goal;

        $goal->user_id = Auth::id();
        $goal->title = $request->input('title');
        $goal->date = $request->input('date');

        $goal->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = Auth::id();
        $goal = Goal::find($id);

        if ($goal->user_id != $user_id) {
          return redirect('/home');
        }

        $all_tasks = Task::where('goal_id', $id)->get();

        // 絞り込み
        if ($request->input('sort')) {

          if ($request->input('sort') == '重要') {
            $tasks = Task::where('goal_id', $id)->where('priority', '重要')->get();
            $sort_mode = '重要';
          }
          if ($request->input('sort') == '緊急') {
            $tasks = Task::where('goal_id', $id)->where('severity', '緊急')->get();
            $sort_mode = '緊急';
          }
          if (is_numeric($request->input('sort'))) {
            $tasks = Task::where('goal_id', $id)->where('category_id', $request->input('sort'))->get();
            $category = Category::where('category_id', $request->input('sort'))->value('category');
            $sort_mode = $category;
          }

        } else {
          $tasks = Task::where('goal_id', $id)->get();
          $sort_mode = '';
        }

        $user_id = Auth::id();
        $categories = Category::where('user_id', $user_id)->get();

        // 現在の日付
        $time = new Carbon();
        $now = $time->format('Y-m-d');

        // 進行中のタスクと完了済みのタスクの配列を作成
        $tasks_progress = [];
        $tasks_complete = [];

        foreach ($all_tasks as $task) {
          // 進行中のタスク
          if ($task->start_date <= $now && $task->complete == 0) {
            $tasks_progress[] = $task;
          }

          // 完了済みのタスク
          if ($task->complete == 1) {
            $tasks_complete[] = $task;
          }
        }

        // 目標達成までの残りの日数
        $goal_date = Carbon::parse($goal->date);
        if ($goal->date < $time) {
          $goal_remaining_days = 0;
        } else {
          $goal_remaining_days = $time->diffInDays($goal_date);
        }

        return Inertia::render('GoalShow', [
          'goal' => $goal,
          'tasks' => $tasks,
          'all_tasks' => $all_tasks,
          'categories' => $categories,
          'now' => $now,
          'tasks_progress' => $tasks_progress,
          'tasks_complete' => $tasks_complete,
          'goal_remaining_days' => $goal_remaining_days,
          'sort_mode' => $sort_mode
        ]);
    }

    public function chart($id)
    {
        $user_id = Auth::id();
        $goal = Goal::find($id);

        if ($goal->user_id != $user_id) {
          return redirect()->back();
        }

        $tasks = Task::where('goal_id', $id)->get();

        // 目標設定日
        $goal_created_date = Goal::where('goal_id', $id)->value('created_at');
        $goal_created_date = new Carbon($goal_created_date);
        // 目標達成日
        $goal_date = Goal::where('goal_id', $id)->value('date');
        $goal_date = date('Y-m-d H:i:s', strtotime($goal_date));
        $goal_date = new Carbon($goal_date);
        $goal_date = $goal_date->addDay(1);

        // 設定日から達成日までを繰り返し処理
        $days = [];

        while($goal_created_date->lte($goal_date)) {
          // 設定日をコピー
          $day = $goal_created_date->copy();
          // 配列daysに格納
          $days[] = $day;
          // 設定日に1日追加
          $goal_created_date->addDay(1);
        }

        // 今日の日付を取得
        $today = new Carbon();
        $today = $today->copy()->timezone('Asia/Tokyo');

        return Inertia::render('GoalChart', ['goal' => $goal, 'tasks' => $tasks, 'days' => $days, 'today' => $today]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $goal = Goal::find($id);

        $goal->update($request->all());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goal = Goal::find($id);
        $goal->delete();

        // 目標に含まれるタスクも削除
        $tasks = Task::where('goal_id', $id)->get();
        foreach ($tasks as $task) {
          $task->delete();
        }

        return redirect()->back();
    }
}
