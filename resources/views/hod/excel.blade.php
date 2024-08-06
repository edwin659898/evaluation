<x-app-layout>
    <!-- Main content -->
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    <div class="content">
        <div class="container">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class=" font-bold card-title text-green-600">Follow Up</h3>
                        </div>
                        <div class="card-body px-2">
                            <div class="content animate__animated animate__zoomIn" aria-labelledby="notice-part-trigger">

                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="w-full border rounded-md m-2 px-2 py-2">
                                                <form action="" method="GET" class="flex items-center justify-end">
                                                    <div class="form-group col-sm-3">
                                                        <label class="font-sans">Dates</label>
                                                        <input type="text" name="date" class="btn-blue" id="reservation" value="{{request('date')}}">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label class="font-sans">Evaluation Type</label>
                                                        <select class="btn-blue" name="evaluation_type" required>
                                                            <option disabled="disabled" selected="selected">-- Select Evaluation type --</option>
                                                            <option value="probation" {{ 'probation' == (request('evaluation_type') ?? '') ? 'selected' : '' }}>Probation</option>
                                                            <option value="yearly" {{ 'yearly' == (request('evaluation_type') ?? '') ? 'selected' : '' }}>Yearly</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label>Apply:</label>
                                                        <div>
                                                            <button class="btn btn-primary btn-sm">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12 table-responsive">
                                                <table id="example1" class="table-responsive table table-bordered table-striped">
                                                    <thead>
                                                        <td> Employee Name</td>
                                                        <td> Department</td>
                                                        <td> Site</td>
                                                        <td> Designation</td>
                                                        <td> Objective Type</td>
                                                        <td> Objective status</td>
                                                        <td> Employee comments</td>
                                                        <td> Supervisor Comments</td>
                                                        <td> Employee Marks</td>
                                                        <td> Supervisor Marks</td>
                                                        <td> Marks Out Of</td>
                                                        <td> T&D Skill</td>
                                                        <td> T&D Knowledge</td>
                                                        <td> T&D Experience</td>
                                                        <td> T&D Other</td>
                                                        <td> Supervisor Works Well</td>
                                                        <td> Supervisor Needs Improvement</td>
                                                        <td> Org Works Well</td>
                                                        <td> Org Needs Improvement</td>
                                                        <td> Employee Comments</td>
                                                        <td> Supervisor Comments</td>
                                                        <td> Manager Comments</td>
                                                        <td> HOD Comments</td>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($datas as $data)
                                                        <tr>
                                                            <td>{{$data->user->name}}</td>
                                                            <td>{{$data->user->department}}</td>
                                                            <td>{{$data->user->site}}</td>
                                                            <td>{{$data->user->job_title}}</td>
                                                            <td>
                                                                @foreach($data->sectionOne->partB as $item)
                                                                <li>{{$item->Objective}}</li>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionOne->partB as $item)
                                                                <li>{{$item->status}}</li>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionOne->partB as $item)
                                                                <li>{{$item->E_comments}}</li>
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionOne->partB as $item)
                                                                <li>{{$item->S_comments}}</li>
                                                                @endforeach
                                                            </td>

                                                            </td>
                                                            <td>{{$data->sectionTwo->sum('Employee_level')}}</td>
                                                            <td>{{$data->sectionTwo->sum('Supervisor_level')}}</td>
                                                            <td>{{$data->sectionTwo->count('Competence_id')*5}}</td>
                                                            <td>
                                                                @foreach($data->sectionThree as $item)
                                                                @if($item->topic == 'Skill')
                                                                <ul>
                                                                    <li>{{$item->training_required}}</li>
                                                                </ul>
                                                                @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionThree as $item)
                                                                @if($item->topic == 'Experience')
                                                                <ul>
                                                                    <li>{{$item->training_required}}</li>
                                                                </ul>
                                                                @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionThree as $item)
                                                                @if($item->topic == 'Knowledge')
                                                                <ul>
                                                                    <li>{{$item->training_required}}</li>
                                                                </ul>
                                                                @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($data->sectionThree as $item)
                                                                @if($item->topic == 'Other')
                                                                <ul>
                                                                    <li>{{$item->training_required}}</li>
                                                                </ul>
                                                                @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{!!$data->sectionFour->sup_works_well ?? ''!!}</td>
                                                            <td>{!!$data->sectionFour->sup_needs_improvement ?? ''!!}</td>
                                                            <td>{!!$data->sectionFour->org_works_well ?? ''!!}</td>
                                                            <td>{!!$data->sectionFour->org_needs_improvement ?? ''!!}</td>
                                                            <td>{!!$data->sectionSix->employee_comments ?? ''!!}</td>
                                                            <td>{!!$data->sectionSix->supervisor_comments ?? ''!!}</td>
                                                            <td>{!!$data->sectionSix->manager_comments ?? $data->sectionSix->supervisor_comments ?? ''!!}</td>
                                                            <td>{!!$data->sectionSix->hod_comments ?? ''!!}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

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
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
</x-app-layout>