<?php

namespace App\Http\Controllers;

use App\Models\ExtraInformation;
use App\Models\SectionFive;
use App\Models\SectionSix;
use App\Models\Signature;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;

class SectionSixController extends Controller
{
    public function create()
    {
        $progress = ExtraInformation::where('user_id', auth()->id())->where('status', '!=', 'HOD reviewed')->latest()->first();

        if ($progress) {
            abort_if($progress->sectionFive->count() < 2 && $progress->evaluation_type == 'yearly', 403, 'You must complete the previous section');
            $info = $progress->load('SectionSix');
            return view('user.section-six', compact('info'));
        } else {
            abort(403, 'You must complete the previous section');
        }
    }

    public function store(Request $request)
    {

        $validated_data = $request->validate([
            "employee_comments"  => "required",
            "supervisor_comments"  => "required",
        ]);

        $info = ExtraInformation::where('user_id', auth()->id())
                ->where('status', '!=', 'HOD reviewed')
                 
                ->latest()->first();
        $validated_data["extra_info"] = $info->id;

        SectionSix::updateOrCreate(
            ['extra_info' => $info->id],
            [
                'user_id' => auth()->id(), 'employee_comments' => $request->employee_comments,
                'supervisor_comments' => $request->supervisor_comments
            ]
        );

        if(auth()->user()->manager_id == auth()->user()->HOD_id){
            $info->update(['status' => 'manager reviewed']);
            $data = [
                'intro'  => 'Dear HOD ' . auth()->user()->department . ',',
                'content'   => auth()->user()->name . ' has completed his performance evaluation and request your review.',
                'name' => 'HOD ' . auth()->user()->department,
                'email' => auth()->user()->HOD_email,
                'subject'  => 'Successful completion of performance evaluation.'
            ];
            Mail::send('emails.mail', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject($data['subject']);
            });
        }else{
            $info->update(['status' => 'completed']);
            $data = [
                'intro'  => 'Dear Supervisor for ' . auth()->user()->name . ',',
                'content'   => auth()->user()->name . ' has completed his performance evaluation and request your review.',
                'name' => 'Supervisor Notification',
                'email' => auth()->user()->manager->email,
                'subject'  => 'Successful completion of performance evaluation.'
            ];
            Mail::send('emails.mail', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject($data['subject']);
            });
        }

        Toastr::success('Saved successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('section.six');
    }

    public function final()
    {
        $data = ExtraInformation::with('user','supervisor', 'sectionOne.partB', 'sectionTwo', 'sectionThree', 'sectionFour', 'sectionFive', 'sectionSix')
            ->where('user_id', auth()->id())->where('status', '!=', 'HOD reviewed') ->latest()->first();
        if ($data != null) {
            return view('User.final', compact('data'));
        } else {
            Toastr::warning('No evalution in progress. Here are the previous ones', 'Warning', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('dashboard');
        }
    }

    public function printResults()
    {
        $data = $data = ExtraInformation::where('user_id', auth()->id())->latest()->first()->toArray();
        view()->share('data', $data);

        $pdf = PDF::loadView('User.document', ['data' => $data]);
        return $pdf->download(auth()->user()->name . '.pdf');
    }
}
