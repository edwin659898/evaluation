<x-app-layout>

    <div class="content">
        <div class="container">

            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="font-bold text-green-500 card-title">Manager Review</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-green-700 font-bold">
                                        <td>Date Submitted</td>
                                        <td>Employee</td>
                                        <td>Supervisor</td>
                                        <td>Status</td>
                                        <td>Review Period</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $extra_info)
                                    <tr>
                                        <td>{{$extra_info->created_at->format('d-m-Y')}}</td>
                                        <td>{{$extra_info->user->name}}</td>
                                        <td>{{$extra_info->supervisor->name}}</td>
                                        <td>{{$extra_info->status}}</td>
                                        <td>{{$extra_info->review_period}}</td>
                                        <td><a href="{{route('manager.view',$extra_info->id)}}"><i class="fas fa-eye text-green-600 hover:text-green-800"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</x-app-layout>