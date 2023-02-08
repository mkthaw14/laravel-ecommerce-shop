@extends('frontend.layout')
@section('title')
    Shop   
@endsection

@section('main_section')
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">

        <div class="dropdown mb-5" >
            <a class="btn btn-dark dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item category-link" data-id="0" href="#!">All Products</a></li>
                <li><hr class="dropdown-divider" /></li>

                @foreach ($categories as $category)
                    <li><a class="dropdown-item category-link" data-id="{{$category->id}}" href="#!">{{$category->name}}</a></li>   
                @endforeach
            </ul>
        </div>

        <div id="product-section" class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach ($products as $product)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <img class="card-img-top" src="{{asset($product->image)}}" alt="{{asset($product->image)}}" width="450px" height="300px"/>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{$product->name}}</h5>
                                <!-- Product price-->
                                ${{$product->price}}
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto add-to-cart" data-id="{{$product->id}}" data-name="{{$product->name}}" data-img="{{$product->image}}" data-price="{{$product->price}}" href="#">Add to cart</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>   
@endsection

@section('scripts')
 <script src="{{asset("frontend/js/add-to-cart.js")}}"></script>
 <script>
    const checkOutRoute = `{{route("shop.check-out")}}`;
    const siteName = "http://localhost:8000";

    $(document).ready(function() {
        $( ".category-link").on("click", function(e) {
            e.preventDefault();

            //alert("click");
            $(".category-link").removeClass("active");
            $(this).addClass("active");

            $.get(`{{route("shop.get-product-by-category")}}`, {category_id:$(this).data("id")}, function(data) {
                console.log(data);
                updateProductSection(data);
            });
        });


    });  


    function updateProductSection(data)
    {
        let products = '';
        data.products.forEach(function(item, index) {

            products += `
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="${siteName + "/" + item.image}" alt="${siteName + "/" + item.image}" width="450px" height="300px"/>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">${item.name}</h5>
                            <!-- Product price-->
                            $${item.price}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto add-to-cart" href="#" data-id="${item.id}" data-name="${item.name}" data-img="${item.image}" data-price="${item.price}">Add to cart</a></div>
                    </div>
                </div>
            </div>
            `;

        });


        $("#product-section").html(products);
    }
 </script>   
@endsection
