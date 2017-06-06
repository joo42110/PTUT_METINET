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
use AppBundle\Form\MatchType;
use Doctrine\Common\Util\Debug;
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
        if ($match->isPlayed()) {
            return new JsonResponse("Ce match à déjà été joué.",500);
        }



        $errorNoRound = false;
        if ($match->getTournament()->getDays()->count() > 0) { //Y'a-t-il des jours de tournoi ?
            foreach($match->getTournament()->getDays()->toArray() as $day){ //Si oui, ses jours on-t-ils tous au moins 1 créneau horaire ?
                if($day->getRounds()->count() <= 0){
                    $errorNoRound = true;
                }
            }
        }
        else{
            $errorNoRound = true;
        }


        if($errorNoRound){
            return new JsonResponse("Vous devez ajouter des créneaux horaire aux jours de ce tournoi avant de pouvoir commencer a programmer les matchs",500);
        }


        $form = $this->createForm(MatchType::class, $match, array(
            'method' => 'POST',
        ));

        //Sauvegarde de la référence vers l'ancien arbitre et terrain pour les libérer sur ce créneau si ils sont changés
        $oldReferee = $match->getReferee();
        $oldField = $match->getField();
        $oldRound = $match->getRound();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion du conflit arbitre/horaire
            if($match->getRound()->getReferees()->contains($match->getReferee())){
                //Si l'arbitre a déjà un match sur cet horaire
                return new JsonResponse('Cet arbitre a déjà un match programmé sur ce créneau horaire',500);
            }
            else{
                if($oldReferee !== null &&  $oldRound !== null){ //Retrait des anciennes associations arbitre/créneau
                    $oldReferee->removeRound($oldRound);
                }
                $match->getReferee()->addRound($match->getRound());
            }

            //Gestion du conflit terrain/horaire
            if($match->getRound()->getFields()->contains($match->getField())){
                //Si le terrain accueille déjà un match sur cet horaire
                return new JsonResponse('Ce terrain a déjà un match programmé sur ce créneau horaire',500);
            }
            else{
                if($oldField !== null &&  $oldRound !== null){ //Retrait des anciennes associations terrain/créneau
                    $oldField->removeRound($oldRound);
                }
                $match->getField()->addRound($match->getRound());
            }

            $match->setProgramed(true);

            $em->persist($match);
            $em->flush();

            return new JsonResponse();


        }
        else if($form->isSubmitted() && !$form->isValid()){
            return new JsonResponse("Erreur : données du formulaire non valides",500);
        }



        return $this->render('AppBundle/Match/edit.html.twig', array(
                'form' => $form->createView(),
                'match' => $match,
        ));

    }


    // ------------ API RELATED ACTIONS ------------

    public function addGoalAction($matchId,$teamId){
        return $this->goalChange($matchId,$teamId,"add");
    }

    public function removeGoalAction($matchId,$teamId){
        return $this->goalChange($matchId,$teamId,"remove");
    }

    public function addCardAction($matchId,$teamId,$color){
        return $this->cardChange($matchId,$teamId,"add",$color);
    }

    public function removeCardAction($matchId,$teamId,$color){
        return $this->cardChange($matchId,$teamId,"remove",$color);
    }

    public function endAction($matchId){
        $em = $this->getDoctrine()->getManager();

        $match =  $em->getRepository(Match::class)->findOneById($matchId);
        if (!$match) {
            return new JsonResponse("Ce match n'existe pas.",404);
        }

        if ($this->getUser() != $match->getReferee()) {
            return new JsonResponse("Vous n'êtes pas l'arbitre de ce match.",403);
        }


        if ($match->isPlayed()) {
            return new JsonResponse("Ce match a déjà été joué.",500);
        }

        $match->setPlayed(true);
        $match->setMatchEndTime(new \DateTime());

        $em->persist($match);
        $em->flush();

        return new JsonResponse();
    }

    // ------------ FONCTIONS NON ROUTABLES (Factorisation du code) ------------

    /* Appeler la fonction avec
     *  $action = "add" | Ajouter un but
     *  $action = "remove" | Retirer un but
     */
    public function goalChange($matchId,$teamId,$action){

        $em = $this->getDoctrine()->getManager();

        $match =  $em->getRepository(Match::class)->findOneById($matchId);
        if (!$match) {
            return new JsonResponse("Ce match n'existe pas.",404);
        }

        if ($this->getUser() != $match->getReferee()) {
            return new JsonResponse("Vous n'êtes pas l'arbitre de ce match.",403);
        }

        if ($match->isPlayed()) {
            return new JsonResponse("Ce match a déjà été joué.",500);
        }

        $team =  $em->getRepository(Team::class)->findOneById($teamId);
        if (!$team){
            return new JsonResponse("Cette équipe n'existe pas.",404);
        }

        if(!$match->getTeams()->contains($team)){
            return new JsonResponse("Cette équipe n'appartient pas a ce match.",500);
        }

        foreach($match->getScores() as $score){
            if($score->getTeam() == $team){

                if($action == "add"){
                    $score->addGoal();
                }
                else if($action == "remove"){
                    $score->removeGoal();
                }
                else{
                    throw new \Exception('Valeur du paramètre $action invalide : la valeur devrait être "add" ou "remove"');
                }

                $em->persist($score);
                $em->flush();

                return new JsonResponse($score->getGoals());
            }
        }

        return new JsonResponse("Erreur interne : aucun objet Score associé a cette équipe pour ce match.",500);

    }

    /* Appeler la fonction avec
     *  $action = "add" | Ajouter un carton
     *  $action = "remove" | Retirer un carton
     * --------------------------
     *  $color = "yellow" | Carton jaune
     *  $color = "red" | Carton rouge
     */
    public function cardChange($matchId,$teamId,$action,$color){

        $em = $this->getDoctrine()->getManager();

        $match =  $em->getRepository(Match::class)->findOneById($matchId);
        if (!$match) {
            return new JsonResponse("Ce match n'existe pas.",404);
        }

        if ($this->getUser() != $match->getReferee()) {
            return new JsonResponse("Vous n'êtes pas l'arbitre de ce match.",403);
        }

        if ($match->isPlayed()) {
            return new JsonResponse("Ce match a déjà été joué.",500);
        }

        $team =  $em->getRepository(Team::class)->findOneById($teamId);
        if (!$team){
            return new JsonResponse("Cette équipe n'existe pas.",404);
        }

        if(!$match->getTeams()->contains($team)){
            return new JsonResponse("Cette équipe n'appartient pas a ce match.",500);
        }

        foreach($match->getCards() as $cards){
            if($cards->getTeam() == $team){

                if($color == "yellow" || $color == "red"){
                    if($action == "add"){
                        $functionName = "add" . ucfirst($color);
                        $cards->$functionName();
                    }
                    else if($action == "remove"){
                        $functionName = "remove" . ucfirst($color);
                        $cards->$functionName();
                    }
                    else{
                        throw new \Exception('Valeur du paramètre $action invalide : la valeur devrait être "add" ou "remove"');
                    }
                }
                else{
                    return new JsonResponse('Couleur du carton invalide : la valeur devrait être "red" ou "yellow"',500);
                }


                $em->persist($cards);
                $em->flush();

                $getterName = "get" . ucfirst($color);
                $return = $cards->$getterName();
                return new JsonResponse($return);
            }
        }

        return new JsonResponse("Erreur interne : aucun objet Cards associé a cette équipe pour ce match.",500);

    }


}