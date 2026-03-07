@extends('layouts.masterDashboard')

@section('title', 'Tambah Produk — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Tambah Produk Baru</h6>
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama Produk</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Masukkan nama produk" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id" class="form-control-label">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-control-label">Harga (Rp)</label>
                                <input class="form-control" type="number" id="price" name="price" placeholder="Contoh: 350000" required>
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <hr class="horizontal dark mt-0">
                            <h6 class="text-sm">Varian Ukuran & Stok</h6>
                            <p class="text-xs text-secondary">Tentukan ukuran yang tersedia (S, M, L, XL, dll) beserta stoknya masing-masing.</p>
                            
                            <div id="size-container">
                                <div class="row size-row mb-3">
                                    <div class="col-md-5">
                                        <input type="text" name="sizes[]" class="form-control" placeholder="Ukuran (S, M, L, XL, atau All Size)" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" name="size_stocks[]" class="form-control" placeholder="Jumlah Stok" required min="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-icon-only remove-size w-100" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-size" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Ukuran
                            </button>
                            <hr class="horizontal dark">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="form-control-label">Deskripsi Produk</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Jelaskan detail produk, bahan, ukuran, dll."></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr class="horizontal dark mt-0">
                            <h6 class="text-sm">Foto Produk</h6>
                            <p class="text-xs text-secondary">Tambahkan foto produk satu per satu. Foto pertama akan menjadi foto utama.</p>
                            
                            <div id="image-container">
                                <div class="row image-row mb-3 align-items-center">
                                    <div class="col-md-2">
                                        <div class="preview-container border-radius-lg border" style="width: 80px; height: 80px; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            <img class="img-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                            <i class="fas fa-image text-secondary opacity-5 preview-placeholder"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <input class="form-control image-input" type="file" name="images[]" accept="image/*" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" type="text" name="image_colors[]" placeholder="Keterangan Warna (e.g. Black)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-icon-only remove-image w-100" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-image" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Gambar
                            </button>
                            <hr class="horizontal dark">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-control-label d-block">Status Produk</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="status" name="status" value="active" checked>
                                <label class="form-check-label ms-2" for="status">Aktif (Muncul di Web)</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label d-block">Label Khusus</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_best_seller" name="is_best_seller" value="1">
                                <label class="form-check-label ms-2" for="is_best_seller">Best Seller</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label d-block">&nbsp;</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_recommended" name="is_recommended" value="1">
                                <label class="form-check-label ms-2" for="is_recommended">Produk Rekomendasi</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="reset" class="btn btn-light btn-sm me-2">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('size-container');
        const addButton = document.getElementById('add-size');

        addButton.addEventListener('click', function() {
            const firstRow = container.querySelector('.size-row');
            const newRow = firstRow.cloneNode(true);
            
            // Clear inputs in the new row
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            
            // Enable remove button in the new row
            const removeBtn = newRow.querySelector('.remove-size');
            removeBtn.disabled = false;
            
            container.appendChild(newRow);
            updateRemoveButtons();
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-size')) {
                const row = e.target.closest('.size-row');
                if (container.querySelectorAll('.size-row').length > 1) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.size-row');
            if (rows.length > 0) {
                const firstRemoveBtn = rows[0].querySelector('.remove-size');
                firstRemoveBtn.disabled = (rows.length === 1);
            }
        }

        // --- DYNAMIC IMAGE ROWS ---
        const imageContainer = document.getElementById('image-container');
        const addImageButton = document.getElementById('add-image');

        addImageButton.addEventListener('click', function() {
            const firstRow = imageContainer.querySelector('.image-row');
            const newRow = firstRow.cloneNode(true);
            
            // Clear inputs and preview in the new row
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            const previewImg = newRow.querySelector('.img-preview');
            const placeholder = newRow.querySelector('.preview-placeholder');
            previewImg.src = '';
            previewImg.style.display = 'none';
            placeholder.style.display = 'block';
            
            // Enable remove button in the new row
            const removeBtn = newRow.querySelector('.remove-image');
            removeBtn.disabled = false;
            
            imageContainer.appendChild(newRow);
            updateImageRemoveButtons();
        });

        imageContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('image-input')) {
                const input = e.target;
                const row = input.closest('.image-row');
                const previewImg = row.querySelector('.img-preview');
                const placeholder = row.querySelector('.preview-placeholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        placeholder.style.display = 'none';
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                }
            }
        });

        imageContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-image')) {
                const row = e.target.closest('.image-row');
                if (imageContainer.querySelectorAll('.image-row').length > 1) {
                    row.remove();
                    updateImageRemoveButtons();
                }
            }
        });

        function updateImageRemoveButtons() {
            const rows = imageContainer.querySelectorAll('.image-row');
            if (rows.length > 0) {
                const firstRemoveBtn = rows[0].querySelector('.remove-image');
                firstRemoveBtn.disabled = (rows.length === 1);
            }
        }
    });
</script>
@endpush
