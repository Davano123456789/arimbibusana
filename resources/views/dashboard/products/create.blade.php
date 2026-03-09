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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price" class="form-control-label">Harga (Rp)</label>
                                <input class="form-control" type="number" id="price" name="price" placeholder="Contoh: 350000" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount_price" class="form-control-label">Harga Diskon (Rp) <small class="text-secondary italic font-normal">— Opsional</small></label>
                                <input class="form-control" type="number" id="discount_price" name="discount_price" placeholder="Harga setelah diskon">
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <hr class="horizontal dark mt-0">
                            
                            <!-- Dedicated Cover Image Section -->
                            <div class="mb-4 p-3 border rounded" style="background: #fffef5; border-color: #f0c040 !important;">
                                <h6 class="text-sm mb-1"><i class="fas fa-image me-2 text-warning"></i>Gambar Cover Produk</h6>
                                <p class="text-xs text-secondary mb-2">Upload gambar yang akan tampil sebagai gambar utama di katalog dan beranda. <strong class="text-warning">Opsional</strong> — jika tidak diisi, foto variasi pertama yang digunakan.</p>
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div id="cover-preview-container" class="border rounded" style="width: 80px; height: 80px; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            <img id="cover-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                            <i class="fas fa-image text-secondary opacity-5" id="cover-placeholder"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" type="file" name="cover_image" id="cover_image_input" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-sm">Variasi Produk (Warna &amp; Ukuran)</h6>
                            <p class="text-xs text-secondary">Tambahkan foto produk untuk setiap warna. Di dalam setiap warna, tentukan ukuran dan stok yang tersedia.</p>
                            
                            <div id="variation-container">
                                <!-- First Variation Group -->
                                <div class="variation-group border p-3 mb-4 rounded bg-gray-50">
                                    <div class="row align-items-center mb-3 pb-2 border-bottom">
                                        <div class="col-md-2">
                                            <div class="preview-container border-radius-lg border bg-white" style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                <img class="img-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                <i class="fas fa-image text-secondary opacity-5 preview-placeholder"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="text-xs">Foto Baju Warna Ini</label>
                                            <input class="form-control image-input form-control-sm" type="file" name="images[]" accept="image/*" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-xs">Nama Warna</label>
                                            <input class="form-control form-control-sm" type="text" name="image_colors[]" placeholder="e.g. Merah Maroon" required>
                                        </div>
                                        <div class="col-md-1 text-end mt-4">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-variation w-100" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Sizes for this variation -->
                                    <div class="sizes-container ps-3 border-start border-3 border-info">
                                        <label class="text-xs font-weight-bold text-info">Ukuran & Stok untuk Warna Ini:</label>
                                        <div class="size-rows-wrapper">
                                            <div class="row size-row mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" name="sizes[0][]" class="form-control form-control-sm" placeholder="Ukuran (S, M, L, XL)" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="size_stocks[0][]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-size w-100" disabled>
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-link text-info btn-sm px-0 mb-0 add-size-to-variation" data-variation-index="0">
                                            <i class="fas fa-plus me-1"></i> Tambah Ukuran di Warna Ini
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-variation" class="btn btn-info btn-sm w-100">
                                <i class="fas fa-plus me-2"></i>Tambah Warna Baru
                            </button>

                            <div class="mt-4">
                                <h6 class="text-sm">Panduan Ukuran (Size Guide)</h6>
                                <p class="text-xs text-secondary">Opsional. Upload gambar panduan ukuran khusus untuk produk ini.</p>
                                
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div id="size-guide-preview-container" class="border-radius-lg border" style="width: 80px; height: 80px; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            <img id="size-guide-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                            <i class="fas fa-ruler-combined text-secondary opacity-5 size-guide-placeholder"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input class="form-control" type="file" name="size_guide" id="size_guide_input" accept="image/*">
                                    </div>
                                </div>
                            </div>
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
        const variationContainer = document.getElementById('variation-container');
        const addVariationBtn = document.getElementById('add-variation');
        let variationIndex = 0; // Starts at 0 because 1 is already in HTML

        // --- 1. DYNAMIC VARIATION GROUPS (IMAGE + COLOR) ---
        addVariationBtn.addEventListener('click', function() {
            variationIndex++;
            
            const html = `
                <div class="variation-group border p-3 mb-4 rounded bg-gray-50">
                    <div class="row align-items-center mb-3 pb-2 border-bottom">
                        <div class="col-md-2">
                            <div class="preview-container border-radius-lg border bg-white" style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img class="img-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                <i class="fas fa-image text-secondary opacity-5 preview-placeholder"></i>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="text-xs">Foto Baju Warna Ini</label>
                            <input class="form-control image-input form-control-sm" type="file" name="images[]" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <label class="text-xs">Nama Warna</label>
                            <input class="form-control form-control-sm" type="text" name="image_colors[]" placeholder="e.g. Biru Navy" required>
                        </div>
                        <div class="col-md-1 text-end mt-4">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-variation w-100">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Sizes for this variation -->
                    <div class="sizes-container ps-3 border-start border-3 border-info">
                        <label class="text-xs font-weight-bold text-info">Ukuran & Stok untuk Warna Ini:</label>
                        <div class="size-rows-wrapper">
                            <div class="row size-row mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="sizes[${variationIndex}][]" class="form-control form-control-sm" placeholder="Ukuran (S, M, L, XL)" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="size_stocks[${variationIndex}][]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-size w-100" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link text-info btn-sm px-0 mb-0 add-size-to-variation" data-variation-index="${variationIndex}">
                            <i class="fas fa-plus me-1"></i> Tambah Ukuran di Warna Ini
                        </button>
                    </div>
                </div>
            `;
            
            variationContainer.insertAdjacentHTML('beforeend', html);
            updateVariationRemoveButtons();
        });

        // --- 2. DYNAMIC SIZES INSIDE A VARIATION ---
        variationContainer.addEventListener('click', function(e) {
            // Add Size
            if (e.target.closest('.add-size-to-variation')) {
                const btn = e.target.closest('.add-size-to-variation');
                const vIndex = btn.getAttribute('data-variation-index');
                const sizesWrapper = btn.previousElementSibling; // .size-rows-wrapper
                
                const sizeHtml = `
                    <div class="row size-row mb-2">
                        <div class="col-md-5">
                            <input type="text" name="sizes[${vIndex}][]" class="form-control form-control-sm" placeholder="Ukuran (S, M, L, XL)" required>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="size_stocks[${vIndex}][]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-size w-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                sizesWrapper.insertAdjacentHTML('beforeend', sizeHtml);
                updateSizeRemoveButtons(sizesWrapper);
            }
            
            // Remove Size
            if (e.target.closest('.remove-size')) {
                const row = e.target.closest('.size-row');
                const wrapper = row.closest('.size-rows-wrapper');
                if (wrapper.querySelectorAll('.size-row').length > 1) {
                    row.remove();
                    updateSizeRemoveButtons(wrapper);
                }
            }

            // Remove Variation
            if (e.target.closest('.remove-variation')) {
                const group = e.target.closest('.variation-group');
                group.remove();
                
                updateVariationRemoveButtons();
                updateVariationIndices();
            }
        });

        function updateSizeRemoveButtons(wrapper) {
            const rows = wrapper.querySelectorAll('.size-row');
            if (rows.length > 0) {
                const firstRemoveBtn = rows[0].querySelector('.remove-size');
                firstRemoveBtn.disabled = (rows.length === 1);
            }
        }

        function updateVariationRemoveButtons() {
            const groups = variationContainer.querySelectorAll('.variation-group');
            if (groups.length > 0) {
                const firstRemoveBtn = groups[0].querySelector('.remove-variation');
                firstRemoveBtn.disabled = (groups.length === 1);
            }
        }

        function updateVariationIndices() {
            const groups = variationContainer.querySelectorAll('.variation-group');
            groups.forEach((group, index) => {
                // Update cover radio value
                const radio = group.querySelector('.cover-radio');
                if (radio) radio.value = index;

                // Update size input names
                const sizeInputs = group.querySelectorAll('input[name^="sizes"]');
                sizeInputs.forEach(input => input.name = `sizes[${index}][]`);
                
                // Update stock input names
                const stockInputs = group.querySelectorAll('input[name^="size_stocks"]');
                stockInputs.forEach(input => input.name = `size_stocks[${index}][]`);
                
                // Update add button data-variation-index
                const addBtn = group.querySelector('.add-size-to-variation');
                if (addBtn) addBtn.setAttribute('data-variation-index', index);
            });
            variationIndex = groups.length - 1; // Sync global index counter
        }

        // --- 3. IMAGE PREVIEW (Event Delegation) ---
        variationContainer.addEventListener('change', function(e) {
            if (e.target.classList.contains('image-input')) {
                const input = e.target;
                const group = input.closest('.variation-group');
                const previewImg = group.querySelector('.img-preview');
                const placeholder = group.querySelector('.preview-placeholder');

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

        // Size Guide Preview
        const sizeGuideInput = document.getElementById('size_guide_input');
        const sizeGuidePreview = document.getElementById('size_guide_preview');
        const sizeGuidePlaceholder = document.querySelector('.size-guide-placeholder');

        if (sizeGuideInput) {
            sizeGuideInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        sizeGuidePreview.src = e.target.result;
                        sizeGuidePreview.style.display = 'block';
                        if (sizeGuidePlaceholder) sizeGuidePlaceholder.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Cover Image Preview
        const coverInput = document.getElementById('cover_image_input');
        const coverPreview = document.getElementById('cover-preview');
        const coverPlaceholder = document.getElementById('cover-placeholder');
        if (coverInput) {
            coverInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        coverPreview.src = e.target.result;
                        coverPreview.style.display = 'block';
                        if (coverPlaceholder) coverPlaceholder.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endpush
