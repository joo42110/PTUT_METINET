<?php
namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\UserType;
use UserBundle\Entity\User;
use \Doctrine\Common\Util\Debug;

class UserController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findBy(array(), array('created' => 'desc'));

        return $this->render('UserBundle/User/list.html.twig', array(
            'users' => $users
        ));
    }

    public function newAction(Request $request)
    {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute("homepage");
        }


        $em = $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(UserType::class, $user, array(
            'method' => 'POST',
        ));

        $errors = array();
        if ($request->getMethod() == 'POST') { // Sauvegarde
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $encoder = $this->container->get('security.password_encoder');
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

                $user->setUsername($user->getMail());

                $users = $em->getRepository('UserBundle:User')->findAll();
                if(count($users) > 0)
                    $user->setRoles(array("ROLE_USER"));
                else{ //Si il n'y a pas encore d'utilisateurs, le premier utilisateur deviens le super-admin
                    $user->setRoles(array("ROLE_SUPER_ADMIN"));
                }

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute("login");

            }

            $validator = $this->get('validator');
            $errors = $validator->validate($form);


        }

        return $this->render(
            'UserBundle/User/new.html.twig',
            array(
                'form' => $form->createView(),
                'user' => $user,
                'error_msg' => $errors,

            ));

    }

    public function editAction(Request $request, $userId)
    {

        $errors = array();
        $success = false;

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneById($userId);


        if ($this->getUser()->getId() != $user->getId()) { //On vérifie que l'utilisateur essaye bien d'éditer son propre profil, ou qu'il est admin
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Ce profil appartient a un autre utilisateur, vous ne pouvez pas l'éditer !");
        }

        $oldPassword = $user->getPassword(); //We backup the old password to restore it if the user don't want to change is OR to check the old password re-input on modification

        $form = $this->createForm(UserType::class, $user, array(
            'method' => 'POST',
        ));

        if ($request->getMethod() == 'POST') { // Sauvegarde
            $form->handleRequest($request);
            $validator = $this->get('validator');
            $errors = $validator->validate($form);
            if ($form->isSubmitted() && $form->isValid()) {


                $newPassword = $user->getPassword(); //On sauvegarde le password entré par l'utilisateur


                $user->setPassword($oldPassword); //On réaffecte l'ancien mot de passe pour :
                // 1 - si l'utilisateur ne veut pas modifier son mot de passe, garder l'ancien
                // 2 - si l'utilisateur veut modifier son mot de passe, comparer l'ancien avec le champ de vérification du mot de passe

                if (!empty($newPassword)) { //Si l'utilisateur a rentré un nouveau mot de passe

                    $encoder = $this->container->get('security.password_encoder');

                    $oldPasswordCheck = $request->get('user')["oldPassword"]; //Extraction du champ "oldPassword" depuis la requête car ce champ n'est pas bind a l'objet


                    if ($encoder->isPasswordValid($user, $oldPasswordCheck)) { //On vérifie que la vérification du mot de passe correspond bien a l'ancien mot de passe
                        $user->setPassword($encoder->encodePassword($user, $newPassword));
                    } else {

                        throw new \Exception("ALED UN HACKER");
                    }
                }

                $user->setUsername($user->getMail());

                $em->persist($user);
                $em->flush();
                $success = true;

            }

        }

        return $this->render(
            'UserBundle/User/edit.html.twig',
            array(
                'form' => $form->createView(),
                'user' => $user,
                'error_msg' => $errors,
                'success' => $success
            ));

    }

    public function changeRoleAction(Request $request, $userId){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneById($userId);

        if(!$user){
            return new JsonResponse("Cet utilisateur n'existe pas",404);
        }

        $newRole = $request->request->get('role');


        if(!in_array($newRole,['ROLE_USER','ROLE_REFEREE','ROLE_ADMIN'])){
            return new JsonResponse("Valeur du rôle invalide",500);
        }
        else{
            $user->setRoles([$newRole]);
            $em->persist($user);
            $em->flush();
            return new JsonResponse("Modification effectuée");
        }

    }

    public function refereeMatchListAction($userId){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneById($userId);

        if(!$user){
            throw $this->createNotFoundException("Cet utlisateur n'existe pas");
        }

        return $this->render(':UserBundle/User:refereeMatchList.html.twig',array(
            'referee' => $user
        ));
    }

}
    
