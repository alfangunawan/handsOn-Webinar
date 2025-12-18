@extends('layouts.app')

@section('title', 'Daftarkan Katering - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="separator">›</span>
                <a href="{{ route('katerings.index') }}">Katering</a>
                <span class="separator">›</span>
                <span class="current">Daftarkan Katering</span>
            </nav>
            <h1>Daftarkan Katering Baru</h1>
            <p>Daftarkan usaha katering Anda dan mulai menjangkau lebih banyak pelanggan</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="section">
        <div class="container">
            <div class="form-card">
                <div class="form-intro">
                    <div class="intro-icon">🏪</div>
                    <h2>Bergabung Bersama MealLink</h2>
                    <p>Isi informasi katering Anda untuk mulai menawarkan menu lezat kepada pelanggan di seluruh Indonesia.</p>
                </div>

                <form action="{{ route('katerings.store') }}" method="POST" class="katering-form">
                    @csrf
                    
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
                            value="{{ old('name') }}"
                            placeholder="Contoh: Dapur Mama Delicious"
                            required
                        >
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Nama yang menarik dan mudah diingat pelanggan</span>
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
                            placeholder="Ceritakan tentang katering Anda... Apa yang membuat katering Anda spesial? Jenis makanan apa yang Anda tawarkan?"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <span class="form-hint">Deskripsi yang menarik membantu pelanggan mengenal katering Anda</span>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('katerings.index') }}" class="btn btn-outline">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span>✨</span> Daftarkan Katering
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
        max-width: 500px;
        margin: 0 auto;
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
    
    .form-hint {
        display: block;
        margin-top: 8px;
        font-size: 0.85rem;
        color: var(--gray-400);
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        padding-top: 28px;
        border-top: 1px solid var(--gray-200);
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
