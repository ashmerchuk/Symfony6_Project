<?php

namespace App\Controller;

use App\Repository\TodoSqlRepository;
use App\Service\TodoService;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AbstractController
{
    public TodoSqlRepository $repository;
    public TodoService $service;
    public function __construct(){
        $pdo = new PDO('sqlite:./sk.db');
        $this->repository = new TodoSqlRepository($pdo);
        $this->service = new TodoService($this->repository);
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
}
