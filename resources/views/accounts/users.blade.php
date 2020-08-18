@extends('layouts.admin')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">

        $(function () {



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

          });



          var table = $('.data-table').DataTable({

              processing: true,

              serverSide: true,

              ajax: "{{ route('ajaxproducts.index') }}",

              columns: [

                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                  {data: 'name', name: 'name'},

                  {data: 'email', name: 'email'},

                  {data: 'password', name: 'password'},

                  {data: 'action', name: 'action', orderable: false, searchable: false},

              ]

          });



          $('#createNewProduct').click(function () {

              $('#saveBtn').val("create-product");

              $('#product_id').val('');

              $('#productForm').trigger("reset");

              $('#modelHeading').html("Create New User");

              $('#ajaxModel').modal('show');

          });



          $('body').on('click', '.editProduct', function () {

            var product_id = $(this).data('id');

            $.get("{{ route('ajaxproducts.index') }}" +'/' + product_id +'/edit', function (data) {

                $('#modelHeading').html("Edit User");

                $('#saveBtn').val("edit-user");

                $('#ajaxModel').modal('show');

                $('#product_id').val(data.id);

                $('#name').val(data.name);

                $('#detail').val(data.email);

            })

         });



          $('#saveBtn').click(function (e) {

              e.preventDefault();

              $(this).html('Sending..');



              $.ajax({

                data: $('#productForm').serialize(),

                url: "{{ route('ajaxproducts.store') }}",

                type: "POST",

                dataType: 'json',

                success: function (data) {



                    $('#productForm').trigger("reset");

                    $('#ajaxModel').modal('hide');

                    table.draw();



                },

                error: function (data) {

                    console.log('Error:', data);

                    $('#saveBtn').html('Save Changes');

                }

            });

          });



          $('body').on('click', '.deleteProduct', function () {



              var product_id = $(this).data("id");

              confirm("Are You sure want to delete this user?");



              $.ajax({

                  type: "DELETE",

                  url: "{{ route('ajaxproducts.store') }}"+'/'+product_id,

                  success: function (data) {

                      table.draw();

                  },

                  error: function (data) {

                      console.log('Error:', data);

                  }

              });

          });



        });

      </script>
@endsection


@section('content')
<div class="container">
    <h2 class="pt-3">Danh sách tài khoản</h2>
<br>
<a class="btn btn-success mb-3" href="javascript:void(0)" id="createNewProduct"> Create New User</a>

    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Name</th>

                <th>Email</th>

                <th>Password</th>

                <th width="">Action</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="modelHeading"></h4>

            </div>

            <div class="modal-body">

                <form id="productForm" name="productForm" class="form-horizontal">

                   <input type="hidden" name="product_id" id="product_id">

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Name</label>

                        <div class="col-sm-12">

                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-12">

                            <input id="email" name="email" required="" placeholder="Enter Email" class="form-control">

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="password" class="col-sm-2 control-label">Password</label>

                        <div class="col-sm-12">

                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Name" value="" maxlength="50" required="">

                        </div>

                    </div>


                    <div class="col-sm-offset-2 col-sm-10">

                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes

                     </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection
