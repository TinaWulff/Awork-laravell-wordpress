<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class WordPressController extends Controller
{
    public function showForm()
    {
        $user = \App\Models\User::first();
        return view('wordpress-info', compact('user'));
    }

    public function saveForm(Request $request)
    {
        $user = \App\Models\User::first();

        if (!$user) {
            // Opret ny bruger, hvis der ingen findes
            $user = new \App\Models\User();
            $user->name = 'Testbruger'; // Kan ændres til noget mere relevant
            $user->email = 'test@example.com';
            $user->password = bcrypt('hemmelig');
        }

        $user->wp_url = $request->input('wp_url');
        $user->wp_username = $request->input('wp_username');
        $user->wp_app_password = \Crypt::encryptString($request->input('wp_app_password'));
        $user->save();

        return redirect('/wordpress-dashboard')->with('success', 'Oplysninger gemt! Du kan nu bruge WordPress-funktionerne.');
    }

    public function showDashboard()
    {
        return view('wordpress-dashboard');
    }

    public function showUploadForm()
    {
        return view('upload-images');
    }

    public function showCreatePageForm()
    {
        return view('create-page');
    }


public function showPostForm()
{
    // Hent WordPress credentials fra din database
    $user = \App\Models\User::first();
    $wp_url = $user->wp_url;
    $wp_username = $user->wp_username;
    $wp_app_password = $user->wp_app_password ? \Crypt::decryptString($user->wp_app_password) : null;

    // Hent sider fra WordPress via REST API
    $response = Http::withBasicAuth($wp_username, $wp_app_password)
        ->get(rtrim($wp_url, '/') . '/wp-json/wp/v2/pages?per_page=100');

    // Hvis API-kaldet lykkes, brug resultaterne – ellers tomt array
    $pages = $response->successful() ? $response->json() : [];

    // Send $pages til viewet
    return view('wordpress-post', compact('pages'));
}


public function addNewPage(Request $request)
{
    // Valider input
    $request->validate([
        'new_title' => 'required',
        'content' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Hent WordPress credentials fra database
    $user = \App\Models\User::first();
    $wp_url = $user->wp_url;
    $wp_username = $user->wp_username;
    $wp_app_password = $user->wp_app_password ? \Crypt::decryptString($user->wp_app_password) : null;

    $content = $request->input('content');
    $imageHtml = '';

    // Upload billeder hvis der er nogen
    if ($request->hasFile('images')) {
        $uploadedImages = [];
        
        foreach ($request->file('images') as $image) {
            // Upload hvert billede til WordPress Media Library
            $imageContent = file_get_contents($image->getPathname());
            $fileName = $image->getClientOriginalName();
            
            $uploadResponse = Http::withBasicAuth($wp_username, $wp_app_password)
                ->withHeaders([
                    'Content-Type' => $image->getMimeType(),
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ])
                ->withBody($imageContent, $image->getMimeType())
                ->post(rtrim($wp_url, '/') . '/wp-json/wp/v2/media');

            if ($uploadResponse->successful()) {
                $mediaData = $uploadResponse->json();
                $uploadedImages[] = $mediaData;
                
                // Opbyg HTML for billedet
                $imageHtml .= '<figure class="wp-block-image"><img src="' . $mediaData['source_url'] . '" alt="' . $mediaData['alt_text'] . '" /></figure>';
            }
        }

        // Placer billeder baseret på brugerens valg
        $imagePosition = $request->input('image_position', 'top');
        
        switch ($imagePosition) {
            case 'top':
                $content = $imageHtml . $content;
                break;
            case 'bottom':
                $content = $content . $imageHtml;
                break;
            case 'after_first_paragraph':
                // Find første afsnit (efter første </p> tag)
                $paragraphs = explode('</p>', $content);
                if (count($paragraphs) > 1) {
                    $paragraphs[0] .= '</p>' . $imageHtml;
                    $content = implode('</p>', $paragraphs);
                } else {
                    // Hvis der ikke er nogen paragraf-tags, tilføj billederne efter første linjeskift
                    $lines = explode("\n", $content);
                    if (count($lines) > 1) {
                        $lines[0] .= "\n" . $imageHtml;
                        $content = implode("\n", $lines);
                    } else {
                        $content = $content . $imageHtml;
                    }
                }
                break;
        }
    }

    // Tilføj kommentar til content hvis udfyldt
    if ($request->filled('comment')) {
        $comment = $request->input('comment');
        $content .= '<div style="color:blue;"><h3>Kommentar</h3><p>' . e($comment) . '</p></div>';
    }

    // Opret ny side via WordPress REST API
    $response = \Http::withBasicAuth($wp_username, $wp_app_password)
        ->post(rtrim($wp_url, '/') . '/wp-json/wp/v2/pages', [
            'title' => $request->input('new_title'),
            'content' => $content,
            'status' => 'draft' // eller 'publish' hvis du ønsker at udgive med det samme
        ]);

    if ($response->successful()) {
        return back()->with('success', 'Ny side er oprettet i WordPress med billeder!');
    } else {
        return back()->with('error', 'Der skete en fejl: ' . $response->body());
    }
}

public function uploadMedia(Request $request)
{
    // Valider input
    $request->validate([
        'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Hent WordPress credentials fra database
    $user = \App\Models\User::first();
    $wp_url = $user->wp_url;
    $wp_username = $user->wp_username;
    $wp_app_password = $user->wp_app_password ? \Crypt::decryptString($user->wp_app_password) : null;

    // Hent det uploadede billede
    $image = $request->file('media');
    $fileName = $image->getClientOriginalName();
    
    // Læs billedets indhold som binær data
    $imageContent = file_get_contents($image->getPathname());
    
    // Upload til WordPress Media Library via REST API med korrekt format
    $response = Http::withBasicAuth($wp_username, $wp_app_password)
        ->withHeaders([
            'Content-Type' => $image->getMimeType(),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ])
        ->withBody($imageContent, $image->getMimeType())
        ->post(rtrim($wp_url, '/') . '/wp-json/wp/v2/media');

    if ($response->successful()) {
        $mediaData = $response->json();
        $message = 'Billede er uploadet til WordPress Media Library!';
        
        // Tilføj kommentar til billedet hvis udfyldt
        if ($request->filled('comment')) {
            $updateResponse = Http::withBasicAuth($wp_username, $wp_app_password)
                ->put(rtrim($wp_url, '/') . '/wp-json/wp/v2/media/' . $mediaData['id'], [
                    'caption' => [
                        'raw' => $request->input('comment')
                    ]
                ]);
            
            if ($updateResponse->successful()) {
                $message .= ' Kommentar er også tilføjet.';
            }
        }
        
        return back()->with('success', $message);
    } else {
        return back()->with('error', 'Der skete en fejl ved upload: ' . $response->body());
    }
}



    //Til Opdatering af ELEMENTOR-side

    public function addToElementorPage(Request $request)
{
    $request->validate([
        'page_id' => 'required|integer',
        'content' => 'required|string',
        'comment' => 'nullable|string',
    ]);

    // Hent brugerens WordPress credentials
    $user = \App\Models\User::first();
    $wp_url = $user->wp_url;
    $wp_username = $user->wp_username;
    $wp_app_password = $user->wp_app_password ? \Crypt::decryptString($user->wp_app_password) : null;

    // Send til WordPress custom endpoint
    $response = \Http::withoutVerifying()
        ->post(rtrim($wp_url, '/') . '/wp-json/myplugin/v1/add-elementor-content', [
            'page_id' => $request->input('page_id'),
            'content' => $request->input('content'),
            'comment' => $request->input('comment'),
        ]);

    if ($response->successful()) {
        return back()->with('success', 'Indhold er tilføjet til Elementor-siden!');
    } else {
        $errorData = $response->json();
        $errorMessage = $errorData['message'] ?? 'Ukendt fejl';
        return back()->with('error', 'Fejl: ' . $errorMessage);
    }
}
}