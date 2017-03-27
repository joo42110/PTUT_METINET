<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 09/03/2017
 * Time: 15:18
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Tournament;
use AppBundle\Form\AddTeamsType;
use AppBundle\Form\TournamentType;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TournamentController extends Controller
{

    public function listAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tournaments = $em->getRepository('AppBundle:Tournament')->findAll();


        return $this->render('AppBundle/Tournament/list.html.twig', array(
            'tournaments' => $tournaments,
        ));
    }

    public function createAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TournamentType::class, null, array(
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
        ));


        
    }

    public function editAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository('AppBundle:Tournament')->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        $form = $this->createForm(TournamentType::class, $tournament, array(
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
        ));
    }

    public function addTeamsAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository('AppBundle:Tournament')->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        $form = $this->createForm(AddTeamsType::class, $tournament, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tournament = $form->getData();

            // Doctrine is not injecting reference in the objects so we do it manually
            foreach($tournament->getTeams() as $team){
                $team->setTournament($tournament);
                foreach($team->getPlayers() as $player){
                    $player->setTeam($team);
                }
            }


            $em->persist($tournament);
            $em->flush();
        }

        return $this->render('AppBundle/Tournament/addteams.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}