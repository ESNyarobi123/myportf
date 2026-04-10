<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case ContentManager = 'content_manager';
    case Editor = 'editor';
}
