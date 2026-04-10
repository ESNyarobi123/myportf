<?php

namespace App\Enums;

enum ProjectLifecycleStatus: string
{
    case Draft = 'draft';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Archived = 'archived';
}
