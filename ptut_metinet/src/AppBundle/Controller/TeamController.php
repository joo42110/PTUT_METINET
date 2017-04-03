<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 29/03/2017
 * Time: 16:01
 */

namespace AppBundle\Controller;


use AppBundle\Form\TeamEditType;
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

        $form = $this->createForm(TeamEditType::class, $team, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $team = $form->getData();

            // Doctrine is not injecting reference in the objects so we do it manually
            foreach($team->getPlayers() as $player){
                $player->setTeam($team);
            }

            $em->persist($team);
            $em->flush();

            return($this->redirectToRoute('add_teams',array('tournamentId' => $team->getTournament()->getId())));
        }

        return $this->render('AppBundle/Team/edit.html.twig', array(
            'form' => $form->createView(),
            'team' => $team,
        ));

    }
}