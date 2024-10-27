<header>
    <!-- AUFRUF-SETTING => DYNAMIC -->
    <h1><?= $setting['title'] ?></h1>
    <!-- image in DIV-TAG=> wie ein Block -->
    <div id="logo">
        <!-- AUFRUF-SETTING => DYNAMIC -->
        <img src="<?= asset($setting['logo'] ) ?>" alt="PIZZA">
    </div>
</header>