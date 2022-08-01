@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



    <div class="content-wrapper">
        <div class="container-full">
            <section class="content">
                <div class="row">

                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header">
                                <h4 class="box-title">Student <strong>Role Generator</strong></h4>
                            </div>

                            <div class="box-body">
                                <form method="POST" action="{{route('roll.generate.store')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Year</h5>
                                                <div class="controls">
                                                    <select name="year_id" id="year_id" required
                                                            class="form-control">
                                                        <option value="" selected=""  disabled>Select Year
                                                        </option>
                                                        @foreach($years as $year)
                                                            <option
                                                                value="{{$year->id}}">
                                                                {{$year->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Selected Class </h5>
                                                <div class="controls">
                                                    <select name="class_id" id="class_id"
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Class
                                                        </option>
                                                        @foreach($classes as $class)
                                                            <option
                                                                value="{{$class->id}}" >
                                                                {{$class->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4" style="padding-top: 25px">
                                            <a id="search" class="btn btn-primary" name="search">Search</a>
                                        </div>


                                    </div>


                                    {{--   Role   Generate  Table                             --}}

                                    <div class="row d-none" id="roll-generate">
                                        <div class="col-md-12">
                                            <table class="table table-bordered table-striped" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID No.</th>
                                                    <th>Student Name</th>
                                                    <th>Student Father Name</th>
                                                    <th>Gender</th>
                                                    <th>Role</th>
                                                </tr>
                                                </thead>
                                                <tbody id="roll-generate-tr">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input type="submit" value="Role Generator" class="btn btn-info">

                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->

        </div>
    </div>


    <script type="text/javascript">
        $(document).on('click', '#search', function () {
            var year_id = $('#year_id').val();
            var class_id = $('#class_id').val();
            $.ajax({
                url: "{{ route('student.registration.getstudents')}}",
                type: "GET",
                data: {'year_id': year_id, 'class_id': class_id},
                success: function (data) {
                    $('#roll-generate').removeClass('d-none');
                    var html = '';
                    $.each(data, function (key, v) {
                        html +=
                            '<tr>' +
                            '<td>' + v.student.id_no + '<input type="hidden" name="student_id[]" value="' + v.student_id + '"></td>' +
                            '<td>' + v.student.name + '</td>' +
                            '<td>' + v.student.fname + '</td>' +
                            '<td>' + v.student.gender + '</td>' +
                            '<td><input type="text" class="form-control form-control-sm" name="roll[]" value="' + v.role + '"></td>' +
                            '</tr>';
                    });
                    html = $('#roll-generate-tr').html(html);
                }
            });
        });

    </script>

@endsection
