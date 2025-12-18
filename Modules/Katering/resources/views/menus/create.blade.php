@extends('layouts.app')

@section('title', 'Tambah Menu Baru - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('menus.index') }}">Menu</a>
                <span class="separator">›</span>
                <span class="current">Tambah Menu</span>
            </nav>
            <h1>Tambah Menu Baru</h1>
            <p>Tambahkan menu baru ke dalam katalog katering Anda</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="section">
        <div class="container">
            <div class="form-card">
                <form action="{{ route('menus.store') }}" method="POST" class="menu-form">
                    @csrf
                    
                    <div class="form-grid">
                        <!-- Katering Selection -->
                        <div class="form-group full-width">
                            <label class="form-label" for="katering_id">
                                <span class="label-icon">🏪</span>
                                Pilih Katering
                            </label>
                            <select name="katering_id" id="katering_id" class="form-input form-select @error('katering_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Katering --</option>
                                @isset($katerings)
                                    @foreach($katerings as $katering)
                                        <option value="{{ $katering->id }}" {{ old('katering_id') == $katering->id ? 'selected' : '' }}>
                                            {{ $katering->name }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('katering_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Menu Name -->
                        <div class="form-group full-width">
                            <label class="form-label" for="name">
                                <span class="label-icon">🍽️</span>
                                Nama Menu
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-input @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}"
                                placeholder="Contoh: Nasi Goreng Special"
                                required
                            >
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="form-group full-width">
                            <label class="form-label" for="description">
                                <span class="label-icon">📝</span>
                                Deskripsi Menu
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="form-input form-textarea @error('description') is-invalid @enderror" 
                                rows="4"
                                placeholder="Deskripsikan menu Anda dengan detail yang menarik..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div class="form-group">
                            <label class="form-label" for="price">
                                <span class="label-icon">💰</span>
                                Harga per Porsi
                            </label>
                            <div class="price-input-wrapper">
                                <span class="price-prefix">Rp</span>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    class="form-input price-input @error('price') is-invalid @enderror" 
                                    value="{{ old('price') }}"
                                    placeholder="25000"
                                    min="0"
                                    step="500"
                                    required
                                >
                            </div>
                            @error('price')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Preview Card -->
                    <div class="preview-section">
                        <h3>Preview Menu</h3>
                        <div class="menu-card preview-card">
                            <div class="menu-image">🍽️</div>
                            <div class="menu-content">
                                <span class="menu-category">Katering</span>
                                <h3 id="preview-name">Nama Menu</h3>
                                <p id="preview-desc">Deskripsi menu akan muncul di sini...</p>
                                <div class="menu-footer">
                                    <div class="menu-price">Rp <span id="preview-price">0</span> <span>/porsi</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('menus.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span>✨</span> Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        font-size: 0.9rem;
    }
    .breadcrumb a {
        color: var(--gray-400);
        transition: var(--transition);
    }
    .breadcrumb a:hover {
        color: var(--primary);
    }
    .breadcrumb .separator {
        color: var(--gray-500);
    }
    .breadcrumb .current {
        color: var(--white);
    }
    
    .form-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: var(--shadow-lg);
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--gray-700);
    }
    
    .label-icon {
        font-size: 1.1rem;
    }
    
    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius);
        font-size: 1rem;
        font-family: inherit;
        transition: var(--transition);
        background: var(--white);
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }
    
    .form-input.is-invalid {
        border-color: #dc2626;
    }
    
    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 20px;
        padding-right: 40px;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }
    
    .price-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .price-prefix {
        position: absolute;
        left: 16px;
        font-weight: 600;
        color: var(--gray-500);
    }
    
    .price-input {
        padding-left: 50px;
    }
    
    .form-error {
        display: block;
        margin-top: 6px;
        font-size: 0.85rem;
        color: #dc2626;
    }
    
    .preview-section {
        background: var(--gray-50);
        padding: 24px;
        border-radius: var(--radius);
        margin-bottom: 32px;
    }
    
    .preview-section h3 {
        font-size: 1rem;
        margin-bottom: 16px;
        color: var(--gray-600);
    }
    
    .preview-card {
        max-width: 320px;
        margin: 0 auto;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        padding-top: 24px;
        border-top: 1px solid var(--gray-200);
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column-reverse;
        }
        
        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Live Preview
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    
    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-desc');
    const previewPrice = document.getElementById('preview-price');
    
    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nama Menu';
    });
    
    descInput.addEventListener('input', function() {
        previewDesc.textContent = this.value || 'Deskripsi menu akan muncul di sini...';
    });
    
    priceInput.addEventListener('input', function() {
        const price = parseInt(this.value) || 0;
        previewPrice.textContent = price.toLocaleString('id-ID');
    });
</script>
@endpush
