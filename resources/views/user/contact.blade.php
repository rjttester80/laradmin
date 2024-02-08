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
                              <h3>Contact Us</h3>
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
                            <h6>Please fill in the fields below...</h6>
                            <form action="" method="post" class="text-center">
                                @csrf
                                <div class="row mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                                    @if ($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                                @if ($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Contact Number">
                                    @if ($errors->has('mobile'))<span class="text-danger">{{ $errors->first('mobile') }}</span>@endif
                                </div>
                                <div class="row mb-3">
                                    <textarea class="form-control" id="message" name="message" rows="3" placeholder="Message"></textarea>
                                    @if ($errors->has('message'))<span class="text-danger">{{ $errors->first('message') }}</span>@endif
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </form>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                                  </div>
                              </div>
                          </header>
@include('user.footer')

