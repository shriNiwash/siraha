<!DOCTYPE html>
<html lang="en" data-layout="topnav" data-menu-color="brand">
<head>
  <meta charset="utf-8" />
  <title>Tez LIS SYSTEM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <style>
  .position-absolute {
    position: absolute !important
  }
  .start-0 {
    left: 0 !important
  }
  .end-0 {
    right: 0 !important
  }
  .bottom-0 {
    bottom: 0 !important
  }
  .w-100 {
    width: 100% !important
  }

  .w-auto {
    width: auto !important
  }

  .mw-100 {
    max-width: 100% !important
  }

  .vw-100 {
    width: 100vw !important
  }

  .min-vw-100 {
    min-width: 100vw !important
  }

  .h-100 {
    height: 100% !important
  }

  .h-auto {
    height: auto !important
  }

  .mh-100 {
    max-height: 100% !important
  }

  .vh-100 {
    height: 100vh !important
  }

  .min-vh-100 {
    min-height: 100vh !important
  }

  body.authentication-bg .account-pages {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    min-height: 100vh
  }
  .position-relative {
    position: relative !important
  }
  .justify-content-center {
    -webkit-box-pack: center !important;
    -ms-flex-pack: center !important;
    justify-content: center !important
  }
  </style>
</head>
<body class="authentication-bg position-relative">
  <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">

  </div>
  <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
          <div class="card">
            <div class="card-body p-4">

              <div class="text-center w-75 m-auto">
                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                <p class="text-muted mb-4">LIS login portal.</p>
              </div>
              <?php if(!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert"><?= $error_message ?></div>
              <?php endif; ?>
              <form class="loginn" action="<?php echo base_url('system/login') ?>" method="post">

                <div class="mb-3">
                  <label for="emailaddress" class="form-label">Username</label>
                  <input class="form-control" type="email" name="username" id="emailaddress" required="" placeholder="Enter your email">
                </div>

                <div class="mb-3">
                  <a href="auth-recoverpw.html" class="text-muted float-end fs-12">Forgot your password?</a>
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                    <div class="input-group-text" data-password="false">
                      <i class="fa fa-eye password-addon"></i>
                    </div>
                  </div>
                </div>

                <div class="mb-3 mb-3">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                  </div>
                </div>

                <div class="mb-3 mb-0 text-center">
                  <button class="btn btn-primary" id="shri" type="submit"> Log In </button>
                </div>

              </form>
            </div> <!-- end card-body -->
          </div>
        </div> <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end page -->

  <script>

  var element = document.getElementById("eye_change");
  if (document.getElementById('password-addon')) {
    document.getElementById('password-addon').addEventListener('click', function () {
      var passwordInput = document.getElementById("password");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        element.classList.add("fa-eye-slash");
        element.classList.remove("fa-eye");
      } else {
        passwordInput.type = "password";
        element.classList.add("fa-eye");
        element.classList.remove("fa-eye-slash");
      }
    });
  }

</script>

</body>
</html>
