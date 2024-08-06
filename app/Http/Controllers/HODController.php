<?php

namespace App\Http\Controllers;

use App\Models\ExtraInformation;
use App\Models\SectionSix;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class HODController extends Controller
{
    public function IT()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'IT' || auth()->user()->role_admin, 403, 'Unauthorized access');

        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'IT');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function ME()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'M&E' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'M&E');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function Communications()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Communications' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data =  ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Communications');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function Accounts()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Accounts' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Accounts');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function Operations()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Operations' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Operations');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function HR()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Human Resources' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Human Resources');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function Forestry()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Forestry' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Forestry');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function MITI()
    {
        abort_unless(auth()->user()->role_HOD && auth()->user()->department == 'Miti Magazine' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'manager reviewed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Miti Magazine');
            })
            ->get();
        return view('hod.table', compact('data'));
    }

    public function view($id)
    {
        abort_if(!auth()->user()->role_HOD, 403, 'Unauthorized access');
        $data = ExtraInformation::with(
            'user',
            'supervisor',
            'sectionOne',
            'sectionTwo',
            'sectionThree',
            'sectionFour',
            'sectionFive',
            'sectionSix',
        )->findOrFail($id);

        if ($data->user->department == auth()->user()->department || auth()->user()->role_admin) {
            return view('hod.report', compact('data'));
        } else {
            abort(403, 'Restricted access');
        }
    }

    public function comment(Request $request, $id)
    {
        abort_if(!auth()->user()->role_HOD, 403, 'Unauthorized access');
        $request->validate([
            'hod_comments' => 'required',
        ]);

        $comment = SectionSix::findOrFail($id);
        $comment->update([
            'hod_comments' => $request->hod_comments, 'hod_date' => now()->format('Y-m-d')
        ]);

        $password = uniqid() . $comment->user_id;

        $evaluation = ExtraInformation::findOrFail($comment->extra_info);
        $evaluation->update([
            'review_hod' => auth()->id(),
            'status' => 'HOD reviewed',
            'access_password' => $password
        ]);

        $data = $evaluation->load('user')->toArray();

        // view()->share('data', $data);

        // $pdf = PDF::loadView('user.document', ['data' => $data]);
        // $timestamp = uniqid() . $comment->user_id;
        // Storage::put('public/pdf/' . $timestamp . '/evaluation.pdf', $pdf->output());


        $info = [
            'intro'  => 'Dear ' . $data['user']['name'] . ',',
            'content'   => 'Your performance evauation has been reviewed by the HOD and given his remarks',
            'password' => $password,
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'subject'  => 'Successful completion of HOD review on your performance evaluation.'
        ];
        Mail::send('emails.link', $info, function ($message) use ($info) {
            $message->to($info['email'], $info['name'])
                ->subject($info['subject']);
        });

        Toastr::success('Saved successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('dashboard');
    }

    public function followUp()
    {
        abort_if(!auth()->user()->role_admin, 403, 'Unauthorized access');
        return view('hod.follow-up');
    }

    public function report($id)
    {
        abort_if(!auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::with(
            'user',
            'myHod',
            'supervisor',
            'sectionOne',
            'sectionTwo',
            'sectionThree',
            'sectionFour',
            'sectionFive',
            'sectionSix',
        )->find($id);
        return view('hod.print', compact('data'));
    }

    public function filing($id)
    {
        abort_if(!auth()->user()->role_admin, 403, 'Unauthorized access');
        ini_set('max_execution_time', 60000);
        $data = ExtraInformation::with(
            'user',
            'myHod',
            'supervisor',
            'sectionOne',
            'sectionOne.partB',
            'sectionTwo',
            'sectionTwo.comp', 
            'sectionThree',
            'sectionFour',
            'sectionFive',
            'sectionSix',
        )->find($id)->toArray();

        return view('user.document', ['data' => $data]);
        //view()->share('data', $data);

        //$pdf = PDF::loadView('user.document', ['data' => $data]);
        //return $pdf->download('Evaluation.pdf');
    }
}
