@extends('frontend.include.master')
@section('body')
<div class="container mt-3">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div style="display: flex; justify-content: center;">
                <div class="thumbnail-images">
                    @foreach ($thamnails as $thumbnail)
                    <img class="product-thumbnail" src="{{asset('images/products/thumbnail/'.$thumbnail->thumbnail)}}" alt="Product thumbnail 1" onclick="changeMainImage('{{asset('images/products/thumbnail/'.$thumbnail->thumbnail)}}')">
                    @endforeach
                </div>
                <div class="product-gallery">
                    <div class="main-image">
                        <a href="#"><img id="mainImage" class="product-main-img" src="{{asset('images/products/preview/'.$product_info->preview)}}" alt="Main product image"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <form action="{{route('checkout')}}" method="POST">
                @csrf
                <div class="product__details__text">
                    <h3 class="mt-3">{{$product_info->name}}</h3>
                    @php
                     $total_star = App\Models\Review::where('product_id', $product_info->id)->whereNotNull('comment')->sum('star');

                     $totalReview = App\Models\Review::where('product_id', $product_info->id)->whereNotNull('comment')->count();
                    $rating = 0;
                        if ($totalReview) {
                            $rating = $total_star / $totalReview;
                        }
                        $averageRating = round($totalReview ? $total_star / $totalReview : 0);
                    @endphp
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($averageRating))
                                <i class="fa fa-star"></i>
                            @elseif ($i == ceil($averageRating) && $averageRating - floor($averageRating) > 0)
                                <i class="fa fa-star-half-o"></i>
                            @else
                              <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span>({{ $totalReview }} reviews)</span>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                    <div class="product__details__price fs-3"><span class="text-danger me-2">ট {{$product_info->after_discount}}</span> <del>{{$product_info->price}}</del></div>
                    <div class="bttn" style="max-width: 400px;">
                        <div class="row">
                            <div class="col-md-4 col-12 mb-2">
                                <div class="article">
                                    <button type="button" class="button-design buttonminus">-</button>
                                    <input type="text" name="quantity" class="button-design" id="quantity1" value="1">
                                    <button type="button" class="button-design buttonplus">+</button>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="order-container">
                                    <button type="submit" name="click" value="1" class="btn w-100 text-white" style="background-color: #E2B01F;">Order Now</button>
                        </div>
                    </div>
                </div>
            </form>
                    <form action="{{route('add.cart')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                        <input type="hidden" name="quantity" value="1" />
                        <button type="submit" class="btn w-100 mt-3 text-white" style="background-color: #FA8500;">Add Cart</button>
                    </form>
                    <span class="btn w-100 mt-3 mb-2 text-white" style="background-color: #2446f2;">01786296633</span>
                    </div>
                    <ul>
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
        </div>
    </div>
</div>

<div class="container col-lg-12 mt-4" id="jjj">
    <div class="product-details-tabs">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#tabs-1" type="button" role="tab" aria-controls="tabs-1" aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tabs-3" type="button" role="tab" aria-controls="tabs-3" aria-selected="false">Reviews</button>
            </li>
        </ul>
        <div class="tab-content" id="productTabContent">
            <div class="tab-pane fade show active" id="tabs-1" role="tabpanel" aria-labelledby="description-tab">
                <div class="product-details-tab-desc">
                    <h6>Products Description</h6>
                    <p>{!!$product_info->long_desp!!}</p>
                    
                </div>
            </div>
            <!-- Reviews Section -->
            <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="product-details-tab-desc">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Reviews ({{$totalReview}}) <span class="text-warning">Ratings </span>{{$rating}}</h6>

                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Write a Review
                        </button>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            @if ($reviews)
                            @foreach ($reviews as $review)
                            <div class="review-item">
                                <div class="review-author">{{ $review->name }}</div>
                                <div class="review-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->star)
                                            &#9733; <!-- filled star -->
                                        @else
                                            &#9734; <!-- empty star -->
                                        @endif
                                   @endfor
                                </div>
                                <div class="review-comment">{{ $review->comment }}</div>
                            </div>
                           @endforeach
                            No Review
                           @else
                           @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Review Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Submit Your Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="alert-container"></div>
                            <form id="review-form" action="{{ route('review.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                                <div class="mb-3">
                                    <h6>Your Rating</h6>
                                    <div class="submit-rating d-flex justify-content-between">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input id="star-{{ $i }}" type="radio" name="star" value="{{ $i }}" />
                                            <label for="star-{{ $i }}" title="{{ $i }} stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="reviewer-name">Name</label>
                                    <input type="text" id="reviewer-name" name="name" class="form-control" placeholder="Enter your name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="review-comment">Comment</label>
                                    <textarea id="review-comment" name="comment" class="form-control" rows="4" placeholder="Write your review"></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light">
    <div class="container mt-3">
        <div class="d-flex justify-content-center flex-wrap">
            @foreach ($thamnails as $thumbnail)
                <img src="{{asset('images/products/thumbnail/'.$thumbnail->thumbnail)}}" class="img-fluid mb-3" alt="">
            @endforeach
        </div>

        <div class="video-container">
            <iframe src="{{$product_info->vdo_link}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>

<div class="mb-5 mt-5 container">
    <div class="ptoduct-title fs-3">
       Related Poducts
    </div>
    <div class="product-list container2">
       @foreach ($products as $product)
        <div class="card cardhover">
            <a href="{{route('details',$product->slug)}}">
                <img class="img-fluid" src="{{asset('images/products/preview/'.$product->preview)}}" alt="Product Image">
            </a>
            <div class="card-body">
                <a href="{{route('details',$product->slug)}}"  style="text-decoration: none;">
                    <p class="card-text">{{$product->name}}</p>
                </a>
                <p class="price">{{$product->after_discount}}</p>
                <p class="original-price"><del>{{$product->price}}</del> -{{$product->discount}}</p>
            </div>
        </div>
       @endforeach
    </div>
</div>
@endsection
@push('js')
@if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 5000,
            close: true,
            stopOnFocus: true,
            backgroundColor: "rgba(40, 167, 69, 0.9)",
            position: "right",
            gravity: "bottom"
        }).showToast();
    </script>
@endif

<script>
    document.getElementById('review-form').addEventListener('submit', function(event) {
        event.preventDefault();
    
        const form = event.target;
        const formData = new FormData(form);
        const alertContainer = document.getElementById('alert-container');
    
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (response.status === 422) {
                return response.json().then(errors => {
                    throw errors;
                });
            }
            return response.json();
        })
        .then(data => {
            alertContainer.innerHTML = '';
            if (data.success) {
                const successMessage = document.createElement('div');
                successMessage.classList.add('alert', 'alert-success');
                successMessage.textContent = data.success;
                alertContainer.appendChild(successMessage);
                form.reset();
            }
        })
        .catch(errors => {
            alertContainer.innerHTML = '';
            const errorList = document.createElement('ul');
            errorList.classList.add('alert', 'alert-danger');
            Object.keys(errors.errors).forEach(key => {
                const errorItem = document.createElement('li');
                errorItem.textContent = errors.errors[key][0];
                errorList.appendChild(errorItem);
            });
            alertContainer.appendChild(errorList);
        });
    });
    </script>
@endpush