@extends('partner.dashboard')
@section('partner')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Menu</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Contacts</a></li>
                                <li class="breadcrumb-item active">Edit Menu</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-9 col-lg-8">

                    <!-- end card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Partner Edit Menu</h4>

                        </div>
                        <div class="card-body p-4">
                            <form id="myForm" action="{{ route('partner.menu.edit.submit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$menu->id}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class=" form-group mb-3">
                                                <label for="example-text-input" class="form-label">Menu Name</label>
                                                <input class="form-control" type="text" id="menu_name"
                                                    name="menu_name" value="{{$menu->menu_name}}" aria-describedby="unique-id-here">

                                            </div>
                                            <div class=" mb-3">
                                                <label for="example-text-input" class="form-label">Image</label>
                                                <input class="form-control" type="file"  name="image" id="image">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-3 mt-lg-3 ">

                                            <div class="avatar-xl me-3">
                                                <img src="{{asset($menu->image) }}" alt="" width="110"
                                                    class="rounded-circle p-1 bg-primary" id="showImage">
                                            </div>
                                            <div class="mt-4 pt-3">

                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Edit Menu</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- end tab content -->
                </div>
                <!-- end col -->


                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    menu_name: {
                        required: true,
                    },
                 

                },
                messages: {
                    menu_name: {
                        required: 'Please Enter Menu Name',
                    },
                

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
