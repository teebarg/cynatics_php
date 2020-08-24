<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Repositories\ImageRepository;

class ImageController extends BaseController
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function store(ImageRequest $request)
    {
        $result = $this->imageRepository->store($request->validated());

        if ($result){
            return $this->sendSuccess($result->toArray(), ResponseMessages::ACTION_SUCCESSFUL);
        }
        return $this->sendError(ResponseMessages::UPLOAD_FAILED, ResponseCodes::UNPROCESSABLE_ENTITY );
    }

    public function update(Image $image, ImageRequest $request)
    {
        $upload = $this->imageRepository->update($image, $request->validated());
        if ($upload[0]){
            return $this->sendSuccess([], ResponseMessages::ACTION_SUCCESSFUL);
        }
        return $this->sendError(ResponseMessages::UPLOAD_FAILED, ResponseCodes::UNPROCESSABLE_ENTITY );
    }
}
