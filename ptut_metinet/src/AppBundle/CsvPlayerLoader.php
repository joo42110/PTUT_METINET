<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 10:34
 */

namespace AppBundle;

use Doctrine\Common\Collections\ArrayCollection;

class CsvPlayerLoader
{
    private $csv_folder;

    /**
     * CsvPlayerLoader constructor.
     * @param $csv_folder
     */
    public function __construct($csv_folder)
    {
        $this->csv_folder = $csv_folder;
    }


    /**
     * @param string $csv_file
     *
     * @return ArrayCollection
     */
    public function load($csv_file){

        fopen($this->csv_folder.'/'.$csv_file,'r');

        return new ArrayCollection();

    }


}