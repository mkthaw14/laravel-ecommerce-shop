<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset("frontend/css/styles.css")}}" rel="stylesheet" />
        <script src="https://unpkg.com/feather-icons"></script>

    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="{{route("shop")}}">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route("shop")}}">Home</a></li>

                    </ul>
                    <div class="d-flex">
                        <a class="btn btn-outline-dark" href="{{route('shop.cart')}}">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill cart-icon">0</span>
                        </a>

                    </div>

                    @guest
                        @if (Route::has('login'))
                            <a class="btn btn-outline-dark mx-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                    @else

                        <div class="dropdown">
                            <a  class="btn btn-outline-dark mx-3 dropdown-toggle" id="navbarDropdown"  href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest


                </div>


            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        @yield('main_section')
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website {{date("Y")}}</p></div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset("frontend/js/scripts.js")}}"></script>
        <script>
            const path = "http://localhost:8000/";
            const storageKey = "cart-items";
            const showByQuantity = true;

            $(document).ready(function() {
                updateCartUI(showByQuantity);
            })

            function updateCartUI(byQuantity)
            {
                let storedItems = JSON.parse(localStorage.getItem(storageKey));

                if(!storedItems)
                {
                    $(".cart-icon").text(0);
                    return;
                }

                if(byQuantity)
                {
                    let totalQuantity = 0;
                    storedItems.forEach(function(item, index) {
                        totalQuantity += item.qty;
                    });

                    $(".cart-icon").text(totalQuantity);
                }
                else
                    $(".cart-icon").text(storedItems.length);
            }

        </script>
        @yield('scripts')

    </body>
</html>
