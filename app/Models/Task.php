<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 主キーの変更
    protected $primaryKey = 'task_id';

    protected $fillable = [
      'user_id',
      'goal_id',
      'title',
      'category_id',
      'start_date',
      'end_date',
      'priority',
      'severity',
      'comment',
      'complete'
    ];
}
