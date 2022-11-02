<?php
/**
 * Created by PhpStorm.
 * User: note
 * Date: 06.06.2021
 * Time: 16:03
 */

namespace App\Services\Status;


use App\Models\Status;

class StatusService
{

    public function getItems()
    {
        return Status::all();
    }
}