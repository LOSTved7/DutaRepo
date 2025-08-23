<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\DU_colleges;
use Illuminate\Support\Facades\Mail;
class StaffCollegeMappingController extends Controller
{
    protected $current_menu;

    public function __construct()
    {
        $this->current_menu = 'StaffCollegeMapping';
    }

    public function index(Request $request)
    {
        // $staffProfiles = DB::table('staff_profile')->where('status',1)->pluck('name', 'id');
        $gat_nayak = !empty($request->gat_nayak) ? $request->gat_nayak : '';
        $staff_name = !empty($request->staff_name) ? $request->staff_name : '';
        $staffProfiles = DB::table('staff_detail')->where('status',1)->pluck('name', 'id');
        $staff_Profile_id = DB::table('staff_profile')->where('status',1)->where('users_id', Auth::user()->id)->pluck( 'id')->first();
        $staff_Profile_arr = DB::table('staff_profile')
                               ->join('users', 'staff_profile.users_id', '=', 'users.id')
                               ->where('staff_profile.status',1);
                                       if(Auth::user()->role_id == 60) {
                                             $staff_Profile_arr->where('users_id', Auth::user()->id);
                                       }
                               $staff_Profile_arr =$staff_Profile_arr->pluck( 'staff_profile.name','staff_profile.id');
        $staff_detail_arr = DB::table('staff_detail')->where('status',1)->pluck( 'name','id');
        $data = DB::table('staff_college_mapping')
                  ->where('staff_college_mapping.status',1)
                  ->join('staff_detail', 'staff_college_mapping.staff_detail_id', '=', 'staff_detail.id')
                  ->where('staff_detail.status',1);
        if(Auth::user()->role_id == 60) {
            $data->where('staff_profile_id', $staff_Profile_id);
        }
        if(!empty($gat_nayak)) {
            $data->where('staff_profile_id', $gat_nayak);
        }
        if(!empty($staff_name)) {
            $data->where('staff_detail_id', $staff_name);
        }
        $data = $data->get();
        return view($this->current_menu . '.index', [
            'current_menu' => $this->current_menu,
            'data' => $data,
            'staff_Profile_arr' => $staff_Profile_arr,
            'staffProfiles' => $staffProfiles,
            'staff_detail_arr' => $staff_detail_arr,
        ]);
    }

    public function create(Request $request)
    {
        $college_name = !empty($request->college_name)?$request->college_name:'';
        $staff_profile_id = !empty($request->staff_profile_id)?$request->staff_profile_id:'';
        $staffProfiles = DB::table('staff_profile')->join('users', 'staff_profile.users_id', '=', 'users.id')->where('staff_profile.status',1)->pluck( 'staff_profile.name','staff_profile.id');
        $duColleges = DU_colleges::pluck('college_name');
        if(Auth::user()->role_id==60){
            $duColleges = DB::table('gat_nayak_college_mapping')
                          ->where('staff_profile_id',$staff_profile_id)
                          ->pluck('college_name','college_name');
            $staffProfiles = DB::table('staff_profile')->join('users', 'staff_profile.users_id', '=', 'users.id')->where('staff_profile.status',1)->where('users_id',Auth::user()->id)->pluck( 'staff_profile.name','staff_profile.id');
        }
        $data = DB::table('staff_detail')->where('status',1)->where('college_name',$college_name)->get();
        $exist = DB::table('staff_college_mapping')
                  ->where('status',1)
                  ->pluck('staff_profile_id','staff_detail_id');
        return view($this->current_menu . '.create', [
            'current_menu' => $this->current_menu,
            'staffProfiles' => $staffProfiles,
            'duColleges' => $duColleges,
            'data' => $data,
            'exist' => $exist,
            'college_name' => $college_name,
            'staff_profile_id' => $staff_profile_id,
        ]);
    }

    public function store(Request $request)
    {
        $staff_profile_id = !empty($request->staff_profile_id)?$request->staff_profile_id:'';
        $staff_id = !empty($request->staff_id)?$request->staff_id:[];
        $status = !empty($request->status)?$request->status:1;
        $data = [];
        foreach ($staff_id as $staff_detail_id) {
            $data[] = [
                'staff_profile_id' => $staff_profile_id,
                'staff_detail_id' => $staff_detail_id,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ];
        }
        DB::table('staff_college_mapping')
        ->where('staff_profile_id', $staff_profile_id)
        ->update([
                'status' => 9,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
        // dd($data);
        DB::beginTransaction();
            DB::table('staff_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff Mapped successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function edit($encid)
    {
        $id = Crypt::decryptString($encid);
        $mapping = DB::table('staff_college_mapping')->where('status',1)->where('staff_profile_id',$id)->get();
        $staffProfiles = DB::table('staff_profile')->pluck('name', 'id');
        $duColleges = DU_colleges::pluck('college_name');

        return view($this->current_menu . '.edit', [
            'current_menu' => $this->current_menu,
            'data' => $mapping,
            'encrypted_id' => $encid,
            'duColleges' => $duColleges,
            'staffProfiles' => $staffProfiles,
        ]);
    }

    public function update(Request $request, $encid)
    {
        $id = Crypt::decryptString($encid);

        $staff_profile_id = $id;
        $college_name = !empty($request->college_name)?$request->college_name:'';
        $status = !empty($request->status)?$request->status:1;
        $data = [];
        foreach ($college_name as $college) {
            $data[] = [
                'staff_profile_id' => $staff_profile_id,
                'college_name' => $college,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ];
            DB::table('staff_college_mapping')
            ->where('staff_profile_id', $staff_profile_id)
            ->where('status', 1)
            ->update([
                    'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
        // dd($data);
        DB::beginTransaction();
            DB::table('staff_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff college mapping Updated successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function destroy($encid)
    {
        $id = Crypt::decryptString($encid);

        DB::beginTransaction();
            DB::table('staff_college_mapping')->where('staff_profile_id', $id)->update([
                'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
            ]);
            DB::commit();
            Session::flash('message', 'Mapping deleted successfully.');
        return redirect()->route($this->current_menu . '.index');
    }
    public function send_whatsapp_notification(Request $request)
    {
        $subject = !empty($request->subject) ? $request->subject : '';
        $body = !empty($request->body) ? $request->body : '';
        $selected_staff = !empty($request->selected_staff) ? $request->selected_staff : '';
        $body = str_replace('    ', ' ', $request->input('body'));
        $staffIds = $request->input('staff_ids');
        $image_url = $request->input('image_url');
        $numbers = !empty($selected_staff) ? json_decode($selected_staff) : [];
        $whatsapp_nos = DB::table('staff_detail')->whereIn('id', $numbers)->pluck('whatsapp')->toArray();
        if (empty($whatsapp_nos)) {
            return back()->with('error', 'No WhatsApp numbers selected to send notification.');
        }
        foreach ($whatsapp_nos as $num) {
            if (empty($num) || $num == "") {
                return back()->with('error', 'WhatsApp Number Not Found to send notification.');
            }
        }
        $attachment = !empty($request->file('attachment'))?$request->file('attachment'):'';
        $destinationPath_profile = '';
        $fileName ='';
        if(!empty($attachment)) {
            $extension = $attachment->getClientOriginalExtension();
            $fileName = date('YmdHis').rand(10,99).'.'.$extension;
                
            $destinationPath_profile = public_path('whatsapp_message_attachments');
            $attachment->move($destinationPath_profile, $fileName);
            // dd($destinationPath_profile.'/'.$fileName);
        }
        else {
            $pathForDB_profile = NULL;
        }

        foreach ($whatsapp_nos as $id => $mobile) {
            if (!empty($mobile)) {

                $api_key   = "446121c5221741959770a43777e4aea7";
                $base_url  = "https://wa.smsidea.com/api/v1";
                $phone_no  = "91".$mobile;

                $message   = str_replace('    ', ' ', $body);
                $image_url = $destinationPath_profile.'/'.$fileName;

                $action = $fileName ? "sendImage" : "sendMessage";
                if ($action == "sendMessage") {
                    $json = [
                        "key"     => $api_key,
                        "to"      => $phone_no,
                        "message" => $message
                    ];
                } else {
                    $json = [
                        "key"=> $api_key,
                        "to"=> $phone_no,
                        "url"=> $image_url,
                        "caption"  => $message,
                        "filename" => $fileName
                    ];
                }

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $base_url . "/" . $action,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS   => 10,
                    CURLOPT_TIMEOUT        => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => "POST",
                    CURLOPT_POSTFIELDS     => json_encode($json),
                    CURLOPT_HTTPHEADER     => ["Content-Type: application/json"]
                ]);

                $response = curl_exec($ch);
                curl_close($ch);

                $decoded = json_decode($response);
                if (!empty($decoded->ErrorMessage) && $decoded->ErrorMessage == "success") {
                    DB::table("staff_detail")
                        ->where("whatsapp", $mobile)
                        ->update([
                            "whatsapp_message_sent"      => 1,
                            "whatsapp_message_sent_time" => date("Y-m-d H:i:s"),
                        ]);
                }
            }
        }
        return back()->with('message', 'WhatsApp messages sent successfully.');
    }
    public function send_mail_notification(Request $request)
    {
        $subject = !empty($request->subject) ? $request->subject : '';
        $body = !empty($request->body) ? $request->body : '';
        $body = nl2br(e($body));
        $selected_staff = !empty($request->selected_staff) ? $request->selected_staff : '';
        $staffIds = $request->input('staff_ids');
        $image_url = $request->input('image_url');
        $numbers = !empty($selected_staff) ? json_decode($selected_staff) : [];
        $emails = DB::table('staff_detail')->whereIn('id', $numbers)->pluck('email1')->toArray();
        if (empty($emails)) {
            return back()->with('error', 'No Emails selected to send notification.');
        }
        foreach ($emails as $num) {
            if (empty($num) || $num == "") {
                return back()->with('error', 'Email Not Found to send notification.');
            }
        }
        $attachment = !empty($request->file('attachment'))?$request->file('attachment'):'';
          $destinationPath_profile = '';
        $fileName ='';
        if(!empty($attachment)) {
            $extension = $attachment->getClientOriginalExtension();
            $fileName = date('YmdHis').rand(10,99).'.'.$extension;
                
            $destinationPath_profile = public_path('email_message_attachments');
            $attachment->move($destinationPath_profile, $fileName);
            $filePath = $destinationPath_profile.'/'.$fileName;
        }
        else {
            $pathForDB_profile = NULL;
            $filePath = '';
        }

        foreach ($emails as $email) {
            Mail::send([], [], function ($message) use ($email, $subject, $body, $filePath, $fileName) {
                $message->to($email)
                    ->subject($subject)
                    ->setBody($body, 'text/html');

                if ($filePath && file_exists($filePath)) {
                    $message->attach($filePath, [
                        'as' => $fileName
                    ]);
                }
            });
            DB::table("staff_detail")
                ->where("email1", $email)
                ->update([
                    "mail_sent"      => 1,
                    "email_sent_time" => date("Y-m-d H:i:s"),
                ]);
        }
        return back()->with('message', 'Email sent successfully.');
    }
}
     









