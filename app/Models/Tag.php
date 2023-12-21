<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_tag', 'tag_id', 'task_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($tag) {
            $tasks = $tag->tasks;
            foreach ($tasks as $task) {
                $task->tags()->detach($tag->id);
            }
        });
    }

}
