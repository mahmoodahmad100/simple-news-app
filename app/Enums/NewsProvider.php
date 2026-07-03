<?php

namespace App\Enums;

enum NewsProvider: string
{
    case NEWS_API = 'newsapi';
    case GUARDIAN = 'guardian';
    case NYTIMES = 'nytimes';
}