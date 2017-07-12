<?php

namespace authentication\AuthBundle\Controller;

use authentication\AuthBundle\Model\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        if (TRUE === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('playerslist');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        $errors = $authenticationUtils->getLastAuthenticationError();

        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('authenticationAuthBundle::login.html.twig',[
            'errors' => $errors,
            'username' => $lastUserName

        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){

        return $this->redirectToRoute('login');
    }
    /**
     * @Route("/adduser")
     */
    public function addUser(){
        $user= new Users();
        $user->setUsername('max');
        $user->setEmail('max.ololo@mail.com');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user,'ololo123');
        $user->setPassword($password);
        $user->save();

        return $this->redirecttoRoute('login');
    }


}
