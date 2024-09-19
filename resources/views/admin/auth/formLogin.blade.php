<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css"
    rel="stylesheet"
    />
    <title>Login Admin</title>
</head>
<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
      
                  <h3 class="mb-5">Sign in to Admin</h3>
                  @include('admin.layout_admin.hide')
                  @include('admin.layout_admin.alert')
                <form action="/admin/login" method="POST">
                    @csrf
                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="email" name="email" id="typeEmailX-2" class="form-control form-control-lg" value="{{ old('email') }}"/>
                      <label class="form-label" for="typeEmailX-2">Email</label>
                    </div>
        
                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="password" name="password" id="typePasswordX-2" class="form-control form-control-lg" />
                      <label class="form-label" for="typePasswordX-2">Password</label>
                    </div>
        
                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-start mb-4">
                      <input class="form-check-input" type="checkbox" value="" id="form1Example3" name="remember"/>
                      <label class="form-check-label" for="form1Example3"> Remember me </label>
                    </div>
                    <button  class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                    <a href="/" class="btn btn-danger mt-3">Quay lại trang chủ</a>
                </form>
      
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"
></script>
</body>
</html>