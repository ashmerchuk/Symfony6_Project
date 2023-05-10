<?php

namespace App\Controller;

use App\Service\SignUpService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class SignUpController extends AbstractController
{
    public function __construct(
        private readonly SignUpService $service
    ){
    }

    function signUp(Request $request, SessionInterface $session): Response {
        $usersEmail = $request->get('signUpEmail');
        $usersPassword = $request->get('signUpPassword');
        if($this->service->addUser($usersEmail, $usersPassword)){
            $session->getFlashBag()->add('success', 'You signed up successfully');
            return new RedirectResponse('/log_in');
        }
        $session->getFlashBag()->add('error', 'Invalid credentials. Email should be unique. Please try again.');
        return new RedirectResponse('/log_in');
    }
}
