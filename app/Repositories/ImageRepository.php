<?php

namespace App\Repositories;

use App\Helpers\ImageUploader;
use App\Models\Image;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class ImageRepository
 * @package App\Repositories
 * @version June 16, 2020, 10:45 am UTC
*/

class ImageRepository extends Repository
{

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    public function __construct(App $app, Collection $collection, Request $request, ImageUploader $imageUploader)
    {
        parent::__construct($app, $collection, $request);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Image::class;
    }

    /**
     * Configure the Model
     * @param $data
     * @return bool
     */
    public function store($data)
    {
        $model = app('App\Models\\' . Str::studly($data['model']))->findOrFail($data['target']);
        $upload = $this->imageUploader->upload($data['image'], $model->name);
        if ($upload[0]){
            $model->image()->create(['image' => $upload[1]]);
            return $model->fresh();
        }
        return false;
    }

    public function update($model, $data) {
        return $this->imageUploader->upload($data['image'], $model->image, 'update');
    }

}
