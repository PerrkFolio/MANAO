<?php
/**
 * Created by PhpStorm.
 * User: note
 * Date: 06.06.2021
 * Time: 16:02
 */

namespace App\Services\Category;


use App\Models\Category;

class CategoryService
{

    public function getItems()
    {
        return Category::all();
    }
}