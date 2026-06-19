<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\SiteSetting;
use App\Models\Course;
use App\Models\News;
use App\Models\Gallery;
use App\Models\FooterPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class FrontWebSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Sliders
        Slider::create([
            'title' => 'Welcome to LEARN Academy',
            'subtitle' => 'Special 15% discount for early registrants. Rebranding celebration!',
            'image_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1470&auto=format&fit=crop',
            'target_url' => '/programs',
            'is_active' => true,
            'order_index' => 1,
            'clicks' => 245,
        ]);

        Slider::create([
            'title' => 'Free Placement Diagnostic Test',
            'subtitle' => 'Test your English capability levels in real-time online.',
            'image_path' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1470&auto=format&fit=crop',
            'target_url' => '/placement-test',
            'is_active' => true,
            'order_index' => 2,
            'clicks' => 182,
        ]);

        Slider::create([
            'title' => 'Premium Modern Campus Facilities',
            'subtitle' => 'Modern lecture halls, state-of-the-art computer labs and cafes.',
            'image_path' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop',
            'target_url' => '/services',
            'is_active' => true,
            'order_index' => 3,
            'clicks' => 95,
        ]);

        Slider::create([
            'title' => 'Summer Registration Open',
            'subtitle' => 'Cohort registrations for July intake starting soon.',
            'image_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop',
            'target_url' => '/tuition',
            'is_active' => false,
            'order_index' => 4,
            'clicks' => 0,
        ]);

        // 2. Seed Site Settings (About Us)
        $settings = [
            'about_us_text' => 'LEARN Academy is Cambodia\'s premier English school, specializing in outcome-based academic preparation, interactive language courses, and student success support programs.',
            'mission' => 'To deliver high-impact, communicative English training that equips students with real-world skills, enabling academic and professional growth globally.',
            'vision' => 'To be recognized as the regional gold standard in language learning, cultivating confident communicators who achieve excellence in their selected fields.',
            'value_1_title' => 'Academic Excellence',
            'value_1_description' => 'We push for high academic goals and prepare students with the practical capability to pass benchmarks.',
            'value_2_title' => 'Communicative Quality',
            'value_2_description' => 'We construct our modules around modern interactive and speaking sessions for active confidence.',
            'value_3_title' => 'Outcome-Focused Support',
            'value_3_description' => 'We offer language advisors, Peer Teaching mentors, and internships to solidify job readyness.',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::setValue($key, $value);
        }

        // 3. Seed Courses
        Course::create([
            'name' => 'University Survival English',
            'code' => 'USE-101',
            'category' => 'Academic Prep',
            'duration' => '10 Weeks (100 Hours)',
            'tuition_fee' => 180.00,
            'status' => 'active',
            'description' => 'Designed specifically for graduates and undergraduates entering English-taught university courses. This program builds the foundational academic capabilities required to thrive, focusing on speech comprehension, vocabulary development, note-taking strategies during live lectures, and seminar engagement.',
            'outcomes' => "Learn to extract core themes and map detailed structures of 45-minute academic lectures.\nExpand vocabulary across major scientific, mathematical, and social disciplines.\nParticipate confidently in academic debates, voicing opinions and defending thesis statements.\nRead and summarize journal reviews, reports, and textbook case studies."
        ]);

        Course::create([
            'name' => 'NextGen English',
            'code' => 'NGE-202',
            'category' => 'General English',
            'duration' => '12 Weeks (120 Hours)',
            'tuition_fee' => 150.00,
            'status' => 'active',
            'description' => 'A comprehensive general English curriculum built for the next generation of students. We focus on immersion techniques, correcting pronunciation, eliminating grammar errors, and developing quick conversational responses. Ideal for building solid English habits from the ground up.',
            'outcomes' => "Master standard sentence construction patterns and crucial tenses (present, past, future).\nSpeak fluently on common topics (family, weather, hobbies, work) with accurate pronunciation.\nOvercome public speaking anxiety through team dialogue and roleplay tasks.\nDraft structured emails, personal journals, and descriptive reviews."
        ]);

        Course::create([
            'name' => 'English Anytime Anywhere',
            'code' => 'EAA-303',
            'category' => 'Blended / Flex',
            'duration' => 'Self-Paced (Up to 6 Months)',
            'tuition_fee' => 220.00,
            'status' => 'active',
            'description' => 'Our premier flexible learning program built for busy students and professionals. Utilizing the custom LEARN Academy online learning dashboard, you complete grammar video lessons and tests at your own pace while attending scheduled weekly 1-on-1 feedback sessions with an English advisor.',
            'outcomes' => "Complete self-paced grammar, listening, and spelling lessons anywhere, on any device.\nJoin unlimited weekly conversation circles led by international tutors.\nReceive customized feedback on pronunciation and syntax structure during 1-on-1 checkins.\nKeep track of learning metrics, quiz history, and progress records via the portal."
        ]);

        Course::create([
            'name' => 'English for Academic Writing',
            'code' => 'EAW-404',
            'category' => 'Advanced Writing',
            'duration' => '8 Weeks (80 Hours)',
            'tuition_fee' => 240.00,
            'status' => 'active',
            'description' => 'Academic essays and graduation theses demand absolute accuracy and professional style. This course trains students to draft, structure, cite, and proofread high-level academic texts. Essential preparation for international scholarship submissions and master/doctoral studies.',
            'outcomes' => "Learn APA, Harvard, and Chicago citation styles to eliminate plagiarism risks.\nWrite clear literature reviews, thesis outlines, abstracts, and discussion segments.\nApply advanced transition devices and formal, passive sentence syntax structures.\nDevelop systematic editing, peer-reviewing, and proofreading processes."
        ]);

        Course::create([
            'name' => 'English for Business',
            'code' => 'EFB-505',
            'category' => 'Corporate / Professional',
            'duration' => '10 Weeks (90 Hours)',
            'tuition_fee' => 195.00,
            'status' => 'draft',
            'description' => 'Prepare yourself for the global marketplace. This program covers corporate correspondence, boardroom negotiation, business proposals, product presentations, and cross-cultural communication etiquette. Taught with simulation methodologies to duplicate corporate circumstances.',
            'outcomes' => "Master formal business writing: emails, executive summaries, agendas, and contracts.\nDeliver persuasive pitches and project presentations with professional slides.\nLearn negotiation strategies, counter-proposals, and conflict-resolution phrasing.\nAnalyze global business news and discuss market trends in fluent English."
        ]);

        // 4. Seed News
        News::create([
            'title' => 'Official Rebranding of LEARN Academy',
            'slug' => 'official-rebranding-of-learn-academy',
            'content' => 'We are pleased to announce our transition to LEARN Academy with revamped classrooms, state-of-the-art computer labs, and a brand-new outcome-based ESL preparation syllabus. Over the next month, student portal updates will introduce dynamic class listings and attendance trackers.',
            'category' => 'Announcement',
            'author' => 'Dean Smith',
            'image_path' => 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=400&auto=format&fit=crop',
            'published_at' => Carbon::parse('2026-06-09 10:00:00'),
            'views' => 1245,
            'status' => 'published',
        ]);

        News::create([
            'title' => 'Outstanding Academic Achievement Scholarship Awards',
            'slug' => 'outstanding-academic-achievement-scholarship-awards',
            'content' => 'Highlights and photo coverage from the awards ceremony at the primary lobby. The event celebrated our top-performing students who demonstrated outstanding academic performance, leadership skills, and active participation in peer tutoring programs.',
            'category' => 'Event',
            'author' => 'Admin PR',
            'image_path' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop',
            'published_at' => Carbon::parse('2026-06-04 09:00:00'),
            'views' => 842,
            'status' => 'published',
        ]);

        News::create([
            'title' => 'Interactive ESL Speaking Sessions Start July Intake',
            'slug' => 'interactive-esl-speaking-sessions-start-july-intake',
            'content' => 'New syllabus structure incorporating peer teaching and group survival dialogs. We have developed dynamic speaking modules to push conversational confidence, helping students practice real-life communication scenarios in real time.',
            'category' => 'Academic',
            'author' => 'Teacher Team',
            'image_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop',
            'published_at' => Carbon::parse('2026-05-28 14:00:00'),
            'views' => 412,
            'status' => 'published',
        ]);

        News::create([
            'title' => 'How to Succeed in Academic English Writing',
            'slug' => 'how-to-succeed-in-academic-english-writing',
            'content' => 'Practical strategies and citation tips from the Language Advising Service center. This guide covers how to write structured paragraphs, avoid common grammar errors, format references properly, and develop a clear, analytical writing style for essays and thesis proposals.',
            'category' => 'Tips',
            'author' => 'Advising Dept',
            'image_path' => null,
            'published_at' => null,
            'views' => 0,
            'status' => 'draft',
        ]);

        // 5. Seed Gallery
        Gallery::create([
            'title' => 'Classroom A',
            'image_path' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop',
            'category' => 'Campus Classrooms',
            'status' => 'visible',
        ]);

        Gallery::create([
            'title' => 'Lab B',
            'image_path' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop',
            'category' => 'Computer Labs',
            'status' => 'visible',
        ]);

        Gallery::create([
            'title' => 'Hall C',
            'image_path' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=600&auto=format&fit=crop',
            'category' => 'Cafe & Lounge',
            'status' => 'visible',
        ]);

        Gallery::create([
            'title' => 'Lobby D',
            'image_path' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?q=80&w=400&auto=format&fit=crop',
            'category' => 'Student Activities',
            'status' => 'visible',
        ]);

        // 6. Seed Footer Pages
        FooterPage::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'seo_description' => 'LEARN Academy student and visitor privacy standards and cookies policies.',
            'status' => 'active',
            'content' => '<h3>1. Information We Collect</h3><p>We collect student registration details, diagnostic placement test answers, progress grades, and contact form inquiries to manage academic cohorts.</p><h3>2. Security of Data</h3><p>All student information is stored securely in our centralized management database. We do not sell or share student data with external third parties without consent.</p>',
        ]);

        FooterPage::create([
            'title' => 'Terms of Service',
            'slug' => 'terms-of-service',
            'seo_description' => 'Terms of Service, guidelines, and policy requirements for LEARN Academy.',
            'status' => 'active',
            'content' => '<h3>1. Tuition and Registration</h3><p>Students must complete the diagnostic placement test and confirm class schedules prior to the term starting date. Fees are non-refundable after the first class session.</p><h3>2. Code of Conduct</h3><p>All candidates must follow classroom guidelines, respect peers, maintain academic integrity, and attend at least 80% of lectures to pass.</p>',
        ]);

        FooterPage::create([
            'title' => 'Frequently Asked Questions (FAQ)',
            'slug' => 'faq',
            'seo_description' => 'General questions about LEARN Academy English programs, costs, and terms.',
            'status' => 'active',
            'content' => '<h3>FAQ Categories</h3><h5>Q: How long is a standard English term?</h5><p>A: Most English courses span 10 to 12 weeks, depending on the academic prep intensity.</p><h5>Q: How can I check my English capability level?</h5><p>A: You can register and complete our free online Placement Diagnostic Test on the website.</p>',
        ]);

        FooterPage::create([
            'title' => 'Rebranding Disclaimers',
            'slug' => 'rebrand-disclaimer',
            'seo_description' => 'Official disclaimers on academic certificate transition structures.',
            'status' => 'draft',
            'content' => '<h3>Official Rebranding Disclaimers</h3><p>All academic credentials, certificates of completion, and student grade records issued under our previous branding remain fully valid and accredited by our academic committee.</p>',
        ]);
    }
}
