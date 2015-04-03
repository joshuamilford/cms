<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Flash;
use App\Page;
use Illuminate\Http\Request;

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
	public function index()
	{
		return view('pages.index')->with(['pages' => Page::all()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pages.create');
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
		Page::create($data);
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
		return view('pages.edit', compact('page'));
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

	}

	private function make_slug($request)
	{
		// make slug
		if($request->slug == '')
		{
			$i = 1;
			$tmp_slug = preg_replace('/[^a-z0-9]/', '-', strtolower($request->title));
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

}
