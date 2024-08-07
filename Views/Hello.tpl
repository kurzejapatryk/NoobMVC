<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .container {
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        font-family: 'Poppins', sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: antiquewhite;
        -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
        border-radius: 10px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>{$language['hello']}</h1>
        <h2>{$language['hello_installation_successful']}</h2>
        <div class="tenor-gif-embed" data-postid="23007548" data-share-method="host" data-aspect-ratio="1.40351" data-width="100%">
            <a href="https://tenor.com/view/success-gif-23007548">Success GIF</a>from <a href="https://tenor.com/search/success-gifs">Success GIFs</a>
        </div>
        {$language['hello_message']}
    </div>

    <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
    
    <!-- SQL debug -->
    {if SQL_DEBUG}
        <hr>
        {$SQL_DEBUG_HTML}
    {/if}

</body>
</html>