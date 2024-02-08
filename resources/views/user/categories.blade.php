@extends('user.dashboard')

@section('workspace')
    <h1 class="mb-4">Categories</h1>
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
    <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#addCategoryModal">
        Add Category
    </button>

    <div class="alert alert-success" role="alert" id="notify">
    </div>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="tbody">
            @foreach($categories as $category)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                <button type="button" data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                    data-slug="{{ $category->slug }}" class="btn btn-info editButton" data-toggle="modal"
                    data-target="#editCategoryModal">Edit</button>
                <button type="button" data-id="{{ $category->id }}" class="btn btn-warning trashButton"
                    data-toggle="modal" data-target="#trashCategoryModal">Trash</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    <div class="float-right"></div>
    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="addCategory" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="catname" id="catname"
                                    placeholder="Enter category name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="text" class="w-100" name="catslug" id="catslug"
                                    placeholder="Enter category slug" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"  id="addCatBtn">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- edit User Modal -->
    <div class="modal fade" id="editCategoryModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCategory" action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" id="id" name="id">
                                <input type="text" class="w-100" name="catname" id="cname"
                                    placeholder="Enter Category name" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="text" class="w-100" name="catslug" id="cslug"
                                placeholder="Enter category slug" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning updateButton" id="updateCategoryBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- trash User Modal -->
    <div class="modal fade" id="trashCategoryModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Trash Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="trashCategory">
                    @csrf
                    <div class="modal-body">
                        <p>You can restore Category back!</p>
                        <input type="hidden" id="cat_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="trashCategoryBtn">Trash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('other-scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#addCategory").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $('#addCatBtn').text('Adding Category...');
                $.ajax({
                    url: "{{ route('addCategory') }}",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        //console.log(data);
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $(".editButton").click(function() {
                //console.log('user edited');
                var catID = $(this).attr('data-id');
                var catName = $(this).attr('data-name');
                var catSlug = $(this).attr('data-slug');
                $("#id").val(catID);
                $("#cname").val(catName);
                $("#cslug").val(catSlug);

            });

            $("#editCategory").submit(function(e) {
                e.preventDefault();
                $('.updateButton').prop('disabled', true);
                const fd = new FormData(this);
                $('#updateCategoryBtn').text('Updating Category...');
                $.ajax({
                    url: "{{ route('editCategory') }}",
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

        });
    </script>
@endpush
