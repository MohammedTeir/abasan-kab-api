<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        $categories = ServiceCategory::all();

        return response()->view('services.servicelist',compact('services','categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \App\Http\Requests\AddServiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddServiceRequest $request)
    {
        $service = new Service([
            'service_category_id' => $request->input('service_category_id'),
            'service_name' => $request->input('service_name'),
            'price' => $request->input('price'),
            'required_time' => $request->input('required_time'),
            'required_documents' => $request->input('required_documents'),
        ]);
        $service->save();

        return response()->json([
            'message' => 'تم اٍضافة الخدمة بنجاح.',
            'data' => $service,
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \App\Http\Requests\UpdateServiceRequest  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update([
            'service_category_id' => $request->input('service_category_id',$service->service_category_id),
            'service_name' => $request->input('service_name',$service->service_name),
            'price' => $request->input('price',$service->price),
            'required_time' => $request->input('required_time',$service->required_time),
            'required_documents' => $request->input('required_documents',$service->required_documents),
        ]);

        return response()->json([
            'message' => 'تم تحديث الخدمة بنجاح.',
            'data' => $service,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'تم حذف الخدمة بنجاح.',
        ], Response::HTTP_OK);
    }




}
