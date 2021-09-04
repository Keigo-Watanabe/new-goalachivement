<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $all_tasks = Task::where('user_id', $user_id)->get();
        $categories = Category::where('user_id', $user_id)->get();

        // 現在の日付
        $time = new Carbon();
        $now = $time->format('Y-m-d');

        // 絞り込み
        if ($request->input('sort')) {

          if ($request->input('sort') == '降順') {
            $tasks = Task::where('user_id', $user_id)->orderBy('end_date', 'desc')->get();
            $sort_mode = '降順';
          }

          if ($request->input('sort') == '昇順') {
            $tasks = Task::where('user_id', $user_id)->orderBy('end_date', 'asc')->get();
            $sort_mode = '昇順';
          }

          if ($request->input('sort') == '重要') {
            $tasks = Task::where('user_id', $user_id)->where('priority', '重要')->get();
            $sort_mode = '重要';
          }

          if ($request->input('sort') == '緊急') {
            $tasks = Task::where('user_id', $user_id)->where('severity', '緊急')->get();
            $sort_mode = '緊急';
          }

          if (is_numeric($request->input('sort'))) {
            $tasks = Task::where('user_id', $user_id)->where('category_id', $request->input('sort'))->get();
            $category = Category::where('category_id', $request->input('sort'))->value('category');
            $sort_mode = $category;
          }

          if ($request->input('sort') == '未着手') {
            $tasks = [];

            foreach ($all_tasks as $task) {
              if ($task->start_date > $now && $task->complete == 0) {
                $tasks[] = $task;
              }
            }

            $sort_mode = '未着手';
          }

          if ($request->input('sort') == '進行中') {
            $tasks = [];

            foreach ($all_tasks as $task) {
              if ($task->start_date <= $now && $task->complete == 0) {
                $tasks[] = $task;
              }
            }

            $sort_mode = '進行中';
          }

          if ($request->input('sort') == '完了済') {
            $tasks = [];

            foreach ($all_tasks as $task) {
              if ($task->complete == 1) {
                $tasks[] = $task;
              }
            }

            $sort_mode = '完了済';
          }

        } else {
          $tasks = Task::where('user_id', $user_id)->get();
          $sort_mode = '';
        }

        return Inertia::render('Task', ['all_tasks' => $all_tasks, 'tasks' => $tasks, 'categories' => $categories, 'now' => $now, 'sort_mode' => $sort_mode]);
    }

    public function matrix(Request $request)
    {
        $user_id = Auth::id();
        $all_tasks = Task::where('user_id', $user_id)->get();
        $categories = Category::where('user_id', $user_id)->get();

        // 現在の日付
        $time = new Carbon();
        $now = $time->format('Y-m-d');

        // 絞り込み
        if ($request->input('sort')) {

          if ($request->input('sort') == '降順') {
            $tasks = Task::where('user_id', $user_id)->orderBy('end_date', 'desc')->get();
            $sort_mode = '降順';
          }

          if ($request->input('sort') == '昇順') {
            $tasks = Task::where('user_id', $user_id)->orderBy('end_date', 'asc')->get();
            $sort_mode = '昇順';
          }

          if ($request->input('sort') == 'A') {
            $tasks = Task::where('user_id', $user_id)->where('priority', '重要')->where('severity', '緊急')->get();
            $sort_mode = '重要かつ緊急';
          }

          if ($request->input('sort') == 'B') {
            $tasks = Task::where('user_id', $user_id)->where('priority', '重要')->where('severity', '')->get();
            $sort_mode = '重要だが緊急でない';
          }

          if ($request->input('sort') == 'C') {
            $tasks = Task::where('user_id', $user_id)->where('priority', '')->where('severity', '緊急')->get();
            $sort_mode = '緊急だが重要でない';
          }

          if ($request->input('sort') == 'D') {
            $tasks = Task::where('user_id', $user_id)->where('priority', '')->where('severity', '')->get();
            $sort_mode = '重要でも緊急でもない';
          }

        } else {
          $tasks = Task::where('user_id', $user_id)->get();
          $sort_mode = '';
        }

        // マトリクス-タスク件数
        $a = [];
        $b = [];
        $c = [];
        $d = [];

        foreach ($all_tasks as $task) {
          // 重要かつ緊急
          if ($task->priority == '重要' && $task->severity == '緊急') {
            $a[] = $task;
          }
          // 重要だが緊急でない
          if ($task->priority == '重要' && $task->severity == '') {
            $b[] = $task;
          }
          // 緊急だが重要でない
          if ($task->priority == '' && $task->severity == '緊急') {
            $c[] = $task;
          }
          // 重要でも緊急でもない
          if ($task->priority == '' && $task->severity == '') {
            $d[] = $task;
          }
        }

        $a_num = count($a);
        $b_num = count($b);
        $c_num = count($c);
        $d_num = count($d);

        return Inertia::render('TaskMatrix', ['all_tasks' => $all_tasks, 'tasks' => $tasks, 'categories' => $categories, 'now' => $now, 'sort_mode' => $sort_mode, 'a_num' => $a_num, 'b_num' => $b_num, 'c_num' => $c_num, 'd_num' => $d_num]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new Task();

        $task->user_id = Auth::id();
        $task->goal_id = $request->input('goal_id');
        $task->title = $request->input('title');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');

        // カテゴリーが追加されたら保存
        if ($request->input('category_id')) {
          $task->category_id = $request->input('category_id');
        } else {
          // カテゴリーが追加されなかったら0を登録
          $task->category_id = 0;
        }

        // 重要を追加されたら保存
        if ($request->input('priority')) {
          $task->priority = $request->input('priority');
        } else {
          $task->priority = '';
        }

        // 緊急を追加されたら保存
        if ($request->input('severity')) {
          $task->severity = $request->input('severity');
        } else {
          $task->severity = '';
        }

        $task->complete = 0;
        $task->save();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->title = $request->input('title');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');

        // カテゴリーが追加されたら保存
        if ($request->input('category_id')) {
          $task->category_id = $request->input('category_id');
        } else {
          // カテゴリーが追加されなかったら0を登録
          $task->category_id = 0;
        }

        // 重要を追加されたら保存
        if ($request->input('priority')) {
          $task->priority = $request->input('priority');
        } else {
          $task->priority = '';
        }

        // 緊急を追加されたら保存
        if ($request->input('severity')) {
          $task->severity = $request->input('severity');
        } else {
          $task->severity = '';
        }

        $task->save();

        return redirect()->back();
    }

    public function complete(Request $request, $id)
    {
        $task = Task::find($id);
        $task->complete = $request->input('complete');
        $task->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->back();
    }
}
