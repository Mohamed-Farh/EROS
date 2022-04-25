@guest
    @php
    $today = \Carbon\Carbon::now();
    $advs = \App\Models\Adv::whereStatus(1)
        ->whereRaw('"' . $today . '" between `start_date` and `End_date`')
        ->where('country_id', null)
        ->get();
    @endphp
    <div class="slider-sec py-2 text-center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if ($advs)
                    @foreach ($advs as $k => $advert)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a href="{{ route('frontend.advDetails', ['advProduct' => $advert]) }}">
                                @if ($advert->firstMedia)
                                    <img src="{{ asset($advert->firstMedia->file_name) }}" alt="{{ $advert->name }}">
                                @else
                                    <img src="{{ asset('images/advert.png') }}" alt="{{ $advert->name }}">
                                @endif

                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $advert->name }}</h5>
                                    <p>{{ $advert->description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endguest
{{-- ##################################################################################################################### --}}
@auth
    @php
    $today = \Carbon\Carbon::now();
    $userAddress = \App\Models\UserAddress::whereUserId(auth()->user()->id)->first();
    if ($userAddress && $userAddress->country_id != '') {
        $advs = \App\Models\Adv::whereStatus(1)
            ->whereRaw('"' . $today . '" between `start_date` and `End_date`')
            ->where(function ($query) {
                $query->where('country_id', $userAddress->country_id)->orWhere('country_id', null);
            })
            ->get();
    } else {
        $advs = \App\Models\Adv::whereStatus(1)
            ->whereRaw('"' . $today . '" between `start_date` and `End_date`')
            ->where('country_id', null)
            ->get();
    }
    @endphp
    <div class="slider-sec py-2 text-center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @if ($advs)
                    @foreach ($advs as $k => $advert)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a href="{{ route('frontend.advDetails', ['advProduct' => $advert]) }}">
                                @if ($advert->firstMedia)
                                    <img src="{{ asset($advert->firstMedia->file_name) }}" alt="{{ $advert->name }}">
                                @else
                                    <img src="{{ asset('images/advert.png') }}" alt="{{ $advert->name }}">
                                @endif
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>{{ $advert->name }}</h5>
                                    <p>{{ $advert->description }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endauth
