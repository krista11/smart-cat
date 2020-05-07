<?php
function makeHeader()
{?>
    <div class="menu">
        <div class="menu-centered">
            <img src="images/cat-acc.png" alt="bossy-cat-cat"><a href="/bossy-cat">Bossy Cat</a>
        </div>
        <div class="menu-right">
            <a href="/bossy-cat/action_log">Action log</a>
            <a href="/bossy-cat/support">Support</a>
            <a href="Controllers/logout">Logout</a>
        </div>
    </div>
    <div class="mobile-menu">
        <a href="/bossy-cat/action_log">Action log</a>
        <a href="/bossy-cat/support">Support</a>
        <a href="Controllers/logout">Logout</a>
    </div>
<?php 
}
?>