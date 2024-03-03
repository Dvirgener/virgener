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

    private function actualUpload(string $created_from, array $fileData): array
    {
        $numberofFiles = count($fileData['name']);
        $allFiles = [];
        for ($x = 0; $x < $numberofFiles; $x += 1) {
            $tempName = $fileData['tmp_name'][$x];
            $originalName = $fileData['name'][$x];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $saveName = bin2hex(random_bytes(4)) . "_" . $fileData['name'][$x];
            $fileType = $fileData['type'][$x];
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
        return $ids;
    }

    public function deleteExistingFiles(array $files)
    {
        foreach ($files as $file) {
            $fileName = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $file])->find();
            $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . "/" . $fileName['file_save_name'];
            unlink($filePath);
            $this->db->query("DELETE FROM uploads WHERE id = :id", ['id' => $file]);
        }
    }

    public function upload(string $created_from, string $idFrom, array $fileData)
    {
        if ($fileData['name'][0] !== "") {
            $ids = $this->actualUpload($created_from, $fileData);

            // * Updating the work or update table to insert identity of files
            $fileIdsToSave = serialize($ids);
            switch ($created_from) {
                case "addWork":
                    $this->db->query("UPDATE work SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "editWork":
                    $workFileIds = $this->db->query("SELECT files FROM work WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['files']);
                    $this->deleteExistingFiles($workFileIds);
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
                case "updateUpdateWork":
                    $workFileIds = $this->db->query("SELECT files FROM updates WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['files']);
                    $this->deleteExistingFiles($workFileIds);
                    $this->db->query("UPDATE updates SET files = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
            }
        }
    }

    public function vehicleUpload(string $created_from, string $idFrom, array $fileData)
    {
        if ($fileData['name'][0] !== "") {
            $ids = $this->actualUpload($created_from, $fileData);

            // * Updating the work or update table to insert identity of files
            $fileIdsToSave = serialize($ids);
            switch ($created_from) {
                case "pictures":
                    $this->db->query("UPDATE vehicles SET pictures = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "certOfReg":
                    $this->db->query("UPDATE vehicles SET cert_reg = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "officialReceipt":
                    $this->db->query("UPDATE vehicles SET official_receipt = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "insurance":
                    $this->db->query("UPDATE vehicles SET insurance_policy = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "updatePictures":
                    $workFileIds = $this->db->query("SELECT pictures FROM vehicles WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['pictures']);
                    $this->deleteExistingFiles($workFileIds);
                    $this->db->query("UPDATE vehicles SET pictures = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "updateCertOfReg":
                    $workFileIds = $this->db->query("SELECT cert_reg FROM vehicles WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['cert_reg']);
                    $this->deleteExistingFiles($workFileIds);
                    $this->db->query("UPDATE vehicles SET cert_reg = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "updateOfficialReceipt":
                    $workFileIds = $this->db->query("SELECT official_receipt FROM vehicles WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['official_receipt']);
                    $this->deleteExistingFiles($workFileIds);
                    $this->db->query("UPDATE vehicles SET official_receipt = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
                    break;
                case "updateInsurance":
                    $workFileIds = $this->db->query("SELECT insurance_policy FROM vehicles WHERE id = :id", ['id' => $idFrom])->find();
                    $workFileIds = unserialize($workFileIds['insurance_policy']);
                    $this->deleteExistingFiles($workFileIds);
                    $this->db->query("UPDATE vehicles SET insurance_policy = :fileIds WHERE id = :id", ['fileIds' => $fileIdsToSave, 'id' => $idFrom]);
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
        $file = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $file['file']])->find();

        $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . '/' . $file['file_save_name'];
        if (!file_exists($filePath)) {
            redirectTo('/');
        }
        header("Content-Disposition: inline;filename={$file['file_save_name']}");
        header("Content-Type: {$file['file_type']}");
        readfile($filePath);
    }

    public function deleteFile(array $files)
    {
        foreach ($files as $file) {
            $fileDetails = $this->db->query("SELECT * FROM uploads WHERE id = :id", ['id' => $file])->find();
            $filePath = paths::STORAGE_UPLOADS_FILEREFERENCE . '/' . $fileDetails['file_save_name'];
            unlink($filePath);
            $this->db->query("DELETE FROM uploads WHERE id = :id", ['id' => $fileDetails['id']]);
        }
    }
}
