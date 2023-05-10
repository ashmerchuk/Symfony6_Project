<?php

namespace App\Controller;

use App\Service\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{

    public function __construct(
        private readonly LoginService $service,
    ){
    }

    function logIn(): Response {
        return $this->render(
            'hello/login.html.twig'
        );
    }

    function logInCheck(Request $request, SessionInterface $session): Response {
        $usersEmail = $request->get('logInEmail');
        $usersPassword = $request->get('logInPassword');
        $userId = $this->service->checkUser($usersEmail, $usersPassword);
        if($userId === null) {
            $session->getFlashBag()->add('login_error', 'Invalid credentials. Wrong Email or Password.');
            return new RedirectResponse('/log_in');
        }
        session_start();
        $_SESSION['user_id'] = $userId;
        return new RedirectResponse('/list');
    }

    function logOut () : Response{
        unset($_SESSION['email'], $_SESSION['password'], $_SESSION['userId']);
        return new RedirectResponse('/log_in');
    }
}
