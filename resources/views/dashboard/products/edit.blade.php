@extends('layouts.masterDashboard')

@section('title', 'Edit Produk — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Edit Produk: {{ $product->name }}</h6>
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama Produk</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id" class="form-control-label">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="price" class="form-control-label">Harga (Rp)</label>
                                <input class="form-control" type="number" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="Contoh: 350000" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="discount_price" class="form-control-label">Harga Diskon (Rp) <small class="text-secondary italic font-normal">— Opsional</small></label>
                                <input class="form-control" type="number" id="discount_price" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" placeholder="Harga setelah diskon">
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <hr class="horizontal dark mt-0">

                            <!-- Dedicated Cover Image Upload -->
                            <div class="mb-4 p-3 border rounded" style="background: #fffef5; border-color: #f0c040 !important;">
                                <h6 class="text-sm mb-1"><i class="fas fa-image me-2 text-warning"></i>Gambar Cover Produk</h6>
                                <p class="text-xs text-secondary mb-2">Gambar utama yang tampil di katalog dan beranda. Upload baru untuk mengganti. <strong class="text-warning">Opsional</strong> — jika tidak diubah, cover lama tetap dipakai.</p>
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="border rounded" style="width: 80px; height: 80px; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            @if($product->cover_image)
                                                <img id="cover-preview" src="{{ asset('storage/' . $product->cover_image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img id="cover-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                <i class="fas fa-image text-secondary opacity-5" id="cover-placeholder"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control form-control-sm" type="file" name="cover_image" id="cover_image_input" accept="image/*">
                                        @if($product->cover_image)
                                            <p class="text-xs text-info mt-1 mb-0"><i class="fas fa-info-circle me-1"></i>Sudah ada cover. Upload baru untuk mengganti.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h6 class="text-sm">Variasi Produk (Warna &amp; Ukuran)</h6>
                            <p class="text-xs text-secondary">Kelola foto produk, nama warna, dan varian ukuran di bawahnya. Centang "Hapus" jika ingin membuang warna tertentu sepenuhnya.</p>
                            
                            <!-- EXISTING VARIATIONS -->
                            <div id="existing-variation-container" class="mb-5">
                                <h6 class="text-xs font-weight-bold text-uppercase text-secondary mb-3">Variasi Saat Ini</h6>
                                @foreach($product->images as $index => $image)
                                <div class="variation-group existing-variation-group border p-3 mb-4 rounded bg-white shadow-sm">
                                    <div class="row align-items-center mb-3 pb-2 border-bottom">
                                        <div class="col-md-2">
                                            <div class="preview-container border-radius-lg border" style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                <img src="{{ asset('storage/' . $image->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-xs">Foto Saat Ini</label>
                                            <input class="form-control form-control-sm" type="text" value="{{ basename($image->image) }}" readonly>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="text-xs">Nama Warna</label>
                                            <input class="form-control form-control-sm" type="text" name="existing_image_colors[{{ $image->id }}]" value="{{ old('existing_image_colors.' . $image->id, $image->color) }}" placeholder="Keterangan Warna" required>
                                        </div>
                                        <div class="col-md-1 text-end mt-3">
                                            <div class="form-check">
                                                <input class="form-check-input ms-auto" type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_{{ $image->id }}">
                                                <label class="form-check-label text-xs text-danger mb-0" for="delete_{{ $image->id }}">Hapus</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Existing Sizes for this variation -->
                                    <div class="sizes-container ps-3 border-start border-3 border-primary">
                                        <label class="text-xs font-weight-bold text-primary">Ukuran & Stok (Warna Ini):</label>
                                        <div class="size-rows-wrapper form-group">
                                            @foreach($image->sizes as $sizeIndex => $size)
                                            <div class="row size-row mb-2">
                                                <input type="hidden" name="existing_sizes[{{ $image->id }}][{{ $size->id }}][id]" value="{{ $size->id }}">
                                                <div class="col-md-5">
                                                    <input type="text" name="existing_sizes[{{ $image->id }}][{{ $size->id }}][size]" class="form-control form-control-sm" value="{{ $size->size }}" placeholder="Ukuran (S, M, L, XL)" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" name="existing_sizes[{{ $image->id }}][{{ $size->id }}][stock]" class="form-control form-control-sm" value="{{ $size->stock }}" placeholder="Stok" required min="0">
                                                </div>
                                                <div class="col-md-2 text-center">
                                                   <div class="form-check mb-0 mt-1">
                                                       <input class="form-check-input" type="checkbox" name="delete_existing_sizes[]" value="{{ $size->id }}" id="delete_size_{{ $size->id }}">
                                                       <label class="form-check-label text-xs text-danger mb-0" for="delete_size_{{ $size->id }}">Hapus</label>
                                                   </div>
                                                </div>
                                            </div>
                                            @endforeach

                                            <!-- Area for NEW sizes added to EXISTING image -->
                                            <div class="new-sizes-for-existing-wrapper" id="new-sizes-wrapper-{{ $image->id }}">
                                                <!-- Dynamic new sizes go here -->
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-link text-primary btn-sm px-0 mb-0 add-new-size-to-existing" data-image-id="{{ $image->id }}">
                                            <i class="fas fa-plus me-1"></i> Tambah Ukuran Baru di Warna Ini
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- NEW VARIATIONS CONTAINER -->
                            <div id="variation-container">
                                <h6 class="text-xs font-weight-bold text-uppercase text-info mb-3">Tambah Warna Baru (Opsional)</h6>
                                <!-- Dynamic new variations go here -->
                            </div>
                            
                            <button type="button" id="add-variation" class="btn btn-info btn-sm w-100 mb-4">
                                <i class="fas fa-plus me-2"></i>Tambah Warna Baru
                            </button>

                            <div class="mt-4">
                                <h6 class="text-sm">Panduan Ukuran (Size Guide)</h6>
                                <p class="text-xs text-secondary">Upload gambar panduan ukuran baru jika ingin mengganti yang lama.</p>
                                
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div id="size-guide-preview-container" class="border-radius-lg border" style="width: 80px; height: 80px; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            @if($product->size_guide)
                                                <img id="size-guide-preview" src="{{ asset('storage/' . $product->size_guide) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                <i class="fas fa-ruler-combined text-secondary opacity-5 size-guide-placeholder" style="display: none;"></i>
                                            @else
                                                <img id="size-guide-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                                <i class="fas fa-ruler-combined text-secondary opacity-5 size-guide-placeholder"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input class="form-control" type="file" name="size_guide" id="size_guide_input" accept="image/*">
                                        @if($product->size_guide)
                                            <p class="text-xs text-info mt-1 mb-0"><i class="fas fa-info-circle me-1"></i>Sudah ada panduan ukuran. Upload baru untuk mengganti.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-control-label d-block">Status Produk</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="status" name="status" value="active" {{ $product->status == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="status">Aktif (Muncul di Web)</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label d-block">Label Khusus</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_best_seller" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="is_best_seller">Best Seller</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-control-label d-block">&nbsp;</label>
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" id="is_recommended" name="is_recommended" value="1" {{ $product->is_recommended ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="is_recommended">Produk Rekomendasi</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Perbarui Produk</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const existingVariationContainer = document.getElementById('existing-variation-container');
        const variationContainer = document.getElementById('variation-container');
        const addVariationBtn = document.getElementById('add-variation');
        
        let newVariationIndex = 0; // Index for completely new color variations

        // --- 1. DYNAMIC: ADD NEW SIZES TO EXISTING VARIATIONS ---
        if (existingVariationContainer) {
            existingVariationContainer.addEventListener('click', function(e) {
                // Add new size row to existing image
                if (e.target.closest('.add-new-size-to-existing')) {
                    const btn = e.target.closest('.add-new-size-to-existing');
                    const imageId = btn.getAttribute('data-image-id');
                    const wrapper = document.getElementById(`new-sizes-wrapper-${imageId}`);
                    const newSizeIndex = wrapper.children.length; // Count existing dynamic new rows
                    
                    const sizeHtml = `
                        <div class="row size-row mb-2">
                            <div class="col-md-5">
                                <input type="text" name="new_sizes_for_existing[${imageId}][${newSizeIndex}][size]" class="form-control form-control-sm" placeholder="Ukuran Baru (S, M, L)" required>
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="new_sizes_for_existing[${imageId}][${newSizeIndex}][stock]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                            </div>
                            <div class="col-md-2 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-dynamic-size w-100 mt-1">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    wrapper.insertAdjacentHTML('beforeend', sizeHtml);
                }

                // Remove dynamic new size from existing image
                if (e.target.closest('.remove-dynamic-size')) {
                    const row = e.target.closest('.size-row');
                    row.remove();
                    // Indices don't strictly need recalculation here because backend loops over whatever is submitted
                }
            });
        }

        // --- 2. DYNAMIC: ADD COMPLETELY NEW VARIATIONS (IMAGE + COLOR + SIZES) ---
        addVariationBtn.addEventListener('click', function() {
            const html = `
                <div class="variation-group new-variation-group border p-3 mb-4 rounded bg-gray-50">
                    <div class="row align-items-center mb-3 pb-2 border-bottom">
                        <div class="col-md-2">
                            <div class="preview-container border-radius-lg border bg-white" style="width: 80px; height: 80px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img class="img-preview" src="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                <i class="fas fa-image text-secondary opacity-5 preview-placeholder"></i>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="text-xs">Foto Baju Warna Baru</label>
                            <input class="form-control image-input form-control-sm" type="file" name="new_images[]" accept="image/*" required>
                        </div>
                        <div class="col-md-4">
                            <label class="text-xs">Nama Warna Baru</label>
                            <input class="form-control form-control-sm" type="text" name="new_image_colors[]" placeholder="e.g. Hijau Army" required>
                        </div>
                        <div class="col-md-1 text-end mt-4">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-new-variation w-100">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Sizes for this NEW variation -->
                    <div class="sizes-container ps-3 border-start border-3 border-info">
                        <label class="text-xs font-weight-bold text-info">Ukuran & Stok untuk Warna Baru Ini:</label>
                        <div class="size-rows-wrapper">
                            <div class="row size-row mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="new_sizes[${newVariationIndex}][]" class="form-control form-control-sm" placeholder="Ukuran (S, M, L, XL)" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="new_size_stocks[${newVariationIndex}][]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-new-size w-100" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-link text-info btn-sm px-0 mb-0 add-size-to-new-variation" data-variation-index="${newVariationIndex}">
                            <i class="fas fa-plus me-1"></i> Tambah Ukuran di Warna Ini
                        </button>
                    </div>
                </div>
            `;
            
            variationContainer.insertAdjacentHTML('beforeend', html);
            newVariationIndex++;
        });

        // --- 3. DYNAMIC: ACTIONS INSIDE COMPLETELY NEW VARIATIONS ---
        variationContainer.addEventListener('click', function(e) {
            // Add Size to New Variation
            if (e.target.closest('.add-size-to-new-variation')) {
                const btn = e.target.closest('.add-size-to-new-variation');
                const vIndex = btn.getAttribute('data-variation-index');
                const sizesWrapper = btn.previousElementSibling; // .size-rows-wrapper
                
                const sizeHtml = `
                    <div class="row size-row mb-2">
                        <div class="col-md-5">
                            <input type="text" name="new_sizes[${vIndex}][]" class="form-control form-control-sm" placeholder="Ukuran (S, M, L, XL)" required>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="new_size_stocks[${vIndex}][]" class="form-control form-control-sm" placeholder="Stok" required min="0">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-icon-only remove-new-size w-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                sizesWrapper.insertAdjacentHTML('beforeend', sizeHtml);
                const rows = sizesWrapper.querySelectorAll('.row');
                if(rows.length > 0) rows[0].querySelector('.remove-new-size').disabled = false;
            }
            
            // Remove Size from New Variation
            if (e.target.closest('.remove-new-size')) {
                const row = e.target.closest('.size-row');
                const wrapper = row.closest('.size-rows-wrapper');
                if (wrapper.querySelectorAll('.size-row').length > 1) {
                    row.remove();
                    const remainingRows = wrapper.querySelectorAll('.size-row');
                    if (remainingRows.length === 1) {
                        remainingRows[0].querySelector('.remove-new-size').disabled = true;
                    }
                }
            }

            // Remove Entire New Variation Group
            if (e.target.closest('.remove-new-variation')) {
                const group = e.target.closest('.new-variation-group');
                group.remove();
                updateNewVariationIndices();
            }
        });

        function updateNewVariationIndices() {
            const groups = variationContainer.querySelectorAll('.new-variation-group');
            groups.forEach((group, index) => {
                const sizeInputs = group.querySelectorAll('input[name^="new_sizes["]');
                sizeInputs.forEach(input => input.name = `new_sizes[${index}][]`);
                
                const stockInputs = group.querySelectorAll('input[name^="new_size_stocks["]');
                stockInputs.forEach(input => input.name = `new_size_stocks[${index}][]`);
                
                const addBtn = group.querySelector('.add-size-to-new-variation');
                if (addBtn) addBtn.setAttribute('data-variation-index', index);
            });
            newVariationIndex = groups.length;
        }

        // --- 4. IMAGE PREVIEW (Event Delegation for new variations) ---
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

        // --- Size Guide Preview ---
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
