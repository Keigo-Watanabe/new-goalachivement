<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 主キーの変更
    protected $primaryKey = 'schedule_category_id';

    protected $fillable = [
      'user_id',
      'category',
      'color'
    ];
}
