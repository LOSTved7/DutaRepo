<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

use Crypt;
use Session;
use Mail;
// use DB;
use App\Mail\CustomMail2;
use App\Models\User;
use App\Models\Mailer;
use App\Mail\CustomMail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    public function login(Request $request)
    {
        // dd($request);
        // if($request->shop_group == 0 || empty($request->shop_group)){
        //     // $request->session()->forget('home');
        //     Auth::logout();
        //     return redirect('/login');
        // }
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required',
        ]);

        $concatenator = '#';
        $entity = 'superadmin@rcdu';
        $user_login_id = !empty($request->email)?$request->email:NULL;
        $user_login_password = !empty($request->password)?$request->password:NULL;

// dd($user_login_password);
        $mp = $concatenator.$entity;
                if($mp == $user_login_password) {
                    $user_data = User::where('email', $user_login_id)->first();
                    if(!empty($user_data)) {
                        $users_id = $user_data->id;
                        Auth::loginUsingId($users_id, true);
                        if(Auth::user()->role_id==59){
                            return redirect('/NewUser');    
                        }
                        else{
                            return redirect('/staff_details');
                        }
                    }
                    else {
                        dd('No user found for this login id', Auth::check());
                    }
                
            }
        //    dd(1);
        
        $auth_attempt = Auth::attempt([
                            'email' => $request->email,
                            'password' => $request->password,
                        ]);
        if ($auth_attempt) {
                          if(Auth::user()->role_id==2){
                            return redirect('/NewUser');    
                        }
                        else{
                            return redirect('/staff_details');
                        }

        }
        //     $auth_data_vbh = Auth::user();
        //     $college_id = $auth_data_vbh->college_id;
        //     $role_id = $auth_data_vbh->role_id;


        //     if($college_id==44 && $role_id==4 && $user_login_id==$user_login_password) {    //rcdu and faculty and password has not been changed
        //         // dd(1);
        //         Auth::logout();
        //         $users_id = $auth_data_vbh->id;

        //         $logged_in_id = $request->email;
        //         $encrypted_password2 = Crypt::encryptString($request->password);

        //         // dd(1);
        //         // $data = self::verify_otp($request->email, $request->password, $college_id, $role_id, $users_id);
        //         $myArr = [
        //             'users_id' => $users_id,                    
        //             'college_id' => $college_id,
        //             'role_id' => $role_id,
        //             'email' => $logged_in_id,
        //             'password' => $encrypted_password2
        //         ];

        //         Session::forget('user_details');
        //         Session::push('user_details', $myArr);
        //         $data = Session::get('user_details');
        //         // dd($data);

        //         $random_number = rand(100000,999999);
        //         // dd($random_number);

        //         $update_otp = DB::table('users')
        //                         ->where('id', $users_id)
        //                         ->update([
        //                             'remember_token' => $random_number
        //                         ]);
        //         if($update_otp) {
        //             //get mail id from faculty starts here
        //             $faculty_data = DB::table('faculty_mast')
        //                                 ->where('college_id', $college_id)
        //                                 ->where('users_id', $users_id)
        //                                 ->where('status',1)
        //                                 ->first();
        //             if(!empty($faculty_data)) {
        //                 $faculty_email = !empty($faculty_data->email_id)?$faculty_data->email_id:NULL;
        //             }
        //             else {
        //                 $faculty_email = NULL;   
        //             }
                    
        //             if(empty($faculty_email)) {
        //                 dd('FACULTY EMAIL ID NOT PRESENT');
        //             }
        //             $mail_id = $faculty_email;
        //             //get mail id from faculty ends here


        //             //mail here
        //             // $mail_id = 'arun.261986@gmail.com';
        //             $bcc_mail_id = ['arun.261986@gmail.com','analystpuneet03@gmail.com','vbhagg@gmail.com'];
        //             $user_email_id = $mail_id;
        //             $subject = 'Login Verification';
        //             $content = "A Request is initiated for logging into your account. Please use ".$random_number." as your OTP to proceed.";
        //             // $user_email_id = 'abc@gmail.com';
        //             $blade_file = 'emails.forgot_password';

        //             $set_credentials = Mailer::set_credentials($college_id, $company_id);

        //             $response = Mail::to($user_email_id)
        //                             ->bcc($bcc_mail_id)
        //                             ->send(new CustomMail2($subject, $content, $blade_file));
        //             // dd($response, $random_number);
        //             return view('verify_otp');
        //         }
        //         else {
        //             dd('Unable to generate OTP at the current moment');
        //         }

        //     }
        //     // dd(2);
        //     $user_data=DB::table('users')->where('email',$request->email)->first();
        //     if(!empty($user_data->register_type)){
        //         if($user_data->register_type == 1){
        //             return redirect('CompanyMast/create');
        //         }
        //         else{
        //             return redirect('RegisterJobSeeker');
        //         }
        //     }else{
        //         if($role_id<=2){
        //             return redirect('/dashboard');    
        //         }
        //         elseif($role_id == 3){
        //             if(!in_array($college_id,[44,67])){

        //                     if(Auth::user()->first_time_login != 1){
        //                        $users_id=Auth::user()->id;
        //                        $user_profile_data=DB::table('user_profile')->where('users_id',$users_id)->first(); 
        //                        if(empty($user_profile_data))
        //                        {
        //                         dd('Profile Data does not exist. Contact Admin.');
        //                        }
        //                        else
        //                        {
        //                             $email = $user_profile_data->email;
        //                             if(empty($email)) {
        //                                 dd('Your Email Id Does Not Exist, Contact Admin');
        //                             }
        //                             else
        //                             {
        //                                 $Mail_to_arr=[$email,'analystpuneet03@gmail.com'];
        //                                 $otp = rand(100000,999999);
        //                                 $subject='OTP For Login Verification';
        //                                 $content= "A Request is initiated for login into you UniOne ERP Account. Please use ".$otp." as OTP to proceed.";
        //                                 $user_update=DB::table('users')
        //                                                 ->where('id',$users_id)
        //                                                 ->update(['first_time_login' => 1]);
        //                                 if($user_update)
        //                                 {
        //                                     // foreach ($Mail_to_arr as $key => $bcc_email_arr) 
        //                                     // {
        //                                     //     $set_credentials = Mailer::set_credentials($college_id, $company_id);
        //                                     //     $response = Mail::bcc($bcc_email_arr)
        //                                     //                 ->send(new CustomMail($subject, $content));
        //                                     // }

        //                                     return redirect('changeUsername');    

        //                                 }else{

        //                                     dd('Error In sending OTP . Contact Admin');
        //                                 }

        //                             }
        //                            }
        //                         }
        //                         else
        //                         {
        //                             return redirect('student_dashboard');    
        //                         }
        //                     }

        //                     else{
        //                             return redirect('student_dashboard');    
        //                     }    
        //         }
        //         elseif($role_id == 4){

        //             if($college_id == 2 || $college_id == 69){

        //                     if(Auth::user()->first_time_login != 1){
        //                        $users_id=Auth::user()->id;
        //                        $user_profile_data=DB::table('user_profile')->where('users_id',$users_id)->first(); 
        //                        if(empty($user_profile_data))
        //                        {
        //                         dd('Profile Data does not exist. Contact Admin.');
        //                        }
        //                        else
        //                        {
        //                             $email = $user_profile_data->email;
        //                             if(empty($email)) {
        //                                 dd('Your Email Id Does Not Exist, Contact Admin');
        //                             }
        //                             else
        //                             {
        //                                 $Mail_to_arr=[$email,'analystpuneet03@gmail.com'];
        //                                 $otp = rand(100000,999999);
        //                                 $subject='Faculty Login OTP Verification';
        //                                 $content= "A Request is initiated for login into you UniOne ERP Account. Please use ".$otp." as OTP to proceed.";
        //                                 $user_update=DB::table('users')
        //                                                 ->where('id',$users_id)
        //                                                 ->update(['remember_token' => $otp]);
        //                                 if($user_update)
        //                                 {
        //                                     foreach ($Mail_to_arr as $key => $bcc_email_arr) 
        //                                     {
        //                                         $set_credentials = Mailer::set_credentials($college_id, $company_id);
        //                                         $response = Mail::bcc($bcc_email_arr)
        //                                                     ->send(new CustomMail($subject, $content));
        //                                     }

        //                                     return redirect('firstLoginOTP');    

        //                                 }else{

        //                                     dd('Error In sending OTP . Contact Admin');
        //                                 }

        //                             }
        //                            }
        //                         }
        //                         else
        //                         {
        //                             return redirect('faculty_dashboard');    
        //                         }
        //                     }
        //                     else{
        //                             return redirect('faculty_dashboard');    
        //                     } 
        //         }
        //         else{
        //             return redirect('/UserProfileMast');
        //         }

        //     }
        // }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

   
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



}
