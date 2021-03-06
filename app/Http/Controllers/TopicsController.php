<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
		//except 只对包含操作内 以外的操作验证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request,Topic $topic)
	{
		$topics = $topic->WithOrder($request->order)	
			->paginate(10);
		return view('topics.index', compact('topics'));
	}

    public function show(Request $request, Topic $topic)
    {	
		// URL 矫正
		if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{	
		$categories = Category::all();

		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{	
		
		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->save();
		return redirect()->to($topic->link())->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{	
		$this->authorize('update', $topic);
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '成功删除');
	}

	//文件上传
	public function uploadImage(Request $request,ImageUploadHandler $upload){
		// 初始化返回数据，默认是失败的
		$data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
		];

		
		if($file = $request->upload_file){
			$images = $upload->save($file,'topics',Auth::id(),1024);

			if($images){
				$data['file_path'] = $images['path'];
				$data['msg']       = "上传成功!";
				$data['success']   = true;
				
			}
		}
		
		return $data;
	}
}