<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('admin/upload-test')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="upload_file" id="upload_file">
        <button type="submit">Uplaod</button>
    </form>

    <img src="{{url('admin/show-file/1698735376vFV8a.png')}}"/>
</body>
</html>