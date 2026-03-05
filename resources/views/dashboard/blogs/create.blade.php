@extends('layouts.masterDashboard')

@section('title', 'Tambah Blog — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Tambah Blog Baru</h6>
                <a href="{{ route('dashboard.blogs.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title" class="form-control-label">Judul Blog</label>
                                <input class="form-control" type="text" id="title" name="title" placeholder="Masukkan judul blog" required>
                            </div>

                            <div class="form-group">
                                <label for="editor" class="form-control-label">Konten Blog</label>
                                <textarea id="editor" name="content"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-none border">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="thumbnail" class="form-control-label">Thumbnail</label>
                                        <div class="mb-3">
                                            <div id="preview-thumbnail" class="border-radius-lg border mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 200px; overflow: hidden; background: #f8f9fa;">
                                                <img id="img-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                <i id="placeholder-icon" class="fas fa-image text-secondary opacity-5 fa-3x"></i>
                                            </div>
                                            <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this)">
                                            <p class="text-xs text-secondary mt-2">Format: JPG, PNG, WEBP. Maks: 2MB</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="author" class="form-control-label">Penulis / Author</label>
                                        <input class="form-control" type="text" id="author" name="author" value="Admin" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="status" class="form-control-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="published" selected>Published</option>
                                            <option value="draft">Draft (Simpan Saja)</option>
                                        </select>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary w-100">Simpan Blog</button>
                                        <button type="reset" class="btn btn-outline-secondary w-100 mt-2">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Summernote CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
    .note-editor .note-editable {
        background-color: #fff;
        min-height: 400px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#editor').summernote({
            placeholder: 'Tulis konten blog di sini...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                }
            }
        });

        function uploadImage(file) {
            let data = new FormData();
            data.append("upload", file);
            $.ajax({
                url: "{{ route('dashboard.blogs.upload') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.uploaded) {
                        $('#editor').summernote('insertImage', response.url);
                    }
                },
                error: function(data) {
                    console.error(data);
                }
            });
        }
    });

    function previewImage(input) {
        const preview = document.getElementById('img-preview');
        const icon = document.getElementById('placeholder-icon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
