@extends('partner.dashboard')
@section('partner')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Add Menu Details</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                <li class="breadcrumb-item active">Add Menu Details</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12 col-lg-12">

                    <!-- end card -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Partner Add Menu Details</h4>

                        </div>
                        <div class="card-body p-4">
                            <form id="myForm" action="{{ route('partner.menu.detials.add.submit') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Category</label>

                                            <select class="form-select" name="category_id" id="category_id">
                                                <option selected="" disabled="">Select</option>
                                                @foreach ($category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Menu</label>

                                            <select class="form-select" name="menu_id">
                                                <option selected="" disabled="">Select</option>
                                                @foreach ($menu as $item)
                                                    <option value="{{ $item->id }}">{{ $item->menu_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">City</label>

                                            <select class="form-select" name="city_id">
                                                <option selected="" disabled="">Select</option>
                                                @foreach ($city as $item)
                                                    <option value="{{ $item->id }}">{{ $item->city_name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Name</label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Price</label>
                                            <input class="form-control" type="text" id="price" name="price"
                                                aria-describedby="unique-id-here">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">discount_price</label>
                                            <input class="form-control" type="text" id="discount_price"
                                                name="discount_price" aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">QTY</label>
                                            <input class="form-control" type="text" id="qty" name="qty"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Size</label>
                                            <input class="form-control" type="text" id="size" name="size"
                                                aria-describedby="unique-id-here">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class=" form-group mb-3">
                                            <label for="example-text-input" class="form-label">Image</label>
                                            <input class="form-control" type="file" name="image" id="image">

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class=" form-group mb-3">
                                            <div class="avatar-xl me-3">
                                                <img src="{{ url('image/no_image.jpg') }}" alt="" width="110"
                                                    class="rounded-circle p-1 bg-primary" id="showImage">
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-lg-4 col-md-6">
                                        <div class="mt-3 mt-lg-3 ">
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" name="most_populer" id="formCheck2"
                                                value="1">
                                                <label class="form-check-label" for="formCheck2">
                                                    Most Populer
                                                </label>
                                            </div>
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" name="best_seller" id="formCheck2"
                                                    value="1">
                                                <label class="form-check-label" for="formCheck2">
                                                    Best Seller
                                                </label>
                                            </div>

                                            <div class="mt-4 pt-3">

                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Submit New
                                                    Menu Detials</button>
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
        });
    </script>
     <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    menu_id: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    qty: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter Name',
                    },
                    image: {
                        required: 'Please Select Image',
                    },
                    category_id: {
                        required: 'Please Select Category',
                    },
                    menu_id: {
                        required: 'Please Select Menu',
                    },
                    city_id: {
                        required: 'Please Select City',
                    },
                    price: {
                        required: 'Please Add Price',
                    },
                    qty: {
                        required: 'Please Select QTY',
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
