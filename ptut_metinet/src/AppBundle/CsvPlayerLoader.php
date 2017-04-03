<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 27/03/2017
 * Time: 10:34
 */

namespace AppBundle;

use AppBundle\Entity\Player;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Definition\Exception\Exception;

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

        $file = fopen($this->csv_folder.'/'.$csv_file,'r');

        $collection = new ArrayCollection();

        $first_line = true;
        while (($data = fgetcsv($file,0,";")) !== false) {
            if(!$first_line){
                for($i=0;$i<3;$i++){
                    $data[$i] = utf8_encode($data[$i]); //Gestion des accents éventuels
                }

                //$player = new Player($data[0],$data[1],$data[2]);
                $player = new Player();
                $player->setName($data[0]);
                $player->setFirstname($data[1]);
                $player->setLicenceNumber($data[2]);

                $collection->add($player);

            }
            $first_line = false;
        }

        fclose($file);

        return $collection;

    }


}