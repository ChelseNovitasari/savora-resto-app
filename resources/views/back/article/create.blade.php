@extends('back.layout.template')

@section('title', 'Tambah Article Baru - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-newspaper me-1"></i>Tambah Article Baru</h1>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            @if ($errors->all())
            <div class="my-3">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ url('article') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" placeholder="Masukkan judul artikel" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Artikel <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" id="myeditor" class="form-control @error('content') is-invalid @enderror"
                        rows="10">{{ old('content') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Thumbnail</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror"
                        accept="image/*" onchange="previewImage(event)" required>
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Preview Gambar --}}
                    <div class="mt-2">
                        <img id="img-preview" src="#" alt="Preview Gambar" class="img-thumbnail d-none"
                            style="max-height: 200px;">
                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-primary">Reset</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Artikel
                        </button>
                        <a href="{{ route('article.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
        clipboard_handleImages: false
    }

    CKEDITOR.replace('myeditor', options);
    // Image Preview
    $("#image").change(function () {
        previewImage(this);
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#img-preview")
                    .attr("src", e.target.result)
                    .removeClass("d-none");
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
@endpush
