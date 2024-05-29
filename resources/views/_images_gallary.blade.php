@if(count($images))
    <div class="row" id="images-gallery">
        @foreach($images as $image)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-3">
                @php
                    $imgSize = getimagesize($image->image_filepath);
                    $imgWidth = $imgSize[0];
                    $imgHeight = $imgSize[1];
                    $img = \Rolandstarke\Thumbnail\Facades\Thumbnail::src($image->image_filepath, 'public');
                @endphp
                <a href="{{ $img->url() }}"
                   data-pswp-width="{{ $imgWidth }}"
                   data-pswp-height="{{ $imgHeight }}"
                   data-cropped="true"
                   target="_blank">
                    <img class="img-thumbnail" src="{{ $img->crop(200, 200)->url() }}" alt=""/>
                </a>
            </div>
        @endforeach

        <link href="{{ asset('libs/photoswipe/dist/photoswipe.css') }}" rel="stylesheet">
        <script type="module">
            import PhotoSwipeLightbox from '{{ asset('libs/photoswipe/dist/photoswipe-lightbox.esm.min.js') }}';
            const lightbox = new PhotoSwipeLightbox({
                gallery: '#images-gallery',
                children: 'a',
                // setup PhotoSwipe Core dynamic import
                pswpModule: () => import('{{ asset('libs/photoswipe/dist/photoswipe.esm.min.js') }}')
            });
            lightbox.init();
        </script>
        @include('_photoswipe')
    </div>
@endif
