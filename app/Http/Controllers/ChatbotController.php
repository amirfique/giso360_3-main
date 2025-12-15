<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Handle the chatbot query.
     */
    public function handleQuery(Request $request)
    {
        // 1. Validate the user's request
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $userQuery = $request->input('query');

        try {
            // 2. Get the knowledge base
            
            $knowledgePath = 'knowledge-base'; // The directory storage/app/knowledge-base
            $files = Storage::files($knowledgePath);
            $knowledgeBase = "";

            if (empty($files)) {
                return response()->json(['answer' => 'Sorry, my knowledge base is currently empty.'], 500);
            }

            // Loop through all files in the directory
            foreach ($files as $file) {
                // Only read .txt files (like faq.txt, giso-program.txt, etc.)
                if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
                    // Add the file content and a separator
                    $knowledgeBase .= Storage::get($file) . "\n\n---\n\n";
                }
            }

            // Check if we actually loaded any text
            if (empty(trim($knowledgeBase))) {
                return response()->json(['answer' => 'Sorry, no valid .txt knowledge files were found.'], 500);
            }

            // 3. Get the Gemini API Key from .env
            $apiKey = env('GEMINI_API_KEY');
            if (!$apiKey) {
                return response()->json(['answer' => 'API key is not configured.'], 500);
            }

            // 4. Construct the prompt for Gemini
            $finalPrompt = "You are a helpful assistant for my web application.
            Only answer questions based on the following context.
            If the question cannot be answered by the context, politely say 'I do not have that information.'

            CONTEXT:
            ---
            $knowledgeBase
            ---

            USER'S QUESTION:
            $userQuery
            ";

            // 5. Call the Gemini API using Laravel's Http Client
            
            // <<< THIS IS THE ONLY LINE THAT CHANGED >>>
            $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

            $response = Http::post($apiUrl, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $finalPrompt]
                        ]
                    ]
                ]
            ]);

            // 6. Check for a successful response and send it back
            if ($response->successful()) {
                // The structure of the Gemini response is nested.
                Log::info($response->json());

                // Use optional chaining (?. ) for safety
                $answer = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I could not generate a response.';
                
                return response()->json(['answer' => $answer]);
            } else {
                // Handle API errors
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['answer' => 'There was an error communicating with the AI.'], 502); // Bad Gateway
            }

        } catch (\Exception $e) {
            // Handle any other errors (e.g., file not found)
            Log::error('Chatbot Error: ' . $e->getMessage());
            return response()->json(['answer' => 'An internal server error occurred.'], 500);
        }
    }
}