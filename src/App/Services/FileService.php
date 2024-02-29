<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\config\paths;
use Dotenv\Store\File\Paths as FilePaths;

class FileService
{

    public function __construct(private Database $db)
    {
    }

    // public function fileValidator(?array $formData)
    // {

    //     if (!$formData || $formData['error'] !== UPLOAD_ERR_OK) {
    //         throw new ValidationException([
    //             'receipt' => ["Failed to upload File!"]
    //         ]);
    //     }

    //     $maxFileSizeMB = 3 * 1024 * 1024;


    //     $originalFileName = $formData['name'];

    //     if (!preg_match('/^[A-Za-z0-9\s._-]+$/', $originalFileName)) {
    //         throw new ValidationException(['receipt' => ["Invalid Filename!"]]);
    //     }
    // }

    public function upload(string $created_from, string $idFrom, array $fileData)
    {
        // * this is to extract individual file details and put in an array
        if ($fileData['workfiles']['name'][0] !== "") {
            $numberofFiles = count($fileData['workfiles']['name']);
            $allFiles = [];
            for ($x = 0; $x < $numberofFiles; $x += 1) {
                $tempName = $fileData['workfiles']['tmp_name'][$x];
                $originalName = $fileData['workfiles']['name'][$x];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $saveName = bin2hex(random_bytes(4)) . "_" . $fileData['workfiles']['name'][$x];
                $fileType = $fileData['workfiles']['type'][$x];
                $oneFile = [
                    'tempName' => $tempName,
                    'originalName' => $originalName,
                    'saveName' => $saveName,
                    'fileType' => $fileType,
                    'fileExtension' => $fileExtension
                ];
                $allFiles[] = $oneFile;
            }

            // * Uploading of files to DB and folder
            foreach ($allFiles as $file) {
                $uploadpath = paths::STORAGE_UPLOADS_FILEREFERENCE . "/" . $file['saveName'];
                if (!move_uploaded_file($file['tempName'], $uploadpath)) {
                }
                $this->db->query(
                    "INSERT INTO uploads (upload_from, file_original_name, file_save_name, file_type, file_extension)
                        VALUES (:uploadFrom, :originalName, :saveName, :fileType, :fileExtenstion)",
                    [
                        'uploadFrom' => $created_from,
                        'originalName' => $file['originalName'],
                        'saveName' => $file['saveName'],
                        'fileType' => $file['fileType'],
                        'fileExtenstion' => $file['fileExtension']
                    ]
                );
                $ids[] = $this->db->id();
            }

            // * Updating the work or update table to insert identity of files
            $fileIdsToSave = serialize($ids);
            switch ($created_from) {
                case "addWork":
                    $this->db->query("UPDATE work SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "editWork":
                    $workFileIds = $this->db->query("SELECT * FROM work WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['files']);
                    foreach ($workFileIds as $file) {
                        $fileName = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $file])->find();
                        $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . "/" . $fileName['file_save_name'];
                        unlink($filePath);
                        $this->db->query("DELETE FROM uploads WHERE id = :id", ['id' => $file]);
                    }
                    $this->db->query("UPDATE work SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    return $workFileIds;
                    break;
                case "updateWork":
                    $this->db->query("UPDATE updates SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "updateSubWork":
                    $this->db->query("UPDATE updates SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "complySubWork":
                    $this->db->query("UPDATE updates SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "complyWork":
                    $this->db->query("UPDATE updates SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
            }
        }
    }

    public function getFile(string $id)
    {
        $file = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $id])->find();
        return $file;
    }

    public function read(array $file)
    {
        // dd($file);
        $file = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $file['file']])->find();

        $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . '/' . $file['file_save_name'];
        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        header("Content-Disposition: inline;filename={$file['file_save_name']}");
        header("Content-Type: {$file['file_type']}");
        readfile($filePath);
    }

    // public function delete(array $receipt)
    // {
    //     $filePath = paths::STORAGE_UPLOADS . '/' . $receipt['storage_filename'];
    //     unlink($filePath);
    //     $this->db->query("DELETE FROM receipts WHERE id = :id", ['id' => $receipt['id']]);
    // }
}
