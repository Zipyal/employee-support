@php
    use App\Models\UploadImage;
    use Illuminate\Database\Eloquent\Collection;
    use Rolandstarke\Thumbnail\Facades\Thumbnail;

    /** @var UploadImage[]|Collection $images */
    /** @var bool $multiple */
@endphp

<label for="upload-images" class="form-label">Изображения</label>
<div class="input-group has-validation">
    @if(!isset($multiple) || true === $multiple)
        <input class="form-control @error('images*') is-invalid @enderror" type="file" id="upload-images" name="images[]" multiple>
        @error('images*')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @else
        <input class="form-control @error('image') is-invalid @enderror" type="file" id="upload-images" name="image">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @endif
</div>

@if($images->count())
    <div class="row my-2" id="images-gallery">
        @foreach($images as $image)
            @if(!file_exists($image->image_filepath))
                @continue
            @endif
            @php
                $imgSize = getimagesize($image->image_filepath);
                $imgWidth = $imgSize[0];
                $imgHeight = $imgSize[1];
                $img = Thumbnail::src($image->image_filepath, 'public');
            @endphp
            <div class="col-2">
                <div class="hover-bg-light d-inline-block p-2 text-center">
                    <a href="{{ $img->url() }}"
                       data-pswp-width="{{ $imgWidth }}"
                       data-pswp-height="{{ $imgHeight }}"
                       data-cropped="true"
                       target="_blank">
                        <img class="img-thumbnail" src="{{ $img->crop(200, 200)->url() }}" alt="">
                    </a>
                    <div class="btn-delete-image btn btn-sm text-danger mt-1"
                         data-url="{{ $deleteUrl ?? route('upload-image-delete', ['id' => $image->uuid]) }}">
                        <i class="fas fa-trash-alt" title="Удалить изображение"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <link href="{{ asset('libs/photoswipe/dist/photoswipe.css') }}" rel="stylesheet">
    <script type="module">
        import PhotoSwipeLightbox
            from '{{ asset('libs/photoswipe/dist/photoswipe-lightbox.esm.min.js') }}';

        const lightbox = new PhotoSwipeLightbox({
            gallery: '#images-gallery',
            children: 'a',
            pswpModule: () => import('{{ asset('libs/photoswipe/dist/photoswipe.esm.min.js') }}')
        });
        lightbox.init();
    </script>
    @include('_photoswipe')
@endif


<script defer>
    document.querySelectorAll('.btn-delete-image').forEach(function (btn) {
        btn.addEventListener('click', function (e) {

            fetch(btn.dataset.url, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json'},
                body: JSON.stringify({_token: "{{ csrf_token() }}"})

            }).then(function (response) {
                if (response.ok || response.status === 404) {
                    btn.parentNode.parentNode.remove();
                }

            }).catch(function (e) {
                console.error(e);
            });

        });
    });
</script>

