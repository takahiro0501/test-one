<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sentence;
use App\Models\FooterLink;
use App\Http\Requests\Admin\HeaderRequest;
use App\Http\Requests\Admin\FooterRequest;
use Illuminate\Support\Facades\Storage;

class AdminDesignController extends Controller
{
    public function header(){

        $sentence1 = Sentence::where('no',1)->first();
        $sentence2 = Sentence::where('no',2)->first();

        return view('admin.header',compact('sentence1','sentence2'));
    }

    public function headerExe(HeaderRequest $request)
    {
        if(!is_null($request->file('file'))){
            //ファイル削除
            $files = Storage::allFiles('public/images/');
            //ファイルをローカルに保存する
            Storage::putFileAs('public/images/', $request->file('file'), 'logo.png');
        }
        $sentence1 = Sentence::where('no',1)->update(['sentence' => $request->sentence1]);
        $sentence2 = Sentence::where('no',2)->update(['sentence' => $request->sentence2]);

        return redirect()->route('admin.header');
    }

    public function footer()
    {
        $links = FooterLink::orderBy('id','asc')->get();
        return view('admin.footer',compact('links'));
    }

    public function footerExe(FooterRequest $request)
    {
        $links = $request->all();
        for($i = 0 ; $i < 9 ; $i++ ){
            FooterLink::where('id', $i+1)->update([
                'link_name' => $links['name'.$i] ,
                'link' => $links['link'.$i] ,
            ]);
        };
        return redirect()->route('admin.footer');
    }
}
