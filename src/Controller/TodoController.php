<?php

namespace App\Controller;

use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{
    public function __construct(
        private readonly TodoService $service
    ){
    }

    public function listItems(): Response
    {
        if($_COOKIE['userId'] == null){
            return new RedirectResponse('/log_in');
        }
        return $this->render(
            'hello/hello.html.twig',
            [
                'skills' =>  $this->service->getAllTodos(),
            ]
        );
    }

    public function addItems(Request $request): RedirectResponse
    {
        $nameOfSkill = $request->get('nameOfSkill');
        $this->service->addTodo($nameOfSkill);
        return new RedirectResponse('/list');
    }

    public function deleteItems(Request $request): RedirectResponse
    {
        $indexOfRemoving = $request->get('name');
        $this->service->deleteTodo($indexOfRemoving);
        return new RedirectResponse('/list');
    }
}
