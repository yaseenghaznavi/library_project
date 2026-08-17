<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

use App\Models\Book;

class ChatController extends Controller
{
    //
    public function chat(Request $request)
    {
        $response = Http::withHeaders([
            'x-goog-api-key' => config('services.gemini.key'),
            'Content-Type' => 'application/json',
        ])->post(
            'https://generativelanguage.googleapis.com/v1beta/interactions',
            [
                'model' => 'gemini-3.6-flash',
                'input' => "You are a helpful Library Management System assistant.
                        IMPORTANT RULES:
                        - For ANY question about whether a book exists, availability, quantity, price, author, description, or book details, you MUST use the search_books tool.
                        - Never answer those questions from your own knowledge.
                        - Only use the database results returned by search_books.
                        - If search_books returns no books, clearly say the library does not have a matching book.
                        - Keep answers short and friendly.

                        User question: " . $request->message,
                'tools' => [
                    [
                        'type' => 'function',
                        'name' => 'search_books',
                        'description' => 'Search the library database for books by title or author.',
                        'parameters' => [
                            'type' => 'object',
                            'properties' => [
                                'query' => [
                                    'type' => 'string',
                                    'description' => 'The book title or author name to search for.',
                                ],
                            ],
                            'required' => ['query'],
                        ],
                    ],
                ],
            ]
        );

        $data = $response->json();

        $functionCall = collect($data['steps'] ?? [])
                            ->firstWhere('type', 'function_call');

        if($functionCall && $functionCall['name'] === 'search_books')
        {
            $query = $functionCall['arguments']['query'];
            $books = $this->searchBooks($query);

            $toolResponse = Http::withHeaders([
                'x-goog-api-key' => config('services.gemini.key'),
                'Content-Type' => 'application/json',
            ])->post(
                'https://generativelanguage.googleapis.com/v1beta/interactions',
                [
                    'model' => 'gemini-3.6-flash',
                    'previous_interaction_id' => $data['id'],
                    'input' => [
                        [
                            'type' => 'function_result',
                            'call_id' => $functionCall['id'],
                            'name' => 'search_books',
                            'result' => [
                                'books' => $books->toArray(),
                            ],
                        ],
                    ],
                ]
            );

            $toolData = $toolResponse->json();

            $finalMessage = collect($toolData['steps'] ?? [])
                ->where('type', 'model_output')
                ->flatMap(fn ($step) => $step['content'] ?? [])
                ->firstWhere('type', 'text');

            logger($toolResponse->body());

            return response()->json([
                'message' => $finalMessage['text'] ?? 'I found the book data but could not generate a response.'
            ]);


        }



        // logger($books->toJson());

        // logger($response->json());

        // $message = collect($data['steps'] ?? [])
        //     ->where('type', 'model_output')
        //     ->flatMap(fn ($step) => $step['content'] ?? [])
        //     ->firstWhere('type', 'text');

        // return response()->json([
        //     'message' => $message['text'] ?? 'Gemini returned no text response.'
        // ]);
    }

    private function searchBooks(string $query){
        return Book::where('title', 'LIKE', '%'.$query.'%')
                    ->orWhere('author_name', 'LIKE', '%'.$query.'%')
                    ->limit(5)
                    ->get([
                        'id',
                        'title',
                        'author_name',
                        'price',
                        'quantity',
                        'description',
                    ]);
    }
    
    
}
