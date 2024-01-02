<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\musicPlaylist;


class playerController
{

    public function __construct(private TemplateEngine $view)
    {
    }

    public function player()
    {

        echo $this->view->render('karaoke/player.php', ['title' => 'About']);
    }
}
