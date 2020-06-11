<?php

namespace App\Http\Controllers;

use App\Business;
use App\Helpers\ImageUploader;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Http\Requests\ImageRequest;
use App\Image;
use Illuminate\Http\Request;

class ImageController extends BaseController
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function store(Business $business, ImageRequest $request)
    {
        $upload = $this->imageUploader->upload($request->input('image'), $business->business_name);
        if ($upload[0]){
            $business->image()->create(['image' => $upload[1]]);
            return $this->sendSuccess([], ResponseMessages::ACTION_SUCCESSFUL);
        }
        return $this->sendError(ResponseMessages::UPLOAD_FAILED, ResponseCodes::UNPROCESSABLE_ENTITY );
    }

    public function update(Image $image, Request $request)
    {

        $upload = $this->imageUploader->upload($request->input('image'), $image->image, 'update');
        if ($upload[0]){
            return $this->sendSuccess([], ResponseMessages::ACTION_SUCCESSFUL);
        }
        return $this->sendError(ResponseMessages::UPLOAD_FAILED, ResponseCodes::UNPROCESSABLE_ENTITY );
    }
}
