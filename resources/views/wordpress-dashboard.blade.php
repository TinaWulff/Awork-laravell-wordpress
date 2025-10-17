@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <h1 class="dashboard-title">Send indhold til din hjemmeside</h1>

    <div class="dashboard-cards">
        <!-- Upload billeder knap -->
        <a href="/upload-images" class="dashboard-card-link">
            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    <img src="{{ asset('assets/images/image-to-wordpress.png') }}" alt="Upload billeder">
                </div>
                <h2 class="dashboard-card-title">Upload billeder</h2>
                <p class="dashboard-card-description">Upload billeder til WordPress Media Library</p>
            </div>
        </a>

        <!-- Opret side knap -->
        <a href="/create-page" class="dashboard-card-link">
            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    <img src="{{ asset('assets/images/text-to-wordpress.png') }}" alt="Opret ny side">
                </div>
                <h2 class="dashboard-card-title">Opret ny side</h2>
                <p class="dashboard-card-description">Opret en ny WordPress-side med tekst og billeder</p>
            </div>
        </a>
    


        <!-- NYT: Tilføj til Elementor-side knap -->
        <a href="/add-to-elementor" class="dashboard-card-link">
            <div class="dashboard-card">
                <div class="dashboard-card-icon">
                    📝
                </div>
                <h2 class="dashboard-card-title">Tilføj til Elementor-side</h2>
                <p class="dashboard-card-description">Tilføj nyt indhold til en eksisterende Elementor-side</p>
            </div>
        </a>
    </div>


    <!-- Link tilbage til WordPress-info hvis de vil ændre indstillinger -->
    <div class="dashboard-settings-link">
        <a href="/wordpress-info">⚙️ Ændre WordPress-indstillinger</a>
    </div>
</div>
@endsection
