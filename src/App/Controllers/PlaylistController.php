<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{TransactionService, MusicService};


class playlistController
{
    public function __construct(private TemplateEngine $view, private MusicService $musicPlaylist)
    {
    }

    public function playlist()
    {
        $queue = $this->musicPlaylist->queueMusic();
        if ($queue == null) {
            redirectTo('/karaoke');
        }
        $this->musicPlaylist->addPlays($queue['id'], $queue['plays']);
        echo $this->view->render(
            "karaoke/playlist.php",
            [
                'queue' => $queue['youtube'],
                'songTitle' => $queue['title'],
                'title' => $queue['title'],
                'artist' => $queue['artist']
            ]
        );
    }
}
