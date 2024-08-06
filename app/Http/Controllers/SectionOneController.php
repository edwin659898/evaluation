<?php

namespace App\Http\Controllers;

use App\Models\ExtraInformation;
use App\Models\SectionOne;
use App\Models\SectionOnePartB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SectionOneController extends Controller
{
    public function create()
    {
        $progress = ExtraInformation::where('user_id', auth()->id())
        ->where('status', '!=', 'HOD reviewed') 
        ->latest()->first();

        abort_if($progress == '', 403, 'You must complete the previous section');
        $info = $progress->load('sectionOne.partB');
        return view('user.section-one', compact('info'));
    }

    public function store(Request $request)
    {

        $Validated_data = $request->validate([
            'q_oneA' => 'required',
            'q_oneB' => 'required',
            'q_oneC' => 'required',
            'q_three' => 'required',
            'q_four' => 'required',
            'q_five' => 'required',
            'q_six' => 'required',
        ]);

        $info = ExtraInformation::where('user_id', auth()->id())->where('status', '!=', 'HOD reviewed') ->latest()->first();

        $data = SectionOne::updateOrCreate(
            ['extra_info' => $info->id],
            [
                'user_id' => auth()->id(),
                'q_oneA' => $Validated_data['q_oneA'],
                'q_oneB' => $Validated_data['q_oneB'],
                'q_oneC' => $Validated_data['q_oneC'],
                'q_three' => $Validated_data['q_three'],
                'q_four' => $Validated_data['q_four'],
                'q_five' => $Validated_data['q_five'],
                'q_six' => $Validated_data['q_six'],
            ]
        );

        foreach ($request->Objective as $key => $Objective) {
            SectionOnePartB::create([
                'section_one_id' => $data->id, 'Objective' => $Objective, 'status' => $request->status[$key],
                'E_comments' => $request->E_comments[$key], 'S_comments' => $request->S_comments[$key]
            ]);
        }
        Toastr::success('Saved successfully', 'Success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('section.one');
    }
}
