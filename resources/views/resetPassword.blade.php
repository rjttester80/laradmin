@include('user.header')

<div class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
          <div class="bg-white p-4 p-md-5 rounded shadow-sm">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Reset Password</h3>
                </div>
              </div>
            </div>
            @if($errors->any())
                @foreach($errors->all() as $error )
                    <p style="color: red;">{{ $error }}</p>
                @endforeach
            @endif
            <form action="{{ route('resetPassword') }}" method="post">
                @csrf
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <input type="hidden" class="form-control" name="id" value="{{ $user->id }}">
                <div class="col-12">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                    @if ($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
                  </div>
                  <div class="col-12">
                    <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                    @if ($errors->has('confirm_password'))<span class="text-danger">{{ $errors->first('confirm_password') }}</span>@endif
                  </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary" type="submit">Reset Password</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
                <div class="col-12">
                  <hr class="mt-5 mb-4 border-secondary-subtle">
                  <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                      <a href="{{ route('login') }}" class="link-secondary text-decoration-none">Login</a>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
                </div>
            </div>
        </header>

@include('user.footer')

