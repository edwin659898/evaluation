<?php

namespace App\Http\Controllers;

use App\Models\ExtraInformation;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ExtraInformationController extends Controller
{
    public function dashboard()
    {
        $extra_info = ExtraInformation::with('supervisor')->where('user_id', auth()->id())->get();
        return view('dashboard', compact('extra_info'));
    }

    public function index()
    {
        return view('user.non-disclosure');
    }

    public function moreInfo()
    {
        $info = ExtraInformation::with('supervisor')->where('user_id', auth()->id())
            ->where('status', '!=', 'HOD reviewed')
            ->latest()->first();
        $users = User::all();
        return view('user.personal-info', compact(['users', 'info']));
    }

    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'evaluation_type' => 'required',
            'Academic' => 'required',
            'Designation' => 'required',
            'service_years' => 'required',
            'review_supervisor' => 'required',
            'review_period' => 'required',
            'last_appraisal' => 'required',
        ]);

        $data = auth()->user()->more_info()->create($validatedData);
        Toastr::success('Saved successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect('/user/Extra-Information');
    }

    public function file(Request $request)
    {
        $timestamp = $request->password;
        $data = ExtraInformation::where( 'access_password' ,$timestamp)->first();
        $data->load(
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
        )->toArray();

        return view('user.document', ['data' => $data]);
    }

    public function excel()
    {
        $string = request('date');
        $str_arr = explode("-", $string);
        $start_date = request('date') ? date('Y-m-d', strtotime($str_arr[0])) : '';
        $end_date = request('date') ? date('Y-m-d', strtotime($str_arr[1])) : '';
        
        $datas = ExtraInformation::whereHas('user')
            ->with(
                'user',
                'myHod',
                'supervisor',   
                'sectionOne.partB',
                'sectionTwo',
                'sectionThree',
                'sectionFour',
                'sectionFive',
                'sectionSix',
            )
            ->when(request('date') != '', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->when(request('evaluation_type'), function ($query) use ($start_date, $end_date) {
                $query->where('evaluation_type', request('evaluation_type'));
            })
            ->get();

        return view('hod.excel', compact('datas'));
    }

    public function previousEvaluation($id)
    {
        $data = ExtraInformation::findOrFail($id)
            ->load('supervisor', 'sectionOne.partB', 'sectionTwo', 'sectionThree', 'sectionFour', 'sectionFive', 'sectionSix');

        return view('User/previous-evaluation', compact('data'));
    }

    public function viewMyPDF($slug)
    {
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
        )->where('access_password', $slug)->first()->toArray();

        return view('user.document', ['data' => $data]);
    }
}
