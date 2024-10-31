<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreNoticeRequest;
use Session;

class InformationController extends Controller
{
    protected $information;
    protected $categories;
    public function __construct(Information $information,Categories $categories)
    {
        $this->information = $information;
        $this->categories = $categories;

    }
    public function index(Request $request){
        $values = categories::all();

        //検索
        $information_title = $request->input('information_title');
        $information_kbn = $request->input('information_kbn');
        $keisai_ymd = !empty($keisai_ymd) ? date("Ymd", strtotime($request->input('keisai_ymd'))):null;
        $enable_start_ymd=  !empty($enable_start_ymddate) ? date("Ymd", strtotime($request->input('enable_start_ymd'))):null;
        $enable_end_ymd =  !empty($enable_end_ymddate)? date("Ymd", strtotime($request->input('enable_end_ymd'))):null;

        $query =Information::query();
        if(!empty($information_title) || !empty($information_kbn) || !empty($keisai_ymd) || !empty($enable_start_ymd)  || !empty($enable_end_ymd)  ){
            if(!empty(($information_title))){   
                $query->where('information_title','LIKE',$information_title);
             }
            if(!empty(($information_kbn))){
                $query->where('information_kbn','Like',$information_kbn);
             }
             if(!empty(($keisai_ymd))){
                $query->where('keisai_ymd','Like',$keisai_ymd);

             }
             if(!empty(($enable_start_ymd))){
                $query->where('enable_start_ymd','Like',$enable_start_ymd);
             }
             if(!empty(($enable_end_ymd))){
                $query->where('enable_end_ymd','Like',$enable_end_ymd);
             }

             $query=$query->paginate(10);
        }
        else{
            $query=Information::paginate(10);
        }

        $message = '';

        if(Session::has('message')){
            $message = Session::get('message');
        }

        return view('notice.index', ['values' => $values, 'informations' => $query, 'message' => $message],
        compact('information_title', 'information_kbn', 'keisai_ymd', 'enable_start_ymd', 'enable_end_ymd'));
    }
    public function show($id) {
        Information::find($id);
        return view('notice.edit',compact('values'));
    }
    public function create(){
        $values = categories::all();
        return view('notice.create')->with('values',$values);
    }
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'information_title' => 'required|max:100',
            'information_kbn' =>'required|max:1',
            'keisai_ymd' =>'required|date',
            'enable_start_ymd' =>'required|date|after:keisai_ymd',
            'enable_end_ymd' =>'required|date|after:enable_start_ymd',
            'information_naiyo' =>'required',  
            ]);
    
            if ($validator->fails()) {
                // エラーを返すか、エラーとともにリダイレクトする
                return redirect()->back()->with('errors', $validator->errors());
            }

        $message="";

        $keisai_ymd = date("Ymd", strtotime($request->keisai_ymd));
        $enable_start_ymd = date("Ymd", strtotime($request->enable_start_ymd));
        $enable_end_ymd = date("Ymd", strtotime($request->enable_end_ymd));
   
        Information::create([
        'information_title'     =>$request->information_title,
        'information_kbn'       =>$request->information_kbn,
        'keisai_ymd'            =>$keisai_ymd,
        'enable_start_ymd'      =>$enable_start_ymd,
        'enable_end_ymd'        =>$enable_end_ymd,
        'information_naiyo'     =>$request->information_naiyo,
        'create_user_cd'        =>'admin',
        'update_user_cd'        =>'admin',
        ]);
        
        $message="登録が完了しました。";

        return to_route('notice.index')->with('message', $message);
    }

    public function edit(Request $request){
        $information = Information::find($request->id);
        $values = categories::all();
 
        if($information->delete_flag == null){
            $information->keisai_ymd = date('Y-m-d', strtotime($information->keisai_ymd));
            $information->enable_start_ymd  = date('Y-m-d', strtotime($information->enable_start_ymd ));
            $information->enable_end_ymd = date('Y-m-d', strtotime($information->enable_end_ymd));
     
           return view('notice.edit', 
           ['values' => $values, 'information' => $information]);
        }
       
    
       
    }

    public function update(Request  $request,$id){

        $validator = Validator::make($request->all(),[
        'information_title' => 'required|max:100',
        'information_kbn' =>'required|max:1',
        'keisai_ymd' =>'required|date',
        'enable_start_ymd' =>'required|date',
        'enable_end_ymd' =>'required|date',
        'information_naiyo' =>'required',  
        ]);

        if ($validator->fails()) {
            // エラーを返すか、エラーとともにリダイレクトする
            return $validator->errors();
        }

        $information = Information::find($id);
        $message="";

        $request->keisai_ymd = date("Ymd", strtotime($request->keisai_ymd));
        $request->enable_start_ymd = date("Ymd", strtotime($request->enable_start_ymd));
        $request->enable_end_ymd = date("Ymd", strtotime($request->enable_end_ymd));

        $information->information_title     =$request->information_title;
        $information->information_kbn       =$request->information_kbn;
        $information->keisai_ymd            = $request->keisai_ymd ;
        $information->enable_start_ymd      =$request->enable_start_ymd;
        $information->enable_end_ymd        =$request->enable_end_ymd;
        $information->information_naiyo     =$request->information_naiyo;
        $information->create_user_cd        ='admin';
        $information->update_user_cd        ='admin';
        $information->save();

        $message="変更が完了しました。";

        return to_route('notice.index')->with('message', $message);
      }

      public function destory(Request $request,$id){
        $message="";

        $information = Information::find($id);
        $information->delete_flag = '1';
        $information->save();

        $message="削除が完了しました。";

        return to_route('notice.index')->with('message', $message);
       
    }
  
}

