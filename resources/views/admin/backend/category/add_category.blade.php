@extends('admin.dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Category</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                <li class="breadcrumb-item active">Add Category</li>
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
                            <h4 class="card-title">Admin Add Category</h4>

                        </div>
                        <div class="card-body p-4">
                            <form id="myForm" action="{{ route('admin.category.add.submit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class=" form-group mb-3">
                                                <label for="example-text-input" class="form-label">Category Name</label>
                                                <input class="form-control" type="text" id="category_name"
                                                    name="category_name" aria-describedby="unique-id-here">

                                            </div>
                                            <div class=" form-group mb-3">
                                                <label for="example-text-input" class="form-label">Image</label>
                                                <input class="form-control" type="file" name="image" id="image">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-3 mt-lg-3 ">

                                            <div class="avatar-xl me-3">
                                                <img src="{{ url('image/no_image.jpg') }}" alt="" width="110"
                                                    class="rounded-circle p-1 bg-primary" id="showImage">
                                            </div>
                                            <div class="mt-4 pt-3">

                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Submit New
                                                    Category</button>
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
@endsection