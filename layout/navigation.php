<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg" style="background-color: #3F3F3F;">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
            <a class="nav-item nav-link <?php echo ($current_page == 'new_article.php') ? 'active' : ''; ?>" href="new_article.php">New Article</a>
        </div>
    </div>
</nav>