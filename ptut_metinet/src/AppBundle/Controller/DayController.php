<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 09/03/2017
 * Time: 15:18
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Day;
use AppBundle\Form\DayRoundsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DayController extends Controller
{

    public function editAction(Request $request,$dayId){

        $em = $this->getDoctrine()->getManager();

        $day =  $em->getRepository(Day::class)->findOneById($dayId);

        if (!$day) {
            return new JsonResponse("Ce jour de tournoi n'existe pas.",500);
        }

        $form = $this->createForm(DayRoundsType::class, $day, array(
            'method' => 'POST',
        ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach($day->getRounds()->toArray() as $round){
                $round->setDay($day);
            }

            $em->persist($day);
            $em->flush();

            return new JsonResponse();


        }

        $responseData = [
            "dayDate" => $day->getDate()->format('d/m/Y'),
            "renderedView" => $this->render('AppBundle/Day/edit.html.twig', array(
                'form' => $form->createView(),
                'tournament' => $day,
            ))->getContent()
        ];

        return new JsonResponse($responseData);
    }


}