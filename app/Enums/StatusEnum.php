<?php

namespace App\Enums;

use App\Enums\Traits\BackedEnum;

enum StatusEnum: string
{
    use BackedEnum;
    case Todo = 'todo';

    case InProgress = 'in_progress';

    case Done = 'done';
}
