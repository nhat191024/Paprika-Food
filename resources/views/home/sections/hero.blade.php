<!-- Hero Section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .swiper-pagination-bullet {
        background: white;
        opacity: 0.5;
    }
    .swiper-pagination-bullet-active {
        background: #ffae00;
        opacity: 1;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<section class="relative w-full overflow-hidden group"
    x-data="{
        initSwiper() {
            if (typeof Swiper === 'undefined') {
                setTimeout(() => this.initSwiper(), 100);
                return;
            }
            new Swiper(this.$refs.container, {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: this.$refs.pagination,
                    clickable: true,
                },
                navigation: {
                    nextEl: this.$refs.next,
                    prevEl: this.$refs.prev,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
            });
        }
    }"
    x-init="initSwiper()">
    
    <div x-ref="container" class="swiper w-full">
        <div class="swiper-wrapper">
            <!-- Default Slide -->
            <div class="swiper-slide relative flex flex-col justify-center min-h-[60vh] md:min-h-[80vh] py-20 bg-zinc-200" style="background-image: url('https://lotteria.com.sg/wp-content/uploads/LOTTERIA_Signature-Image_Main_horizontal.webp'); background-size: cover; background-position: center center;">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="relative flex items-center w-full max-w-7xl mx-auto px-8">
                    <div class="w-full max-w-2xl">
                        <h1 class="text-balance break-words text-4xl font-extrabold leading-tight tracking-tight text-white uppercase sm:text-5xl md:text-6xl lg:text-7xl [text-shadow:_0_2px_4px_rgba(0,0,0,0.5)]">
                            {!! __('client/home.hero_title') !!}
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Dynamic Banners -->
            @foreach($banners ?? [] as $banner)
                @if($banner->image->isNotEmpty())
                    <div class="swiper-slide relative flex flex-col justify-center min-h-[60vh] md:min-h-[80vh] py-20 bg-zinc-200" style="background-image: url('{{ $banner->image->first()->getUrl() }}'); background-size: cover; background-position: center center;">
                        <div class="absolute inset-0 bg-black/40"></div>
                        @if($banner->title)
                            <div class="relative flex items-center w-full max-w-7xl mx-auto px-8">
                                <div class="w-full max-w-2xl">
                                    <h1 class="text-balance break-words text-4xl font-extrabold leading-tight tracking-tight text-white uppercase sm:text-5xl md:text-6xl lg:text-7xl [text-shadow:_0_2px_4px_rgba(0,0,0,0.5)]">
                                        {{ $banner->title }}
                                    </h1>
                                </div>
                            </div>
                        @endif
                        @if($banner->link)
                            <a href="{{ $banner->link }}" class="absolute inset-0 z-10" aria-label="{{ $banner->title ?? 'Banner link' }}"></a>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
        
        <!-- Controls -->
        <div class="swiper-pagination" x-ref="pagination"></div>
        <div class="swiper-button-prev !text-white after:!text-3xl drop-shadow-md opacity-0 group-hover:opacity-100 transition-opacity" x-ref="prev"></div>
        <div class="swiper-button-next !text-white after:!text-3xl drop-shadow-md opacity-0 group-hover:opacity-100 transition-opacity" x-ref="next"></div>
    </div>
</section>
