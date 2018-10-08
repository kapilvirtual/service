@extends('layouts.admin.app')

@section('content')
    
    <h3 class="page-title">Permissions</h3>
    <p>
        <button type="button" class="btn btn-success" id="add-new-permission">Add New</button> <!-- data-toggle="modal" data-target="#myModal" -->
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
           Permission List
        </div>
<div class="panel-body table-responsive">
        <table id="all-permission"  class="display table table-bordered table-striped" >
        <thead>
          <tr>
           <th><input type="checkbox" name="select_all" value="1" id="select-all-permission"></th>
            <th>Permission Name</th>
            <th>Permission Access</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>                                         
        </tbody>
    </table>
</div>
    </div>

    <div class="modal fade" id="AddPermissionForm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Add Permission
                </h4>
            </div>
                       
            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="editForm" value=""/>
                <form role="form" method="POST" action="#">
                    <div class="form-group">
                        <label for="AddPermissionFor">Permission Name</label>
                        <input type="email" class="form-control" id="AddPermissionFor" name="permission_name" placeholder="Enter permission name"/>
                    </div>
                 
                    <div class="form-group">
                        <label for="AddPermissionFor">Permission Access</label>
                        <div class="checkbox"> 
                            <label><input class="check_list" id="check_add" name="permission[]" value="add" type="checkbox">Add</label>
                            <label><input class="check_list" id="check_edit" name="permission[]" value="edit" type="checkbox">Edit</label>
                            <label><input class="check_list" id="check_view" name="permission[]" value="view" type="checkbox">View</label>
                            <label><input class="check_list" id="check_delete" name="permission[]" value="delete" type="checkbox">Delete</label>
                        </div>
                    </div>
                    <button type="button" id="permissionButton" class="btn btn-default addPermissionButton">Submit</button>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary savechanges">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript') 
    <script>
        $(document).ready(function() { 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var permissionAjaxtable = $('#all-permission').DataTable({
            "dom": 'Bfrtip',
           // "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "buttons": [
               // { extend: 'copyHtml5', className: 'copyButton' },
               // { extend: 'excelHtml5', className: 'excelButton' },
                //{ extend: 'csvHtml5', className: 'csvButton' },
               // { extend: 'pdfHtml5', className: 'pdfButton' },
                { extend: 'colvis', className: 'colvisButton' },
                { extend: 'print', className: 'printButton' },
                {
                    text: 'Delete records',
                    className: 'deletebtn deletebtn-danger',
                }
        ],
            "columnDefs": [ 
                    {
                        'targets': 0, 
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center dt-head-center',
                        'render': function (data, type, full, meta){
                            return '<input type="checkbox" name="delete[]" class="checkPermission"  value="' 
                            + $('<div/>').text(data).html() + '">';
                        }
                    },
            ],  
            "processing": true,
            "serverSide": true,
            "searching": true,
            "oLanguage": {
               "sEmptyTable": "No records available."
            },
            "ajax": 
                    {
                        "url": "{{route('admin.permissionlist')}}",
                        "type": "GET",
                        "pages": 10
                    }
                }).on( 'search.dt', function (settings) {
            //setTimeout(function(){$('#tags-listing_processing').hide();}, 500);
        });
   

        $('body').on('click', '.pre-delete', function(e) {   
            e.preventDefault();
            var delId = $(this).attr('data-val');
            var perId = [];
            if(delId !=''){
                perId[0] = delId;
                ConfirmDialogDelete(perId);
            }

        });

        $('body').on('click', '.deletebtn', function(e) {   
            e.preventDefault();
            var perId = [];
            $('input.checkPermission:checkbox:checked').each(function(i){
                perId[i] = $(this).val();
            });
            if(perId.length > 0){
                ConfirmDialogDelete(perId);
            }
            else{
                swal("",'Please select permission to delete.','warning');
            }
        });


        function ConfirmDialogDelete(val){
            var formData = {
                'id':  val//for get email 
            };

            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this record!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                    url: "{{ route('admin.trash') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        permissionAjaxtable.draw();
                        swal("Your requested has been completed successfully!", {
                         icon: "success",
                        });
                    },
                    error: function (data)
                    {
                        swal("Error", "There is some problem to complete your request.", "error");
                    }
                });
              } 
            });
        };


  
        // Handle click on "Select all" control
        $('#select-all-permission').on('click', function(){
            var rows = permissionAjaxtable.rows({ 'search': 'applied' }).nodes();
            $('input.checkPermission[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('body').on('click', '.listTodos', function(e) {   
                e.preventDefault();
                var todoId = $(this).attr('id'); 
              
        });

        $('body').on('click', '#add-new-permission', function(e) {
            e.preventDefault();
            $('#AddPermissionForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
            $('.savechanges').hide();
            //$("#PermissionAlert").alert('close');
        });

        $('body').on('click', '.addPermissionButton', function(e) {
            e.preventDefault();
            if($('#AddPermissionFor').val() == ''){
                $('#AddPermissionFor').focus();
                swal("Error!", "Please Add permission name", "error");
            }
            else if($('input[name="permission[]"]:checked').length == ''){
                $('input[name="permission"]').focus();
                swal("Error!", "Please select permission access", "error");
            }
            else{

                var permission_name = $('#AddPermissionFor').val();
                var permissionAccess = [];
                $('input[name="permission[]"]:checked').each(function(i) {
                    permissionAccess[i] = $(this).val();
                });

                var formData = {
                 'name':  permission_name,
                    'permission_access':  permissionAccess,
                };
                 $.ajax({
                    url: "{{ route('admin.addpermission') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        permissionAjaxtable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddPermissionForm').modal('hide');
                    },
                    error: function (data)
                    {   
                        var json = JSON.parse(data.responseText);
                        swal("Error",json.errors.name[0] , "error");
                    }
                });
            }
        });

                   
        function isInArray(value, array) {
            return array.indexOf(value) > -1;
        }      

        $('body').on('click', '.per-edit', function(e) {
            e.preventDefault();
            $('#AddPermissionForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });  

            
            $('#permissionButton').removeClass('addPermissionButton').addClass('editPermissionButton');
            $('#myModalLabel').text('Update Permission');
            $('.savechanges').show();

            var editid = $(this).data('val');
            $('#editForm').val(editid);
            var define_url = "{{route('admin.get-permission-record', ['id' => '@perId' ])}}";
            $.ajax({
                url: define_url.replace("@perId", editid),
                type: 'GET',
                success: function(data) {
                    $('#AddPermissionFor').val(data.name);
                    var arrPermission = data.permission_access.split(",");
                    $.each( arrPermission, function( key, value ) {
                        $('body').find('#check_'+value).prop('checked', true);
                    });
                }
            });
        });

        /* 
            Function for upate permission while updating permission record
        */
        $('body').on('click', '.editPermissionButton, .savechanges', function(e) {
           e.preventDefault();

            if($('#AddPermissionFor').val() == ''){
                $('#AddPermissionFor').focus();
                swal("Error!", "Please Add permission name", "error");
            }
            else if($('input[name="permission[]"]:checked').length == ''){
                $('input[name="permission"]').focus();
                swal("Error!", "Please select permission access", "error");
            }
            else{
                var permission_name = $('#AddPermissionFor').val();
                var permissionAccess = [];
                $('input[name="permission[]"]:checked').each(function(i) {
                    permissionAccess[i] = $(this).val();
                });

                var editid = $('#editForm').val();
                var formData = {
                    'name':  permission_name,
                    'permission_access':  permissionAccess,
                    'updateID' : editid
                };

                $.ajax({
                    url: "{{ route('admin.update-permission') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        permissionAjaxtable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddPermissionForm').modal('hide');
                    },
                    error: function (data)
                    {   
                        var json = JSON.parse(data.responseText);
                        swal("Error",json.errors.name[0] , "error");
                    }
                });
            }

        });
        // End function for update permission


        $('#AddPermissionForm').on('shown.bs.modal', function (e) {
            
        });

        /*
            Function for setup values while close or hide the pop up action
        */
        $('#AddPermissionForm').on('hidden.bs.modal', function (e) {
            $('#permissionButton').removeClass('editPermissionButton').addClass('addPermissionButton');
            $('#editForm').val('');
            $('#myModalLabel').text('Add Permission');
            $('#AddPermissionFor').val('');
            var permission  = "add,edit,view,delete";
            var arrPermission = permission.split(",");
            $.each( arrPermission, function( key, value ) {
                $('#check_'+value).prop('checked', false);
            });

        });
        // End for close or hide pop up close event




        //permissionAjaxtable.draw();

});
//               
       // window.route_mass_crud_entries_destroy = '';
    </script>
@endsection