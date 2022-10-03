<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="search-box">
        <h1 class="search-box__title">Search Books by Authors..</h1>
        <form action="">
            <div class="search-container">
                <input type="text" name="q" placeholder="Search books by author..." class="search-input" id="searchInput">
                <button type="submit" class="search-button" id="searchButton">Search</button>
            </div>
        </form>
        <div class="search-results" id="searchResults">
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>