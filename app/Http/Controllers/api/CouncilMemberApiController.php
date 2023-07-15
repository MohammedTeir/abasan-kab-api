<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MunicipalCouncilMember;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouncilMemberApiController extends Controller
{
    /**
 * Display a listing of the municipal council members.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function index()
{
    $members = MunicipalCouncilMember::all();

        $formattedMembers = $members->map(function ($member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'position' => $member->position,
                'mobile_number' => $member->mobile_number,
                'cv_url' => $member->cv_url,
                'image_url' => $member->image_url,
            ];
        });

        return response()->json([
            'message' => 'Successfully retrieved municipal council members.',
            'data' => $formattedMembers,
        ], Response::HTTP_OK);
    }

}
