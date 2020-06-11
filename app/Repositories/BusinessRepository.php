<?php

namespace App\Repositories;

use App\Business;
use App\Helpers\ImageUploader;

/**
 * Class BusinessRepository
 * @package App\Repositories
*/

class BusinessRepository extends Repository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Business::class;
    }

    public function store($data) {
        $model =  parent::store($data);
        $imageUploader = new ImageUploader();
        $upload = $imageUploader->upload($imageUploader::DEFAULT_IMAGE, $model->business_name);
        $model->image()->create(['image' => $upload[1]]);
        if (isset($data['categories'])){
            $model->categories()->sync($data['categories']);
        }
        return $model;
    }

    public function update($model, $data)
    {
       $model =  parent::update($model, $data);
       if (isset($data['categories'])){
           $model->categories()->sync($data['categories']);
       }
       return $model;
    }

    public function getAll($filter)
    {
        return $this->model::orderBy('id')->filter($filter)->paginate();
    }
}
