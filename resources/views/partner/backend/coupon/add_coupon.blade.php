@extends('partner.dashboard')
@section('partner')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Coupon</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                <li class="breadcrumb-item active">Add Coupon</li>
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
                            <h4 class="card-title">Add Coupon</h4>

                        </div>
                        <div class="card-body p-4">
                            <form id="mymenu" action="{{ route('coupon.add.submit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Coupon Name</label>
                                            <input class="form-control" type="text" id="coupon_name" name="coupon_name"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Coupon Desc</label>
                                            <input class="form-control" type="text" name="coupon_desc"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Coupon Discount</label>
                                            <input class="form-control" type="text" name="discount"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Coupon Validity</label>
                                            <input class="form-control" type="date" name="validity"
                                                aria-describedby="unique-id-here" min="{{ \Carbon\Carbon::now()->format('Y-m-d')}}">

                                        </div>
                                    </div>
                                    <div class="mt-4 pt-3">

                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit New
                                            Coupon</button>
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
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mymenu').validate({
                rules: {
                    coupon_name: {
                        required: true,
                    },


                },
                messages: {
                    coupon_name: {
                        required: 'Please Enter Category Name',
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
