<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Assets/style.css">
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
    <div class="w-1/3 mx-auto p-5 mt-5 bg-amber-100 shadow-xl rounded-md">
        <h1 class="text-4xl">{$language['hello']}</h1>
        <h2 class="my-2 text-2xl">NoobMVC installation successful!</h2>
        <div class="tenor-gif-embed" data-postid="23007548" data-share-method="host" data-aspect-ratio="1.40351" data-width="100%">
            <a href="https://tenor.com/view/success-gif-23007548">Success GIF</a>from <a href="https://tenor.com/search/success-gifs">Success GIFs</a>
        </div>
        <p class="pt-2">This is the default view for the Hello controller. You can find it in the Views/Hello.tpl file.</p>
        <p>For more information on how to use NoobMVC, please visit the <a class="text-blue-600 hover:text-blue-400" href="https://github.com/kurzejapatryk/NoobMVC/wiki">NoobMVC website on Github</a>.</p>
        <p>Now, go ahead and create your own controllers and views!</p>
    </div>

    <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
    
    <!-- SQL debug -->
    {if SQL_DEBUG}
        <hr>
        {$SQL_DEBUG_HTML}
    {/if}

</body>
</html>