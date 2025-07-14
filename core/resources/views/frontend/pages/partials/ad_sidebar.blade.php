<style>
.ad-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1.3;
    transition: color 0.3s ease;
}
.ad-company {
    font-size: 14px;
    font-weight: 500;
}

.ad-description {
    font-size: 13px;
    color: #555;
    line-height: 1.5;
}
.single-shop-left img {
    width: 100%;
    height: 216px; 
    display: block;
    border-radius: 8px;
}
</style>
@if(isset($ads) && is_array($ads) && array_key_exists('sidebar', $ads))
    @forelse($ads['sidebar'] as $ad)
        <div class="single-shop-left bg-white radius-10 mt-4">
            <div class="single-shop-left-title open flex-column">
                <h4 class="ad-title">{{ mb_substr(trim($ad->title), 0, 27) }}</h4>
                <a href="{{$ad->url}}" target="_blank">
                    <img src="{{ asset('assets/uploads/ads/' . $ad->cover_image) }}" alt="ad">
                </a>
                <div class="ad-company text-muted mt-1">{{$ad->company}}</div>
                <div class="ad-description mt-2">{{$ad->description}}</div>
            </div>
        </div>
    @empty
    @endforelse
@endif
