<?php

namespace App\Http\Controllers;

use App\Service;
use App\ServiceType;
use App\ServiceStatus;
use App\ScheduledService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $services  = Service::all();
        return $services;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }

    public function getServicebyCategory($idCategory){
        $serviceStatusid= ServiceStatus::where('name', 'activo')->value('id');
        $services = Service::where('type_id', $idCategory)->where('status_id', $serviceStatusid)->get();
        $array = array();
        foreach ($services as $s) {
            $array['id'] = $s->id;
            $array['status']   = ServiceType::where('id', $s->type_id)->get();
            $array['serviceSchedule']   = ScheduledService::where('id', $s->scheduled_service_id)->get();
            $array['date'] = $s->executionDate;
            $array['comments'] = $s->statusComment;
            $array['status'] = 'activo';
        }
        return $array;
        // $services = ServiceType::where('')


    }
}
