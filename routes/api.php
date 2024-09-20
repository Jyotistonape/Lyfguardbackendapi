<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {

    //new routes
    Route::post('common-check-role', [App\Http\Controllers\app\AuthController::class, 'checkRole']);

    Route::post('common-send-otp', [App\Http\Controllers\app\AuthController::class, 'sendOTP']);
    Route::post('common-login', [App\Http\Controllers\app\AuthController::class, 'login']);
    Route::get('common-get-profile', [App\Http\Controllers\app\HomeController::class, 'commonGetProfile']);
    

    //end of new routes

    Route::post('send-otp', [App\Http\Controllers\app\HomeController::class, 'send_otp']);
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'api_login']);

    Route::post('driver-send-otp', [App\Http\Controllers\driverApp\HomeController::class, 'send_otp']);
    Route::post('driver-login', [App\Http\Controllers\Auth\LoginController::class, 'api_driver_login']);

    Route::post('booking-manager-send-otp', [App\Http\Controllers\bookingManagerApp\HomeController::class, 'send_otp']);
    Route::post('booking-manager-login', [App\Http\Controllers\Auth\LoginController::class, 'api_booking_manager_login']);

    Route::post('private-ambulance-driver-send-otp', [App\Http\Controllers\privateAmbulanceDriverApp\HomeController::class, 'send_otp']);
    Route::post('private-ambulance-driver-login', [App\Http\Controllers\Auth\LoginController::class, 'api_private_driver_login']);

    Route::post('private-ambulance-booking-manager-send-otp', [App\Http\Controllers\privateAmbulanceBookingManagerApp\HomeController::class, 'send_otp']);
    Route::post('private-ambulance-booking-manager-login', [App\Http\Controllers\Auth\LoginController::class, 'api_private_booking_manager_login']);

    Route::post('customer-assist-manager-send-otp', [App\Http\Controllers\assistApp\HomeController::class, 'send_otp']);
    Route::post('customer-assist-manager-login', [App\Http\Controllers\Auth\LoginController::class, 'api_customer_assist_manager_login']);

});


Route::group(['middleware' => ['jwt']], function () {

    //monty new route
    
    Route::get('common-get-profile', [App\Http\Controllers\app\HomeController::class, 'commonGetProfile']);
    Route::get('common-manager-booking', [App\Http\Controllers\app\BookingController::class, 'getBookings']);
    Route::get('common-get-booking-id/{id}', [App\Http\Controllers\app\BookingController::class, 'getBookingByBookingID']);

    Route::post('common-manager-accept-booking-request', [App\Http\Controllers\app\BookingController::class, 'acceptBookingRequest']);

    Route::post('common-manager-assign-booking-request', [App\Http\Controllers\app\BookingController::class, 'assignBookingRequest']);

    Route::post('common-manager-update-booking-request', [App\Http\Controllers\app\BookingController::class, 'updateBookingRequest']);

    Route::post('common-manager-cancel-booking', [App\Http\Controllers\app\BookingController::class, 'cancelBooking']);

    Route::get('common-get-home', [App\Http\Controllers\app\BookingController::class, 'getHomeDashboard']);

    Route::get('logout', [App\Http\Controllers\app\BookingController::class, 'logout']);

    


    //end if new route

    /** Testing */

    Route::get('testing', [App\Http\Controllers\TestController::class, 'sendTestNotificationToUser']);

    /** User */
    Route::get('get-home', [App\Http\Controllers\app\HomeController::class, 'get_home']);
    Route::get('get-profile', [App\Http\Controllers\app\ProfileController::class, 'get_profile']);
    Route::post('update-profile', [App\Http\Controllers\app\ProfileController::class, 'update_profile']);

    Route::get('get-listing-type', [App\Http\Controllers\app\ListingTypeController::class, 'get_type']);
    Route::get('listing-type/{id}/{lat}/{long}', [App\Http\Controllers\app\ListingTypeController::class, 'get_listing_by_type']);

    Route::get('get-firstaid-category', [App\Http\Controllers\app\FirstAidController::class, 'get_category']);
    Route::get('get-firstaid-category/{catID}', [App\Http\Controllers\app\FirstAidController::class, 'get_first_aid']);

    Route::get('get-emergency-type', [App\Http\Controllers\app\EmergencyTypeController::class, 'get_type']);

    Route::get('get-branch/{lat}/{long}', [App\Http\Controllers\app\BrachController::class, 'get_branch']);

//    Route::get('emergency/book/{emergencyTypeID}/{lat}/{long}', [App\Http\Controllers\app\BookingController::class, 'get_branch']);
    Route::post('emergency/book', [App\Http\Controllers\app\BookingController::class, 'get_branch']);
    Route::get('get-booking-update/{bookingID}', [App\Http\Controllers\app\BookingController::class, 'get_booking_update']);
    Route::get('bookings/{day}', [App\Http\Controllers\app\BookingController::class, 'get_bookings']);
    Route::get('booking/{bookingID}', [App\Http\Controllers\app\BookingController::class, 'get_booking_by_id']);
    Route::post('cancel-booking', [App\Http\Controllers\app\BookingController::class, 'cancel_booking']);

    Route::post('cancel-booking-user', [App\Http\Controllers\app\BookingController::class, 'cancel_booking_user']);

    Route::get('get-ambulance-type', [App\Http\Controllers\app\AmbulanceTypeController::class, 'get_type']);
    Route::get('get-amenity', [App\Http\Controllers\app\AmenityController::class, 'get_amenity']);

    Route::get('get-preferred-hospital', [App\Http\Controllers\app\PreferredHospitalController::class, 'get_preferred_hospital']);
    Route::post('add-preferred-hospital', [App\Http\Controllers\app\PreferredHospitalController::class, 'add_preferred_hospital']);
    Route::post('remove-preferred-hospital', [App\Http\Controllers\app\PreferredHospitalController::class, 'remove_preferred_hospital']);

    
    /* Private Ambulance */

    Route::get('private-ambulance-get-amenity', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_amenity']);
    Route::post('private-ambulance-get-ambulance-type-by-amenity', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_ambulance_type_by_amenity']);

    Route::post('emergency/private-ambulance-book', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_ambulance']);
    Route::get('get-private-ambulance-booking-update/{bookingID}', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_booking_update']);
    Route::get('private-ambulance-bookings/{day}', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_bookings']);
    Route::get('private-ambulance-booking/{bookingID}', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'get_booking_by_id']);
    Route::post('cancel-private-ambulance-booking', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'cancel_booking']);
    Route::post('update-private-ambulance-booking-payment', [App\Http\Controllers\app\PrivateAmbulanceBookingController::class, 'update_payment']);


    /** Driver */

    Route::get('driver-get-home', [App\Http\Controllers\driverApp\HomeController::class, 'get_home']);
    Route::get('driver-get-profile', [App\Http\Controllers\driverApp\HomeController::class, 'get_profile']);


    Route::get('driver-bookings/{day}', [App\Http\Controllers\driverApp\BookingController::class, 'get_bookings']);
    Route::get('driver-booking/{bookingID}', [App\Http\Controllers\driverApp\BookingController::class, 'get_booking_by_id']);

    Route::get('get-off-duty-ambulance', [App\Http\Controllers\driverApp\AmbulanceController::class, 'get_off_duty_ambulance']);
    Route::post('driver-start-duty-ambulance', [App\Http\Controllers\driverApp\AmbulanceController::class, 'start_duty']);
    Route::post('driver-stop-duty-ambulance', [App\Http\Controllers\driverApp\AmbulanceController::class, 'stop_duty']);

    Route::post('driver-save-route-coordinates', [App\Http\Controllers\driverApp\BookingController::class, 'save_route_coordinates']);
    Route::post('driver-update-trip', [App\Http\Controllers\driverApp\BookingController::class, 'update_trip']);

    /** Booking Manager */

    Route::get('booking-manager-get-home', [App\Http\Controllers\bookingManagerApp\HomeController::class, 'get_home']);
    Route::get('booking-manager-get-profile', [App\Http\Controllers\bookingManagerApp\HomeController::class, 'get_profile']);

    Route::get('manager-bookings/{day}', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'get_bookings']);
    Route::get('manager-booking/{bookingID}', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'get_booking_by_id']);

    Route::post('manager-accept-booking-request', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'accept_booking_request']);
    Route::post('manager-assign-booking-request', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'assign_booking_request']);
    Route::post('manager-update-booking-request', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'update_booking_request']);
    Route::post('manager-cancel-booking', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'cancel_booking']);

    Route::get('manager-get-active-driver', [App\Http\Controllers\bookingManagerApp\EmergencyBookingController::class, 'get_active_drivers']);
    
    Route::get('manager-logout', [App\Http\Controllers\bookingManagerApp\HomeController::class, 'api_logout']);

    
    /** Private Ambulance Booking Manager */

    Route::get('private-ambulance-booking-manager-get-home', [App\Http\Controllers\privateAmbulanceBookingManagerApp\HomeController::class, 'get_home']);
    Route::get('private-ambulance-booking-manager-get-profile', [App\Http\Controllers\privateAmbulanceBookingManagerApp\HomeController::class, 'get_profile']);

    Route::get('private-ambulance-manager-bookings/{day}', [App\Http\Controllers\privateAmbulanceBookingManagerApp\EmergencyBookingController::class, 'get_bookings']);
    Route::get('private-ambulance-manager-booking/{bookingID}', [App\Http\Controllers\privateAmbulanceBookingManagerApp\EmergencyBookingController::class, 'get_booking_by_id']);

    Route::post('private-ambulance-manager-accept-booking-request', [App\Http\Controllers\privateAmbulanceBookingManagerApp\EmergencyBookingController::class, 'accept_booking_request']);
    Route::post('private-ambulance-manager-update-booking-request', [App\Http\Controllers\privateAmbulanceBookingManagerApp\EmergencyBookingController::class, 'update_booking_request']);
    Route::post('private-ambulance-manager-cancel-booking', [App\Http\Controllers\privateAmbulanceBookingManagerApp\EmergencyBookingController::class, 'cancel_booking']);
    
    Route::get('private-ambulance-manager-logout', [App\Http\Controllers\privateAmbulanceBookingManagerApp\HomeController::class, 'api_logout']);


    /** Private Ambulance Driver */
    
    Route::get('private-ambulance-driver-get-home', [App\Http\Controllers\privateAmbulanceDriverApp\HomeController::class, 'get_home']);
    Route::get('private-ambulance-driver-get-profile', [App\Http\Controllers\privateAmbulanceDriverApp\HomeController::class, 'get_profile']);

    Route::get('private-ambulance-driver-bookings/{day}', [App\Http\Controllers\privateAmbulanceDriverApp\BookingController::class, 'get_bookings']);
    Route::get('private-ambulance-driver-booking/{bookingID}', [App\Http\Controllers\privateAmbulanceDriverApp\BookingController::class, 'get_booking_by_id']);

    //new post api

    Route::post('get-amenity-by-ambulance-id', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'postGetAmbulanceAmenityByID']);

    //end of post api

    Route::get('private-ambulance-driver-get-amenity-by-ambulance/{ambulanceID}', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'get_ambulance_amenities']);

    Route::get('get-off-duty-private-ambulance', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'get_off_duty_ambulance']);
    Route::post('driver-start-duty-private-ambulance', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'start_duty']);
    Route::post('driver-stop-duty-private-ambulance', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'stop_duty']);
    Route::post('private-ambulance-driver-save-current-coordinates', [App\Http\Controllers\privateAmbulanceDriverApp\AmbulanceController::class, 'save_current_coordinates']);

    Route::post('private-ambulance-driver-accept-booking-request', [App\Http\Controllers\privateAmbulanceDriverApp\EmergencyBookingController::class, 'accept_booking_request']);
    Route::post('private-ambulance-driver-update-booking-request', [App\Http\Controllers\privateAmbulanceDriverApp\EmergencyBookingController::class, 'update_booking_request']);
    Route::post('private-ambulance-driver-cancel-booking', [App\Http\Controllers\privateAmbulanceDriverApp\EmergencyBookingController::class, 'cancel_booking']);

    Route::post('private-ambulance-driver-save-route-coordinates', [App\Http\Controllers\privateAmbulanceDriverApp\BookingController::class, 'save_route_coordinates']);
    Route::post('private-ambulance-driver-update-trip', [App\Http\Controllers\privateAmbulanceDriverApp\BookingController::class, 'update_trip']);

    Route::get('logout', [App\Http\Controllers\app\HomeController::class, 'api_logout']);

/* assistApp */

    Route::get('customer-assist-manager-get-home', [App\Http\Controllers\assistApp\HomeController::class, 'get_home']);
    Route::get('customer-assist-manager-get-profile', [App\Http\Controllers\assistApp\HomeController::class, 'get_profile']);
    Route::get('customer-assist-manager-logout', [App\Http\Controllers\assistApp\HomeController::class, 'api_logout']);

    Route::get('customer-assist-manager-private-ambulance-get-amenity', [App\Http\Controllers\assistApp\PrivateAmbulanceBookingController::class, 'get_amenity']);
    Route::post('customer-assist-manager-private-ambulance-get-ambulance-type-by-amenity', [App\Http\Controllers\assistApp\PrivateAmbulanceBookingController::class, 'get_ambulance_type_by_amenity']);

    Route::post('customer-assist-manager-emergency/private-ambulance-book', [App\Http\Controllers\assistApp\PrivateAmbulanceBookingController::class, 'get_ambulance']);
});

Route::fallback(function () {
    return response()->json(['code' => 404, 'message' => 'Not Found', 'data' => array()], 404);
})->name('fallback.404');