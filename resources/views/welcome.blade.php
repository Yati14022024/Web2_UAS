<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body>
    <h1>Welcome to My Blog</h1>
    <p>This is the welcome page of my laravel application.</p>

    <!-- Button to navigate to post index -->
    <a href="{{ route('posts.index') }}">Link to Posts Index</a>
        <button>View All Posts</button>
    </a>
</body>

</html>