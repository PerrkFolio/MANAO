<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\Lead\LeadService;
use App\Services\Response\ResponseService;
use Illuminate\Http\Request;

class LeadController extends ApiController
{

    /**
     * StatusController constructor.
     */
    public function __construct(LeadService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ResponseService::sendJsonReponse(
            true,
                [
                    'items' => $this->service->getItems()->toArray()
                ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lead $lead)
    {
        //
        $lead = $this->service->store($request, $lead);
        return ResponseService::sendJsonReponse(
            true,
            [
                'item' => $lead->toArray()
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        return ResponseService::sendJsonReponse(
            true,
            [
                'item' => $lead->toArray()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        //
        $lead = $this->service->store($request, $lead);

        return ResponseService::sendJsonReponse(
            true,
            [
                'item' => $lead->toArray()
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
