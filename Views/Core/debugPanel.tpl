<style>
    .debugPanel {
        font-family: 'Poppins', sans-serif;
        position: fixed;
        margin: 0;
        padding: 5px 10px;
        z-index: 500;
        bottom: 0;
        left: 0;
        width: calc(100% - 20px);
        background-color: royalblue;
        color: white;
    }

    .debugPanel__content {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        height: 100%;
        flex-wrap: nowrap;
    }

    .debugPanel span {
        white-space: nowrap;
    }

    .debugPanel h2 {
        font-size: 1em;
    }

    .debugPanel ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .debugPanel li {
        display: flex;
        float: left;
        padding: 5px 10px;
        border-right: 1px solid white;
        align-items: center;
        justify-content: center;
    }

    .debugPanel li:last-child {
        border-right: none;
    }

    .debugPanel li a {
        color: white;
        text-decoration: none;
    }

    .debugPanel li a:hover {
        color: white;
        text-decoration: underline;
    }

    .debugPanel__span {
        display: inline-block;
        padding: 5px;
        border-radius: 5px;
        margin-left: 5px;
        color: white;
        background-color: rgba(255, 255, 255, 0.2);
    }

    .debugPanel__SQLDebug {
        display: none;
        padding: 10px;
        overflow-y: auto;
        max-height: calc(100vh - 63px);;
    }

    .debugPanel__LoadedFiles {
        display: none;
        padding: 10px;
        overflow-y: auto;
        max-height: calc(100vh - 63px);
    }
</style>

<div style="height: 48px; width: 100%;"></div>

<div class="debugPanel">
    <div id="SQLDebug" class="debugPanel__SQLDebug" style="display: none;">
        <h2>Debug SQL</h2>
        {foreach $DEBUG['sql'] as $query}
            <table style="margin-bottom: 5px;">
                <tr>
                    <td colspan='2'>SQL: {$query['SQL']}</td>
                </tr>
                <tr>
                    <td>Status: {$query['error']}</td>
                    <td>Vars:
                        {foreach $query['vars'] as $key => $value}
                            <b>{$key}</b>: {$value},
                        {/foreach}
                    </td>
                </tr>
            </table>
        {/foreach}
        <hr>
    </div>
    <div id="LoadedFiles" class="debugPanel__LoadedFiles" style="display: none;">
        <h2>Loaded files</h2>
        <table>
            {foreach $DEBUG['loaded_files'] as $file}  
                <tr><td>{$file}</td></tr>
            {/foreach}
        </table>
        <hr>
    </div>
    <div class="debugPanel__content">
        <span><b>NoobMVC Debug</b></span>
        <ul>
            <li>Memory usage: <span class="debugPanel__span">{$DEBUG['memory_usage']} kb</span></li>
            <li>Execution time: <span class="debugPanel__span">{$DEBUG['execution_time']} ms<span></li>
            <li>Controller: <span class="debugPanel__span">{$DEBUG['controller']}</span></li>
            <li>Action: <span class="debugPanel__span">{$DEBUG['action']}</span></li>
            <li>View: <span class="debugPanel__span">{$DEBUG['view']}</span></li>
            <li>Lang: <span class="debugPanel__span">{$lang_code}</span></li>
            <li>User:
                {if $user}
                    <span class="debugPanel__span">{$user->username}</span>
                {else}
                    <span class="debugPanel__span">Guest</span>
                {/if}
            </li>
            <li class="dropdown">
                <a href="#" onclick="showSQLDebug()" class="dropdown-toggle" data-toggle="dropdown">SQL queries <span class="caret"></span></a>  
            </li>
            <li class="dropdown">
                <a href="#" onclick="showLoadedFiles()">Loaded files</a>
            </li>
        </ul>
        <span>v{CORE_VERSION}</span>
    </div>
</div>

<script>
function showSQLDebug() {
    var x = document.getElementById("SQLDebug");
    var y = document.getElementById("LoadedFiles");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
    }
}
function showLoadedFiles() {
    var x = document.getElementById("LoadedFiles");
    var y = document.getElementById("SQLDebug");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
    }
}
</script>