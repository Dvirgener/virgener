<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\config\paths;
use App\Services\{MusicService};


class KaraokeController
{
    public function __construct(private TemplateEngine $view, private MusicService $musicService)
    {
    }


    public function karaokeMain()
    {
        $allSongs = $this->musicService->getSongs();
        echo $this->view->render("karaoke/karaokemain.php", ['allSongs' => $allSongs]);
    }

    public function addSong()
    {

        $this->musicService->addSongtoPlaylist($_POST);
        redirectTo('/karaoke');
    }

    public function addSongtoDB()
    {
        $this->musicService->addSongtoDB($_POST);
    }

    public function editSong()
    {
        $editSong = $this->musicService->getOneSong($_GET['id']);
        echo $this->view->render("karaoke/editMusic.php", ['editSong' => $editSong]);
    }
    public function editSongSave()
    {
        $this->musicService->editSong($_POST);
        redirectTo('/karaoke');
    }

    public function deleteSong()
    {
        $this->musicService->deleteSong($_GET['delete']);
        redirectTo('/karaoke');
    }

    public function addSongtoCue()
    {
        $songData = $this->musicService->getOneSong($_GET['cue']);
        $this->musicService->addSongtoPlaylist($songData);
    }

    public function liveSearch()
    {
        $result = $this->musicService->liveSearch($_GET['input']);
        echo $this->view->render("karaoke/liveSearch.php", ['searchResult' => $result]);

    }
}
