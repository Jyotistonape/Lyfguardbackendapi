<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);

Route::group(['prefix' => 'panel', 'middleware' => ['auth']], function () {

    Route::get('dashboard', [App\Http\Controllers\panel\DashboardController::class, 'index'])->name('dashboard');

    Route::get('listing-types', [App\Http\Controllers\panel\ListingTypeController::class, 'index'])->name('listListingType');
    Route::get('create-listing-type', [App\Http\Controllers\panel\ListingTypeController::class, 'create'])->name('createListingType');
    Route::post('store-listing-type', [App\Http\Controllers\panel\ListingTypeController::class, 'store'])->name('storeListingType');
    Route::get('edit-listing-type/{id}', [App\Http\Controllers\panel\ListingTypeController::class, 'edit'])->name('editListingType');
    Route::put('update-listing-type/{id}', [App\Http\Controllers\panel\ListingTypeController::class, 'update'])->name('updateListingType');
    Route::delete('delete-listing-type/{id}', [App\Http\Controllers\panel\ListingTypeController::class, 'destroy'])->name('deleteListingType');

    Route::get('hospital-types', [App\Http\Controllers\panel\HospitalTypeController::class, 'index'])->name('listHospitalType');
    Route::get('create-hospital-type', [App\Http\Controllers\panel\HospitalTypeController::class, 'create'])->name('createHospitalType');
    Route::post('store-hospital-type', [App\Http\Controllers\panel\HospitalTypeController::class, 'store'])->name('storeHospitalType');
    Route::get('edit-hospital-type/{id}', [App\Http\Controllers\panel\HospitalTypeController::class, 'edit'])->name('editHospitalType');
    Route::put('update-hospital-type/{id}', [App\Http\Controllers\panel\HospitalTypeController::class, 'update'])->name('updateHospitalType');
    Route::delete('delete-hospital-type/{id}', [App\Http\Controllers\panel\HospitalTypeController::class, 'destroy'])->name('deleteHospitalType');

    Route::get('branch-types', [App\Http\Controllers\panel\BranchTypeController::class, 'index'])->name('listBranchType');
    Route::get('create-branch-type', [App\Http\Controllers\panel\BranchTypeController::class, 'create'])->name('createBranchType');
    Route::post('store-branch-type', [App\Http\Controllers\panel\BranchTypeController::class, 'store'])->name('storeBranchType');
    Route::get('edit-branch-type/{id}', [App\Http\Controllers\panel\BranchTypeController::class, 'edit'])->name('editBranchType');
    Route::put('update-branch-type/{id}', [App\Http\Controllers\panel\BranchTypeController::class, 'update'])->name('updateBranchType');
    Route::delete('delete-branch-type/{id}', [App\Http\Controllers\panel\BranchTypeController::class, 'destroy'])->name('deleteBranchType');

    Route::get('speciality', [App\Http\Controllers\panel\SpecialityController::class, 'index'])->name('listSpeciality');
    Route::get('create-speciality', [App\Http\Controllers\panel\SpecialityController::class, 'create'])->name('createSpeciality');
    Route::post('store-speciality', [App\Http\Controllers\panel\SpecialityController::class, 'store'])->name('storeSpeciality');
    Route::get('edit-speciality/{id}', [App\Http\Controllers\panel\SpecialityController::class, 'edit'])->name('editSpeciality');
    Route::put('update-speciality/{id}', [App\Http\Controllers\panel\SpecialityController::class, 'update'])->name('updateSpeciality');
    Route::delete('delete-speciality/{id}', [App\Http\Controllers\panel\SpecialityController::class, 'destroy'])->name('deleteSpeciality');

    Route::get('firstaid-categories', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'index'])->name('listFirstAidCategory');
    Route::get('create-firstaid-category', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'create'])->name('createFirstAidCategory');
    Route::post('store-firstaid-category', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'store'])->name('storeFirstAidCategory');
    Route::get('edit-firstaid-category/{id}', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'edit'])->name('editFirstAidCategory');
    Route::put('update-firstaid-category/{id}', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'update'])->name('updateFirstAidCategory');
    Route::delete('delete-firstaid-category/{id}', [App\Http\Controllers\panel\FirstAidCategoryController::class, 'destroy'])->name('deleteFirstAidCategory');

    Route::get('firstaid', [App\Http\Controllers\panel\FirstAidController::class, 'index'])->name('listFirstAid');
    Route::get('create-firstaid', [App\Http\Controllers\panel\FirstAidController::class, 'create'])->name('createFirstAid');
    Route::post('store-firstaid', [App\Http\Controllers\panel\FirstAidController::class, 'store'])->name('storeFirstAid');
    Route::get('edit-firstaid/{id}', [App\Http\Controllers\panel\FirstAidController::class, 'edit'])->name('editFirstAid');
    Route::put('update-firstaid/{id}', [App\Http\Controllers\panel\FirstAidController::class, 'update'])->name('updateFirstAid');
    Route::delete('delete-firstaid/{id}', [App\Http\Controllers\panel\FirstAidController::class, 'destroy'])->name('deleteFirstAid');

    Route::get('services', [App\Http\Controllers\panel\ServiceController::class, 'index'])->name('listService');
    Route::get('create-service', [App\Http\Controllers\panel\ServiceController::class, 'create'])->name('createService');
    Route::post('store-service', [App\Http\Controllers\panel\ServiceController::class, 'store'])->name('storeService');
    Route::get('edit-service/{id}', [App\Http\Controllers\panel\ServiceController::class, 'edit'])->name('editService');
    Route::put('update-service/{id}', [App\Http\Controllers\panel\ServiceController::class, 'update'])->name('updateService');
    Route::delete('delete-service/{id}', [App\Http\Controllers\panel\ServiceController::class, 'destroy'])->name('deleteService');

    Route::get('amenities', [App\Http\Controllers\panel\AmenityController::class, 'index'])->name('listAmenity');
    Route::get('create-amenity', [App\Http\Controllers\panel\AmenityController::class, 'create'])->name('createAmenity');
    Route::post('store-amenity', [App\Http\Controllers\panel\AmenityController::class, 'store'])->name('storeAmenity');
    Route::get('edit-amenity/{id}', [App\Http\Controllers\panel\AmenityController::class, 'edit'])->name('editAmenity');
    Route::put('update-amenity/{id}', [App\Http\Controllers\panel\AmenityController::class, 'update'])->name('updateAmenity');
    Route::delete('delete-amenity/{id}', [App\Http\Controllers\panel\AmenityController::class, 'destroy'])->name('deleteAmenity');

    Route::get('ambulance-types', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'index'])->name('listAmbulanceType');
    Route::get('create-ambulance-type', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'create'])->name('createAmbulanceType');
    Route::post('store-ambulance-type', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'store'])->name('storeAmbulanceType');
    Route::get('edit-ambulance-type/{id}', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'edit'])->name('editAmbulanceType');
    Route::put('update-ambulance-type/{id}', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'update'])->name('updateAmbulanceType');
    Route::delete('delete-ambulance-type/{id}', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'destroy'])->name('deleteAmbulanceType');

    Route::get('emergency-types', [App\Http\Controllers\panel\EmergencyTypeController::class, 'index'])->name('listEmergencyType');
    Route::get('create-emergency-type', [App\Http\Controllers\panel\EmergencyTypeController::class, 'create'])->name('createEmergencyType');
    Route::post('store-emergency-type', [App\Http\Controllers\panel\EmergencyTypeController::class, 'store'])->name('storeEmergencyType');
    Route::get('edit-emergency-type/{id}', [App\Http\Controllers\panel\EmergencyTypeController::class, 'edit'])->name('editEmergencyType');
    Route::put('update-emergency-type/{id}', [App\Http\Controllers\panel\EmergencyTypeController::class, 'update'])->name('updateEmergencyType');
    Route::delete('delete-emergency-type/{id}', [App\Http\Controllers\panel\EmergencyTypeController::class, 'destroy'])->name('deleteEmergencyType');

    Route::get('listing/{typeID}', [App\Http\Controllers\panel\ListingController::class, 'index'])->name('listListing');
    Route::get('create-listing', [App\Http\Controllers\panel\ListingController::class, 'create'])->name('createListing');
    Route::post('store-listing', [App\Http\Controllers\panel\ListingController::class, 'store'])->name('storeListing');
    Route::get('edit-listing/{id}', [App\Http\Controllers\panel\ListingController::class, 'edit'])->name('editListing');
    Route::put('update-listing/{id}', [App\Http\Controllers\panel\ListingController::class, 'update'])->name('updateListing');
    Route::delete('delete-listing/{id}', [App\Http\Controllers\panel\ListingController::class, 'destroy'])->name('deleteListing');

    Route::get('hospitals', [App\Http\Controllers\panel\HospitalController::class, 'index'])->name('listHospital');
    Route::get('create-hospital', [App\Http\Controllers\panel\HospitalController::class, 'create'])->name('createHospital');
    Route::post('store-hospital', [App\Http\Controllers\panel\HospitalController::class, 'store'])->name('storeHospital');
    Route::get('edit-hospital/{id}', [App\Http\Controllers\panel\HospitalController::class, 'edit'])->name('editHospital');
    Route::put('update-hospital/{id}', [App\Http\Controllers\panel\HospitalController::class, 'update'])->name('updateHospital');
    Route::delete('delete-hospital/{id}', [App\Http\Controllers\panel\HospitalController::class, 'destroy'])->name('deleteHospital');

    Route::get('branches', [App\Http\Controllers\panel\BranchController::class, 'index'])->name('listBranch');
    Route::get('create-branch', [App\Http\Controllers\panel\BranchController::class, 'create'])->name('createBranch');
    Route::post('store-branch', [App\Http\Controllers\panel\BranchController::class, 'store'])->name('storeBranch');
    Route::get('edit-branch/{id}', [App\Http\Controllers\panel\BranchController::class, 'edit'])->name('editBranch');
    Route::post('update-branch/{id}', [App\Http\Controllers\panel\BranchController::class, 'update'])->name('updateBranch');
    Route::delete('delete-branch/{id}', [App\Http\Controllers\panel\BranchController::class, 'destroy'])->name('deleteBranch');

    Route::get('ambulances', [App\Http\Controllers\panel\AmbulanceController::class, 'index'])->name('listAmbulance');
    Route::get('create-ambulance', [App\Http\Controllers\panel\AmbulanceController::class, 'create'])->name('createAmbulance');
    Route::post('store-ambulance', [App\Http\Controllers\panel\AmbulanceController::class, 'store'])->name('storeAmbulance');
    Route::get('edit-ambulance/{id}', [App\Http\Controllers\panel\AmbulanceController::class, 'edit'])->name('editAmbulance');
    Route::put('update-ambulance/{id}', [App\Http\Controllers\panel\AmbulanceController::class, 'update'])->name('updateAmbulance');
    Route::delete('delete-ambulance/{id}', [App\Http\Controllers\panel\AmbulanceController::class, 'destroy'])->name('deleteAmbulance');

    Route::get('drivers', [App\Http\Controllers\panel\DriverController::class, 'index'])->name('listDriver');
    Route::get('create-driver', [App\Http\Controllers\panel\DriverController::class, 'create'])->name('createDriver');
    Route::post('store-driver', [App\Http\Controllers\panel\DriverController::class, 'store'])->name('storeDriver');
    Route::get('edit-driver/{id}', [App\Http\Controllers\panel\DriverController::class, 'edit'])->name('editDriver');
    Route::put('update-driver/{id}', [App\Http\Controllers\panel\DriverController::class, 'update'])->name('updateDriver');
    Route::delete('delete-driver/{id}', [App\Http\Controllers\panel\DriverController::class, 'destroy'])->name('deleteDriver');

    Route::get('booking-manager', [App\Http\Controllers\panel\BookingManagerController::class, 'index'])->name('listBookingManager');
    Route::get('create-booking-manager', [App\Http\Controllers\panel\BookingManagerController::class, 'create'])->name('createBookingManager');
    Route::post('store-booking-manager', [App\Http\Controllers\panel\BookingManagerController::class, 'store'])->name('storeBookingManager');
    Route::get('edit-booking-manager/{id}', [App\Http\Controllers\panel\BookingManagerController::class, 'edit'])->name('editBookingManager');
    Route::put('update-booking-manager/{id}', [App\Http\Controllers\panel\BookingManagerController::class, 'update'])->name('updateBookingManager');
    Route::delete('delete-booking-manager/{id}', [App\Http\Controllers\panel\BookingManagerController::class, 'destroy'])->name('deleteBookingManager');
    
    Route::get('add-balance-to-wallet', [App\Http\Controllers\panel\AddBalanceToWalletController::class, 'create'])->name('addBalanceToWallet');
    Route::post('store-balance-to-wallet', [App\Http\Controllers\panel\AddBalanceToWalletController::class, 'store'])->name('storeBalanceToWallet');
    
    Route::get('get-wallet', [App\Http\Controllers\panel\WalletController::class, 'index'])->name('getWallet');
    Route::get('add-balance-to-branch-wallet', [App\Http\Controllers\panel\WalletController::class, 'create'])->name('addBalanceToBWallet');
    Route::post('store-balance-to-branch-wallet', [App\Http\Controllers\panel\WalletController::class, 'store'])->name('storeBalanceToBWallet');

    Route::get('get-sub-wallet', [App\Http\Controllers\panel\SubWalletController::class, 'index'])->name('getSubWallet');

    Route::get('customer-support-manager', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'index'])->name('listCustomerSupport');
    Route::get('create-customer-support-manager', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'create'])->name('createCustomerSupport');
    Route::post('store-customer-support', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'store'])->name('storeCustomerSupport');
    Route::get('edit-customer-support-manager/{id}', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'edit'])->name('editCustomerSupport');
    Route::put('update-customer-support-manager/{id}', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'update'])->name('updateCustomerSupport');
    Route::delete('delete-customer-support-manager/{id}', [App\Http\Controllers\panel\CustomerSupportManagerController::class, 'destroy'])->name('deleteCustomerSupport');

    //Employee Customer Support Profile

    Route::get('employee-customer-support-profile', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'index'])->name('listEmployeeCustomerSupport');
    Route::get('create-employee-customer-support-profile', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'create'])->name('createEmployeeCustomerSupport');
    Route::post('store-employee-customer-support-profile', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'store'])->name('storeEmpployeeCustomerSupport');
    Route::get('edit-employee-customer-support-profile/{id}', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'edit'])->name('editEmpployeeCustomerSupport');
    Route::put('update-employee-customer-support-profile/{id}', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'update'])->name('updateEmpployeeCustomerSupport');
    Route::delete('delete-employee-customer-support-profile/{id}', [App\Http\Controllers\panel\EmployeeCustomerSupportProfile::class, 'destroy'])->name('deleteEmpployeeCustomerSupport');



    Route::get('customer-assist-manager', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'index'])->name('listCustomerAssist');
    Route::get('create-customer-assist-manager', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'create'])->name('createCustomerAssist');
    Route::post('store-customer-assist', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'store'])->name('storeCustomerAssist');
    Route::get('edit-customer-assist-manager/{id}', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'edit'])->name('editCustomerAssist');
    Route::put('update-customer-assist-manager/{id}', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'update'])->name('updateCustomerAssist');
    Route::delete('delete-customer-assist-manager/{id}', [App\Http\Controllers\panel\CustomerAssistManagerController::class, 'destroy'])->name('deleteCustomerAssist');

    Route::get('create-booking', [App\Http\Controllers\panel\CustomBookingController::class, 'create'])->name('createBooking');
    Route::post('store-booking', [App\Http\Controllers\panel\CustomBookingController::class, 'get_branch'])->name('storeBooking');

    Route::get('create-private-booking', [App\Http\Controllers\panel\CustomPrivateBookingController::class, 'create'])->name('createPrivateBooking');
    Route::post('store-private-booking', [App\Http\Controllers\panel\CustomPrivateBookingController::class, 'get_ambulance'])->name('storePrivateBooking');

    /*Private Ambulance*/
    Route::group(['prefix' => 'private-ambulance'], function () {

        Route::post('update-notify-user', [App\Http\Controllers\panel\DashboardController::class, 'update_notify_user'])->name('updateNotifyUser');

        Route::get('admin', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'index'])->name('listPrivateAmbulanceAdmin');
        Route::get('create-admin', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'create'])->name('createPrivateAmbulanceAdmin');
        Route::post('store-admin', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'store'])->name('storePrivateAmbulanceAdmin');
        Route::get('edit-admin/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'edit'])->name('editPrivateAmbulanceAdmin');
        Route::put('update-admin/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'update'])->name('updatePrivateAmbulanceAdmin');
        Route::delete('delete-admin/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAdminController::class, 'destroy'])->name('deletePrivateAmbulanceAdmin');

        Route::get('types', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'index'])->name('listPrivateAmbulanceType');
        Route::get('create-type', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'create'])->name('createPrivateAmbulanceType');
        Route::post('store-type', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'store'])->name('storePrivateAmbulanceType');
        Route::get('edit-type/{id}', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'edit'])->name('editPrivateAmbulanceType');
        Route::put('update-type/{id}', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'update'])->name('updatePrivateAmbulanceType');
        Route::delete('delete-type/{id}', [App\Http\Controllers\panel\PrivateAmbulanceTypeController::class, 'destroy'])->name('deletePrivateAmbulanceType');

        Route::get('amenities', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'index'])->name('listPrivateAmbulanceAmenity');
        Route::get('create-amenity', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'create'])->name('createPrivateAmbulanceAmenity');
        Route::post('store-amenity', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'store'])->name('storePrivateAmbulanceAmenity');
        Route::get('edit-amenity/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'edit'])->name('editPrivateAmbulanceAmenity');
        Route::put('update-amenity/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'update'])->name('updatePrivateAmbulanceAmenity');
        Route::delete('delete-amenity/{id}', [App\Http\Controllers\panel\PrivateAmbulanceAmenityController::class, 'destroy'])->name('deletePrivateAmbulanceAmenity');

        Route::get('drivers', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'index'])->name('listPrivateAmbulanceDriver');
        Route::get('create-driver', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'create'])->name('createPrivateAmbulanceDriver');
        Route::post('store-driver', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'store'])->name('storePrivateAmbulanceDriver');
        Route::get('edit-driver/{id}', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'edit'])->name('editPrivateAmbulanceDriver');
        Route::put('update-driver/{id}', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'update'])->name('updatePrivateAmbulanceDriver');
        Route::delete('delete-driver/{id}', [App\Http\Controllers\panel\PrivateAmbulanceDriverController::class, 'destroy'])->name('deletePrivateAmbulanceDriver');

        Route::get('ambulance', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'index'])->name('listPrivateAmbulance');
        Route::get('create-ambulance', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'create'])->name('createPrivateAmbulance');
        Route::post('store-ambulance', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'store'])->name('storePrivateAmbulance');
        Route::get('edit-ambulance/{id}', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'edit'])->name('editPrivateAmbulance');
        Route::put('update-ambulance/{id}', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'update'])->name('updatePrivateAmbulance');
        Route::delete('delete-ambulance/{id}', [App\Http\Controllers\panel\PrivateAmbulanceController::class, 'destroy'])->name('deletePrivateAmbulance');

        Route::get('booking-manager', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'index'])->name('listPrivateAmbulanceBookingManager');
        Route::get('create-booking-manager', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'create'])->name('createPrivateAmbulanceBookingManager');
        Route::post('store-booking-manager', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'store'])->name('storePrivateAmbulanceBookingManager');
        Route::get('edit-booking-manager/{id}', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'edit'])->name('editPrivateAmbulanceBookingManager');
        Route::put('update-booking-manager/{id}', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'update'])->name('updatePrivateAmbulanceBookingManager');
        Route::delete('delete-booking-manager/{id}', [App\Http\Controllers\panel\PrivateAmbulanceBookingManagerController::class, 'destroy'])->name('deletePrivateAmbulanceBookingManager');

    });

    Route::get('users', [App\Http\Controllers\panel\UserController::class, 'index'])->name('listUser');

});

Route::group(['prefix' => 'ajax'], function () {
    Route::get('get-ambulance-type-by-id', [App\Http\Controllers\panel\AmbulanceTypeController::class, 'get_ambulance_type_by_id'])->name('ajax_ambulance_type');
    Route::get('get-speciality-by-branch-type', [App\Http\Controllers\panel\SpecialityController::class, 'get_speciality_by_branch_type_id'])->name('ajaxSpeciality');
    Route::get('get-ambulance-type-by-amenities', [App\Http\Controllers\panel\CustomPrivateBookingController::class, 'get_ambulance_type_by_amenities'])->name('ajax_ambulance_type_by_amenities');
});


Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/privacy-policy', [App\Http\Controllers\frontend\HomeController::class, 'privacy_policy'])->name('privacyPolicy');
Route::get('/terms-and-conditions', [App\Http\Controllers\frontend\HomeController::class, 'terms_and_conditions'])->name('termsConditions');
Route::get('home', function () {
    return redirect(route('home'));
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
});

Route::get('/jwtsecret', function () {
    Artisan::call('jwt:secret');
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
});

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
