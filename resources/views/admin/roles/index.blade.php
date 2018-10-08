@extends('layouts.admin.app')

@section('content')
    
    <h3 class="page-title">Roles</h3>
    <p>
        <button type="button" class="btn btn-success" id="add-new-roles">Add New</button> <!-- data-toggle="modal" data-target="#myModal" -->
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
           Role List
        </div>
        <div class="panel-body table-responsive">
                <table id="all-roles"  class="display table table-bordered table-striped" >
                <thead>
                  <tr>
                   <th><input type="checkbox" name="select_all" value="1" id="select-all-roles"></th>
                    <th>Roles Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>                                         
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="AddRolesForm" tabindex="-1" role="dialog" 
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
                    Add Role
                </h4>
            </div>
                       
            <!-- Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="editForm" value=""/>
                <form role="form" method="POST" action="#">
                    <div class="form-group">
                        <label for="AddRolesFor">Role Name*</label>
                        <input type="text" class="form-control" id="AddRolesFor" name="permission_name" placeholder="Enter permission name"/>
                    </div>
                    <div class="form-group">
                        <label for="AddRolesPermissionFor">Permissions</label>
                        <select class="permission-selection form-control" name="permission[]" multiple="multiple" id="permissions"></select>
                    </div>
                    <button type="button" id="rolesButton" class="btn btn-default addRolesButton">Submit</button>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary savechanges">Save changes</button>
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

        var rolesAjaxtable = $('#all-roles').DataTable({
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
                            return '<input type="checkbox" name="delete[]" class="checkRoles"  value="' 
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
                    "url": "{{route('admin.role-list')}}",
                    "type": "GET",
                    "pages": 10
                }
            }).on( 'search.dt', function (settings) {
            //setTimeout(function(){$('#tags-listing_processing').hide();}, 500);
        });

        $('body').on('click', '.role-delete', function(e) {   
            e.preventDefault();
            var delId = $(this).attr('data-val');
            var perId = [];
            if(delId != ''){
                perId[0] = delId;
                ConfirmDialogDelete(perId);
            }

        });

        $('body').on('click', '.deletebtn', function(e) {   
            e.preventDefault();
            var perId = [];
            $('input.checkRoles:checkbox:checked').each(function(i){
                perId[i] = $(this).val();
            });
           console.log(perId);
            if(perId.length > 0){
                ConfirmDialogDelete(perId);
            }
            else{
                swal("",'Please select roles to delete.','warning');
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
                    url: "{{ route('admin.destory-role') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        rolesAjaxtable.draw();
                        swal("Your requested has been completed successfully!", {
                         icon: "success",
                        });
                    },
                    error: function (data)
                    { console.log(data);
                        swal("Error", "There is some problem to complete your request.", "error");
                    }
                });
              } 
            });
        };

        // Handle click on "Select all" control
        $('#select-all-roles').on('click', function(){
            var rows = rolesAjaxtable.rows({ 'search': 'applied' }).nodes();
            $('input.checkRoles[type="checkbox"]', rows).prop('checked', this.checked);
        });

        $('body').on('click', '#add-new-roles', function(e) {
            e.preventDefault();
            $('#AddRolesForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });
            
            $('.savechanges').hide();
            //$("#PermissionAlert").alert('close');
        });

        $('.permission-selection').select2({
            allowClear: false,
            minimumResultsForSearch: 10,
            tokenSeparators: [',', ' '],
            multiple: true,
            minimumInputLength: 1,
            ajax: {
                url: "{{ route('admin.get-permission') }}",
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


        $('body').on('click', '.addRolesButton', function(e) {
            e.preventDefault();

            var options = $('#permissions > option:selected');

            if($('#AddRolesFor').val() == ''){
                $('#AddRolesFor').focus();
                swal("Error!", "Please Add roles name", "error");
            }
            else if(options.length == 0){
                $('#permissions').focus();
                swal("Error!", "Please select permissions", "error");
            }
            else{
                var roles_name = $('#AddRolesFor').val();
                var permissionAccess ={};
                
                $('#permissions option:selected').each(function() {
                    permissionAccess[$(this).val()] = $(this).text();
                });

                var formData = {
                    'name':  roles_name,
                    'permission_access':  permissionAccess,
                };

                $.ajax({
                    url: "{{ route('admin.add-role') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        rolesAjaxtable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddRolesForm').modal('hide');
                    },
                    error: function (data){   
                        var json = JSON.parse(data.responseText);
                        swal("Error",json.errors.name[0] , "error");
                    }
                });
            }
        });

        $('body').on('click', '.per-edit', function(e) {
            e.preventDefault();
            $('#AddRolesForm').modal({
                backdrop: 'static',
                fadeDuration: 1000,
                fadeDelay: 0.50
            });  

            
            $('#rolesButton').removeClass('addRolesButton').addClass('editRolesButton');
            $('#myModalLabel').text('Update Roles');
            $('.savechanges').show();

            var editid = $(this).data('val');
            $('#editForm').val(editid);
            var arrPermission ={};
            var define_url = "{{route('admin.get-roles-record', ['id' => '@perId' ])}}";
            $.ajax({
                url: define_url.replace("@perId", editid),
                type: 'GET',
                success: function(data) {
                    $('#AddRolesFor').val(data.name);
                    $.each( data.permissions, function( key, value ) {
                        arrPermission[this.id] =  this.name;
                    });

                    $.each(arrPermission, function(val, text) { 
                        $('#permissions').append($("<option value='"+val+"' selected>"+text+"</option>"));
                        $('#permissions').trigger('change');
                    });
                }
            });
        });


        /* 
            Function for upate permission while updating permission record
        */
        $('body').on('click', '.editRolesButton, .savechanges', function(e) {
            e.preventDefault();
            
             var options = $('#permissions > option:selected');

            if($('#AddRolesFor').val() == ''){
                $('#AddRolesFor').focus();
                swal("Error!", "Please Add roles name", "error");
            }
            else if(options.length == 0){
                $('#permissions').focus();
                swal("Error!", "Please select permissions", "error");
            }
            else{
                var roles_name = $('#AddRolesFor').val();
                var permissionAccess ={};
                
                $('#permissions option:selected').each(function() {
                    permissionAccess[$(this).val()] = $(this).text();
                });

                var editid = $('#editForm').val();
                var formData = {
                    'name':  roles_name,
                    'permission_access':  permissionAccess,
                    'updateID' : editid
                };

                $.ajax({
                    url: "{{ route('admin.update-roles') }}",
                    type: 'POST',
                    dataType: "text",
                    data: formData,
                    success: function(data) { 
                        rolesAjaxtable.draw();
                        swal("Your request has been completed successfully!", {
                            icon: "success",
                        });

                        $('#AddRolesForm').modal('hide');
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

        $('#AddRolesForm').on('hidden.bs.modal', function (e) {
            $('#rolesButton').removeClass('editRolesButton').addClass('addRolesButton');
            $('#editForm').val('');
            $('#myModalLabel').text('Add Roles');
            $('#AddRolesFor').val('');
            $("#permissions").val(null).trigger("change");
        });
});
</script>
@endsection