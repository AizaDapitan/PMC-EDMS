<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<img src="{{ $img_path }}" />

	<form method="POST" role="form" enctype="multipart/form-data" action="/upload_file">
		@csrf()

		<input type="file" name="upload" >

		<input type="submit" name="submit">

	</form>


</body>
</html>