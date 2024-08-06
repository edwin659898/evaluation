<?php

namespace App\Http\Controllers;

use App\Models\ExtraInformation;
use App\Models\SectionSix;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupervisorController extends Controller
{
    public function IT()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'IT' || auth()->user()->role_admin, 403, 'Unauthorized access');

        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'IT');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function ME()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'M&E' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'M&E');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function Communications()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Communications' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data =  ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Communications');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function Accounts()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Accounts' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Accounts');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function Operations()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Operations' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Operations');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function HR()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Human Resources' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Human Resources');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function Forestry()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Forestry' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Forestry');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function MITI()
    {
        abort_unless(auth()->user()->role_manager && auth()->user()->department == 'Miti Magazine' || auth()->user()->role_admin, 403, 'Unauthorized access');
        $data = ExtraInformation::where('status', '=', 'completed')
            ->whereHas('user', function ($query) {
                $query->where('department', '=', 'Miti Magazine');
            })
            ->get();
        return view('manager.table', compact('data'));
    }

    public function view($id)
    {
        abort_if(!auth()->user()->role_manager, 403, 'Unauthorized access');
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
            return view('manager.report', compact('data'));
        } else {
            abort(403, 'Restricted access');
        }
    }

    public function comment(Request $request, $id)
    {
        abort_if(!auth()->user()->role_manager, 403, 'Unauthorized access');
        $request->validate([
            'manager_comments' => 'required',
        ]);

        $comment = SectionSix::findOrFail($id);
        $comment->update([
            'manager_comments' => $request->manager_comments, 'manager_date' => now()->format('Y-m-d')
        ]);

        $evaluation = ExtraInformation::findOrFail($comment->extra_info);
        $evaluation->update(['review_manager' => auth()->id(), 'status' => 'manager reviewed']);

        $data = [
            'intro'  => 'Dear HOD ' . $evaluation->user->department . ',',
            'content'   => $evaluation->user->name . ' Dept manager has reviewed their perfomance evaluation and request your approval.',
            'name' => 'HOD ' . $evaluation->user->department,
            'email' => $evaluation->user->HOD_email,
            'subject'  => 'Successful completion of performance evaluation.'
        ];
        Mail::send('emails.mail', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject($data['subject']);
        });

        Toastr::success('Saved successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('dashboard');
    }


}
