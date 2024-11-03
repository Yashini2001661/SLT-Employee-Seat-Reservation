<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/78191ce747.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/changepassword.css') }}">
    <title>Change Password</title>
  </head>
<body>
    <!-- Logout Button -->
    <div class="position-absolute top-0 end-0 p-3">
        <a href='/homeRoute' class="btn btn-light" title="Logout">
            Logout <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
    <div class="container">
        <form action="{{ route('changepw.reset') }}" method="POST">
            @csrf
            <h1>Change Password</h1>

            @if (session('status'))
              <div class="alert alert-success">
                  {{ session('status') }}
              </div>
            @endif


            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
              </div>
            @endif

            <div class="mb-3">
                <label for="emp_id" class="form-label">Username</label>
                <input type="text" name="emp_id" id="emp_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nic" class="form-label">NIC</label>
                <input type="text" name="nic" id="nic" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" name="newPassword" id="newPassword" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="newPassword_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6 custom-button">Change Password</button>

            <div class="login-link">
                <p>
                    <div class="input-group mb-3"> 
                        <button class="btn btn-lg btn-primary w-100 fs-6 custom-button" type="submit">Login</button> 
                    </div> 
                </p>
            </div>
        </form>
    </div>
</body>
</html>
