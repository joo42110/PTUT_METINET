<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 10:25
 */

namespace AppBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CsvToPlayersTransformer implements DataTransformerInterface
{

    private $player_loader;
    private $file_uploader;

    /**
     * CsvToPlayersTransformer constructor.
     * @param $player_loader
     * @param $file_uploader
     */
    public function __construct($player_loader, $file_uploader)
    {
        $this->player_loader = $player_loader;
        $this->file_uploader = $file_uploader;
    }


    /**
     *
     * @param ArrayCollection $players
     * @return null
     */
    public function transform($players)
    {
        return null;
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  UploadedFile $csv_file
     * @return ArrayCollection
     */
    public function reverseTransform($csv_file)
    {

        $csv_filename = $this->file_uploader->uploadCsv($csv_file);
        $players = $this->player_loader->load($csv_filename);
        $this->file_uploader->deleteFile($csv_filename);


        return $players;


    }

}