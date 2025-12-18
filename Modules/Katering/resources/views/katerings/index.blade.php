@extends('layouts.app')

@section('title', 'Daftar Katering - MealLink')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Daftar Katering</h1>
            <p>Jelajahi berbagai penyedia katering terpercaya untuk kebutuhan Anda</p>
        </div>
    </section>

    <!-- Katering Section -->
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

            <!-- Action Bar -->
            <div class="action-bar">
                <div class="katering-count">
                    <span>{{ $katerings->count() }} Katering Terdaftar</span>
                </div>
                @auth
                    <a href="{{ route('katerings.create') }}" class="btn btn-primary">
                        <span>+</span> Daftarkan Katering
                    </a>
                @endauth
            </div>

            @if($katerings->count() > 0)
                <div class="katering-grid">
                    @foreach($katerings as $katering)
                        <div class="katering-card">
                            <div class="katering-icon">
                                🏪
                            </div>
                            <div class="katering-content">
                                <h3>
                                    <a href="{{ route('katerings.show', $katering->id) }}">
                                        {{ $katering->name }}
                                    </a>
                                </h3>
                                <p>{{ Str::limit($katering->description ?? 'Katering berkualitas dengan berbagai pilihan menu.', 100) }}</p>
                                <div class="katering-stats">
                                    <span class="stat">
                                        <span class="stat-icon">🍽️</span>
                                        {{ $katering->menus->count() }} Menu
                                    </span>
                                </div>
                                <div class="katering-actions">
                                    <a href="{{ route('katerings.show', $katering->id) }}" class="btn btn-outline btn-sm">Lihat Detail</a>
                                    @auth
                                        <a href="{{ route('katerings.edit', $katering->id) }}" class="btn-edit">✏️ Edit</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🏪</div>
                    <h3>Belum Ada Katering</h3>
                    <p>Jadilah yang pertama untuk mendaftarkan katering Anda!</p>
                    @auth
                        <a href="{{ route('katerings.create') }}" class="btn btn-primary btn-lg">Daftarkan Katering</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Daftar</a>
                    @endauth
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding: 16px 24px;
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
    .katering-count {
        color: var(--gray-600);
        font-weight: 500;
    }
    .katering-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }
    .katering-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
        transition: var(--transition);
        display: flex;
        gap: 20px;
    }
    .katering-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    .katering-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-primary);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
    }
    .katering-content {
        flex: 1;
    }
    .katering-content h3 {
        font-size: 1.25rem;
        margin-bottom: 8px;
    }
    .katering-content h3 a {
        color: var(--gray-900);
        text-decoration: none;
        transition: var(--transition);
    }
    .katering-content h3 a:hover {
        color: var(--primary);
    }
    .katering-content p {
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 16px;
        line-height: 1.5;
    }
    .katering-stats {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }
    .stat {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
        color: var(--gray-600);
        background: var(--gray-100);
        padding: 4px 12px;
        border-radius: var(--radius-full);
    }
    .katering-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: var(--gray-100);
        color: var(--gray-600);
        font-size: 0.8rem;
        font-weight: 500;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-edit:hover {
        background: var(--gray-200);
        color: var(--gray-800);
    }
    .btn-sm {
        padding: 8px 16px;
        font-size: 0.85rem;
    }
    @media (max-width: 768px) {
        .action-bar {
            flex-direction: column;
            gap: 16px;
        }
        .katering-grid {
            grid-template-columns: 1fr;
        }
        .katering-card {
            flex-direction: column;
            text-align: center;
        }
        .katering-icon {
            margin: 0 auto;
        }
        .katering-stats, .katering-actions {
            justify-content: center;
        }
    }
</style>
@endpush
