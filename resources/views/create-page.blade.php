@extends('layouts.app')

@section('content')
<div class="function-container">
    <div class="back-link">
        <a href="/wordpress-dashboard">← Tilbage til dashboard</a>
    </div>

    <div class="function-card">
        <h1 class="function-title">Indsend tekst til din hjemmeside</h1>
        <p class="function-description">Indsender din tekst til godkendelse af administrator. Tilføj tekst og eventuelt billeder</p>

        <form method="POST" action="/add-new-page" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="new_title" class="form-label">Side (skriv den side teksten tilføjes):</label>
                <input type="text" name="new_title" id="new_title" required class="form-input">
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Tekst til side:</label>
                <textarea name="content" id="content" rows="8" required placeholder="Skriv din tekst her" class="form-textarea"></textarea>
            </div>

            <div class="form-group">
                <label for="images" class="form-label">Tilføj billeder til siden (valgfrit):</label>
                <label for="images" class="custom-file-upload" id="images-label">
                    📸 Vælg billeder (flere ad gangen)
                </label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple class="form-file">
                <div class="file-name" id="images-name"></div>
            </div>

            <div class="form-group">
                <label for="image_position" class="form-label">Hvor skal billederne placeres?</label>
                <div class="custom-select" id="image-position-select">
                    <div class="select-selected">Øverst på siden</div>
                    <div class="select-items select-hide">
                        <div data-value="top">Øverst på siden</div>
                        <div data-value="bottom">Nederst på siden</div>
                        <div data-value="after_first_paragraph">Efter første afsnit</div>
                    </div>
                    <select name="image_position" id="image_position" style="display: none;">
                        <option value="top" selected>Øverst på siden</option>
                        <option value="bottom">Nederst på siden</option>
                        <option value="after_first_paragraph">Efter første afsnit</option>
                    </select>
                </div>
            </div>

            <div class="form-group-large">
                <label for="comment_text" class="form-label">Kommentar til indholdet (valgfrit):</label>
                <input type="text" name="comment" id="comment_text" placeholder="Din kommentar" class="form-input">
            </div>

            <button type="submit" class="submit-button">Indsend til godkendelse</button>
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
