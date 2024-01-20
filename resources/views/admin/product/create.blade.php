@extends('admin.layouts.master')

@section('content')
     <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Product</h1>

          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Product</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{route('admin.slider.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Category</label>
                                    <select id="inputState" class="form-control main-category" name="status" value="{{old('status')}}">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Sub Category</label>
                                    <select id="inputState" class="form-control sub-category" name="status" value="{{old('status')}}">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="inputState">Child Category</label>
                                    <select id="inputState" class="form-control" name="status" value="{{old('status')}}">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status" value="{{old('status')}}">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submmit" class="btn btn-primary">Create</button>
                    </form>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
           $('body').on('change', '.main-category', function(e){
                //alert('hello'); ****Nos ayuda a hacer pruebas
                let id = $(this).val();
                //console.log(id); ****Para revisar en Cosola si está agarrando el id de categoría; si está funcionando el código
                $.ajax({
                  method: 'GET',
                  url: "{{route('admin.product.get-subcategories')}}",
                  data: {
                    id:id
                  },
                  success: function(data){
                    //   console.log(data);
                      $('.sub-category').html('<option value="">Select</option>')

                      $.each(data, function(i, item){
                            //console.log(item.name);
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                  },
                  error: function(xhr, status, error){
                        console.log(error);
                  }
                })
              })
        })
    </script>
@endpush
