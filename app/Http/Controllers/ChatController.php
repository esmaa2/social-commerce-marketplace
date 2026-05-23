<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate user input
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');

        // Fetch all products
        $products = Product::select(
            'id', 'user_id', 'name', 'description', 'price', 'category', 
            'in_stock', 'rating', 'is_digital'
        )->get()->toArray();

        // Group products by category
        $productsByCategory = [];
        foreach ($products as $product) {
            $productsByCategory[$product['category']][] = $product;
        }

        // Build a concise system prompt
        $systemPrompt = "You are a friendly and helpful store assistant. 
You know all products in the store. 
- If the user asks a general question about a category, list only the product names. 
- If the user asks for details about a specific product (price, description, seller, etc.), provide full info. 
- Never invent products. Only talk about real products.\n\n";

        foreach ($productsByCategory as $category => $items) {
            $systemPrompt .= "- {$category}:\n";
            foreach ($items as $p) {
                // Keep description short to avoid huge prompt
                $desc = strlen($p['description']) > 100 ? substr($p['description'], 0, 100) . '...' : $p['description'];
                $systemPrompt .= "  * {$p['name']}: {$desc}. "
                               . "Price: \${$p['price']}. "
                               . ($p['in_stock'] ? "In stock. " : "Out of stock. ")
                               . ($p['is_digital'] ? "Digital product. " : "")
                               . "Published by user ID: {$p['user_id']}.\n";
            }
        }

        // Retrieve last 10 messages from session to avoid huge context
        $conversation = array_slice(session('chat_history', []), -10);
        $conversation[] = ['role' => 'user', 'content' => $userMessage];

        try {
            $response = Http::withHeaders([
                'api-key' => env('AZURE_OPENAI_KEY'),
                'Content-Type' => 'application/json',
            ])->post(env('AZURE_OPENAI_ENDPOINT') . '/openai/deployments/' . env('AZURE_OPENAI_DEPLOYMENT') . '/chat/completions?api-version=' . env('AZURE_OPENAI_API_VERSION'), [
                'messages' => array_merge(
                    [['role' => 'system', 'content' => $systemPrompt]],
                    $conversation
                ),
                'max_tokens' => 700,
            ]);

            if (!$response->successful()) {
                \Log::error('Azure API failed: ' . $response->body());
                $reply = "Sorry, AI service is unavailable right now.";
            } else {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? "Sorry, no response from AI.";
            }

        } catch (\Exception $e) {
            \Log::error('ChatController error: ' . $e->getMessage());
            $reply = "Sorry, I can't respond right now.";
        }

        // Save conversation in session
        $conversation[] = ['role' => 'assistant', 'content' => $reply];
        session(['chat_history' => $conversation]);

        return response()->json(['reply' => $reply]);
    }

    // Reset chat conversation
    public function resetConversation()
    {
        session()->forget('chat_history');
        return response()->json(['status' => 'conversation reset']);
    }
}
