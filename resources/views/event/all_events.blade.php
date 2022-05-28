@extends('layouts.guest')
@section('title',' All Events')
@push('css')
    <style>
        CSS .blog_section {
            padding-top: 5rem;
            padding-bottom: 3rem;
        }

        .blog_section .blog_content .blog_item {
            margin-bottom: 30px;
            box-shadow: 0 0 11px 0 rgba(6, 22, 58, 0.14);
            position: relative;
            border-radius: 2px;
            overflow: hidden;
        }

        /* .blog_section .blog_content .blog_item:hover .blog_image img {
            transform: scale(1.1);
        }

        .blog_section .blog_content .blog_item .blog_image {
            overflow: hidden;
            padding: 0;
        }

        .blog_section .blog_content .blog_item .blog_image img {
            width: 100%;
            transition: transform 0.5s ease-in-out;
        } */

        .blog_section .blog_content .blog_item .blog_image span i {
            position: absolute;
            z-index: 2;
            color: #fff;
            font-size: 18px;
            width: 38px;
            height: 45px;
            padding-top: 7px;
            text-align: center;
            right: 20px;
            top: 0;
            -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 79%, 0 100%);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 79%, 0 100%);
            background-color: #147affx;
        }

        .blog_section .blog_content .blog_item .blog_details {
            padding: 25px 20px 30px 20px;
        }

        .blog_section .blog_content .blog_item .blog_details .blog_title h5 a {
            color: #020d26;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 25px;
            line-height: 32px;
            font-weight: 400;
            transition: all 0.3s;
            text-decoration: none;
        }

        .blog_section .blog_content .blog_item .blog_details .blog_title h5 a:hover {
            color: #147aff;
        }

        .blog_section .blog_content .blog_item .blog_details ul {
            padding: 0 3px 10px 0;
            margin: 0;
        }

        .blog_section .blog_content .blog_item .blog_details ul li {
            display: inline-block;
            padding-right: 15px;
            position: relative;
            color: #7f7f7f;
        }

        .blog_section .blog_content .blog_item .blog_details ul li i {
            padding-right: 7px;
        }

        .blog_section .blog_content .blog_item .blog_details p {
            border-top: 1px solid #e5e5e5;
            margin-top: 4px;
            padding: 20px 0 4px;
        }

        .blog_section .blog_content .blog_item .blog_details a {
            font-size: 16px;
            display: inline-block;
            color: #147aff;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .blog_section .blog_content .blog_item .blog_details a:hover {
            color: #020d26;
        }

        .blog_section .blog_content .blog_item .blog_details a i {
            vertical-align: middle;
            font-size: 20px;
        }

        .blog_section .blog_content .owl-nav {
            display: block;
        }

        .blog_section .blog_content .owl-nav .owl-prev {
            position: absolute;
            left: -27px;
            top: 33%;
            border: 5px solid #fff;
            text-align: center;
            z-index: 5;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            outline: 0;
            background: #147aff;
            transition: all 0.3s;
            color: #fff;
        }

        .blog_section .blog_content .owl-nav .owl-prev span {
            font-size: 25px;
            margin-top: -6px;
            display: inline-block;
        }

        .blog_section .blog_content .owl-nav .owl-prev:hover {
            background: #fff;
            border-color: #147aff;
            color: #147aff;
        }

        .blog_section .blog_content .owl-nav .owl-next {
            position: absolute;
            right: -27px;
            top: 33%;
            border: 5px solid #fff;
            text-align: center;
            z-index: 5;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            outline: 0;
            background: #147aff;
            color: #fff;
            transition: all 0.3s;
        }

        .blog_section .blog_content .owl-nav .owl-next span {
            font-size: 25px;
            margin-top: -6px;
            display: inline-block;
        }

        .blog_section .blog_content .owl-nav .owl-next:hover {
            background: #fff;
            border-color: #147aff;
            color: #147aff;
        }

        @media only screen and (max-width: 577px) {
            .blog_section .owl-nav .owl-prev {
                left: -17px !important;
            }

            .blog_section .owl-nav .owl-next {
                right: -17px !important;
            }
        }

    </style>
@endpush
@push('js')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            nav: true,
            autoplay: true,
            smartSpeed: 3000,
            autoplayTimeout: 7000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    </script>
@endpush
@section('content')
    <section class="blog_section">
        <div class="container">
            <div class="blog_content">
                <div class="owl-carousel owl-theme">
                    <div class="row">
                       @foreach ( $events as $event)
                       <div class="blog_item col-6">
                        <div class="blog_image">
                            <img class="img-fluid"
                            src="https://cdn.pixabay.com/photo/2uuuuu019/03/10/18/31/hong-kong-4046913_960_720.jpg"
                            alt="images not found">
                            <span><i class="icon ion-md-create"></i></span>
                        </div>
                        <div class="blog_details">
                            <div class="blog_title">
                                <h5><a href="#">{{ $event->title }}.</a></h5>
                            </div>
                            <ul>
                                <li><i class="icon ion-md-person"></i>Alexa</li>
                                <li><i class="icon ion-md-calendar"></i>{{ $event->created_at->diffForHumans() }}</li>
                            </ul>
                            <p> {!! Str::limit($event->content, 200) !!} </p>
                            <a href="{{ route('event.detail',['event'=>$event->id]) }}">Read More<i class="icofont-long-arrow-right"></i></a>
                        </div>
                    </div>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
