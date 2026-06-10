<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function programs()
    {
        return view('public.programs');
    }

    public function tuition()
    {
        return view('public.tuition');
    }

    public function services()
    {
        return view('public.services');
    }

    public function events()
    {
        return view('public.events');
    }

    public function placementTest()
    {
        return view('public.placement_test');
    }

    public function submitPlacementTest(Request $request)
    {
        $answers = $request->input('answers', []);
        
        // Correct answers list for the 10 questions
        $correctAnswers = [
            'q1' => 'b', // She ___ to school every day. -> goes
            'q2' => 'c', // They have ___ finished their homework. -> already
            'q3' => 'a', // If it ___ tomorrow, we will cancel the picnic. -> rains
            'q4' => 'd', // The book ___ by a famous author last year. -> was written
            'q5' => 'b', // I look forward to ___ you soon. -> seeing
            'q6' => 'c', // By the time he arrived, the class ___ already started. -> had
            'q7' => 'a', // She speaks English fluently, ___? -> doesn't she
            'q8' => 'd', // I wish I ___ more time to study last week. -> had had
            'q9' => 'b', // Notwithstanding the rain, they ___ playing soccer. -> continued
            'q10' => 'c' // Had I known about the test, I ___ harder. -> would have studied
        ];

        $score = 0;
        foreach ($correctAnswers as $q => $correctVal) {
            if (isset($answers[$q]) && $answers[$q] === $correctVal) {
                $score++;
            }
        }

        // Determine Level and Recommendation
        if ($score <= 3) {
            $level = 'Beginner / Elementry';
            $recommendation = 'NextGen English';
            $description = 'This course focuses on building foundational grammar, basic vocabulary, and everyday communication skills to build your confidence in English.';
        } elseif ($score <= 7) {
            $level = 'Intermediate';
            $recommendation = 'English Anytime Anywhere or University Survival English';
            $description = 'Perfect for enhancing conversational fluency, understanding lectures, and developing academic listening and reading skills necessary for academic contexts.';
        } else {
            $level = 'Advanced';
            $recommendation = 'English for Academic Writing or English for Business';
            $description = 'Designed to polish academic essays, business proposals, and professional presentations. Focuses on sophisticated grammar, vocabulary, and executive writing style.';
        }

        return back()->with([
            'test_submitted' => true,
            'score' => $score,
            'total' => count($correctAnswers),
            'level' => $level,
            'recommendation' => $recommendation,
            'description' => $description
        ]);
    }

    public function successHub()
    {
        return view('public.success_hub');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Simulating contact form save or email trigger
        return back()->with('success', 'Thank you for contacting us! Our team will get back to you shortly.');
    }
}
