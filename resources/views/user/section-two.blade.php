<x-app-layout>
    <!-- Main content -->
    <div class="content">
        <div class="container">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class=" font-bold card-title text-green-700">Section two: Behavioural Competencies</h3>
                        </div>
                        <div class="card-body px-4 animate__animated animate__zoomIn">
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form method="POST" action="{{route('sectionTwo.store')}}" data-name="submit Form">
                                @csrf
                                <div class="row">
                                    <p class="font-sans font-bold text-green-700 mb-2">The choice for which competencies are relevant to the job should be mutually agreed between the employee and the reviewing supervisor. Not all competencies may be appropriate to every role</p>
                                    <div class="table-responsive">
                                        <table class="table invoice-detail-table">
                                            <thead>
                                                <tr class="text-green-700">
                                                    <th>Competence Relevant to job</th>
                                                    <th>Employee level</th>
                                                    <th>Supervisor level</th>
                                                    <th>Comments (How will this be achieved)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($info->sectionTwo->count() < 1)
                                                @foreach($competences as $competence)
                                                <tr>
                                                    <td class="text-sm">
                                                        <input type="hidden" name="Competence_id[{{$loop->index}}]" value="no" />
                                                        <input type="checkbox" name="Competence_id[{{$loop->index}}]" value="{{$competence->id}}" checked class="mr-2" />
                                                        {{$competence->competence_skill}}
                                                    </td>
                                                    <td>
                                                        <select class="btn-blue mike average text-sm" name="Employee_level[]" onchange="update_sumB(),update_avg()">
                                                            <option value="">Select</option>
                                                            <option value="1">Poor 1</option>
                                                            <option value="2">Improvable 2</option>
                                                            <option value="3">Good 3</option>
                                                            <option value="4">Good+ 4</option>
                                                            <option value="5">Excellent 5</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="btn-blue txt average text-sm" name="Supervisor_level[]" onchange="update_sum(),update_avg()">
                                                            <option value="">Select</option>
                                                            <option value="1">Poor 1</option>
                                                            <option value="2">Improvable 2</option>
                                                            <option value="3">Good 3</option>
                                                            <option value="4">Good+ 4</option>
                                                            <option value="5">Excellent 5</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="Comments[]" class="btn-blue h-12 text-sm" placeholder="How will this be achieved">{{ old('Comments')[$loop->index] ?? ''}}</textarea>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                @foreach($info->sectionTwo as $data)
                                                <tr>
                                                    <td class="text-sm">{{$data->comp->competence_skill}}</td>
                                                    <td><input type="text" disabled value="{{$data->Employee_level}}" class="mike average text-sm border-white" /></td>
                                                    <td><input type="text" disabled value="{{$data->Supervisor_level}}" class="txt average text-sm border-white" /></td>
                                                    <td><span class="text-sm">{{$data->Comments}}</span></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td class="text-sm">Total</td>
                                                    <td><span class="flex justify-center items-center mt-1" id="sum-fieldB">0</span></td>
                                                    <td><span class="flex justify-center items-center mt-1" id="sum-field">0</span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-sm">Average</td>
                                                    <td>
                                                        <div class="flex justify-center items-center mt-1 space-x-1 text-sm">
                                                            <span id="avg">0</span> /
                                                            <span>{{$info->sectionTwo->count() * 5}}</span>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <p class="font-sans text-green-700 mb-2">Employee Signature</p>
                                        <span>{{auth()->user()->name}}</span>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <p class="font-sans text-green-700 mb-2">Employee Date</p>
                                        <span>{{now()->format('d-m-Y')}}</span>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <p class="font-sans text-green-700 mb-2">Supervisor Signature</p>
                                        <span>{{$info->supervisor->name}}</span>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <p class="font-sans text-green-700 mb-2">Supervisor Date</p>
                                        <span>{{now()->format('d-m-Y')}}</span>
                                    </div>
                                </div>
                                @if($info->sectionTwo->count() < 1)
                                <div class="flex justify-end mt-2">
                                    <input type="submit" data-wait="Please wait..." value="Save and Continue" class="text-white bg-green-800 font-bold uppercase text-xs px-4 py-2 rounded-full shadow  mr-1 mb-1 hover:bg-blue-500">
                                </div>
                                @endif
                            </form>


                            @if($info->sectionTwo->count() > 1)
                            <div class="flex justify-end mt-4">
                                @if($info->evaluation_type == 'yearly')
                                <a href="{{route('section.three')}}" class="text-green-800 hover:text-blue-600 font-bold px-2">Next <i class="fas fa-arrow-right"></i></a>
                                @else
                                <a href="{{route('section.four')}}" class="text-green-800 hover:text-blue-600 font-bold px-2">Next <i class="fas fa-arrow-right"></i></a>
                                @endif
                            </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.content -->
    @push('scripts')
        <script>
            $('form[data-name="submit Form"]')
                .submit(function(e) {
                    const submitButton = $(e.target).find("input[type=submit]");
                    submitButton.prop("disabled", true);
                    var waitingText = submitButton.attr("data-wait");
                    submitButton.attr("value", waitingText);
                    return true;
                });
        </script>
    @endpush
</x-app-layout>