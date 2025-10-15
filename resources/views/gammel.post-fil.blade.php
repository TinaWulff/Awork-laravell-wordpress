@extends('layouts.app')

@section('content')
<div class="flex-container" style="display: flex; gap: 2rem; flex-wrap: wrap;">
    <!-- ... Artikel for upload billeder ... -->
    <article class="function-block" style="border: 1px solid #ddd; padding: 2rem; border-radius: 8px; flex: 1; min-width: 350px;">
    <h2>Upload billeder til din hjemmeside</h2>
    <form method="POST" action="/upload-media" enctype="multipart/form-data">
        @csrf

        <label for="media">Vælg billede:</label><br>
        <input type="file" name="media" id="media" accept="image/*" required><br><br>

        <label for="upload_type">Vælg upload-type:</label><br>
        <select name="upload_type" id="upload_type">
            <option value="library">Upload til bibliotek</option>
            <option value="page">Upload og indsæt på eksisterende side</option>
        </select><br><br>

        <label for="page_id">Vælg side (kun hvis du vil indsætte på side):</label><br>
        <select name="page_id" id="page_id">
            <option value="">--Vælg side--</option>
            @foreach($pages as $page)
                <option value="{{ $page['id'] }}">{{ $page['title']['rendered'] }}</option>
            @endforeach
        </select><br><br>

        <label for="comment">Kommentar til billede (valgfrit):</label><br>
        <input type="text" name="comment" id="comment" placeholder="Din kommentar"><br><br>

        <button type="submit">Upload billede</button>
    </form>
    </article>


    <!-- Tilføj tekst til hjemmeside -->
    <article class="function-block" style="border: 1px solid #ddd; padding: 2rem; border-radius: 8px; flex: 1; min-width: 350px;">
        <h2>Tilføj tekst til hjemmeside</h2>
        <form method="POST" action="/add-content">
            @csrf

            <label for="content_type">Vælg:</label><br>
            <select name="content_type" id="content_type" onchange="toggleContentForm()">
                <option value="existing">Upload til eksisterende side</option>
                <option value="new">Opret ny side</option>
            </select><br><br>

            <div id="existingPageFields">
                <label for="page_id_text">Vælg side:</label><br>
                <select name="page_id" id="page_id_text">
                    <option value="">--Vælg side--</option>
                    @foreach($pages as $page)
                        <option value="{{ $page['id'] }}">{{ $page['title']['rendered'] }}</option>
                    @endforeach
                </select><br><br>
            </div>

            <div id="newPageFields" style="display:none;">
                <label for="new_title">Titel på ny side:</label><br>
                <input type="text" name="new_title" id="new_title"><br><br>
            </div>

            <label for="content">Tekst til side:</label><br>
            <textarea name="content" id="content" rows="5" placeholder="Skriv din tekst her"></textarea><br><br>

            <label for="comment_text">Kommentar til tekst (valgfrit):</label><br>
            <input type="text" name="comment" id="comment_text" placeholder="Din kommentar"><br><br>

            <button type="submit">Tilføj tekst</button>
        </form>
    </article>
</div>

@if(session('success'))
    <div style="color:green; font-weight:bold; margin-top: 2rem;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color:red; font-weight:bold; margin-top: 2rem;">{{ session('error') }}</div>
@endif

<script>
function toggleContentForm() {
    var type = document.getElementById('content_type').value;
    document.getElementById('existingPageFields').style.display = type === 'existing' ? 'block' : 'none';
    document.getElementById('newPageFields').style.display = type === 'new' ? 'block' : 'none';
}
</script>




@endsection