@extends('layouts.admin')
@section('page_title') {{ ($product) ? "Update" : "Add"}} Product @endsection

@push('styles')
<link href="{{ asset('assets/dropzone/dist/dropzone.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="page-content p-2 p-sm-4">

    <div class="page-heading d-flex align-items-center mb-3">
        <h2 class="h2-responsive">Product images</h2>
        <div class="ml-auto">
            <a class="btn btn-info btn-md" href="/product">All Products</a>
        </div>
    </div>

    @include('product::__partials.product-form-tabs')
    <div>
        <div class="white p-3">
            <form id="myAwesomeDropzone" action="{{ route('ajax.product-images.store') }}" method="post" class="dropzone rounded" enctype="form-data/multipart">
                @csrf
                <div class="fallback">
                    <input name="file" type="file" accept="image/*" multiple />
                </div>
                <div class="dz-default dz-message">
                    <div class="mb-3" style="color: #2d4dd6;">
                        <svg fill="none" stroke="currentColor" style="height: 4rem; width: 4rem;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <span><b>Drag & Drop</b> product images here</span>
                    <div class="my-3">
                        or
                    </div>
                    <div>
                        <div class="btn btn-primary border-0" style="background-color: #2d4dd6;">Browse Images</div>
                    </div>
                </div>
                <input type="number" name="product_id" value="{{ $product->id }}" hidden="true">
                <div class="dropzone-previews"></div>
            </form>

            <p class="mt-2">* Maximun upload file size is 2MB.</p>

            <div id="images-loading" class="text-center pt-4">
                <div class="spinner-grow text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="container-fluid bg-white rounded mt-4 p-4">
                <div id="productImages" class="row">
                </div>
            </div>
        </div>

        <script type="text/template" id="image-template">
            <div class="col-6 col-sm-6 col-md-3 col-xl-2 mb-4">
            <div class="img-wrap bg-ight border">
                    <div class="bg-white">
                        <img class="img-fluid" src="" alt="">
                    </div>
                    <div class="d-flex py-2 px-3 border border-bottom-0 border-right-0 border-left-0 border-top">
                        <div>
                            <div class="dimension"></div> 
                            <div class="file-size"></div>
                        </div>
                        <div class="ml-auto">
                            <button class="del-image-btn p-2"><svg style="height: 1.5rem; width: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
            </div>
		</div>
	</script>

        <script type="text/template" id="no-image-template">
            <div id="no-image">
		<div class="image-icon">
			<i class="far fa-image"></i>
		</div>
		<div class="text">
			<strong>OOPS !!</strong>
			No Images to show
        </div>
	</div>
    
</script>
    </div>
    @endsection
    @push('push_scripts')
    <script type="text/javascript" src="{{ asset('assets/dropzone/dist/dropzone.js') }}"></script>
    {{-- <script src="{{ asset('/assets/admin/js/sweetalert.js') }}" type="text/javascript"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Dropzone.autoDiscover = false;
        $(function() {
            var images = $('#productImages');
            var imageTemplate = $('#image-template').html();
            var noImageTemplate = $('#no-image-template').html();
            var deleteUrl = "{{ route('ajax.product-images.destroy', 'IMAGE_ID ') }}";
            console.log(deleteUrl);

            function renderImageTemplate(image) {
                var templateItem = $(imageTemplate);
                templateItem.find('img').attr('src', image.url);
                templateItem.find('.del-image-btn').attr('data-id', image.id)
                if (image.width) {
                    templateItem.find('.dimension').text(image.width + '×' + image.height);
                }
                templateItem.find('.file-size').text(image.readable_size);
                images.append(templateItem);
            }

            function renderNoImageTemplate() {
                images.append(noImageTemplate)
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            function loadImages() {
                $('#images-loading').show();
                $.ajax("{{ route('ajax.product-images.listing', $product) }}", {
                    dataType: 'json',
                    success: function(data, status, xhr) {
                        // console.log(data);
                        images.empty();
                        console.log(typeof(data));
                        if (jQuery.isEmptyObject(data)) {
                            renderNoImageTemplate();
                        } else {
                            data.forEach(function(image) {
                                renderImageTemplate(image);
                            });
                        }
                    },
                    error: function(jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                }).done(function() {
                    $('#images-loading').hide();
                });
                console.log("Images Reloaded");
            }

            loadImages();

            var myAwesomeDropzone = new Dropzone("form#myAwesomeDropzone", {
                acceptedFiles: '.png,.jpg,.jpeg,.gif',
                previewsContainer: '.dropzone-previews',
                maxFilesize: 2,
                init: function() {
                    var myDropzone = this;
                    this.on("error", function(file, message) { 
                        Swal.fire({title: message, icon: 'error', toast: true, position: "top-end", showConfirmButton: false, timer: 3000 });
                        this.removeFile(file); 
                    });
                    this.on("sendingmultiple", function() {});
                    this.on("successmultiple", function(files, response) {
                        console.log(response);
                    });
                    this.on("errormultiple", function(files, response) {
                        console.log('error multiple');
                        console.log(response);
                    });
                    this.on('success', function(file, response) {
                        console.log('Successful upload');
                        Swal.fire({title: 'Product Image Saved', icon: 'success', toast: true, position: "top-end", showConfirmButton: false, timer: 3000 });
                        loadImages();
                    });
                    this.on('complete', function(file, response) {
                        console.log('upload complete');
                        this.removeFile(file);
                    });
                }
            });

            images.on('click', '.del-image-btn', function(e) {
                event.preventDefault();
                var con = false;
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    text: 'Do you really want to delete this product image? This action cannot be undone.',
                    showCancelButton: true,
                    confirmButtonText: 'Ok',
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            var dummyUrl = deleteUrl;
                            var imageDeleteUrl = dummyUrl.replace(/IMAGE_ID/, $(this).data('id'));
                            console.log("requesting to " + imageDeleteUrl);
                            $(this).hide();
                            $.ajax({
                                    url: imageDeleteUrl,
                                    type: 'POST',
                                    data: {
                                        _method: 'delete'
                                    }
                                })
                                .done(function(response) {
                                    console.log("success");
                                })
                                .fail(function(response) {
                                    console.log("error");
                                })
                                .always(function() {
                                    loadImages();
                                    console.log("complete");
                                });
                        } 
                })
            });
        });
    </script>
    @endpush