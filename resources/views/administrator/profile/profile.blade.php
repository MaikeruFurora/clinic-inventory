@extends('layout.app')
@section('title','Profile')
@section('content')
<section class="section">
    <h2 class="section-title">Profile</h2>

    <div class="section-body">
        <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="far fa-user-circle" style="font-size: 20px"></i>&nbsp;&nbsp;Personal Information</h4>
                 </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12 py-3 px-lg-5">
                            <form>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputFirstname4">First name</label>
                                    <input type="text" class="form-control" id="inputFirstname4" value="{{ auth()->user()->first_name }}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="inputlastname4">Last name</label>
                                    <input type="text" class="form-control" id="inputlastname4" value="{{ auth()->user()->last_name }}">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="inputAddress">Address</label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" value="{{ auth()->user()->address }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAddress">User type</label>
                                        <input type="text" class="form-control" readonly value="{{ ucfirst(auth()->user()->user_type) }}">
                                    </div>
                                </div>
                               
                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->username }}">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->email }}">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>Contact No</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->contact_no }}">
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label>My Privilege: </label>
                                    @foreach (auth()->user()->privilege as $item)
                                    <span class="badge badge-secondary text-dark pt-1 pb-1">{{ $item }}</span>
                                @endforeach
                                  </div>
                               
                                <button type="submit" class="btn btn-primary">Save, Changes</button>
                              </form>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 py-3 px-lg-5">
                                <form>
                                <div class="form-group">
                                    <label><i class="fas fa-key text-secondary"></i> Old password</label>
                                    <input type="password" class="form-control" id="">
                                    </div>
                                <div class="form-group">
                                    <label><i class="fas fa-key text-secondary"></i> New Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-key text-secondary"></i> Confirm Password</label>
                                    <input type="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </div>
</section>
@endsection