@extends('admin.dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">All City</h4>

                        <div class="page-title-right">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#addCity">Add New City</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>City Name</th>
                                        <th>City Slug</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($city as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->city_name }}</td>
                                            <td> {{ $item->city_slug }}</td>
                                            <td><a href="{{ route('admin.edit.category', $item->id) }}"
                                                    class="btn btn-info waves-effect waves-light">Edit</a>
                                                <a id="delete" href="{{ route('admin.delete.category', $item->id) }}"
                                                    class="btn btn-danger waves-effect waves-light">Delete</a>
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
    <!-- sample modal content -->
    <div id="addCity" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form  action="{{ route('admin.city.add.submit') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class=" form-group mb-3">
                                        <label for="example-text-input" class="form-label">City Name</label>
                                        <input class="form-control" type="text" id="city_name" name="city_name"
                                            aria-describedby="unique-id-here">

                                    </div>

                                </div>
                            </div>

                        </div>
                  

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add New City</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
