@extends('partner.dashboard')
@section('partner')



<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Menu</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Menu</li>
                        </ol>
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
                                <th>Menu</th>
                                <th>Image</th>
                                <th>Action</th>
                            
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($menu as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->menu_name}}</td>
                                    <td> <img  src="{{asset($item->image)  }}" style="width: 70px; height=70px;" alt="gurdeep singh osahan"></td>
                                    <td><a href="{{route('admin.edit.category',$item->id)}}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a id="delete" href="{{route('admin.delete.category',$item->id)}}" class="btn btn-danger waves-effect waves-light">Delete</a>
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

@endsection