<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: blanchedalmond;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>{$language['hello']}</h1>
        <h2>NoobMVC installation successful!</h2>
        <p>This is the default view for the Hello controller. You can find it in the Views/Hello.tpl file.</p>
        <p>For more information on how to use NoobMVC, please visit the <a href="https://github.com/kurzejapatryk/NoobMVC/wikim">NoobMVC website on Github</a>.</p>
        <p>Now, go ahead and create your own controllers and views!</p>
        <hr>
    </div>

    <!-- SQL debug -->
    {if SQL_DEBUG}
        {$SQL_DEBUG_HTML}
    {/if}

</body>
</html>