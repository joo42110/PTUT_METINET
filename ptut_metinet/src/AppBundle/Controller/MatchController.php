<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 17/05/2017
 * Time: 10:31 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Match;
use AppBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MatchController extends Controller
{
    public function viewAction($matchId){


        $em = $this->getDoctrine()->getManager();

        $match =  $em->getRepository(Match::class)->findOneById($matchId);


        if (!$match) {
            throw $this->createNotFoundException("Ce match n'existe pas.");
        }

        return $this->render('AppBundle/Match/view.html.twig', array(
                'match' => $match,
        ));

    }
}