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