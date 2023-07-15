<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;

class ServiceRequestController extends Controller
{


    public function downloadArchive(ServiceRequest $serviceRequest)
    {
        try {
            // Get the beneficiary's name and service name
            $beneficiaryName = $serviceRequest->user->name;
            $serviceName = $serviceRequest->service->service_name;

            // Create a unique folder name based on the beneficiary's name

            // Create a unique archive filename
            $archiveFileName = $beneficiaryName . '-' . $serviceName  . '.zip';

            // Create a new ZipArchive instance
            $archive = new ZipArchive;
            $archive->open($archiveFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Iterate over the images associated with the service request
            foreach ($serviceRequest->images as $image) {
                $imageUrl = $image->url;
                $imageName = basename($imageUrl);


                $imageContent = Storage::disk('s3')->get($imageUrl);

                // Add the image file to the archive
                $archive->addFromString($imageName, $imageContent);

            }

            $archive->close();

            // Set the appropriate headers for downloading the archive
            return response()->download($archiveFileName)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function getInProgress()
    {
        $serviceRequests = ServiceRequest::with(['serviceCategory', 'service', 'user'])
            ->where('status', 'In Progress')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('serviceRequests.inProgress',compact('serviceRequests'));
    }

    public function getAccepted()
    {
        $serviceRequests = ServiceRequest::with(['serviceCategory', 'service', 'user'])
            ->where('status', 'Accepted')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('serviceRequests.accepted',compact('serviceRequests'));
    }

    public function getRejected()
    {
        $serviceRequests = ServiceRequest::with(['serviceCategory', 'service', 'user'])
            ->where('status', 'Rejected')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('serviceRequests.rejected',compact('serviceRequests'));
    }


    public function accept(ServiceRequest $serviceRequest)
    {

        // Perform the necessary logic to accept the service request

        $serviceRequest->status = 'Accepted';
        $serviceRequest->save();

        $client = new Client([
            'base_uri' => env('INFOBIP_URL'),
            'headers' => [
                'Authorization' => "App ".env('INFOBIP_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

         $client->request(
            'POST',
            'sms/2/text/advanced',
            [
                RequestOptions::JSON => [
                    'messages' => [
                        [
                            'from' => 'AbasanKab',
                            'destinations' => [
                                ['to' => '97'.$serviceRequest->user->phone]
                            ],
                            'text' => 'تم قبول طلب الخدمة الخاص بك (' . $serviceRequest->service->service_name . '). يرجى الذهاب إلى خدمات الجمهور لإجراء عملية الدفع ومتابعة الإجراءات.' ,
                        ]
                    ]
                ],
            ]
        );

        return response()->json([
            'message' => 'تم قبول طلب الخدمة بنجاح.',
        ], Response::HTTP_OK);
    }

    public function reject(Request $request , ServiceRequest $serviceRequest)
    {
        // Perform the necessary logic to reject the service request
        $request->validate([
            'rejection_reason' => 'required|string',
        ], [
            'rejection_reason.required' => 'حقل سبب الرفض مطلوب.',
            'rejection_reason.string' => 'حقل سبب الرفض يجب أن يكون نصًا.',
        ]);

        // Perform the necessary logic to reject the service request
        $serviceRequest->status = 'Rejected';
        $serviceRequest->rejection_reason = $request->input('rejection_reason');
        $serviceRequest->save();

        $client = new Client([
            'base_uri' => env('INFOBIP_URL'),
            'headers' => [
                'Authorization' => "App ".env('INFOBIP_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

         $client->request(
            'POST',
            'sms/2/text/advanced',
            [
                RequestOptions::JSON => [
                    'messages' => [
                        [
                            'from' => 'AbasanKab',
                            'destinations' => [
                                ['to' => '97'.$serviceRequest->user->phone]
                            ],
                            'text' =>'تم رفض طلب الخدمة الخاص بك (' . $serviceRequest->service->service_name . '). يرجى التواصل مع دائرة خدمات الجمهور لمزيد من التفاصيل والمساعدة.'
                            ,
                        ]
                    ]
                ],
            ]
        );

        return response()->json([
            'message' => 'تم رفض طلب الخدمة بنجاح.',
            'data' => $serviceRequest,
        ], Response::HTTP_OK);
    }

}
