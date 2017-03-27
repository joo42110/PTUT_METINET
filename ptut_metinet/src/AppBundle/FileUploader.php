<?php
namespace AppBundle;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }


    public function uploadCsv(UploadedFile $file)
    {

        $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
        if(in_array($file->getMimeType(),$mimes)){
            $filename = md5(uniqid()) . '.csv';
            $file->move($this->targetDir, $filename);
            return $filename;
        } else {
            throw new Exception('Bad File Extension');
            //return null;
        }

    }


    public function deleteFile($fileName){
        unlink($this->targetDir . '/' . $fileName);
    }


}
// Code from Symfony documentation
//
//
// Refer to https://symfony.com/doc/2.8/reference/forms/types/file.html