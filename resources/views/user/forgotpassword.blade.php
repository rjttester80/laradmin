@include('user.header')
                        <!-- Login 2 - Bootstrap Brain Component -->
<div class="bg-light py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
          <div class="bg-white p-4 p-md-5 rounded shadow-sm">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Forget Password</h3>
                </div>
              </div>
            </div>
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
            <form action="{{ route('forgetPassword') }}" method="post">
                @csrf
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                  @if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn btn-lg btn-primary" type="submit">Forget Password</button>
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

