<?php

namespace App\Http\Controllers;

use App\Models\BookingToken;
use App\Models\User;
use App\Models\PrivateAmbulanceType;
use App\Models\PrivateAmbulanceAmenity;
use App\Models\BranchType;
use App\Models\HospitalType;
use App\Models\ListingType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\FCMService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function generateSlug($title, $table)
    {
        $slug = Str::slug($title);
        $slugList = DB::table($table)
            ->where('slug', 'like', $slug . '%')
            ->get();
        $slugCount = $slugList->count();
        if ($slugCount) {
            return $this->checkSlug($slug . '-' . $slugCount, $table);
        } else {
            return $slug;
        }
    }

    public function checkSlug($title, $table)
    {
        $slugList = DB::table($table)
            ->where('slug', $title)
            ->get();
        $slugCount = $slugList->count();
        if ($slugCount) {
            $newSlug = $title . '-' . $slugCount;
            return $this->checkSlug($newSlug, $table);
        } else {
            return $title;
        }
    }


    public function genrate_booking_id($booking_id, $table)
    {
        $checkBookingID = DB::table($table)
            ->where('booking_id', $booking_id)
            ->first();
        if ($checkBookingID) {
            return $this->genrate_booking_id('LYF-PVB-'.strtoupper(Str::random(20)), $table);
        } else {
            return $booking_id;
        }
    }


    public function genrate_referral_code($referral_code)
    {
        $referralCode = DB::table('users')
            ->where('referral_key', $referral_code)
            ->first();
        if ($referralCode) {
            return $this->genrate_referral_code(strtoupper(Str::random(8)));
        } else {
            return $referral_code;
        }
    }

    public function check_referral_code($referralCode)
    {
        $referralCodeList = DB::table('users')
            ->where('referral_key', $referralCode)
            ->get();
        $referralCodeCount = $referralCodeList->count();
        if ($referralCodeCount) {
            return $this->genrate_referral_code(ucwords(Str::random(8)));
        } else {
            return $referralCodeCount;
        }
    }

    public function uploadmultipleImage($request, $input, $location)
    {
        $path = $location;
        $data = array();
        if ($request->hasFile($input)) {
            foreach ($request->file($input) as $image) {
                $extension = $image->getClientOriginalExtension();
                $filetoStore = 'img-' . MD5(time() . '' . $image) . "." . $extension;
                Storage::disk('local')->put('public/' . $path . '' . $filetoStore, file_get_contents($image->getRealPath()), 'public');
                $data[] = $path . $filetoStore;
            }
            return $data;
        }
    }

    public function imageUpload($request, $input, $location)
    {
        $path = $location;
        if ($request->hasFile($input)) {
            $image = $request->file($input);
            $extension = $image->getClientOriginalExtension();
            $filetoStore = 'img-' . MD5(time() . '' . $image) . "." . $extension;
            Storage::disk('local')->put('public/' . $path . '' . $filetoStore, file_get_contents($image->getRealPath()), 'public');
            return $path . '' . $filetoStore;
        }
        return 'placeholder.jpg';
    }

    public function base64ToImage($location, $imageData)
    {
        $path = $location;
        $file_data = "data:image/png;base64," . $imageData;
        if ($file_data) {
            $imageName = 'img-' . MD5(time()) . '-' . Str::random(4) . ".png";
            @list($type, $file_data) = explode(';', $file_data);
            @list(, $file_data) = explode(',', $file_data);
            if ($file_data != "") {
                Storage::disk('local')->put('public/' . $path . '' . $imageName, base64_decode($file_data));
                return $path . '' . $imageName;
            }
            return 'placeholder.jpg';
        }
        return 'placeholder.jpg';
    }

    public function multipleBase64ToImage($location, $file_data)
    {
        $path = $location;
        $data = array();
        if ($file_data) {
            $fileCollections = explode('<//>', $file_data);
            if (!$fileCollections)
                return 'placeholder.jpg';

            foreach ($fileCollections as $file) {
                if ($file == "NA") {
                    $data[] = 'placeholder.jpg';
                } else {
                    $fileImage = 'data:image/png;base64,' . $file;
                    $imageName = 'img-' . MD5(time()) . '-' . Str::random(4) . " . png";
                    @list($type, $fileImage) = explode(';', $fileImage);
                    @list(, $fileImage) = explode(',', $fileImage);
                    if ($fileImage != "") {
                        Storage::disk('local')->put('public/' . $path . '' . $imageName, base64_decode($fileImage));
//                    return $path . '' . $imageName;
                        $data[] = $path . $imageName;
                    }
                }
            }
            return $data;
        }
        return 'placeholder.jpg';
    }


    public function pushNotification($booking, $ambulances)
    {
        try {

            $title = "You have a request for emergency booking, Click here to accept.";
            $data = array('booking' => $booking, 'ambulances' => $ambulances);
            return $this->sendNotificationrToUser($booking->booking_manager_id, $title, $data);
//            return $this->sendNotificationrToUser(16, $title, $data);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function pushNotificationtoDriver($booking, $title)
    {
        try {
            $data = array('booking' => $booking);
            return $this->sendNotificationrToUser($booking->driver_id, $title, $data);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function pushNotificationtoUser($booking, $title)
    {
        try {
            $data = array('booking' => $booking);
            return $this->sendNotificationrToUser($booking->user_id, $title, $data);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function pushNotificationtoBookingManager($booking, $title)
    {
        try {
            $data = array('booking' => $booking);
            return $this->sendNotificationrToUser($booking->booking_manager_id, $title, $data);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function pushNotificationforPrivateAmbulance($booking, $ambulance, $idFiled)
    {
        try {

            $title = "You have a request for Ambulance booking, Click here to accept.";
            $data = array('booking' => $booking, 'ambulance' => $ambulance);
            return $this->sendNotificationrToUser($booking->$idFiled, $title, $data);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function sendNotificationrToUser($id, $title, $data)
    {
        try {
            $user = User::findOrFail($id);

            FCMService::send(
                $user->fcm_token,
                [
                    'title' => $title,
                    'body' => $data,
//                    'data' => $data,
                ]
            );
            return Response::suc($data,'Request Send');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function send_login_otp($phone, $otp, $name)
    {
        $userName = str_replace("%20", " ", $name);
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.msg91.com/api/v5/otp?template_id=64d3ceb2d6fc0547c16d2d42&mobile=91'.$phone.'&authkey=374825AKyb3CDE623ad317P1&extra_param={"NAME" : "'.$userName.'", "OTP" : "'.$otp.'"}',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function check_amenities_inarray($amenities, $data, $fieldName){
        $arr2 = explode(',', $amenities);
        $arr1 = '';
        $returnArray = array();
        // dd($data);

        foreach($data as $datad){
            if($datad->$fieldName){
                $arr1 = explode(',', $datad->$fieldName);
                if (empty(array_diff($arr2, $arr1))) {
                    array_push($returnArray, $datad);
                }
            }
        }
        return $returnArray;
    } 
    
    public function get_time($createdAT, $actionAT)
    {
        $interval = $actionAT->diff($createdAT)->format('%H:%I:%S');
        return $interval;
    }

}
