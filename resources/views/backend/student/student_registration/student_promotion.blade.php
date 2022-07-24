@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>





    <div class="content-wrapper">
        <div class="container-full">

            <section class="content">

                <!-- Basic Forms -->
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Edit Student </h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col">
                                <form method="post" action="{{route('promotion.student.registration',$editData->student_id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$editData->id}}">
                                    {{--first row--}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Student Name <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="name"
                                                           class="form-control" value="{{$editData['student']['name']}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Father`s Name <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="fname"
                                                           value="{{$editData['student']['fname']}}"      class="form-control" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Mother`s Name <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="mname"
                                                           value="{{$editData['student']['mname']}}"    class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{--second row--}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Mobile Number <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="mobile"
                                                           value="{{$editData['student']['mobile']}}"        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="address" value="{{$editData['student']['address']}}"
                                                           class="form-control" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Select Gender <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="gender" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Gender
                                                        </option>
                                                        <option
                                                            value="Male" {{($editData['student']['gender'] == 'Male')?"selected":''}}>
                                                            Male
                                                        </option>
                                                        <option
                                                            value="Female" {{($editData['student']['gender'] == 'Female')?"selected":''}}>
                                                            Female
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    {{--row three--}}

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Select Religion <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="religion" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Religion
                                                        </option>
                                                        <option
                                                            value="Islam" {{($editData['student']['religion'] == 'Islam')?"selected":''}}>
                                                            Islam
                                                        </option>
                                                        <option
                                                            value="Hindo" {{($editData['student']['religion'] == 'Hindo')?"selected":''}}>
                                                            Hindo
                                                        </option>
                                                        <option
                                                            value="Christian" {{($editData['student']['religion'] == 'Christian')?"selected":''}}>
                                                            Christian
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Date of Birth <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="date" name="dob"  value="{{$editData['student']['dob']}}"
                                                           class="form-control" required >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Discount <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <input type="text" name="discount"
                                                           class="form-control" required  value="{{$editData['discount']['discount']}}">
                                                </div>
                                            </div>
                                        </div>



                                    </div>


                                    {{--4rth row--}}
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Year<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="year_id" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Year
                                                        </option>
                                                        @foreach($years as $year)
                                                            <option
                                                                value="{{$year->id}}" {{($editData->year_id == $year->id)?"selected":""}}>
                                                                {{$year->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Selected Class <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="class_id" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Class
                                                        </option>
                                                        @foreach($classes as $class)
                                                            <option
                                                                value="{{$class->id}}" {{($editData->class_id == $class->id)?"selected":""}}>
                                                                {{$class->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Select Group <span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="group_id" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Group
                                                        </option>
                                                        @foreach($groups as $group)
                                                            <option
                                                                value="{{$group->id}}" {{($editData->group_id == $group->id)?"selected":""}}>
                                                                {{$group->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                    </div>



                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>Shift<span class="text-danger">*</span></h5>
                                                <div class="controls">
                                                    <select name="shift_id" id="select" required
                                                            class="form-control">
                                                        <option value="" selected="" disabled>Select Shift
                                                        </option>
                                                        @foreach($shifts as $shift)
                                                            <option
                                                                value="{{$shift->id}}" {{($editData->shift_id == $shift->id)?"selected":""}}>
                                                                {{$shift->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h5>User Image </h5>
                                                <div class="controls">
                                                    <input type="file" name="image" class="form-control" id="image"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <img style="width: 100px;width: 100px;border: 1px solid #000000" id="showImage" src="{{(!empty($editData['student']['image']))?url('upload/student_images/'.$editData['student']['image']) :url('upload/no_image.jpg')}}" alt="">
                                                </div>
                                            </div>
                                        </div>



                                    </div>



                                    <div class="text-xs-right">
                                        <input type="submit" class="btn btn-rounded btn-info mb-5" value="Promotion">
                                    </div>
                                </form>

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </section>

        </div>
    </div>


    <script>
        $(function (){
            $(document).ready(function (){
                $('#image').change(function (e){
                    var reader = new FileReader();
                    reader.onload = function (e){
                        $('#showImage').attr('src',e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            })
        })

    </script>

@endsection
