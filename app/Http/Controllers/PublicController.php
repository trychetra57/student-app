<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\SiteSetting;
use App\Models\Course;
use App\Models\News;
use App\Models\Gallery;
use App\Models\FooterPage;

class PublicController extends Controller
{
    public function __construct()
    {
        $publicFooterPages = \App\Models\FooterPage::where('status', 'active')->get();
        view()->share('publicFooterPages', $publicFooterPages);
    }

    public function home()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order_index', 'asc')->get();
        $gallery = Gallery::where('status', 'visible')->get();
        $news = News::where('status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
        
        $settings = [
            'about_us_text' => SiteSetting::getValue('about_us_text', 'LEARN Academy is a premier English language learning institute. Designed to help students overcome reading, writing, and communication limitations, we offer high-end courses taught by accredited international experts. We operate with standard, rigorous criteria to ensure high GPA outputs and test success.'),
            'mission' => SiteSetting::getValue('mission', 'Our mission is to deliver comprehensive, immersive, and engaging English language training modules. By providing personalized advising, self-access materials, and student-focused internship programs, we guide our candidates toward academic breakthrough, exam success, and bright professional careers.'),
            'vision' => SiteSetting::getValue('vision', 'We envision becoming the premier national benchmark for language instruction. Through constant curriculum innovation and staff professional development programs, we produce students who excel at university, communicate fluently on the global stage, and lead business development projects.'),
            'value_1_title' => SiteSetting::getValue('value_1_title', 'Academic Excellence'),
            'value_1_description' => SiteSetting::getValue('value_1_description', 'We push for high academic goals and prepare students with the practical capability to pass benchmarks.'),
            'value_2_title' => SiteSetting::getValue('value_2_title', 'Communicative Quality'),
            'value_2_description' => SiteSetting::getValue('value_2_description', 'We construct our modules around modern interactive and speaking sessions for active confidence.'),
            'value_3_title' => SiteSetting::getValue('value_3_title', 'Outcome-Focused Support'),
            'value_3_description' => SiteSetting::getValue('value_3_description', 'We offer language advisors, Peer Teaching mentors, and internships to solidify job readiness.'),
        ];

        return view('public.home', compact('sliders', 'gallery', 'news', 'settings'));
    }

    public function programs()
    {
        $courses = Course::where('status', 'active')->get();
        return view('public.programs', compact('courses'));
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
        $news = News::where('status', 'published')->orderBy('published_at', 'desc')->get();
        return view('public.events', compact('news'));
    }

    public function showPage($slug)
    {
        $page = FooterPage::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('public.show', compact('page'));
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
