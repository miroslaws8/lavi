<?php

namespace utils;

use bundle\Config;

class Uploader
{
    private static $allowedMIME = [
        "image" => array('image/jpeg', 'image/png', 'image/gif'),
        "csv"   => array('text/csv', 'application/vnd.ms-excel', 'text/plain'),
        "file"  => array('application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf',
            'application/zip',
            'application/vnd.ms-powerpoint')
    ];

    private static $fileSize = [100, 5242880];

    private function __construct()
    {

    }

    public static function uploadPicture($file, $storagePath, $id)
    {
        self::$fileSize = [100, 2097152];

        $storagePath = Config::get('STORAGE_PATH').$storagePath;
        return self::upload($file, $storagePath, $id, "image");
    }

    private static function upload($file, $dir, $id, $type = "file")
    {
        $mimeTypes  = self::getAllowedMime($type);
        $filename   = self::getFileName($file);

        $ext = self::MimeToExtension(self::mime($file));

        $hashedFileName = self::getHashedName($id);
        $basename       = $hashedFileName.".".$ext;
        $path           = $dir.$basename;

        self::deleteFiles($dir.$hashedFileName, $mimeTypes);

        $data = [
            "filename"        => $filename,
            "basename"        => $basename,
            "hashed_filename" => $hashedFileName,
            "extension"       => $ext
        ];

        if (!move_uploaded_file($file['tmp_name'], $path)) {
            throw new \Exception("File couldn't be uploaded");
        }

        if (!chmod($path, 0644)) {
            throw new \Exception("File permissions couldn't be changed");
        }

        return $data;
    }

    private static function mime($file)
    {
        return mime_content_type($file['tmp_name']);
    }

    private static function getAllowedMime($key)
    {
        return isset(self::$allowedMIME[$key])? self::$allowedMIME[$key]: [];
    }

    private static function deleteFiles($filePathWithoutExtension, $allowedMIME)
    {

        foreach ($allowedMIME as $mime) {
            $ext = self::MimeToExtension($mime);
            $path = $filePathWithoutExtension . "." . $ext;

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public static function deleteFile($path)
    {
        if (file_exists($path)) {
            if (!unlink($path)) {
                throw new \Exception("File ". $path ." couldn't be deleted");
            }
        } else {
            throw new \Exception("File ". $path ." doesn't exist!");
        }
    }

    private static function getFileName($file)
    {
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $filename = preg_replace("/([^A-Za-z0-9_\-\.]|[\.]{2})/", "", $filename);
        $filename = basename($filename);
        return $filename;
    }

    private static function MimeToExtension($mime)
    {
        $arr = array(
            'image/jpeg' => 'jpeg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
        );
        return isset($arr[$mime])? $arr[$mime]: null;
    }

    private static function getHashedName($id = null)
    {

        if($id === null) $id = time();
        return substr(hash('sha256', $id), 0, 40);
    }
}