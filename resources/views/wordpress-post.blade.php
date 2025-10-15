@extends('layouts.app')

@section('content')
<div class="flex-container" style="display: flex; gap: 2rem; flex-wrap: wrap;">
    <!-- ... Artikel for upload billeder ... -->
    <article class="function-block" style="border: 1px solid #ddd; padding: 2rem; border-radius: 8px; flex: 1; min-width: 350px;">
    <h2>Upload billeder til Media Library</h2>
    <form method="POST" action="/upload-media" enctype="multipart/form-data">
        @csrf

        <label for="media">Vælg billede:</label><br>
        <input type="file" name="media" id="media" accept="image/*" required><br><br>

        <label for="comment">Kommentar til billede (valgfrit):</label><br>
        <input type="text" name="comment" id="comment" placeholder="Din kommentar"><br><br>

        <button type="submit">Upload til Media Library</button>
    </form>
    </article>


    <!-- Tilføj tekst til hjemmeside -->
    <article class="function-block" style="border: 1px solid #ddd; padding: 2rem; border-radius: 8px; flex: 1; min-width: 300px;">
    <h2>Opret ny WordPress-side</h2>

    <form method="POST" action="/add-new-page" enctype="multipart/form-data">
        @csrf

        <label for="new_title">Titel på ny side:</label><br>
        <input type="text" name="new_title" id="new_title" required><br><br>

        <label for="content">Tekst til side:</label><br>
        <textarea name="content" id="content" rows="5" required placeholder="Skriv din tekst her"></textarea><br><br>

        <label for="images">Tilføj billeder til siden (valgfrit):</label><br>
        <input type="file" name="images[]" id="images" accept="image/*" multiple><br>
        <small style="color: #666;">Du kan vælge flere billeder samtidig</small><br><br>

        <label for="image_position">Hvor skal billederne placeres?</label><br>
        <select name="image_position" id="image_position">
            <option value="top">Øverst på siden</option>
            <option value="bottom">Nederst på siden</option>
            <option value="after_first_paragraph">Efter første afsnit</option>
        </select><br><br>

        <label for="comment_text">Kommentar til tekst (valgfrit):</label><br>
        <input type="text" name="comment" id="comment_text" placeholder="Din kommentar"><br><br>

        <button type="submit">Opret side</button>
    </form>
    </article>
</div>

<!-- Success/Error beskeder placeret under articles -->
@if(session('success'))
    <div style="color:green; font-weight:bold; margin-top: 2rem; padding: 1rem; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="color:red; font-weight:bold; margin-top: 2rem; padding: 1rem; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px;">
        {{ session('error') }}
    </div>
@endif

@endsection

    