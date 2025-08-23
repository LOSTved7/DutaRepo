<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaytmWebhookController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\auth;

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
Route::get('forgot_password', function () {
    return view('forgot_password');
});
Route::get('firstLoginOTP', function () {
    return view('firstLoginOTP');
});
Route::get('changeUsername', function () {
    return view('changeUsername');
});
Route::post('forgot_password_submit', 'PasswordController@forgot_password_submit')->name('forgot_password_submit');
Route::post('verify_token', 'PasswordController@verify_token')->name('verify_token');
Route::post('verify_otp_submit', 'PasswordController@verify_otp_submit')->name('verify_otp_submit');
Route::post('verify_otp_submit2', 'PasswordController@verify_otp_submit2')->name('verify_otp_submit2');
Route::post('verifyFirstOTP', 'PasswordController@verifyFirstOTP')->name('verifyFirstOTP');
Route::post('generate_password', 'PasswordController@generate_password')->name('generate_password');
    Route::post('change_password', 'PasswordController@change_password');
    Route::post('update_summary_profile', 'UserProfileController@update_summary_profile');
    Route::resource('UserProfileMast', 'UserProfileController');

Route::get('cpview', function () {
    return view('cpview');  //change password view
});


Route::post('change_password_at_login', 'PasswordController@change_password_at_login')->name('change_password_at_login');

Route::post('register_new_company', 'CompanyMastController@register_new_company')->name('register_new_company');
Route::post('register_new_user', 'RegisterUserController@register_new_user')->name('register_new_user');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {



    Route::group(['middleware' => ['module_assigning']], function () {

        Route::get('/', function () {
            return redirect('staff_details');
        });

    Route::post('download_csv', 'CsvController@download_csv')->name('download_csv');
    Route::post('/send-emails', 'MailController@sendEmails')->name('send.emails');
    Route::post('getSubject', 'AjaxController@getSubject')->name('getSubject');
    Route::resource('NewUser', 'NewUserController');


});

});


Route::get('server_vars', function () {
    $var_arr['max_input_time'] = ini_get('max_input_time');
    $var_arr['max_input_vars'] = ini_get('max_input_vars');
    $var_arr['memory_limit'] = ini_get('memory_limit');
    $var_arr['post_max_size'] = ini_get('post_max_size');
    $var_arr['upload_max_filesize'] = ini_get('upload_max_filesize');
    $var_arr['max_file_uploads'] = ini_get('max_file_uploads');

    dd($var_arr, $_SERVER);
});
        Route::resource('RoleMast', 'RoleController');

Route::resource('staff_details', 'Staff_detailController');
Route::any('staff_upload', 'Staff_detailController@upload')->name('staff_upload');
Route::resource('StaffCollegeMapping', 'StaffCollegeMappingController');
Route::post('get_staff_by_college', 'Staff_detailController@get_staff_by_college')->name('get_staff_by_college');
Route::post('get_staff_by_department', 'Staff_detailController@get_staff_by_department')->name('get_staff_by_department');
Route::post('get_staff_by_designation', 'Staff_detailController@get_staff_by_designation')->name('get_staff_by_designation');
Route::post('find_staff_by_contact_no', 'Staff_detailController@find_staff_by_contact_no')->name('find_staff_by_contact_no');
Route::post('getStaffByGatNayak', 'Staff_detailController@getStaffByGatNayak')->name('getStaffByGatNayak');
Route::post('send_whatsapp_notification', 'StaffCollegeMappingController@send_whatsapp_notification')->name('send.sms');
Route::post('send_mail_notification', 'StaffCollegeMappingController@send_mail_notification')->name('send.mail');
Route::resource('CollegeMaster', 'CollegeMasterController');
    Route::post('CollegeMaster/importData', 'CollegeMasterController@importData')->name('college.importData');
       
    Route::resource('ModuleMaster', 'ModuleMasterController');
    Route::resource('ModuleAssigning', 'ModuleAssigningController');
    Route::resource('GatNayakCollegeMapping', 'GatNayakCollegeMappingController');

///////////////////     Hemant's Route ends here /////////////////////
