@extends('layouts.app')

@section('title', 'Edit Katering - ' . $katering->name . ' - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('katerings.index') }}">Katering</a>
                <span class="separator">›</span>
                <a href="{{ route('katerings.show', $katering->id) }}">{{ $katering->name }}</a>
                <span class="separator">›</span>
                <span class="current">Edit</span>
            </nav>
            <h1>Edit Katering</h1>
            <p>Perbarui informasi katering Anda</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="section">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-card">
                <div class="form-intro">
                    <div class="intro-icon">🏪</div>
                    <h2>{{ $katering->name }}</h2>
                    <p>Edit informasi katering Anda di bawah ini.</p>
                </div>

                <form action="{{ route('katerings.update', $katering->id) }}" method="POST" class="katering-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label class="form-label" for="name">
                            <span class="label-icon">📝</span>
                            Nama Katering
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-input @error('name') is-invalid @enderror" 
                            value="{{ old('name', $katering->name) }}"
                            placeholder="Contoh: Dapur Mama Delicious"
                            required
                        >
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="description">
                            <span class="label-icon">📋</span>
                            Deskripsi Katering
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            class="form-input form-textarea @error('description') is-invalid @enderror" 
                            rows="5"
                            placeholder="Ceritakan tentang katering Anda..."
                        >{{ old('description', $katering->description) }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('katerings.show', $katering->id) }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span>💾</span> Simpan Perubahan
                        </button>
                    </div>
                </form>
                
                <!-- Danger Zone -->
                <div class="danger-zone">
                    <h4>Zona Berbahaya</h4>
                    <p>Hapus katering ini beserta semua menu yang terkait. Aksi ini tidak dapat dibatalkan.</p>
                    <form action="{{ route('katerings.destroy', $katering->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus katering ini beserta semua menunya? Aksi ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <span>🗑️</span> Hapus Katering
                        </button>
                    </form>
                </div>
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
        flex-wrap: wrap;
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
        padding: 48px;
        box-shadow: var(--shadow-lg);
        max-width: 700px;
        margin: 0 auto;
    }
    
    .form-intro {
        text-align: center;
        margin-bottom: 40px;
    }
    .intro-icon {
        font-size: 4rem;
        margin-bottom: 16px;
    }
    .form-intro h2 {
        font-size: 1.75rem;
        margin-bottom: 12px;
    }
    .form-intro p {
        color: var(--gray-500);
    }
    
    .form-group {
        margin-bottom: 28px;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-weight: 600;
        color: var(--gray-700);
        font-size: 1rem;
    }
    
    .label-icon {
        font-size: 1.1rem;
    }
    
    .form-input {
        width: 100%;
        padding: 16px 20px;
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
    
    .form-textarea {
        resize: vertical;
        min-height: 140px;
    }
    
    .form-error {
        display: block;
        margin-top: 8px;
        font-size: 0.85rem;
        color: #dc2626;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        padding-top: 28px;
        border-top: 1px solid var(--gray-200);
    }
    
    .danger-zone {
        margin-top: 48px;
        padding: 24px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius);
    }
    
    .danger-zone h4 {
        color: #dc2626;
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .danger-zone p {
        color: #7f1d1d;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }
    
    .btn-danger {
        background: #dc2626;
        color: var(--white);
        padding: 12px 24px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: var(--radius);
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-danger:hover {
        background: #b91c1c;
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 28px;
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
