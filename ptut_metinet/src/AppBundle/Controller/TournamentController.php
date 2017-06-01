<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 09/03/2017
 * Time: 15:18
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Day;
use AppBundle\Entity\Pool;
use AppBundle\Entity\Tournament;
use AppBundle\Form\AddFieldsType;
use AppBundle\Form\AddTeamsType;
use AppBundle\Form\DayType;
use AppBundle\Form\TournamentDaysType;
use AppBundle\Form\TournamentType;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TournamentController extends Controller
{

    public function listAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tournaments = $em->getRepository(Tournament::class)->findAll();


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


            return $this->redirectToRoute('add_teams',array(
                'tournamentId' => $tournament->getId()
            ));
        }

        return $this->render('AppBundle/Tournament/edit.html.twig', array(
            'form' => $form->createView(),
        ));


        
    }

    public function editAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

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

            return $this->redirectToRoute('add_teams',array(
                        'tournamentId' => $tournament->getId()
                    ));
        }

        return $this->render('AppBundle/Tournament/edit.html.twig', array(
            'form' => $form->createView(),
            'tournament' => $tournament,
        ));
    }

    public function deleteAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            return new JsonResponse("Ce tournoi n'existe pas.",404);
        }

        $em->remove($tournament);
        $em->flush();

        return new JsonResponse();
    }

    public function addTeamsAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        $form = $this->createForm(AddTeamsType::class, $tournament, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Doctrine is not injecting reference in the objects so we do it manually
            foreach($tournament->getTeams() as $team){
                $team->setTournament($tournament);
                if($team->getPlayers() !== null){
                    foreach($team->getPlayers() as $player){
                        $player->setTeam($team);
                    }
                }

            }


            $em->persist($tournament);
            $em->flush();

            return($this->redirectToRoute('add_fields',array('tournamentId' => $tournament->getId())));

            
        }

        return $this->render('AppBundle/Tournament/addteams.html.twig', array(
            'form' => $form->createView(),
            'tournament' => $tournament,
        ));

    }

    public function addFieldsAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        $form = $this->createForm(AddFieldsType::class, $tournament, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Doctrine is not injecting reference in the objects so we do it manually
            foreach($tournament->getFields() as $field){
                $field->setTournament($tournament);

            }


            $em->persist($tournament);
            $em->flush();

            return($this->redirectToRoute('validate_tournament',array('tournamentId' => $tournament->getId())));


        }

        return $this->render('AppBundle/Tournament/addfields.html.twig', array(
            'form' => $form->createView(),
            'tournament' => $tournament,
        ));

    }

    public function validateAction($tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        return $this->render('AppBundle/Tournament/validate.html.twig', array(
            'tournament' => $tournament
        ));
    }

    public function validationStatusAction($tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            return new JsonResponse("Ce tournoi n'existe pas",404);
        }

        $errors = $tournament->validate();

        //Si la validation a renvoyé des erreurs
        if(!empty($errors)){
            return new JsonResponse($errors,500);
        }
        else {

            $tournament->initialize();


            $em->persist($tournament);
            $em->flush();

            return new JsonResponse();
        }

    }

    public function programAction($tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            throw $this->createNotFoundException("Ce tournoi n'existe pas.");
        }

        return $this->render(':AppBundle/Tournament:program.html.twig',array(
            'tournament' => $tournament
        ));

    }

    public function programRoundsAction($tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            return new JsonResponse("Ce tournoi n'existe pas.",404);
        }


        return new JsonResponse($this->render(':AppBundle/Tournament:programRounds.html.twig',array(
            'tournament' => $tournament,
        ))->getContent());

    }

    public function addDayAction(Request $request,$tournamentId){

        $em = $this->getDoctrine()->getManager();

        $tournament =  $em->getRepository(Tournament::class)->findOneById($tournamentId);

        if (!$tournament) {
            return new JsonResponse("Ce tournoi n'existe pas.",404);
        }

        $day = new Day();

        $form = $this->createForm(DayType::class, $day, array(
            'method' => 'POST',
        ));

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //Verficiation que le jour n'existe pas déjà dans le tournoi

            foreach($tournament->getDays()->toArray() as $existingDay){
                if($existingDay->getDate() == $day->getDate()){
                    return new JsonResponse('Ce jour a déjà été ajouté',500);
                }
            }

            $tournament->addDay($day);

            $em->persist($day);
            $em->flush();

            return new JsonResponse();
        }


        if($request->getMethod() === "POST"){Debug::dump($form->getErrors());};

        return new JsonResponse($this->render(':AppBundle/Tournament:addDay.html.twig',array(
            'form' => $form->createView()
        ))->getContent());

    }


}