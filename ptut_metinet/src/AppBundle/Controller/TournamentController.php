<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 09/03/2017
 * Time: 15:18
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TournamentController extends Controller
{

    public function listAction(Request $request){
       // $em = $this->getDoctrine()->getManager();
        //TODO : Import tournaments from database
        $tournaments = array(
            new Tournament("Tournoi du test"),
        );

        return $this->render('AppBundle/Tournament/list.html.twig', array(
            'tournaments' => $tournaments,
        ));
    }

}