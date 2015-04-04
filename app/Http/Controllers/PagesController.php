<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;
use Auth;
use App\Helpers\CategoryHierarchy;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(CategoryHierarchy $hierarchy)
	{
		// $pages = Page::all();
		// $hierarchy->setupItems($pages);
		// $list = $hierarchy->render();
		return view('pages.index')->with(['pages' => Page::all()]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$parents = Page::lists('title', 'id');
		$parents = array_add($parents, 0, '');
		$parents = array_sort($parents, function($value)
		{
			return $value;
		});

		return view('pages.create', compact('parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\StorePageRequest $request)
	{
		$data = $request->all();
		$data['slug'] = $this->make_slug($request);

		$data['user_id'] = Auth::user()->id;

		$page = Page::create($data);

		$tags = $this->make_tags($request);

		$page->tags()->sync($tags);

		Flash::success('Your page has been added.');
		return redirect('/pages');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = Page::findOrFail($id);

		$parents = Page::where('id', '!=', $page->id)->lists('title', 'id');
		$parents = array_add($parents, 0, '');
		$parents = array_sort($parents, function($value)
		{
			return $value;
		});

		$tag_data = $page->tags;
		$tag_array = array();
		foreach($tag_data as $t)
		{
			$tag_array[] = $t->name;
		}
		$tags = implode(', ', $tag_array);
		return view('pages.edit', compact('page', 'tags', 'parents'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Requests\StorePageRequest $request)
	{
		$page = Page::findOrFail($id);

		$data = $request->all();
		$data['slug'] = $this->make_slug($request);
		$page->update($data);

		$tags = $this->make_tags($request);
		$page->tags()->sync($tags);

		Flash::success('Your page has been updated.');
		return redirect('/pages');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$page = Page::findOrFail($id);
		$page->delete();
		$page->tags()->detach();
		Flash::success('Your page has been deleted.');
		return redirect('/pages');
	}

	private function make_slug($request)
	{
		// make slug
		if($request->slug == '')
		{
			$tmp_slug = '';
			if($request->parent_id != 0)
			{
				$parent = Page::where('id', '=', $request->parent_id)->first();
				$tmp_slug .= $parent->slug . '/';
			}
			$i = 1;
			$tmp_slug .= preg_replace('/[^a-z0-9]/', '-', strtolower($request->title));
			do
			{
				$slug = $tmp_slug . ($i > 1 ? '-' . $i : '');
				$existing = Page::where('slug', '=', $slug)->get();
				$i++;
			} while(count($existing) > 0);
			return $slug;
		}
		return $request->slug;
	}

	private function make_tag_slug($tag)
	{
		// make tag slug

		$i = 1;
		$tmp_slug = preg_replace('/[^a-z0-9]/', '-', strtolower($tag));
		do
		{
			$slug = $tmp_slug . ($i > 1 ? '-' . $i : '');
			$existing = Tag::where('slug', '=', $slug)->get();
			$i++;
		} while(count($existing) > 0);
		return $slug;

	}

	private function make_tags($request)
	{
		$tag_data = $request->tags;
		$tag_data = explode(',', $tag_data);
		$tag_data = array_map('trim', $tag_data);
		$tags = array();
		foreach($tag_data as $tag)
		{
			$data = Tag::where('name', '=', $tag)->first();
			if(!$data)
			{
				$slug = $this->make_tag_slug($tag);
				$new_tag = new Tag();
				$new_tag->name = $tag;
				$new_tag->slug = $slug;
				$new_tag->save();
				$tags[] = $new_tag->id;
			}
			else
			{
				$tags[] = $data->id;
			}
		}
		return $tags;
	}

}
