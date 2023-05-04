<?php

namespace App\Controller;

use App\Repository\TodoSqlRepository;
use App\Service\TodoService;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{
    private TodoService $service;

    public function __construct(
        TodoService $service,
    ){
        $this->service = $service;
    }

    public function listItems(): Response
    {
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

    private function service(TodoSqlRepository $repository)
    {
    }
}
