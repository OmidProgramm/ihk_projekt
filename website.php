
<?php 
    require('./funktions.php');
    /* SETTING => DYNAMIC */
   $setting = get_data('setting');
   /* POSTS => DYNAMIC */
   $posts = get_data('posts');
   $top_posts = get_posts_order_by_views($posts);
   $last_posts = get_posts_order_by_data($posts);
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- AUFRUF-SETTING => DYNAMIC -->
        <meta name="description" content="<?= $setting['description'] ?>">
        <meta name="keyword" content="<?= $setting['Keywords'] ?>">
        <meta name="Author" content="<?= $setting['author'] ?>">
         <!-- AUFRUF-SETTING => DYNAMIC -->
        <title><?= $setting['title'] ?></title>
        <link rel="stylesheet" href="<?= asset('css/website.css') ?>">
    </head>
    <body>
        <main>
           <!-- INCLUDE HEADER.PHP & navbar.php -->
           <?php require('./parts/header.php') ?>
           <?php require('./parts/navbar.php') ?>
           
            <section id="content">
                <!-- INCLUDE sidebar.PHP -->
                <?php require('./parts/sidebar.php') ?>
                <div id="articles">
                    <!-- AUFRUF-POSTS => in LOOP -->
                    <?php foreach($posts as $post): ?>
                        <article>
                            <!-- CLASS: fuer WIEDERHOLEN ARTICLES -->
                            <div class="caption">
                                <!-- in CAPTION: DIV - LIST - P - a -->
                                <h3><?= $post['title'] ?></h3>
                                <ul>
                                    <!-- LI: fuer DATA & VIEWS -->
                                    <!-- SPAN: fuer DATA & wechsel die FARBE von DATA -->
                                    <li>date:<span><?= date('Y M d',strtotime($post['date']))  ?></span></li>
                                    <li>views:<span><?= $post['view'] ?></span></li>
                                </ul>
                                <!-- LOREM IPSUM: text vom INTERNET -->
                                <p><?= get_excerpt($post['content'])  ?></p>
                                <!-- post_id gleich id in database_posts -->
                                <a href="single.php?post=<?= $post['id'] ?>">more</a>
                            </div>
                            <div class="image">
                                <img src="<?= asset($post['image']) ?>" alt="<?= $post['title'] ?>">
                            </div>
                            <!-- CLEARFIX: COVER alle ARTICLE'S BEREICH  & FLOAT'S PROBLEM  -->
                            <div class="clearfix"></div>
                        </article>
                    <?php endforeach ?>
                    
                </div>
                <div class="clearfix"></div>
            </section>
            <!-- INCLUDE footer.PHP -->
           <?php require('./parts/footer.php') ?>
        </main>
    </body>
</html>

<!-- 
 respansiv & REAKTIVIAET (vakoneshgaraei) fuer HANDY
 -->