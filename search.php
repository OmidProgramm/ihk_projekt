
<?php 
    require('./funktions.php');
    if(!isset($_GET['search'])){
        redirect('website.php');
    }
    $search = $_GET['search'];
    $setting = get_data('setting');
    $posts = get_data('posts');
    $top_posts = get_posts_order_by_views($posts);
    $last_posts = get_posts_order_by_data($posts);
    $search_posts = get_posts_by_word($posts,$search);
    
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="<?= $setting['description'] ?>">
        <meta name="keyword" content="<?= $setting['Keywords'] ?>">
        <meta name="Author" content="<?= $setting['author'] ?>">
        <title><?= $setting['title'] ?></title>
        <link rel="stylesheet" href="<?= asset('css/website.css') ?>">
    </head>
    <body>
        <main>
           <?php require('./parts/header.php') ?>
           <?php require('./parts/navbar.php') ?>
           
            <section id="content">
                <?php require('./parts/sidebar.php') ?>
                <?php if($search_posts != null): ?>
                    <div id="articles">
                        <?php foreach($search_posts as $post): ?>
                            <article>
                                <div class="caption">
                                    <h3><?= $post['title'] ?></h3>
                                    <ul>
                                        <li>date:<span><?= date('Y M d',strtotime($post['date']))  ?></span></li>
                                        <li>views:<span><?= $post['view'] ?></span></li>
                                    </ul>
                                    <p><?= get_excerpt($post['content'])  ?></p>
                                    <a href="single.php?post=<?= $post['id'] ?>">more</a>
                                </div>
                                <div class="image">
                                    <img src="<?= asset($post['image']) ?>" alt="<?= $post['title'] ?>">
                                </div>
                                <div class="clearfix"></div>
                            </article>
                        <?php endforeach ?>               
                    </div>
                <?php else: ?>
                    <div id="articles">
                        <strong>Suchbegriff gibt es nicht...</strong>
                    </div>
                    
                <?php endif ?>
                <div class="clearfix"></div>
            </section>
           <?php require('./parts/footer.php') ?>
        </main>
    </body>
</html>