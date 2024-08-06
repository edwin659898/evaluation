<x-app-layout>
    <!-- Main content -->
    <div class="content">
        <div class="container">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class=" font-bold card-title text-green-600">Preview Data</h3>
                        </div>
                        <div class="card-body px-2">
                            <div class="content animate__animated animate__zoomIn" aria-labelledby="notice-part-trigger">

                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">

                                                @if($data->sectionSix->supervisor_comments != '' && Request::segment(1) == 'user')
                                                <div class="callout callout-info">
                                                    <h5><i class="fas fa-check-circle fill-current text-green-700"> Congratulations</i></h5>
                                                    You successfully completed the process and below is a preview of data inputed
                                                </div>
                                                @endif
                                                <!-- Main content -->
                                                <div class="invoice p-3 mb-3">

                                                    <div class="row flex justify-center items-center">
                                                        <img class="w-12 h-12 rounded-full" src="{{asset('assets/dist/img/logo.png')}}" alt="logo image" />
                                                        <h5 class="mt-1.5 text-green-700 font-bold">Staff Perfomance Evaluation</h5>
                                                    </div>

                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="row mt-4 px-2">
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Employee Name</p>
                                                                <span>{{auth()->user()->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Department</p>
                                                                <span>{{auth()->user()->department}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Academic/Professional qualifications</p>
                                                                <span>{{$data->Academic}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Current Designation</p>
                                                                <span>{{$data->Designation}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4 px-2">
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Years of service at BGF</p>
                                                                <span>{{$data->service_years}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Reviewing supervisor</p>
                                                                <span>{{$data->supervisor->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Period Under Review</p>
                                                                <span>{{$data->review_period}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-bold text-green-700 mb-2">Last Appraisal Overall Assesment</p>
                                                                <span>{{$data->last_appraisal}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($data->evaluation_type == 'yearly')
                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section One </h6>
                                                        </div>
                                                        <div class="px-4 pt-2">
                                                            <div class="row">
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">1. What is your major role in your position to achieve the company objective</p>
                                                                    <p class="font-sans text-green-700 mb-2">(a) Briefly list the main responsibilities and duties of your current job</p>
                                                                    {!!$data->sectionOne->q_oneA!!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">(b) Special tasks (if any)</p>
                                                                    {!!$data->sectionOne->q_oneB!!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">(c) How do you relate to the vision and mission of the company?</p>
                                                                    {!!$data->sectionOne->q_oneC !!}
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <p class="font-sans text-green-700 mb-2 mr-1">2. Review of the Set Quality Objectives </p>
                                                                <p class="text-green-700 text-xs">(Looking back over the period, assess what you have achieved, and what has not gone so well)</p>
                                                                <table class="table invoice-detail-table">
                                                                    <thead>
                                                                        <tr class="text-green-700">
                                                                            <th>Target Quality Objective Under Review</th>
                                                                            <th>Achieved/Not Achieved</th>
                                                                            <th>Employee Comments</th>
                                                                            <th>Reviewing Supervisor Comments</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($data->sectionOne->partB as $objective)
                                                                        <tr>
                                                                            <td>{{$objective->Objective}}</td>
                                                                            <td>{{$objective->status}}</td>
                                                                            <td>{{$objective->E_comments}}</td>
                                                                            <td>{{$objective->S_comments}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">3.What achievements are you most proud of this year?</p>
                                                                    {!!$data->sectionOne->q_three!!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">4.What factors in your considered opinion would contribute to improved performance in your current and future assignments?</p>
                                                                    {!!$data->sectionOne->q_four!!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">5.What major problems did you encounter in your job? Give reasons.</p>
                                                                    {!!$data->sectionOne->q_five !!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">6.What other additional suggestions do you offer which may help to improve your work performance and efficiency?</p>
                                                                    {!!$data->sectionOne->q_six!!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section two: Behavioural Competencies </h6>
                                                        </div>
                                                        <div class="row px-4 pt-2">
                                                            <p class="font-sans text-green-700 mb-2">The choice for which competencies are relevant to the job should be mutually agreed between the employee and the reviewing supervisor. Not all competencies may be appropriate to every role</p>
                                                            <p class="font-sans text-yellow-700 mb-2">1: Poor 2: Improvable 3: Good 4: Good+ 5: Excellent </p>
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

                                                                        @foreach($data->sectionTwo as $section_two)
                                                                        <tr>
                                                                            <td class="text-sm">{{$section_two->comp->competence_skill}}</td>
                                                                            <td><input type="text" disabled value="{{$section_two->Employee_level}}" class="mike average text-sm border-white" /></td>
                                                                            <td><input type="text" disabled value="{{$section_two->Supervisor_level}}" class="txt average text-sm border-white" /></td>
                                                                            <td><span class="text-sm">{{$section_two->Comments}}</span></td>
                                                                        </tr>
                                                                        @endforeach
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
                                                                                    <span> {{$data->sectionTwo->count() * 5}}</span>
                                                                                </div>
                                                                            </td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="row px-4 pt-2">
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Employee Signature</p>
                                                                <span>{{$data->user->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Employee Date</p>
                                                                <span>{{$data->sectionSix->created_at->format('d-m-Y') ?? $data->created_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Supervisor Signature</p>
                                                                <span>{{$data->supervisor->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Supervisor Date</p>
                                                                <span>{{$data->sectionSix->created_at->format('d-m-Y') ?? $data->created_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Manager Signature</p>
                                                                <span>{{$data->manager->name ?? $data->supervisor->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Manager Date</p>
                                                                <span>{{$data->sectionSix->manager_date ?? $data->updated_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">HOD Signature</p>
                                                                <span>{{$data->myHod->name ?? ''}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">HOD Date</p>
                                                                @if($data->myHod)
                                                                <span>{{$data->updated_at->format('d-m-Y')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @if($data->evaluation_type == 'yearly')
                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section Three: Training and Development Planning </h6>
                                                        </div>
                                                        <div class="row px-4 pt-2">
                                                            <!-- /.card-header -->
                                                            <p class="text-green-700">To be filled by employee then discussed and agreed with the supervisor & Head of department</p>
                                                            <table class="table invoice-detail-table">
                                                                <thead>
                                                                    <tr class="text-green-700">
                                                                        <th>Type</th>
                                                                        <th>Type of Training or development required</th>
                                                                        <th>How will it be achieved</th>
                                                                        <th>Person Responsible</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($data->sectionThree as $training)
                                                                    @if($training->topic == 'Skill')
                                                                    <tr>
                                                                        <td>Skill</td>
                                                                        <td>{{$training->training_required}}</td>
                                                                        <td>{{$training->how_achieved}}</td>
                                                                        <td>{{$training->person_responsible}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if($training->topic == 'Experience')
                                                                    <tr>
                                                                        <td>Experience</td>
                                                                        <td>{{$training->training_required}}</td>
                                                                        <td>{{$training->how_achieved}}</td>
                                                                        <td>{{$training->person_responsible}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if($training->topic == 'Knowledge')
                                                                    <tr>
                                                                        <td>Knowledge</td>
                                                                        <td>{{$training->training_required}}</td>
                                                                        <td>{{$training->how_achieved}}</td>
                                                                        <td>{{$training->person_responsible}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @if($training->topic == 'Other')
                                                                    <tr>
                                                                        <td>Other</td>
                                                                        <td>{{$training->training_required}}</td>
                                                                        <td>{{$training->how_achieved}}</td>
                                                                        <td>{{$training->person_responsible}}</td>
                                                                    </tr>
                                                                    @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section Four: Support Mechanisms </h6>
                                                        </div>

                                                        <div class="px-4 pt-2">
                                                            <div class="row">
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans font-bold text-green-700 mb-2">1. What support mechanisms from your supervisor or other parts of the organization have worked well and what can be improved upon</p>
                                                                    <p class="font-sans text-green-700 mb-2">Supervisor: works well</p>
                                                                    {!!$data->sectionFour->sup_works_well!!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">Supervisor: Need for improvement</p>
                                                                    {!!$data->sectionFour->sup_needs_improvement !!}
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">Other parts of the Organization: What has worked well</p>
                                                                    {!!$data->sectionFour->org_works_well !!}
                                                                </div>
                                                                <div class="form-group w-full">
                                                                    <p class="font-sans text-green-700 mb-2">Other parts of the Organization: Need for improvement</p>
                                                                    {!!$data->sectionFour->org_needs_improvement!!}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @if($data->evaluation_type == 'yearly')
                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section Five: Personal Objective </h6>
                                                        </div>
                                                        <div class="px-4 pt-2">
                                                            <table class="table invoice-detail-table">
                                                                <thead>
                                                                    <tr class="text-green-700">
                                                                        <th>Proposed Personal Objective</th>
                                                                        <th>Departmental/Strategic Business Objective it is linked to</th>
                                                                        <th>How will achievement of this objective be measured</th>
                                                                        <th>What steps will be taken to achieve this</th>
                                                                        <th>Completion date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($data->sectionFive as $objective)
                                                                    <tr>
                                                                        <td>{{$objective->proposed_objective}}</td>
                                                                        <td>{{$objective->department_linked}}</td>
                                                                        <td>{{$objective->objective_measurement}}</td>
                                                                        <td>{{$objective->steps_to_achieve}}</td>
                                                                        <td>{{$objective->completion_date}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Section Six: Overal Comments </h6>
                                                        </div>

                                                        <div class="row px-4 pt-2">
                                                            <div class="form-group w-full">
                                                                <p class="font-sans font-bold text-green-700 mb-2">Based on discussions on the five sections above</p>
                                                                <p class="font-sans text-green-700 mb-2">Employee: Comments</p>
                                                                {!!$data->sectionSix->employee_comments!!}
                                                            </div>
                                                            <div class="form-group w-full">
                                                                <p class="font-sans text-green-700 mb-2">Supervisor: Comments</p>
                                                                {!!$data->sectionSix->supervisor_comments !!}
                                                            </div>
                                                            <div class="form-group w-full">
                                                                <p class="font-sans text-green-700 mb-2">Manager: Comments</p>
                                                                {!!$data->sectionSix->manager_comments ?? $data->sectionSix->supervisor_comments !!}
                                                            </div>
                                                            <div class="form-group w-full">
                                                                <p class="font-sans text-green-700 mb-2">HOD: Comments</p>
                                                                {!!$data->sectionSix->hod_comments !!}
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="border-double border-4 border-light-blue-500 rounded-md mt-2">
                                                        <div class="mb-2 px-2 pt-2">
                                                            <h6 class=" font-bold text-green-700">Signed as an agreed record:</h6>
                                                        </div>

                                                        <div class="row px-4 pt-2">
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Employee Signature</p>
                                                                <span>{{$data->user->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Employee Date</p>
                                                                <span>{{$data->sectionSix->created_at->format('d-m-Y') ?? $data->created_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Supervisor Signature</p>
                                                                <span>{{$data->supervisor->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Supervisor Date</p>
                                                                <span>{{$data->sectionSix->created_at->format('d-m-Y') ?? $data->created_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Manager Signature</p>
                                                                <span>{{$data->manager->name ?? $data->supervisor->name}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">Manager Date</p>
                                                                <span>{{$data->sectionSix->manager_date ?? $data->updated_at->format('d-m-Y')}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">HOD Signature</p>
                                                                <span>{{$data->myHod->name ?? ''}}</span>
                                                            </div>
                                                            <div class="form-group col-sm-3">
                                                                <p class="font-sans text-green-700 mb-2">HOD Date</p>
                                                                @if($data->myHod)
                                                                <span>{{$data->updated_at->format('d-m-Y')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- /.invoice -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </div><!-- /.container-fluid -->
                                </section>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

    </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</x-app-layout>