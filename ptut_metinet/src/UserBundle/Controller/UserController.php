<?php
namespace UserBundle\Controller;

use AppBundle\Entity\GalleryImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\GalleryImageType;
use UserBundle\Form\PasswordChangeType;
use UserBundle\Form\PasswordResetType;
use UserBundle\Form\UserType;
use UserBundle\Entity\User;
use AppBundle\Entity\Campaign;
use \Doctrine\Common\Util\Debug;

class UserController extends Controller
{

    public function listUserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findBy(array(), array('id' => 'desc'));

        return $this->render('UserBundle:User:list.html.twig', array(
            'users' => $users
        ));
    }

    public function newUserAction(Request $request)
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
                $user->setRoles(array("ROLE_USER"));

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

    public function editUserAction(Request $request, $userId)
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

}
    
