
<!DOCTYPE html>
<html lang="en">
  @include('admin.layout_admin.head')
  @yield('css')
  <body>
    <div class="wrapper">
      @include('admin.layout_admin.sidebar')

      <div class="main-panel">
        @include('admin.layout_admin.header')

        <div class="content-container">
          <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12 col-lg-10 col-12">
          @yield('content')
            </div>
          </div>  
        </div>
        @include('admin.layout_admin.hide')
        @include('admin.layout_admin.footer')
      </div>
    </div>
    @include('admin.layout_admin.script')
    @yield('js')
  </body>
</html>
