<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory;
    use SoftDeletes;

    // 主キーの変更
    protected $primaryKey = 'goal_id';

    protected $fillable = [
      'user_id',
      'title',
      'date'
    ];
}
