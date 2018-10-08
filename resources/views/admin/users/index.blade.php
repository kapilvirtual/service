@extends('layouts.admin.app')

@section('content')
    
    <h3 class="page-title">Users</h3>
    <p>
        <button type="button" class="btn btn-success" id="add-new-permission">Add New</button> <!-- data-toggle="modal" data-target="#myModal" -->
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
           List
        </div>
<div class="panel-body table-responsive">
        <table id="UserList"  class="display table table-bordered table-striped" >
        <thead>
          <tr>
            <th><input type="checkbox" name="select_all" value="1" id="select-all-permission"></th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>                                         
        </tbody>
    </table>
</div>
    </div>

    <div class="modal fade" id="AddUserForm" tabindex="-1" role="dialog" 
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
                    Add User
                </h4>
            </div>
                       
            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="editForm" value=""/>
                <form role="form" method="POST" action="#">
                    <div class="form-group">
                        <label for="AddFirstNameFor">First Name</label>
                        <input type="text" class="form-control" id="AddFirstNameFor" name="first_name" placeholder="Enter first name"/>
                    </div>
                    <div class="form-group">
                        <label for="AddMiddleNameFor">Middle Name</label>
                        <input type="text" class="form-control" id="AddMiddleNameFor" name="middle_name" placeholder="Enter middle name"/>
                    </div>
                    <div class="form-group">
                        <label for="AddLastNameFor">Last Name</label>
                        <input type="text" class="form-control" id="AddLastNameFor" name="last_name" placeholder="Enter last name"/>
                    </div>
                    <div class="form-group">
                        <label for="AddEmailFor">Email</label>
                        <input type="email" class="form-control" id="AddEmailFor" name="email" placeholder="Enter permission name"/>
                    </div>                 
                    <div class="form-group">
                        <label for="AddUserRolesFor">User Roles</label>
                        <select class="user-selection form-control" name="roles[]" multiple="multiple" id="userroles"></select>
                    </div>
                    <button type="button" id="userButton" class="btn btn-default addUserButton">Submit</button>
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

        var objUserAjaxTable = $('#UserList').DataTable({
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
                            return '<input type="checkbox" name="delete[]"  value="' 
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
                        "url": "{{route('admin.user-list')}}",
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
            $(':checkbox:checked').each(function(i){
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
                        objUserAjaxTable.draw();
                        swal("Your requested has been completed successfully!", {
                         icon: "success",
                        });
                    },
                    error: function (data)
                    {
                        swal("Error", "There is some problem to complete your request.", "error");
                    }
                });
              } else {
                 //objUserAjaxTable.draw();
                 //swal("Cancelled", "Your imaginary file is safe :)", "error");
              }
            });
    };



        /*$('.deletebtn').click(function(){
            var val = [];
            // $("input:checkbox[name=id]:checked").each(function (i) {
            // $("input[type='checkbox'][name='ProductCode']").each(function(){
            $(':checkbox:checked').each(function(i){
                val[i] = $(this).val();
            });
        });
        */

  
        // Handle click on "Select all" control
        $('#select-all-permission').on('click', function(){
            // Check/uncheck all checkboxes in the table
            var rows = objUserAjaxTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('body').on('click', '.listTodos', function(e) {   
                e.preventDefault();
                var todoId = $(this).attr('id'); 
              
        });

        $('body').on('click', '#add-new-permission', function(e) {
            e.preventDefault();
            $('#AddUserForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
            $('.savechanges').hide();
            //$("#PermissionAlert").alert('close');
        });


        $('.user-selection').select2({
            allowClear: false,
            minimumResultsForSearch: 10,
            tokenSeparators: [',', ' '],
            multiple: true,
            minimumInputLength: 1,
            ajax: {
                url: "{{ route('admin.get-roles') }}",
                dataType: "json",
                type: "GET",
                data: function (params) {
                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (value, index) {
                            return {
                                text: value,
                                id: index
                            }
                        })
                    };
                }
            }
        });

        function validateEmail(email) {
              var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }


        $('body').on('click', '.addUserButton', function(e) {
            e.preventDefault();
            var options = $('#userroles > option:selected');

            if($('#AddFirstNameFor').val() == ''){
                $('#AddFirstNameFor').focus();
                swal("Error!", "Please add first name.", "error");
            }
            else if($('#AddMiddleNameFor').val() == ''){
                $('#AddMiddleNameFor').focus();
                swal("Error!", "Please add middle name.", "error");
            }
            else if($('#AddLastNameFor').val() == ''){
                $('#AddLastNameFor').focus();
                swal("Error!", "Please add last name.", "error");
            }
            else if($('#AddEmailFor').val() == ''){

                $('#AddEmailFor').focus();
                swal("Error!", "Please enter email address.", "error");
            }
            else if( !validateEmail($('#AddEmailFor').val())) {
                $('#AddEmailFor').focus();
                swal("Error!", "Please enter a valid email address.", "error");       
            }
            else if(options.length == 0){
                $('#userroles').focus();
                swal("Error!", "Please select user roles", "error");
            }
            else{
                var varFirstName = $('#AddFirstNameFor').val();
                var varMiddleName = $('#AddMiddleNameFor').val();
                var varLastName = $('#AddLastNameFor').val();
                var varEmail = $('#AddEmailFor').val();
               
                var userRoles ={};
                
                $('#userroles option:selected').each(function() {
                    userRoles[$(this).val()] = $(this).text();
                });

                var formData = {
                    'name':  varFirstName,
                    'first_name':  varFirstName,
                    'middle_name':  varMiddleName,
                    'last_name':  varLastName,
                    'email':  varEmail,
                    'status':  'inactive',
                    'user_roles':  userRoles,
                };

                 $.ajax({
                    url: "{{ route('admin.add-user') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        objUserAjaxTable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddUserForm').modal('hide');
                    },
                    error: function (data)
                    {   
                        var obj = jQuery.parseJSON(data.responseText);
                        var errorString = '';
                        $.each(obj.errors, function(key,value) {
                           errorString += value;
                        }); 

                        if(errorString != ''){
                            swal("Error",errorString , "error");
                        }                       
                    }
                });
            }
        });

                   
        function isInArray(value, array) {
            return array.indexOf(value) > -1;
        }      

        $('body').on('click', '.per-edit', function(e) {
            e.preventDefault();
            $('#AddUserForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });  

            
            $('#userButton').removeClass('addUserButton').addClass('editUserButton');
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
                        objUserAjaxTable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddUserForm').modal('hide');
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


        $('#AddUserForm').on('shown.bs.modal', function (e) {
            
        });

        /*
            Function for setup values while close or hide the pop up action
        */
        $('#AddUserForm').on('hidden.bs.modal', function (e) {
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




        //objUserAjaxTable.draw();

});
//               
       // window.route_mass_crud_entries_destroy = '';
    </script>
@endsection