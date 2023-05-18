@extends('layouts.app')

@section('content')
<div class="container">
    @include('response')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ isset($product) ? __('Edit Product') : __('Create Product') }}</div>
                <div class="card-body">
                    <form id="form" enctype="multipart/form-data"  method="POST"  @if(isset($product)) action="{{ route('product.update', $product->id) }}" @else action="{{ route('product.store') }}" @endif>
                        @csrf
                        @if (isset($product))
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif
                        <div class="form-group mb-3">
                          <label for="productName" class="form-label" >Product Name</label>
                          <input type="text" class="form-control" name="name" id="productName" placeholder="Enter product name" value="{{ isset($product) ? $product->name :  old('name') }}" maxlength="255" required>
                            <span class="text-danger">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                          <label for="productDescription" class="form-label">Product Description</label>
                          <textarea class="form-control" name="description" id="productDescription" placeholder="Enter product description" required>{{ isset($product) ? $product->description : old('description') }}</textarea>
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="productPrice" class="form-label">Product Price</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="number" class="form-control" name="price" id="productPrice" placeholder="Enter product price" value="{{ isset($product) ? $product->price : old('price') }}" min="0" required>
                            </div>
                            <span class="text-danger">
                                @error('price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="imgUpload" class="form-label">Images</label>
                            @if (isset($product))
                                @php
                                    $filePaths = [];
                                @endphp
                                @if (isset($product))
                                    @foreach ($product->images as $image)
                                        @php
                                            $filePaths[] = asset('storage/products/'.$image->image);
                                        @endphp
                                    @endforeach
                                @endif
                                @php
                                    $filePathsJson = json_encode($filePaths);
                                @endphp
                                <input name="image[]" type="file" id="image" class="form-control filepond" data-file="{{ $filePathsJson }}" multiple required>
                            @else
                             <input name="image[]" type="file" id="image" class="form-control" multiple required>
                            @endif
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">{{ isset($product) ? "Update" : "Create" }}</button>
                        <a class="btn btn-danger btn-lg" href="{{ url()->previous() }}" role="button">Cancle</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@isset ($product)
<script>
    let productModel = {!! json_encode($product) !!};
    if(productModel){
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('input[type="file"]');

        const file = inputElement.dataset.file;
        const fileArray = JSON.parse(file);

        const pond = FilePond.create(inputElement,{
            allowFileSizeValidation: true,
            allowFileTypeValidation: true,
            maxFileSize: '2MB',
            labelMaxFileSizeExceeded: 'File is too large',
            labelFileTypeNotAllowed: 'File of invalid type',
            fileValidateTypeLabelExpectedTypes: 'Only image files are allowed.',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg'],
        });
        FilePond.setOptions({
            server: {
                process: '{{ route('temp.product.upload') }}',
                revert: '{{ route('temp.product.delete') }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
            },
        });
        pond.addFiles(fileArray);
    }
</script>
@endisset
<script type="text/javascript">
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        const inputElement = document.querySelector('input[type="file"]');
        const pond = FilePond.create(inputElement,{
            allowFileSizeValidation: true,
            allowFileTypeValidation: true,
            maxFileSize: '2MB',
            labelMaxFileSizeExceeded: 'File is too large',
            labelFileTypeNotAllowed: 'File of invalid type',
            fileValidateTypeLabelExpectedTypes: 'Only image files are allowed.',
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg'],
        });
        FilePond.setOptions({
            server: {
                // process:{
                //     url:'{{ route('temp.product.upload') }}',
                //     onload:(response) =>{
                //         if(response.error){
                //             location.reload();
                //         }
                //     }
                // },
                process: '{{ route('temp.product.upload') }}',
                revert: '{{ route('temp.product.delete') }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
            },

        });
</script>

@endsection
