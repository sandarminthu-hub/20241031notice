<!DOCTYPE html>
<htm>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
        <title>お知らせ</title>
    </head>
    <body class="antialiased">
    <div class="container small">
    <h1 align="center">お知らせ設定登録</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
  <form  class="form-horizontal" method="post" action="{{route('notice.store')}}">
    <div class="form-group">
      @csrf
      <div class="col-xs-10">
        <label for="information_title">お知らせタイトル</label>
        <input type="text" id="information_title" name="information_title" required value="" >
      </div>
      <div class="col-xs-10">  
        <label for="information_kbn">お知らせ区分</label>
        <select id="information_kbn" name="information_kbn"  required >
        <option value="">選択してください。</option>
          @foreach($values as $value)
            <option value="{{$value->id}}">{{$value->category}}</option>;
          @endforeach
       </select>
      </div>
    <div class="col-xs-10">    
      <label for="keisai_ymd">掲載日</label><br>
      <input type="date" id="keisai_ymd" name="keisai_ymd" required value=""></input><br><br>
    </div>
    <div class="col-xs-10">  
      <label for="keisai_ymd">適用期間</label><br>
      <input type="date" id="enable_start_ymd" name="enable_start_ymd" required value=""></input>　～　
      <input type="date" id="enable_end_ymd" name="enable_end_ymd" required value=""></input><br><br>
    </div>
    <div class="col-xs-10">  
      <label for="keisai_ymd">お知らせ内容</label>
      <textarea id="information_naiyo" name="information_naiyo" required value=""></textarea>
    </div>
    <div class="col-xs-10" align="center">  
      <button type="submit" >登録</button>
    </div>
  </div>  
  </form>
  </body>
</htm>
