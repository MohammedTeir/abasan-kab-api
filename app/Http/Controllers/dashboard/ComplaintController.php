<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

class ComplaintController extends Controller
{
    /**
     * Get all complaints.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaints = Complaint::all();

        return response()->view('complaints.complaintlist',compact('complaints'));
    }

    public function downloadComplaintAsPdf(Complaint $complaint)
    {
         // Create Dompdf instance with custom options
         $options = new Options();

         $options->set('defaultFont', 'Amiri');

         // Set the font directory
         $options->set('fontDir', public_path('fonts/'));

         // Register the Arabic font
         $options->set('fontFamily', 'Amiri');
         $options->set('fontCache', storage_path('fonts/'));

        $dompdf = new Dompdf();

        // Load the complaint PDF template view and pass the complaint data
        $pdfContent = view('templates.complaint', compact('complaint'))->render();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($pdfContent);

        // Render the PDF
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = 'complaint_' . $complaint->id . '.pdf';

        // Output the PDF to the browser for download
        $dompdf->stream($filename);
        }

    /**
     * Get all closed complaints.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClosedComplaints()
    {
        $complaints = Complaint::where('status', 'closed')->get();

        return response()->view('complaints.closedcomplaints',compact('complaints'));
    }

    /**
     * Get all complaints in progress.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInProgressComplaints()
    {
        $complaints = Complaint::where('status', 'in progress')->get();

        return response()->view('complaints.inprogresscomplaints',compact('complaints'));
    }

    /**
     * Get all open complaints.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOpenComplaints()
    {
        $complaints = Complaint::where('status', 'open')->get();

        return response()->view('complaints.opencomplaints',compact('complaints'));
    }



    /**
     * Update the status of a complaint to "closed".
     *
     * @param Complaint $complaint
     * @return \Illuminate\Http\JsonResponse
     */
    public function markComplaintAsClosed(Complaint $complaint)
    {

        $complaint->status = 'closed';
        $complaint->closed_at = now();
        $complaint->save();

        return response()->json([
            'message' => 'تم إغلاق الشكوى بنجاح.',
        ], Response::HTTP_OK);
    }

    /**
     * Update the status of a complaint to "in progress".
     *
     * @param  Complaint $complaint
     * @return \Illuminate\Http\JsonResponse
     */
    public function markComplaintAsInProgress(Complaint $complaint)
    {

        $complaint->status = 'in progress';
        $complaint->save();


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
                                ['to' => '97'.$complaint->user->phone]
                            ],
                            'text' => 'تم تحديث حالة الشكوى (' . $complaint->complaint_title . ') إلى قيد المراجعة.',
                        ]
                    ]
                ],
            ]
        );

        return response()->json([
            'message' => 'تم تحديث حالة الشكوى إلى قيد المراجعة.',
        ], Response::HTTP_OK);
    }


}
