@extends('layouts.guest')
@section('title', 'Event Detail')
@push('css')
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f1f1f1;
        }

        /* Header/Blog Title */
        .header {
            padding: 30px;
            font-size: 40px;
            text-align: center;
            background: white;
        }

        /* Create two unequal columns that floats next to each other */
        /* Left column */
        .leftcolumn {
            float: left;
            width: 75%;
        }

        /* Right column */
        .rightcolumn {
            float: left;
            width: 25%;
            padding-left: 20px;
        }

        /* Fake image */
        .fakeimg {
            background-color: #aaa;
            width: 100%;
            padding: 20px;
        }

        /* Add a card effect for articles */
        .card {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Footer */
        .footer {
            padding: 20px;
            text-align: center;
            background: #ddd;
            margin-top: 20px;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 800px) {

            .leftcolumn,
            .rightcolumn {
                width: 100%;
                padding: 0;
            }
        }

    </style>
    <style>
        .forecast {
            margin: 0;
            padding: .3rem;
            background-color: rgb(92, 178, 218);
            font: 1rem 'Fira Sans', sans-serif;
        }

        .forecast>h1,
        .day-forecast {
            margin: .5rem;
            padding: .3rem;
            font-size: 1.2rem;
        }

        .day-forecast {
            background: right/contain content-box border-box no-repeat url('/media/examples/rain.svg') white;
        }

        .day-forecast>h2,
        .day-forecast>p {
            margin: .2rem;
            font-size: 1rem;
        }

    </style>
@endpush
@push('js')
 <script>
     var slideIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1}
  x[slideIndex-1].style.display = "block";
  setTimeout(carousel, 5000); // Change image every 2 seconds
}

 </script>
@endpush
@section('content')
<div class="card">
    <div class="card-body">
        <h2>Events On National volunteerism</h2>


        <div class="row">
            <div class="leftcolumn">
                <div class="card">

                    <h2>{{ $event->title }}</h2>
                    <h5>{{ $event->created_at->diffForHumans() }}</h5>
                    @if (count($event->images) < 1)
                        <img src="" width="800" height="300" alt="event Image not Found">
                    @endif
                    @foreach ($event->images as $img)
                        <img src="{{ asset($img->url) }}" width="700" height="300" alt="event Image not Found" class="mySlides">
                    @endforeach
                    <p>{!! $event->content !!}</p>

                </div>

            </div>
            <div class="rightcolumn">
                <div class="card">
                    <article class="forecast">
                        <h1>Recent Events</h1>
                        @foreach ($featuredEvents as $featureEvent)
                            <article class="day-forecast">
                                <h2>{{ $featureEvent->updated_at->diffForHumans() }}</h2>
                                <p><a
                                        href="{{ route('event.detail', ['event' => $featureEvent->id]) }}">{{ $featureEvent->title }}</a>
                                </p>
                            </article>
                        @endforeach
                    </article>


                </div>


            </div>
        </div>
    </div>
</div>
@endsection
