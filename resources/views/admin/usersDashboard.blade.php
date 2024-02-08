@extends('layout.admin-layout')

@section('workspace')
    <h1 class="mb-4">Users</h1>
   @if(Session::has('success'))
    <p style="color: green">
        {{ Session::get('success') }}
    </p>
    @endif
    @if(Session::has('error'))
    <p style="color: red">
        {{ Session::get('error') }}
    </p>
    @endif
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#addUserModal">
        Add User
    </button>
    {{-- <a href="{{ route('trashed') }}" type="button" class="btn btn-warning mb-1 float-right">
        Trashed
    </a> --}}

    <nav class="navbar navbar-light bg-dark">
        <div class="container-fluid">
            <div class="navbar-brand">
                <input type="month" id="month_filter" class="form-control" placeholder="Select month">
            </div>
            <form class="d-flex">
                <input class="form-control me-2" name="search" id="search" type="search" placeholder="Search"
                    aria-label="Search">
            </form>
        </div>
    </nav>
    <div class="alert alert-success" role="alert" id="notify">
        This is a success alert—check it out!
      </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Image</th>
                <th scope="col">Created At</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody id="tbody">
            @if (count($users) > 0)
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $user->image) }}" width="50"
                                class="img-thumbnail rounded-circle">
                        </td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            <button type="button" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}" data-image="{{ asset('storage/' . $user->image) }}"
                                class="btn btn-info editButton" data-toggle="modal"
                                data-target="#editUserModal">Edit</button>
                            <button type="button" data-id="{{ $user->id }}" class="btn btn-warning trashButton"
                                data-toggle="modal" data-target="#trashUserModal">Delete</button>
                            <input type="checkbox" data-id="{{ $user->id }}" class="toggle-class"
                             data-style="slow" data-toggle="toggle" data-on="Enabled" data-off="Disabled" {{ $user->status == true ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td><strong>Users not found!</strong></td>
                </tr>
            @endif

        </tbody>
    </table>
    <div class="float-right">{{ $users->links('pagination::bootstrap-4') }}</div>
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="addUser" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="name" id="username"
                                    placeholder="Enter user name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="email" class="w-100" name="email" id="useremail"
                                    placeholder="Enter user email" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="file" class="w-100" name="image" id="userimg" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"  id="addUserBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit User Modal -->
    <div class="modal fade" id="editUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUser" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" id="id" name="id">
                                <input type="text" class="w-100" name="name" id="name"
                                    placeholder="Enter user name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="email" class="w-100" name="email" id="email"
                                    placeholder="Enter user email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="password" class="w-100 mt-2" id="new_password" name="new_password"
                                    placeholder="Enter New Password">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <img src="" alt="" style="width: 50px;" id="user_edit_image">
                            </div>
                            <div class="col">
                                <input type="file" class="w-100" name="image" id="img" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning updateButton" id="updateUserBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- trash User Modal -->
    <div class="modal fade" id="trashUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Trash User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="trashUser">
                    @csrf
                    <div class="modal-body">
                        <p>You can restore user back!</p>
                        <input type="hidden" id="user_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="trashUserBtn">Trash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('other-scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('.toggle-class').on('change', function(){
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');
                $.ajax({
                    url: "{{ route('changeStatus') }}",
                    type: "GET",
                    dataType: 'JSON',
                    data: {
                        'status': status,
                        'user_id': user_id
                    },
                    success:function(data) {
                        $('#notify').fadeIn();
                        $('#notify').text('Status Updated Successfully!');
                        setTimeout(()=>{
                            $('#notify').fadeOut();
                        },3000);
                    }
                });
            })

            $(function() {
                $('#toggle-two').bootstrapToggle({
                on: 'Enabled',
                off: 'Disabled'
                });
            })

            $("#addUser").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $('#addUserBtn').text('Adding User...');
                $.ajax({
                    url: "{{ route('addUser') }}",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            //$('#notify').text('User Added Successfully!');
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $("#search").on('keyup', function() {

                var value = $(this).val();
                $.ajax({
                    url: "{{ route('usersDashboard') }}",
                    type: "GET",
                    data: {
                        'search': value
                    },
                    success: function(data) {
                        setTimeout(function() { $('input[type="checkbox"]').bootstrapToggle('toggle'); }, 100);
                        var users = data.users;
                        $("#tbody").html('');

                        if(users.length){
                            $.each(data.users, function(index, user){

                                $("#tbody").append(`
                                <tr>
                                    <th scope="row">${index}</th>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <img src="{{ asset('storage') }}/${user.image}" width="50"
                                            class="img-thumbnail rounded-circle">
                                    </td>
                                    <td>${user.created_at}</td>
                                    <td>
                                        <button type="button" data-id="${user.id}" data-name="${user.name}"
                                            data-email="${user.email}" data-image="{{ asset('storage') }}/${user.image}"
                                            class="btn btn-info editButton" data-toggle="modal"
                                            data-target="#editUserModal">Edit</button>
                                    </td>
                                    <td>
                                        <button type="button" data-id="${user.id}" class="btn btn-warning trashButton"
                                            data-toggle="modal" data-target="#trashUserModal">Trash</button>
                                    </td>
                                    <td>
                                        <input type="checkbox" data-id="${user.id}" class="toggle-class"
                                        data-style="slow" data-toggle="toggle" data-on="Enabled" data-off="Disabled" ${user.status == true ? 'checked' : ''}>
                                    </td>
                                </tr>
                                `);
                            });
                    } else {
                            $("#tbody").append(`
                            <tr>
                                <td><strong>Users not found!</strong></td>
                            </tr>
                            `);
                        }
                    }
                });
            });



            $(".editButton").click(function() {
                //console.log('user edited');
                var userID = $(this).attr('data-id');
                var userName = $(this).attr('data-name');
                var userEmail = $(this).attr('data-email');
                var userImage = $(this).attr('data-image');
                $("#id").val(userID);
                $("#name").val(userName);
                $("#email").val(userEmail);
                $("#user_edit_image").attr('src', userImage);

            });

            $("#editUser").submit(function(e) {
                e.preventDefault();
                $('.updateButton').prop('disabled', true);
                const fd = new FormData(this);
                $('#updateUserBtn').text('Updating User...');
                $.ajax({
                    url: "{{ route('editUser') }}",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $(".trashButton").click(function() {
                var id = $(this).attr('data-id');
                $("#user_id").val(id);
            });

            $("#trashUser").submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $('#trashUserBtn').text('Trashing User...');
                $.ajax({
                    url: "{{ route('trashUser') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });


    $('#month_filter').change(function() {
     var month = $(this).val();

            $.ajax({
                    url: '{{ route("monthData") }}?month='+month,
                    type: "GET",
                    success: function(data) {
                        setTimeout(function() { $('input[type="checkbox"]').bootstrapToggle('toggle'); }, 100);
                        var users = data.users;
                        $("#tbody").html('');
                        if(users.length){
                            $.each(data.users, function(index, user){

                                $("#tbody").append(`
                                <tr>
                                    <th scope="row">${index}</th>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <img src="{{ asset('storage') }}/${user.image}" width="50"
                                            class="img-thumbnail rounded-circle">
                                    </td>
                                    <td>${user.created_at}</td>
                                    <td>
                                        <button type="button" data-id="${user.id}" data-name="${user.name}"
                                            data-email="${user.email}" data-image="{{ asset('storage') }}/${user.image}"
                                            class="btn btn-info editButton" data-toggle="modal"
                                            data-target="#editUserModal">Edit</button>
                                    </td>
                                    <td>
                                        <button type="button" data-id="${user.id}" class="btn btn-warning trashButton"
                                            data-toggle="modal" data-target="#trashUserModal">Trash</button>
                                    </td>
                                    <td>
                                        <input type="checkbox" data-id="${user.id}" class="toggle-class"
                                        data-style="slow" data-toggle="toggle" data-on="Enabled" data-off="Disabled" ${user.status == true ? 'checked' : ''}>
                                    </td>
                                </tr>
                                `);
                            });
                    } else {
                            $("#tbody").append(`
                            <tr>
                                <td><strong>Users not found!</strong></td>
                            </tr>
                            `);
                        }
                    }
                });
     });


        });
    </script>
@endpush
