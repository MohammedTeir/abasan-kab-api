<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCouncilMemberRequest;
use App\Http\Requests\UpdateCouncilMemberRequest;
use App\Models\Image;
use App\Models\MunicipalCouncilMember;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CouncilMemberController extends Controller
{

    /**
     * Display a listing of the municipal council members.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = MunicipalCouncilMember::all();

        return response()->view('user-management.memberlist', compact('members'));
    }


    public function addMember(AddCouncilMemberRequest $request)
    {
        $member = new MunicipalCouncilMember();
        $member->name = $request->input('name');
        $member->position = $request->input('position');
        $member->mobile_number = $request->input('mobile_number');

        $member->save();
        // Upload and save CV file
        if ($request->hasFile('cv_file')) {
            $cvFile = $request->file('cv_file');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $ex = $cvFile->getClientOriginalExtension();
            $name = 'cv' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/development/media/council-members/{$currentYear}-{$currentMonth}/{$request->input('name')}/";
            $member->cv_path = $path . $name;
            $cvFile->storeAs($path, $name, 's3');
        }

        // Upload and save image file
        if ($request->hasFile('image_file')) {
            $imageFile = $request->file('image_file');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $ex = $imageFile->getClientOriginalExtension();
            $name = 'avatar' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/development/media/council-members/{$currentYear}-{$currentMonth}/{$request->input('name')}/";
            $image = new Image();
            $image->url = $path . $name;
            $member->image()->save($image);
            $imageFile->storeAs($path, $name, 's3');
        }

        $member->save();

        return response()->json([
            'message' => 'تمت إضافة عضو المجلس البلدي بنجاح.',
            'data' => $member,
        ], Response::HTTP_CREATED);
    }


    /**
     * Update the specified municipal council member in storage.
     *
     * @param  \App\Http\Requests\UpdateCouncilMemberRequest  $request
     * @param  \App\Models\MunicipalCouncilMember  $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCouncilMemberRequest $request, MunicipalCouncilMember $member)
    {
        $member->name = $request->input('name',$member->name);
        $member->position = $request->input('position', $member->position);
        $member->mobile_number = $request->input('mobile_number',$member->mobile_number);

        // Update CV file
        if ($request->hasFile('cv_file')) {
            // Delete the previous CV file if it exists
            if ($member->cv_path) {
                Storage::disk('s3')->delete($member->cv_path);
            }

            $cvFile = $request->file('cv_file');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $ex = $cvFile->getClientOriginalExtension();
            $name = 'cv' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/development/media/council-members/{$currentYear}-{$currentMonth}/{$member->name}/";

            $member->cv_path = $path.$name;

            $cvFile->storeAs($path, $name, 's3');
        }

        // Update image file
        if ($request->hasFile('image_file')) {
            $image = $member->image;

            // Delete the previous image file if it exists
            if ($image) {
                Storage::disk('s3')->delete($image->url);
                $image->delete();
            }

            $imageFile = $request->file('image_file');
            $currentYear = date('Y');
            $currentMonth = date('m');
            $ex = $imageFile->getClientOriginalExtension();
            $name = 'avatar' . time() * rand(1, 10000000) . '.' . $ex;
            $path = "/development/media/council-members/{$currentYear}-{$currentMonth}/{$member->name}/";

            $newImage = new Image();
            $newImage->url = $path.$name;
            $member->image()->save($newImage);

            $imageFile->storeAs($path, $name, 's3');
        }

        $member->save();

        return response()->json([
            'message' => 'تم تحديث بيانات عضو المجلس البلدي بنجاح.',
            'data' => $member,
        ], Response::HTTP_OK);
    }


    /**
     * Remove the specified municipal council member from storage.
     *
     * @param  \App\Models\MunicipalCouncilMember  $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MunicipalCouncilMember $member)
    {
        $image = $member->image;
        if ($image) {
            // Delete image file
            Storage::disk('s3')->delete($image->url);
            $image->delete();
        }

        // Delete CV file
        if ($member->cv_path) {
            Storage::disk('s3')->delete($member->cv_path);
        }

        $member->delete();

        return response()->json([
            'message' => 'تم حذف عضو المجلس البلدي بنجاح.',
        ], Response::HTTP_OK);
    }

}
