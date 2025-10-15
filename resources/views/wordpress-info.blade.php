@extends('layouts.app')

@section('content')
<div class="info-container">
    <h1 class="info-title">Indtast dine WordPress-oplysninger</h1>
    
    @if(session('success'))
        <div class="info-message success">
            {{ session('success') }}
        </div>
    @endif

    <div class="info-card">
        <form method="POST" action="/wordpress-info">
            @csrf
            <h2 class="info-subtitle">Opret forbindelse med din WordPress-side</h2>
            <p class="info-description">Indtast oplysningerne for at integrere med din hjemmeside og indsende nyt indhold til implementering på siden</p>
            
            <div class="info-form-group">
                <label for="wp_url" class="info-form-label">WordPress URL:</label>
                <input type="text" name="wp_url" id="wp_url" value="{{ old('wp_url', $user->wp_url ?? '') }}" placeholder="https://ditwordpress.dk" class="info-form-input">
            </div>
            
            <div class="info-form-group">
                <label for="wp_username" class="info-form-label">Brugernavn:</label>
                <input type="text" name="wp_username" id="wp_username" value="{{ old('wp_username', $user->wp_username ?? '') }}" class="info-form-input">
            </div>
            
            <div class="info-form-group-large">
                <label for="wp_app_password" class="info-form-label">App Password:</label>
                <input type="password" name="wp_app_password" id="wp_app_password" value="{{ old('wp_app_password', $user->wp_app_password ?? '') }}" class="info-form-input">
            </div>
            
            <button type="submit" class="info-submit-button">Gem forbindelse</button>
        </form>
    </div>
</div>
@endsection