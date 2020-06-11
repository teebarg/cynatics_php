<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

/**
 * @method sendResponse($toArray, string $string)
 */
class CategoryController extends BaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->all();

        return $this->sendSuccess($categories->toArray(), 'Categories retrieved successfully');
    }

    /**
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = $this->categoryRepository->store($request->all());

        return $this->sendSuccess($category->toArray(), 'Category saved successfully');
    }

    /**
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->sendSuccess($category->toArray(), 'Category retrieved successfully');
    }

    /**
     *
     * @param Category $category
     * @param UpdateCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->update($category, $input = $request->all());

        return $this->sendSuccess($category->toArray(), 'Category updated successfully');
    }

    /**
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->sendSuccess([],'Category deleted successfully');
    }
}
