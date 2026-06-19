<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\SiteSetting;
use App\Models\Course;
use App\Models\News;
use App\Models\Gallery;
use App\Models\FooterPage;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontWebController extends Controller
{
    // ==========================================
    // SLIDERS
    // ==========================================
    public function sliders()
    {
        $sliders = Slider::orderBy('order_index', 'asc')->get();
        return view('sliders.index', compact('sliders'));
    }

    public function storeSlider(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'target_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('front_web/sliders', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $data['order_index'] = Slider::max('order_index') + 1;

        $slider = Slider::create($data);
        $this->logAudit('create_slider', $slider, null, $slider->toArray());

        return redirect()->back()->with('success', 'Slider created successfully.');
    }

    public function updateSlider(Request $request, Slider $slider)
    {
        $oldValues = $slider->toArray();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'target_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $slider->is_active;

        if ($request->hasFile('image')) {
            // Delete old image if it is local
            if ($slider->image_path && Str::startsWith($slider->image_path, '/storage/')) {
                $oldPath = Str::replaceFirst('/storage/', '', $slider->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('front_web/sliders', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $slider->update($data);
        $this->logAudit('update_slider', $slider, $oldValues, $slider->toArray());

        return redirect()->back()->with('success', 'Slider updated successfully.');
    }

    public function destroySlider(Slider $slider)
    {
        $oldValues = $slider->toArray();

        // Delete image if local
        if ($slider->image_path && Str::startsWith($slider->image_path, '/storage/')) {
            $oldPath = Str::replaceFirst('/storage/', '', $slider->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $slider->delete();
        $this->logAudit('delete_slider', $slider, $oldValues, null);

        return redirect()->back()->with('success', 'Slider deleted successfully.');
    }

    public function toggleSliderStatus(Slider $slider)
    {
        $oldValues = $slider->toArray();
        $slider->is_active = !$slider->is_active;
        $slider->save();

        $this->logAudit('toggle_slider_status', $slider, $oldValues, $slider->toArray());
        return redirect()->back()->with('success', 'Slider status updated.');
    }

    public function reorderSliders(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:sliders,id'
        ]);

        foreach ($request->order as $index => $id) {
            Slider::where('id', $id)->update(['order_index' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
    }

    // ==========================================
    // ABOUT US
    // ==========================================
    public function aboutUs()
    {
        $settings = [
            'about_us_text' => SiteSetting::getValue('about_us_text', ''),
            'mission' => SiteSetting::getValue('mission', ''),
            'vision' => SiteSetting::getValue('vision', ''),
            'value_1_title' => SiteSetting::getValue('value_1_title', ''),
            'value_1_description' => SiteSetting::getValue('value_1_description', ''),
            'value_2_title' => SiteSetting::getValue('value_2_title', ''),
            'value_2_description' => SiteSetting::getValue('value_2_description', ''),
            'value_3_title' => SiteSetting::getValue('value_3_title', ''),
            'value_3_description' => SiteSetting::getValue('value_3_description', ''),
        ];
        return view('about-us.index', compact('settings'));
    }

    public function updateAboutUs(Request $request)
    {
        $data = $request->validate([
            'about_us_text' => 'required|string',
            'mission' => 'required|string',
            'vision' => 'required|string',
            'value_1_title' => 'required|string|max:255',
            'value_1_description' => 'required|string',
            'value_2_title' => 'required|string|max:255',
            'value_2_description' => 'required|string',
            'value_3_title' => 'required|string|max:255',
            'value_3_description' => 'required|string',
        ]);

        $oldValues = [];
        foreach ($data as $key => $value) {
            $oldValues[$key] = SiteSetting::getValue($key);
            SiteSetting::setValue($key, $value);
        }

        // Create a fake setting model for audit trail
        $settingModel = new SiteSetting(['key' => 'about_us_group']);
        $settingModel->id = 0; // dummy ID
        $this->logAudit('update_about_us', $settingModel, $oldValues, $data);

        return redirect()->back()->with('success', 'About Us statements updated successfully.');
    }

    // ==========================================
    // COURSES
    // ==========================================
    public function courses()
    {
        $courses = Course::latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'category' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'tuition_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft',
            'description' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);

        $course = Course::create($data);
        $this->logAudit('create_course', $course, null, $course->toArray());

        return redirect()->back()->with('success', 'Course created successfully.');
    }

    public function updateCourse(Request $request, Course $course)
    {
        $oldValues = $course->toArray();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'category' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'tuition_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,draft',
            'description' => 'nullable|string',
            'outcomes' => 'nullable|string',
        ]);

        $course->update($data);
        $this->logAudit('update_course', $course, $oldValues, $course->toArray());

        return redirect()->back()->with('success', 'Course updated successfully.');
    }

    public function destroyCourse(Course $course)
    {
        $oldValues = $course->toArray();
        $course->delete();
        $this->logAudit('delete_course', $course, $oldValues, null);

        return redirect()->back()->with('success', 'Course deleted successfully.');
    }

    public function toggleCourseStatus(Course $course)
    {
        $oldValues = $course->toArray();
        $course->status = ($course->status === 'active') ? 'draft' : 'active';
        $course->save();

        $this->logAudit('toggle_course_status', $course, $oldValues, $course->toArray());
        return redirect()->back()->with('success', 'Course status updated.');
    }

    // ==========================================
    // NEWS & ANNOUNCEMENTS
    // ==========================================
    public function news()
    {
        $news = News::latest()->get();
        return view('news.index', compact('news'));
    }

    public function storeNews(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('front_web/news', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = $data['published_at'] ?? now();
        }

        $newsItem = News::create($data);
        $this->logAudit('create_news', $newsItem, null, $newsItem->toArray());

        return redirect()->back()->with('success', 'News article created successfully.');
    }

    public function updateNews(Request $request, News $news)
    {
        $oldValues = $news->toArray();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            // Delete old local image
            if ($news->image_path && Str::startsWith($news->image_path, '/storage/')) {
                $oldPath = Str::replaceFirst('/storage/', '', $news->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('front_web/news', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = $data['published_at'] ?? ($news->published_at ?? now());
        } else {
            $data['published_at'] = null;
        }

        $news->update($data);
        $this->logAudit('update_news', $news, $oldValues, $news->toArray());

        return redirect()->back()->with('success', 'News article updated successfully.');
    }

    public function destroyNews(News $news)
    {
        $oldValues = $news->toArray();

        // Delete image if local
        if ($news->image_path && Str::startsWith($news->image_path, '/storage/')) {
            $oldPath = Str::replaceFirst('/storage/', '', $news->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $news->delete();
        $this->logAudit('delete_news', $news, $oldValues, null);

        return redirect()->back()->with('success', 'News article deleted successfully.');
    }

    public function toggleNewsStatus(News $news)
    {
        $oldValues = $news->toArray();
        if ($news->status === 'published') {
            $news->status = 'draft';
            $news->published_at = null;
        } else {
            $news->status = 'published';
            $news->published_at = now();
        }
        $news->save();

        $this->logAudit('toggle_news_status', $news, $oldValues, $news->toArray());
        return redirect()->back()->with('success', 'News status updated.');
    }

    // ==========================================
    // CAMPUS GALLERY
    // ==========================================
    public function galleries()
    {
        $galleries = Gallery::latest()->get();
        return view('galleries.index', compact('galleries'));
    }

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'category' => 'required|string|max:100',
            'status' => 'nullable|in:visible,hidden',
        ]);

        $data['status'] = $data['status'] ?? 'visible';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('front_web/gallery', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $gallery = Gallery::create($data);
        $this->logAudit('create_gallery_item', $gallery, null, $gallery->toArray());

        return redirect()->back()->with('success', 'Gallery item uploaded successfully.');
    }

    public function destroyGallery(Gallery $gallery)
    {
        $oldValues = $gallery->toArray();

        // Delete image if local
        if ($gallery->image_path && Str::startsWith($gallery->image_path, '/storage/')) {
            $oldPath = Str::replaceFirst('/storage/', '', $gallery->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $gallery->delete();
        $this->logAudit('delete_gallery_item', $gallery, $oldValues, null);

        return redirect()->back()->with('success', 'Gallery item deleted.');
    }

    // ==========================================
    // FOOTER PAGES
    // ==========================================
    public function footerPages()
    {
        $pages = FooterPage::latest()->get();
        return view('footer-pages.index', compact('pages'));
    }

    public function storeFooterPage(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:footer_pages,slug',
            'content' => 'required|string',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,draft',
        ]);

        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        }

        $page = FooterPage::create($data);
        $this->logAudit('create_footer_page', $page, null, $page->toArray());

        return redirect()->back()->with('success', 'Static page created successfully.');
    }

    public function updateFooterPage(Request $request, FooterPage $page)
    {
        $oldValues = $page->toArray();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:footer_pages,slug,' . $page->id,
            'content' => 'required|string',
            'seo_description' => 'nullable|string|max:500',
            'status' => 'required|in:active,draft',
        ]);

        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        } else {
            $data['slug'] = Str::slug($request->title);
        }

        $page->update($data);
        $this->logAudit('update_footer_page', $page, $oldValues, $page->toArray());

        return redirect()->back()->with('success', 'Static page updated successfully.');
    }

    public function destroyFooterPage(FooterPage $page)
    {
        $oldValues = $page->toArray();
        $page->delete();
        $this->logAudit('delete_footer_page', $page, $oldValues, null);

        return redirect()->back()->with('success', 'Static page deleted successfully.');
    }

    public function toggleFooterPageStatus(FooterPage $page)
    {
        $oldValues = $page->toArray();
        $page->status = ($page->status === 'active') ? 'draft' : 'active';
        $page->save();

        $this->logAudit('toggle_footer_page_status', $page, $oldValues, $page->toArray());
        return redirect()->back()->with('success', 'Static page status updated.');
    }

    // ==========================================
    // AUDIT LOG HELPER
    // ==========================================
    private function logAudit(string $action, $model, ?array $oldValues = null, ?array $newValues = null)
    {
        AuditLog::create([
            'user_id' => auth()->id() ?? 1,
            'model_type' => get_class($model),
            'model_id' => $model->id ?? 0,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}
