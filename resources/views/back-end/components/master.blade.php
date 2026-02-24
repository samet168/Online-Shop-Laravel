
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('back-end/assets/vendors/css/vendor.bundle.addons.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    
    <link rel="stylesheet" href="{{ asset('back-end/assets/css/shared/style.css') }}">
  
    <link rel="stylesheet" href="{{ asset('back-end/assets/css/demo_1/style.css') }}">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="{{ asset('back-end/assets/images/favicon.ico') }}" />

    <!-- Bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Toastify messages -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- Select 2 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    @yield('styles')

  </head>
  <body>
    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->
      @include('back-end.components.navbar')
      <!-- partial -->

      <div class="container-fluid page-body-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @include('back-end.components.sidebar')
        <!-- partial -->

        <div class="main-panel">
          <div class="content-wrapper">

           

          @yield("contens")
            

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    


    <!-- Modal -->
    <div class="modal fade" id="modalSearch" tabindex="-5" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered" style="max-width: 40%">
        <div class="modal-content">
          <div class="modal-body p-4 mt-3">
              <div class="form-group">
                  <input type="text" class=" form-control" style="padding: 20px;" name="search" id="searchBox" placeholder="Search items here....">
                  <button type="button" class="btn btn-primary btn-sm ml-2 searchBtn" id="searchBtn">Search</button>
              </div>
          </div>
        </div>
      </div>
    </div>

    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('back-end/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('back-end/assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <!-- endinject -->
    
  
    <script src="{{ asset('back-end/assets/js/shared/off-canvas.js') }}"></script>
    <script src="{{ asset('back-end/assets/js/shared/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('back-end/assets/js/demo_1/dashboard.js') }}"></script>
    <!-- End custom js for this page-->
    <script src="{{ asset('back-end/assets/js/shared/jquery.cookie.js') }}" type="text/javascript"></script>

    {{-- Boostrap 5.2 start --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Boostrap 5.2 end --}}

    <!-- Jquery link script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Toastify messages -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Select 2 script --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> 

    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       });

       const Message = (message) => {
          Toastify({
            text: `${message}`,
            duration: 2000,
            destination: "https://github.com/apvarun/toastify-js",
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            onClick: function(){} // Callback after click
          }).showToast();
        }

     
    </script>

    @yield("scripts")
  </body>
</html>