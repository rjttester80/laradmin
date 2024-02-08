@include('user.header')
            <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="bg-light py-3 py-md-5">
                <div class="container">
                  <div class="row justify-content-md-center">
                    <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                      <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                        <div class="row">
                          <div class="col-12">
                            <div class="mb-5">
                              <h3>Register</h3>
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
                            <form action="{{ route('userRegister') }}" method="post" class="text-center">
                                @csrf
                                <div class="row mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                    @if ($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                                @if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    @if ($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                    @if ($errors->has('confirm_password'))<span class="text-danger">{{ $errors->first('confirm_password') }}</span>@endif
                                </div>
                                <input type="submit" class="btn btn-primary" value="Register">
                            </form>
                            <div class="row">
                                <div class="col-12">
                                  <hr class="mt-5 mb-4 border-secondary-subtle">
                                  <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                    <a href="{{ route('login') }}" class="link-secondary text-decoration-none">Already have an account? Login here</a>
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

