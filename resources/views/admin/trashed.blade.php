@extends('layout.admin-layout')

@section('workspace')
<h1 class="mb-4">Users</h1>
{{-- {{ dd($tusers); }} --}}
<!-- Button trigger modal -->

  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Restore</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
        @if(count($tusers)>0)
            @foreach($tusers as $tuser)
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $tuser->name }}</td>
        <td>{{ $tuser->email }}</td>
        <td><button type="button" data-id="{{ $tuser->id }}" class="btn btn-success restoreButton" data-toggle="modal" data-target="#restoreUserModal">Restore</button></td>
        <td><button type="button" data-id="{{ $tuser->id }}" class="btn btn-danger deleteButton" data-toggle="modal" data-target="#delUserModal">Delete</button></td>
      </tr>
            @endforeach
        @else
        <tr>
            <td>Users not found!</td>
        </tr>
        @endif
    </tbody>
  </table>
   <!-- restore User Modal -->
   <div class="modal fade" id="restoreUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Restore User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="restoreUser">
            @csrf
        <div class="modal-body">
                <p>Do you want to restore user?</p>
                  <input type="hidden" id="restore_id" name="id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="restoreUserBtn">Restore</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  <!-- delete User Modal -->
  <div class="modal fade" id="delUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Delete User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="delUser">
            @csrf
        <div class="modal-body">
                <p>Are you sure to delete this user!!!</p>
                  <input type="hidden" id="user_id" name="id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" id="deleteUserBtn">Delete</button>
        </div>
    </form>
      </div>
    </div>
  </div>

  @endsection
  @push('other-scripts')
  <script type="text/javascript">
    $(document).ready(function(){
        $(".restoreButton").click(function(){
            var id = $(this).attr('data-id');
            $("#restore_id").val(id);
        });

        $("#restoreUser").submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $("#restoreUserBtn").text("Restoring User...");
            $.ajax({
                url:"{{ route('restoreUser') }}",
                type:"GET",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });

        $(".deleteButton").click(function(){
            var id = $(this).attr('data-id');
            $("#user_id").val(id);
        });

        $("#delUser").submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $("#deleteUserBtn").text("Deleting User...");
            $.ajax({
                url:"{{ route('deleteUser') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });

    });
  </script>
  @endpush

