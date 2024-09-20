<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new Service();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['services'] = $this->service->getAllServices();
        $data['pageName'] = "Services";
        return view('panel.service.list-service')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Service";
        return view('panel.service.create-service')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
//            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $service = Service::create([
            'slug' => $this->generateSlug($request->input('name'), 'services'),
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : '',
            'image' => $this->imageUpload($request, 'image', 'services/'),
            'is_emergency' => ($request->input('is_emergency')) ? 1 : 0,
        ]);
        if ($service)
            return \redirect(route('listService'))->with('success', 'Service Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->service->getServiceByID($id);
        if ($service) {
            $data['service'] = $service;
            $data['pageName'] = "Edit Service";
            return view('panel.service.edit-service')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
//            'image' => 'required',
//            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $serviceData = $this->service->getServiceByID($id);
        if (!$serviceData)
            return Redirect::back()->with('error', 'Invalid Service');

        $service = Service::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : $serviceData->description,
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'services/') : $serviceData->image,
            'is_emergency' => ($request->input('is_emergency')) ? 1 : 0,
        ]);
        if ($service)
            return \redirect(route('listService'))->with('success', 'Service Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($service)
            return Redirect::back()->with('success', 'Service Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}
