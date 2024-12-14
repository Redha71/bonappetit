
      @include('frontend.user.header')
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

      <section class="section pt-4 pb-4 osahan-account-page">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                @include('frontend.user.sidebar')
               </div>
               @php
                   $id =Auth::user()->id;
                   $profile_data= App\Models\User::find($id);
               @endphp
               <div class="col-md-9">
                  <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                     <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                           <h4 class="font-weight-bold mt-0 mb-4">User Profile</h4>
                           <div class="bg-white card mb-4 order-list shadow-sm">
                              <div class="gold-members p-4">
                                <form action="{{route('user.profile.edit')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Name</label>
                                                    <input class="form-control" type="text" name="name"
                                                        value="{{ $profile_data->name }}">
                                                </div>
    
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                        value="{{ $profile_data->email }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Photo</label>
                                                    <input class="form-control" type="file" name="image" id="image">
                                                </div>
                                                <div class="mt-4">
    
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light">Edit</button>
                                                </div>
    
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6">
                                            <div class="mt-3 mt-lg-0">
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Phone</label>
                                                    <input class="form-control" type="text" name="phone"
                                                        value="{{ $profile_data->phone }}">
                                                </div>
    
                                                <div class="mb-3">
                                                    <label for="example-text-input" class="form-label">Address</label>
                                                    <input class="form-control" type="text" name="address"
                                                        value="{{ $profile_data->address }}">
                                                </div>
                                                <div class="avatar-xl me-3">
                                                    <img src="{{ !empty($profile_data->image)
                                                        ? url('image/user_image/' . $profile_data->image)
                                                        : url('image/no_image.jpg') }}"
                                                        alt="" width="110" class="rounded-circle p-1 bg-primary" id="showImage">
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </form>
                              </div>
                           </div>

                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  
      <script type="text/javascript">
       @if(Session::has('message'))
       var type = "{{ Session::get('alert-type','info') }}"
       switch(type){
          case 'info':
          toastr.info(" {{ Session::get('message') }} ");
          break;
      
          case 'success':
          toastr.success(" {{ Session::get('message') }} ");
          break;
      
          case 'warning':
          toastr.warning(" {{ Session::get('message') }} ");
          break;
      
          case 'error':
          toastr.error(" {{ Session::get('message') }} ");
          break; 
       }
       @endif 
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader= new FileReader();
                reader.onload =function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    
        </script>

   @include('frontend.user.footer')