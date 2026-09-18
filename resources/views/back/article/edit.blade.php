@extends('back.layout.template')

@section('title', 'Edit Artikel - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-utensils"></i>Edit Artikel</h1>
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

            <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $article->title) }}" placeholder="Judul Artikel..." autofocus>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="published"
                                {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Publish</option>
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>
                                Draft</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Deskripsi Ringkas</label>
                        <textarea name="content" id="myeditor" rows="3"
                            class="form-control @error('content') is-invalid @enderror"
                            placeholder="">{{ old('content', $article->content) }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Ganti Foto Artikel <small class="text-muted">(Biarkan
                                kosong jika tidak diubah)</small></label>
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($article->image)
                        <div class="mt-1">
                            <small class="text-muted d-block">Foto Saat Ini:</small>
                            <img src="{{ asset('storage/back/article-images/' . $article->image) }}"
                                alt="{{ $article->title }}" class="img-thumbnail" style="height: 80px;">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui Artikel</button>
                    <a href="{{ route('article.index') }}" class="btn btn-outline-secondary">Batal</a>
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

</script>

<script>
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
