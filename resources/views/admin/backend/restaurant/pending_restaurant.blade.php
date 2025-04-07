@extends('admin.dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pendding Restaurant</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('partner.dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pending Restaurant</li>
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
                                <th>Email </th>
                                <th>Phone</th>
                                <th>Status</th>

                            
                            </tr>
                            </thead>


                            <tbody>
                                @foreach ($partner as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td> <img  src="{{ !empty( $item->image_cover)
                                        ? url('image/partner_image/' .  $item->image_cover)
                                        : url('image/no_image.jpg') }}" style="width: 70px; height=70px;" alt="gurdeep singh osahan"></td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    
                               
                                      
                                    <td>
                                        <input type="checkbox" data-id="{{$item->id}}" class="toggle-class" data-onstyle="success"
                                            data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive"
                                             {{$item->status ? 'checked' : ''}}>
                                        
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
              url: '/changeRestaurantStatus',
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