@extends('admin.layouts.master')

@section('content')
     <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Sub Category</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Sub Categories</h4>
                    <div class="card-header-action">
                        <a href="{{route('admin.sub-category.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
                    </div>
                  </div>
                  <div class="card-body">
                    {{ $dataTable->table() }}
                  </div>

                </div>
              </div>
            </div>

          </div>
        </section>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function(){
            $('body').on('click', '.change-status', function(){
                //alert('hello'); ****Éste alert es para probar que el código esté funcionando
                let isChecked = $(this).is(':checked');
                //console.log(isChecked); *****Muestra en pantalla el resultado
                let id = $(this).data('id');
                //console.log(id);  *****Muestra en pantalla el resultado
                $.ajax({
                    url: "{{route('admin.category.change-status')}}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data){
                      //console.log(data);
                      toastr.success(data.message)
                    },
                    error: function(xhr, status, error){
                      console.log(error);
                    }
                })
            })
        })
    </script>
@endpush