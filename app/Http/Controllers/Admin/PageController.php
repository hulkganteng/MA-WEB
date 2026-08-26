<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('pages.view'), 403);
        $pages = Page::with('author')->when($request->filled('q'), fn ($q) => $q->where('title','like','%'.$request->string('q').'%'))->latest()->paginate(15)->withQueryString();
        return view('admin.pages.index', compact('pages'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->can('pages.create'), 403);
        return view('admin.pages.form', ['page' => new Page(['status' => 'draft', 'template' => 'default'])]);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->can('pages.create'), 403);
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title']);
        $data['author_id'] = $request->user()->id;
        $data['body'] = clean($data['body']);
        $data['cover'] = $request->file('cover')?->store('pages', 'public');
        $page = Page::create($data);
        activity_log('create', $page, ['title' => $page->title]);
        return redirect()->route('admin.pages.index')->with('flash', ['type'=>'success','message'=>'Halaman dibuat']);
    }

    public function edit(Request $request, Page $page)
    {
        abort_unless($request->user()->can('pages.update'), 403);
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        abort_unless($request->user()->can('pages.update'), 403);
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?: $data['title'], $page);
        $data['body'] = clean($data['body']);
        if ($request->hasFile('cover')) { if ($page->cover) Storage::disk('public')->delete($page->cover); $data['cover'] = $request->file('cover')->store('pages', 'public'); } else unset($data['cover']);
        $page->update($data);
        activity_log('update', $page, ['title' => $page->title]);
        return redirect()->route('admin.pages.index')->with('flash', ['type'=>'success','message'=>'Halaman diperbarui']);
    }

    public function destroy(Request $request, Page $page)
    {
        abort_unless($request->user()->can('pages.delete'), 403);
        activity_log('delete', $page, ['title' => $page->title]); $page->delete();
        return back()->with('flash', ['type'=>'success','message'=>'Halaman dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate(['title'=>['required','string','max:255'],'slug'=>['nullable','string','max:255'],'body'=>['required','string'],'status'=>['required',Rule::in(Page::STATUSES)],'template'=>['required','string','max:50'],'order'=>['nullable','integer','min:0'],'cover'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],'seo_title'=>['nullable','string','max:255'],'seo_description'=>['nullable','string','max:320']]) + ['order'=>0];
    }

    private function uniqueSlug(string $value, ?Page $ignore = null): string
    {
        $base=Str::slug($value) ?: Str::random(8); $slug=$base; $i=2;
        while(Page::withTrashed()->where('slug',$slug)->when($ignore,fn($q)=>$q->whereKeyNot($ignore->id))->exists()) $slug=$base.'-'.$i++;
        return $slug;
    }
}
