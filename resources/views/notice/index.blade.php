<!DOCTYPE html>
<htm>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>
<script src="https://cdn.tailwindcss.com"></script>
        <title>お知らせ</title>
    </head>
    <body class="antialiased">
    <div class="container small">
    <h1 align="center">お知らせ設定</h1>
    <div class="container">
  
    @if ($message)
    <div  style="background-color:green;color:white;">{{ $message }}</div>
    @endif

  <form class="form-horizontal" method="get" action="{{route('notice.index')}}">
  <div class="form-group">
    @csrf
    <div class="col-xs-10">
        <label for="information_title">お知らせタイトル</label>
        <input type="text" id="information_title" name="information_title">
    </div>
    <div class="col-xs-10">
        <label for="information_kbn">お知らせ区分</label>
        <select id="information_kbn" name="information_kbn" value="">
            <option value="0" @if(\Request::get('information_kbn')=== '0') selected @endif>全て</option>
            @foreach($values as $value)
                <option value="{{$value->id}}" @if(\Request::get('information_kbn')== $value->id) selected @endif>{{$value->category}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-10">
        <label for="keisai_ymd">掲載日</label><br>
        <input type="date" id="keisai_ymd" name="keisai_ymd" ></input><br><br>
    </div>
    <div class="col-xs-10">
        <label for="keisai_ymd">適用期間</label><br>
        <input type="date" id="enable_start_ymd" name="enable_start_ymd" ></input>　～　
        <input type="date" id="enable_end_ymd" name="enable_end_ymd" ></input><br><br>
    </div>
    <div class="col-xs-10">
        <input type="submit" value="検索"/>　　
        <input type="reset" style="background-color:red;color:white;" value="クリア"><br><br>
    </div> 
  </div>
  </form> 
    <table style="width:100%" style="background-color:lightblue;  padding: 15px;">
        <table style="width:100%" style="background-color:lightblue;">
        <thead>
            <tr style="background-color:lightblue;">
                <td align="left">
                    <div style="width:500px"><label for="result">検索結果</label></div></td>
                </td>
                <td align="left"><div style="width:500px"></div></td>

                <td align="right"> 
                    <div style="width:235px"></div>{{$informations->links()}}</div>
                </td>
           
            </tr>
        </thead>
        </table>
            <table style="width:100%" style="background-color:lightblue;">
                <thead>
                <tr>
                    <th align="center"></th>
                    <th align="center">お知らせタイトル</th>
                    <th align="center">お知らせ区分</th>
                    <th align="center">掲載日</th>
                    <th align="center">適用期間</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($informations as $information)

                <tr>
                    <td align="center">
                        <input type="radio" value="{{$information->id}}" class="select-radio" id="checkButton" onclick="butotnClick()">
                    </td>
                    <td align="center"> {{$information->information_title}} </td>
                    @foreach($values as $value)
                        @if($information->information_kbn == $value->id)
                    <td align="center"> {{$value->category}}</td>
                        @endif
                    @endforeach
                    <td align="center"> {{ date('Y/m/d', strtotime($information->keisai_ymd))}} </td>
                    <td align="center"> {{date("Y/m/d", strtotime($information->enable_start_ymd))}}　～　
                        {{date("Y/m/d", strtotime($information->enable_end_ymd))}} </td>  
                </tr>
                @endforeach
            </table><br>
            <table style="width:80%" style="background-color:lightblue;">
                <tr>
                    
                    <td align="center"> 
                        <a href="{{route('notice.create')}}"  style="background-color:green;color:white;" >登録</a>
                    </td>
                    <td align="center">
                        <form method="post" action="" id="edit_submit">
                            @csrf
                            <a id="edit_id" href="#" onclick="editPost(this)" style="background-color:orange;color:white;" >変更</a>
                        </form>
                    </td>
                    <td align="center">
                        <form method="post" action="" id="delete_submit">
                            @csrf
                            <a id="delete_id" href="#"  data-id="" onclick="deletePost(this)"  style="background-color:red;color:white;" >削除</a>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>

    </table>    
    </body>
    <script>

        function butotnClick(){
        let idRadio = document.getElementsByClassName('select-radio');
        let len = idRadio.length;
            let checkValue = '';
            let delete_id =  document.getElementById('delete_id');
            let edit_id =  document.getElementById('edit_id');
            let edit_submit =  document.getElementById('edit_submit');
            let delete_submit =  document.getElementById('delete_submit');

            for (let i = 0; i < len; i++){
                if (idRadio.item(i).checked){
                checkValue = idRadio.item(i).value;
                }
            }

            delete_id.setAttribute("data-id", checkValue);
            edit_id.setAttribute("data-id", checkValue);
            edit_submit.setAttribute("action","/notice/" + checkValue + "/edit");
            delete_submit.setAttribute("action","/notice/" + checkValue + "/destory");
    
        }
        idRadio[0].checked = true;
        let checkButton = document.getElementById('checkButton');
        checkButton.addEventListener('click', butotnClick);

    function editPost(e){
        'use strict'
        let idRadio = document.getElementsByClassName('select-radio');
        let checkValue = '';
        let len = idRadio.length;

        for (let i = 0; i < len; i++){

            if (idRadio.item(i).checked){
                checkValue = idRadio.item(i).value;
            }
        }

        if(checkValue==""){
            alert('行を選択してください。')
        }else{
            document.getElementById('edit_submit').submit();
        }
        
        
    }
</script>
<script>
    function deletePost(e){
        'use strict'
        let idRadio = document.getElementsByClassName('select-radio');
        let checkValue = '';
        let len = idRadio.length;

        for (let i = 0; i < len; i++){

            if (idRadio.item(i).checked){
                checkValue = idRadio.item(i).value;
            }
        }

        if(checkValue==""){
            alert('行を選択してください。')
        }else{

            if(confirm('選択したお知らせを削除します。よろしですか？削除したお知らせは復元できません。')){
                document.getElementById('delete_submit').submit();
            }
        }
    }
</script>
</htm>
