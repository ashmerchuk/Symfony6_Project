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

        if(!isset($this->service->getUsersPhoto()[0])){
            $imageUrl = 'https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds=';
        }
        $imageUrl = $this->service->getUsersPhoto()[0];
        if($imageUrl == ''){
            $usersPhoto = ['https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds='];
        }
        else{
            $imageHeaders = @get_headers($imageUrl);
            if ($imageHeaders && str_contains($imageHeaders[0], '200')) {
                $usersPhoto = $this->service->getUsersPhoto();
            } else {
                $usersPhoto = ['https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds='];
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
}
