@extends('partner.dashboard')
@section('partner')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Menu Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Menu Details</li>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Menu</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($menu_details as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td> <img  src="{{asset($item->image)  }}" style="width: 70px; height=70px;" alt="gurdeep singh osahan"></td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item['category']['category_name']}}</td>
                                    <td>{{$item['menu']['menu_name']}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>
                                        @if ($item->discount_price==NULL)
                                            <span class="badge bg-danger">No Discount</span>
                                        @else
                                            @php
                                                $amount= $item->price-$item->discount_price;
                                                $discount =($amount/$item->price)* 100;
                                            @endphp
                                             <span class="badge bg-danger">{{round($discount)}}</span>
                                        @endif
                                      
                                    <td>
                                        <input type="checkbox" data-id="{{$item->id}}" class="toggle-class" data-onstyle="success"
                                            data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive"
                                             {{$item->status ? 'checked' : ''}}>
                                        
                                    </td>
                                    <td><a href="{{route('partner.edit.menu_detials',$item->id)}}" class="btn btn-info waves-effect waves-light">
                                        <i class="fas fa-edit"></i> </a> 
                                        <a id="delete" href="{{route('partner.delete.menu_detials',$item->id)}}" class="btn btn-danger waves-effect waves-light">
                                            <i class="fas fa-trash"></i></a>
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
<script type="text/javascript">
    $(function() {
      $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0; 
          var detials_id = $(this).data('id'); 
           
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/changeStatus',
              data: {'status': status, 'detials_id': detials_id},
              success: function(data){
                // console.log(data.success)
  
                  // Start Message 
  
              const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success', 
                    showConfirmButton: false,
                    timer: 3000 
              })
              if ($.isEmptyObject(data.error)) {
                      
                      Toast.fire({
                      type: 'success',
                      title: data.success, 
                      })
  
              }else{
                 
             Toast.fire({
                      type: 'error',
                      title: data.error, 
                      })
                  }
  
                // End Message   
  
  
              }
          });
      })
    })
  </script>
@endsection