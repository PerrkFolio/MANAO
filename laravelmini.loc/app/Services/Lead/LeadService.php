<?php
/**
 * Created by PhpStorm.
 * User: note
 * Date: 06.06.2021
 * Time: 16:02
 */

namespace App\Services\Lead;


use App\Models\Lead;
use Illuminate\Http\Request;

class LeadService
{

    public function store(Request $request, Lead $lead)
    {
        $lead->fill($request->only($lead->getFillable()));
        $lead->save();

        return $lead;
    }

    public function getItems()
    {
        return Lead::with('category','status')->get();
    }
}