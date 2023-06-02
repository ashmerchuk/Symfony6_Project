<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AddUsersPhotoService;
use App\Service\TodoService;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AddUsersPhotoController extends AbstractController
{
    public function __construct(
        private readonly AddUsersPhotoService $service,
        private readonly TodoService $todoService
    ) {
    }

    public function addUsersPhoto(Request $request): Response
    {
        session_start();
        if($_SESSION == null) {
            return new RedirectResponse('/log_in');
        }


        $imageUrl = $this->todoService->getUsersPhoto()[0];
        if($imageUrl == ''){
            $usersPhoto = ['https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds='];
        }
        else {
            $imageHeaders = @get_headers($imageUrl);
            if ($imageHeaders && str_contains($imageHeaders[0], '200')) {
                $usersPhoto = $this->todoService->getUsersPhoto();
            } else {
                $usersPhoto = ['https://media.istockphoto.com/id/1270368615/vi/vec-to/vector-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-h%E1%BB%93-s%C6%A1-ng%C6%B0%E1%BB%9Di-d%C3%B9ng-bi%E1%BB%83u-t%C6%B0%E1%BB%A3ng-ch%C3%A2n-dung-avatar-logo-k%C3%BD-t%C3%AAn-ng%C6%B0%E1%BB%9Di-h%C3%ACnh-d%E1%BA%A1ng.jpg?s=170667a&w=0&k=20&c=ycMlYTlzniKEIoKNYv7Sax0zNSr0CS8amRMLb6qXzds='];
            }
        }

        return $this->render(
            'hello/addUsersPhoto.html.twig',
            [
                'name' =>  $this->todoService->getUserFromSession(),
                'photoUrl' => $usersPhoto,
            ]
        );
    }

  public function addUrl(Request $request): RedirectResponse
    {

        $photoUrl = $request->get('photoUrl');
        $this->service->addPhotosUrl($photoUrl);
        return new RedirectResponse('/list');
    }

  public function deleteAccount(Request $request, SessionInterface $session): RedirectResponse
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        $this->service->deleteUser($user_id);
        session_unset();
        $session->getFlashBag()->add('deleted_user', 'User has been deleted');
        return new RedirectResponse('/log_in');
    }
}
