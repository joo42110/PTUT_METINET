<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/03/2017
 * Time: 16:01
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends Controller
{

    public function editAction(Request $request,$teamId){

        $em = $this->getDoctrine()->getManager();

        $team =  $em->getRepository('AppBundle:Team')->findOneById($teamId);

        if (!$team) {
            throw $this->createNotFoundException("Cette équipe n'existe pas.");
        }

        /*$form = $this->createForm(TournamentType::class, $team, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tournament = $form->getData();

            $em->persist($tournament);
            $em->flush();
        }

        return $this->render('AppBundle/Tournament/edit.html.twig', array(
            'form' => $form->createView(),
        ));*/

        return new JsonResponse('Edition de la team '.$teamId);
    }
}