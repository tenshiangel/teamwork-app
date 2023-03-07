<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum as RulesEnum;

final class TaskStatus extends RulesEnum
{
    const ToDo = 'to-do';
    const Ongoing = 'ongoing';
    const Closed = 'closed';
    const Removed = 'removed';
}
