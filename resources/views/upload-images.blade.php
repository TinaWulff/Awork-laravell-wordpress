@extends('layouts.app')

@section('content')
<div class="function-container">
    <div class="back-link">
        <a href="/wordpress-dashboard">← Tilbage til dashboard</a>
    </div>

    <div class="function-card">
        <h1 class="function-title">Upload billeder til Media Library</h1>
        <p class="function-description">Upload billeder direkte til dit WordPress Media Library</p>
        
        <form method="POST" action="/upload-media" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="media" class="form-label">Vælg billede:</label>
                <label for="media" class="custom-file-upload" id="file-label">
                    📁 Vælg billede fra computer
                </label>
                <input type="file" name="media" id="media" accept="image/*" required class="form-file">
                <div class="file-name" id="file-name"></div>
            </div>

            <div class="form-group-large">
                <label for="comment" class="form-label">Kommentar til billede (valgfrit):</label>
                <input type="text" name="comment" id="comment" placeholder="Din kommentar" class="form-input">
            </div>

            <button type="submit" class="submit-button">Upload til Media Library</button>
        </form>
    </div>

    <!-- Success/Error beskeder -->
    @if(session('success'))
        <div class="message success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
