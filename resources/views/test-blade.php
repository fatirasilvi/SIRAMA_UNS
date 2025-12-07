<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
</head>
<body>
    <h1>Test File Upload</h1>
    
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form action="{{ route('test.upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".pdf">
        <button type="submit">Upload</button>
    </form>
    
    <hr>
    <h3>PHP Info:</h3>
    <p>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></p>
    <p>post_max_size: <?php echo ini_get('post_max_size'); ?></p>
    <p>memory_limit: <?php echo ini_get('memory_limit'); ?></p>
</body>
</html>