<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\AddUsersPhotoRepository;

class AddUsersPhotoService
{
    public function __construct(
        private readonly AddUsersPhotoRepository $repository
    ) {
    }

    public function addPhotosUrl(string $sanitisePhoto): void
    {
        $this->repository->addPhotosUrl($sanitisePhoto);
    }

    public function deleteUser($sanitiseUsersAccount): void
    {
        $this->repository->deleteUser($sanitiseUsersAccount);
    }

}
