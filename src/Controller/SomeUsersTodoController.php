<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SomeUsersTodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SomeUsersTodoController extends AbstractController
{
    public function __construct(
        private readonly SomeUsersTodoService $service
    ) {
    }

    public function showSomeUsersTodo(Request $request): Response
    {
        $userEmail = $request->get('email');
        return $this->render(
            'hello/someUsersTodo.html.twig',
            [
                'skills' =>  $this->service->getAllTodos($userEmail),
                'email' => $userEmail,
            ]
        );
    }
}
