<?php

namespace App\Controller;

use App\Service\TableService;
use App\Service\TodoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TableController extends AbstractController
{

    public function __construct(
        private readonly TableService $service
    )
    {
    }

    public function showSkillsFromAllUsers(Request $request): Response
    {

        if(!isset($sortName)){
            $sortName = 0;
        }
        if(!isset($sortEmail)){
            $sortEmail = 0;
        }
        if(isset($_POST['sortName'])){
            $sortName = $_POST['sortName'];
            return $this->render(
                'hello/table.html.twig',
                [
                    'skills' => $this->service->getAllSortedByNameTodos($sortName),
                    'sortName' => $sortName,
                    'sortEmail' => $sortEmail,
                ]
            );
        }

        if(isset($_POST['sortEmail'])){
            $sortEmail = $request->request->get('sortEmail') === '1';

            return $this->render(
                'hello/table.html.twig',
                [
                    'skills' => $this->service->getAllSortedByEmailTodos($sortEmail),
                    'sortName' => $sortName,
                    'sortEmail' => $sortEmail,
                ]
            );
        }

        return $this->render(
            'hello/table.html.twig',
            [
                'skills' => $this->service->getAllTodos(),
                'sortName' => $sortName,
                'sortEmail' => $sortEmail,
            ]
        );
    }
}
