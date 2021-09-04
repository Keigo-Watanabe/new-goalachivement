<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 主キーの変更
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
      'user_id',
      'title',
      'schedule_category_id',
      'start_time',
      'end_time',
      'memo'
    ];
}
