<?php

declare(strict_types=1);

namespace App\config;

// This class only provide path constants to our app
class paths
{
    public const VIEW = __DIR__ . "/../views";
    public const SOURCE = __DIR__ . "/../../";
    public const ROOT = __DIR__ . "/../../../";
    public const STORAGE_UPLOADS_SAA = __DIR__ . "/../../../storage/SaaFiles";
    public const STORAGE_UPLOADS_PROFPIC = __DIR__ . "/../../../storage/ProfPic";
    public const STORAGE_UPLOADS_WORKREF = __DIR__ . "/../../../storage/workRef";
}
