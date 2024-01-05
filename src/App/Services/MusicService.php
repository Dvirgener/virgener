<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class MusicService
{
    private $musicPlaylist = array();

    public function __construct(private Database $db)
    {
    }


    public function addSongtoPlaylist(array $song)
    {
        if (!isset($_SESSION['playlist'])) {
            $_SESSION['playlist'] = [];
        }
        $_SESSION['playlist'][] = $song;
    }

    public function queueMusic()
    {
        return array_shift($_SESSION['playlist']);
    }

    public function addSongtoDB(array $formData)
    {
        $this->db->query("INSERT INTO karaoke (artist, title, youtube, mode, added_by)
        VALUES (:artist,:title,:youtube,:mode,:added_by)", [
            'artist' => $formData['artist'],
            'title' => $formData['title'],
            'youtube' => $formData['url'],
            'mode' => $formData['mode'],
            'added_by' => $_SESSION['user']
        ]);

        redirectTo('/karaoke');
    }

    public function getSongs(): array
    {
        $allSongs = $this->db->query("SELECT * FROM karaoke")->findAll();
        return $allSongs;
    }

    public function getOneSong($id): array
    {
        $oneSong = $this->db->query("SELECT * FROM karaoke WHERE id={$id}")->find();
        return $oneSong;
    }

    public function editSong($formData)
    {
        $this->db->query("UPDATE karaoke SET artist = :artist, title = :title, youtube = :url, mode = :mode WHERE id = :id", [
            'artist' => $formData['artist'],
            'title' => $formData['title'],
            'url' => $formData['url'],
            'mode' => $formData['mode'],
            'id' => $formData['id']
        ]);
    }

    public function deleteSong($id)
    {
        $this->db->query("DELETE FROM karaoke WHERE id= :id", ['id' => $id]);
    }

    public function addPlays($id, $plays)
    {
        $updatedPlays = $plays + 1;
        $this->db->query("UPDATE karaoke SET plays = :plays WHERE id= :id", ['plays' => $updatedPlays, 'id' => $id]);
    }

    public function liveSearch(string $searchingFor)
    {
        $searchRes = $this->db->query(
            "SELECT * FROM karaoke WHERE title LIKE :search '%' OR artist LIKE :search '%'",
            [
                'search' => $searchingFor
            ]
        )->findAll();

        return $searchRes;
    }
}
