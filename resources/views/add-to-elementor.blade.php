@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <h1 class="dashboard-title">📝 Tilføj indhold til Elementor-side</h1>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            ✅ {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="form-container" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;">
        <form method="POST" action="{{ route('elementor.add') }}">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="page_id" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Vælg Elementor-side:</label>
                <select name="page_id" id="page_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">-- Vælg side --</option>
                    @foreach($pages as $page)
                        <option value="{{ $page['id'] }}">{{ $page['title']['rendered'] }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="content" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Tekst:</label>
                <textarea name="content" id="content" rows="6" required placeholder="Skriv din tekst her..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit;"></textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="comment" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Kommentar (valgfrit):</label>
                <input type="text" name="comment" id="comment" placeholder="Din kommentar..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <button type="submit" style="background: #0073aa; color: white; padding: 1rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: bold; width: 100%;">
                ➕ Tilføj til Elementor-side
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="/wordpress-dashboard" style="color: #0073aa; text-decoration: none;">← Tilbage til dashboard</a>
        </div>
    </div>
</div>
@endsection