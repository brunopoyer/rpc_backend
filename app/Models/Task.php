<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'due_date',
        'completed_at',
        'deleted_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag', 'task_id', 'tag_id');
    }

    public function getDueDateAttribute($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d');
        }
        return date('d/m/Y', strtotime($value));
    }

    // convert completed_at to date format
    public function getCompletedAtAttribute($value)
    {
        if ($value == null) {
            return null;
        }
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d');
        }
        return date('d/m/Y', strtotime($value));
    }

    public static function convertDate($task)
    {
        $task->due_date = $task->due_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $task->due_date)->format('Y-m-d') : null;
        return $task;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($task) {
            $task->tags()->detach();
        });

        static::creating(function($task) {
            self::convertDate($task);
        });

        static::updating(function($task) {
            self::convertDate($task);
            if ($task->status == StatusEnum::Done) {
                $task->completed_at = date('Y-m-d');
            }
        });
    }
}
