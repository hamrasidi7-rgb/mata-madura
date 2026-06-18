<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiAssistantController extends Controller
{
    /**
     * Endpoint pencarian/tanya AI (placeholder).
     * Hubungkan ke layanan RAG / LLM (mis. mataGen.ai) di sini.
     */
    public function ask(Request $request)
    {
        $question = trim((string) $request->query('q', ''));

        // TODO: panggil service AI dan kembalikan jawaban.
        // return view('ai.answer', [...]);

        return redirect()->route('home')
            ->with('ai_question', $question);
    }
}
