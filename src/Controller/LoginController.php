<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\LoginService;
use App\Service\SignUpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class LoginController extends AbstractController
{
    public function __construct(
        private readonly LoginService $loginService,
        private readonly SignUpService $signUpService
    ) {
    }
    public function logIn(): Response
    {
        return $this->render(
            'hello/login.html.twig'
        );
    }

    public function logInCheck(Request $request, SessionInterface $session): Response
    {
        $usersEmail = $request->get('logInEmail');
        $usersPassword = $request->get('logInPassword');
        $userId = $this->loginService->checkUser($usersEmail, $usersPassword);
        if($userId == null) {
            $session->getFlashBag()->add('login_error', 'Invalid credentials. Wrong Email or Password.');
            return new RedirectResponse('/log_in');
        }

        session_start();
        $_SESSION['user_id'] = $userId;
        return new RedirectResponse('/list');
    }

    public function logOut(): Response
    {
        session_start();
        session_unset();
        return new RedirectResponse('/log_in');
    }

    public function  forgotEmail(): Response{
        return $this->render(
            'hello/forgotEmail.html.twig'
        );

    }

    /**
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function  sendForgotEmail(Request $request, SessionInterface $session, MailerInterface $mailer): Response
    {
        session_start();
        $usersEmail = $request->get('forgot_email');
        if(!$this->loginService->checkForgotEmail($usersEmail)){
            $session->getFlashBag()->add('email_exist_error', 'Email is not exist.');
            return new RedirectResponse('/log_in');
        }

        $_SESSION['user_id'] = $usersEmail;
        $resetToken = uniqid();

        function getCurrentURL(): string
        {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            $requestUri = $_SERVER['REQUEST_URI'];
            return $protocol . $host . $requestUri;
        }
        $url = getCurrentURL();
        $newUrl = str_replace("/send_forgot_email", "", $url);

        $resetLink = $newUrl ."/reset_page?token=" . urlencode($resetToken);
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: <a href=\"$resetLink\">Reset Password</a>";

        $transport = Transport::fromDsn('smtp://johndoegofer@gmail.com:fpidtafftygiqccr@smtp.gmail.com:587');
        // Create a Mailer object
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('johndoegofer@gmail.com')
            ->to($usersEmail)
            ->subject($subject)
            ->html($message);

        $mailer->send($email);

        $session->getFlashBag()->add('check_email', 'Check your email to reset password');
        return new RedirectResponse('/log_in');
    }

    public function resetPage(): Response
    {
        return $this->render(
            'hello/resetPage.html.twig'
        );
    }

    public function resetTypeNewPassword(Request $request, SessionInterface $session): Response
    {
        session_start();
        $userEmail = $_SESSION['user_id'];
        $usersNewPassword = $request->get('new_password');
        if($this->signUpService->updateUsersPassword($userEmail, $usersNewPassword)){
            $session->getFlashBag()->add('confirm_changed_password', 'Password was successfully changed');
            return new RedirectResponse('/log_in');
        }

        return new RedirectResponse('/log_in');
    }
}
