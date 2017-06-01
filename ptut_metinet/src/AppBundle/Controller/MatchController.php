<?php
/**
 * Created by PhpStorm.
 * User: Ororen
 * Date: 17/05/2017
 * Time: 10:31 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Match;
use AppBundle\Form\MatchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


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

    public function editAction(Request $request,$matchId){


        $em = $this->getDoctrine()->getManager();

        $match =  $em->getRepository(Match::class)->findOneById($matchId);


        if (!$match) {
            return new JsonResponse("Ce match n'existe pas.",404);
        }

        $form = $this->createForm(MatchType::class, $match, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion du conflit arbitre/horaire
            if($match->getRound()->getReferees()->contains($match->getReferee())){
                //Si l'arbitre a déjà un match sur cet horaire
                return new JsonResponse('Cet arbitre a déjà un match programmé sur ce créneau horaire',500);
            }
            else{
                $match->getReferee()->addRound($match->getRound());
            }

            //Gestion du conflit terrain/horaire
            if($match->getRound()->getFields()->contains($match->getField())){
                //Si le terrain accueille déjà un match sur cet horaire
                return new JsonResponse('Ce terrain a déjà un match programmé sur ce créneau horaire',500);
            }
            else{
                $match->getField()->addRound($match->getRound());
            }

            $match->setProgramed(true);

            $em->persist($match);
            $em->flush();

            return new JsonResponse();


        }


        return $this->render('AppBundle/Match/edit.html.twig', array(
                'form' => $form->createView(),
                'match' => $match,
        ));

    }
}