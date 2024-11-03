<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/78191ce747.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <title>Admin Login - Employees Seat Reservation System</title>
</head>
<body>
    <!-- Logout Button -->
    <div class="position-absolute top-0 end-0 p-3">
        <a href='/homeRoute' class="btn btn-light" title="Logout">
            Logout <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
    <!----------------------- Main Container ---------------------------> 
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        
        <!----------------------- Login Container ---------------------------> 
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <!--------------------------- Left Box -----------------------------> 
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #fff;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('assets/images/slt.jpg') }}" alt="Example Image" class="img-fluid" style="width: 420px; height:270px; border-radius:20px; margin-top:-20px">
                </div>
            </div> 
            <!--------------------------- Right Box ----------------------------> 
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Admin-Login</h2>
                        <p>WELCOME TO THE SLT SEAT RESERVATION</p>
                    </div>
                    @if ($errors->any())
                        <div class="error-message">
                               @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                        </div>
                    @endif
                    <form action="{{ url('admin-login') }}" method="POST"> 
                        @csrf 
                        <div class="input-group mb-3"> 
                            <label for="username" class="visually-hidden">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-lg bg-light fs-6" placeholder="Username" required>
                        </div> 
                        <div class="input-group mb-1"> 
                            <label for="password" class="visually-hidden">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password" required>
                        </div> 
                        <div class="input-group mb-5 d-flex justify-content-between"> 
                            <div class="form-check"> 
                                <input type="checkbox" class="form-check-input" id="formCheck"> 
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label> 
                            </div>  
                            <div class="forgot">
                                <small><a href="{{ route('changepw') }}" class="signup-btn">Forgot Password?</a></small>
                            </div>
                        </div> 
                        <div class="input-group mb-3"> 
                            <button class="btn btn-lg btn-primary w-100 fs-6 custom-button" type="submit">Login</button> 
                        </div> 
                        <a href='/loginRoute' class="btn btn-lg btn-primary w-100 fs-6 custom-button">User</a>
                    </form> 
                    </form> 
                    
                </div> 
            </div> 
        </div> 
    </div> 

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-DfXdz0Bq1Z5b9U73rZPRgYPXFR2h6G3jT5QXcZ9P/qohzS8ht29p5E8sF3vW1qBQ" crossorigin="anonymous"></script> 
</body>
</html>
