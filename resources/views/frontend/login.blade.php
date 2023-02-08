@extends('frontend.layout')
@section('title')
    Login
@endsection
@section('main_section')
    <div class="container">
        <div class="row d-flex justify-content-center py-5">
            <form class="col-5 row g-3" action="{{route('login')}}" method="POST">
                @csrf
 
    
                <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error("email") is-invalid @endError" id="email" name="email" value="{{old("email")}}">
                  @error('email')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control @error("password") is-invalid @endError" id="password" name="password" value="{{old("password")}}">
                  @error('password')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                        
                <div class="col-12">
                    <button type="submit" class="btn btn-dark float-end">Login</button>
                </div>
    
              </form>
        </div>
    </div>
@endsection
@section('scripts')
    
@endsection

