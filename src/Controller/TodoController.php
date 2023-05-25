<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TodoService;
use PHPUnit\Framework\Constraint\IsNull;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{
    public function __construct(
        private readonly TodoService $service
    ) {
    }

    public function listItems(): Response
    {
        session_start();
        if($_SESSION == null) {
            return new RedirectResponse('/log_in');
        }

        $imageUrl = $this->service->getUsersPhoto()[0];
        if($imageUrl == ''){
            $usersPhoto = ['https://assets.stickpng.com/images/585e4bf3cb11b227491c339a.png'];
        }
        else{
            $imageHeaders = @get_headers($imageUrl);
            if ($imageHeaders && str_contains($imageHeaders[0], '200')) {
                $usersPhoto = $this->service->getUsersPhoto();
            } else {
                $usersPhoto = ['https://assets.stickpng.com/images/585e4bf3cb11b227491c339a.png'];
            }
        }


        return $this->render(
            'hello/hello.html.twig',
            [
                'skills' =>  $this->service->getAllTodos(),
                'name' =>  $this->service->getUserFromSession(),
                'photoUrl' => $usersPhoto,
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
    public function editItems(Request $request): RedirectResponse
    {
        $indexOfRemoving = $request->get('name');
        $this->service->deleteTodo($indexOfRemoving);
        return new RedirectResponse('/list');
    }

//    public function addUserPhoto(Request $request): RedirectResponse
//    {
//        $indexOfRemoving = $request->get('name');
//        $this->service->deleteTodo($indexOfRemoving);
//        return new RedirectResponse('/list');
//    }
}
