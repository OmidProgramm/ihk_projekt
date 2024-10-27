<nav>
    <ul>
        <li><a href="<?= BASE_URL ?>/website.php">Home</a></li>
        <li><a href="<?= BASE_URL ?>/category.php?category=political">Political</a></li>
        <li><a href="<?= BASE_URL ?>/category.php?category=sport">Sport</a></li>
        <li><a href="<?= BASE_URL ?>/category.php?category=social">Social</a></li>
        <?php if(authenticated()): ?>
            <li><a style="color: red;" href="<?= BASE_URL ?>/panel.php">Panel</a></li>
        <?php else: ?>
            <li><a style="color: red;" href="<?= BASE_URL ?>/login.php">Login</a></li>
        <?php endif ?>
        
    </ul>
    <!-- FORM-SEARCH ist am meisten GET -->
    <form action="search.php" method="GET">
        <!-- PLACEHOLDER: text-begriff in kaesten -->
        <input type="text" name="search" placeholder="suchbegriff" value="<?= isset($_GET['search'])? $_GET['search']: '' ?>">
        <input type="submit" value="submit">
    </form>
</nav>