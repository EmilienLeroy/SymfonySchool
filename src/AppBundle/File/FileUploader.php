<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 06/02/2018
 * Time: 15:11
 */

namespace AppBundle\File;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $pathTOproject;

    private $uploadDirectoryFile;

    public function __construct($pathTOproject, $uploadDirectoryFile)
    {
        $this->pathTOproject = $pathTOproject;
        $this->uploadDirectoryFile = $uploadDirectoryFile;
    }

    public function upload(UploadedFile $file, $salt)
    {
        $generatedFileName = time().'_'.$salt.'.'.$file->guessClientExtension();
        $path = $this->pathTOproject.'/web'.$this->uploadDirectoryFile;


        $file->move($path, $generatedFileName);

        return $generatedFileName;
    }
}