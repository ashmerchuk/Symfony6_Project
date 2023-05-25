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
            $usersPhoto = ['https://assets.stickpng.com/images/585e4bf3cb11b227491c339a.png'];
        }
        else {
            $imageHeaders = @get_headers($imageUrl);
            if ($imageHeaders && str_contains($imageHeaders[0], '200')) {
                $usersPhoto = $this->todoService->getUsersPhoto();
            } else {
                $usersPhoto = ['https://assets.stickpng.com/images/585e4bf3cb11b227491c339a.png'];
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
}
