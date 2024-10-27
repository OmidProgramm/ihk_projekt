
<?php
    require('./funktions.php');
    if(!authenticated()){
        redirect("./login.php");
    }

    $user = get_user_data();
    if($_SERVER['REQUEST_METHOD']== 'POST' and isset($_POST['title']) and isset($_POST['category']) and isset($_POST['content']) and isset($_FILES['image'])){
        $title = $_POST['title'];
        $category = $_POST['category'];
        $content = $_POST['content'];
        $image = $_FILES['image']; 
        $errors = validate_post($title,$category,$content,$image);
        if(!count($errors)){
            $posts = get_data('posts');
            create_post($posts, $title, $category, $content,$image);
            redirect("./panel.php");
        }
    }
    
?>
<html>
    <head>
        <title>Panel</title>
        <link rel="stylesheet" href="<?= asset('css/website.css') ?>">
        <link rel="stylesheet" href="<?= asset('css/panel.css') ?>">
    </head>
    <body>
        <main>
            <nav>
                <ul>
                    <li><a href="<?= BASE_URL ?>website.php">Home</a></li>
                    <li><a href="<?= BASE_URL ?>panel.php">Panel</a></li>
                    <li><a href="<?= BASE_URL ?>create.php">Create post</a></li>
                    <li><a href="<?= BASE_URL ?>logout.php">Logout</a></li>
                </ul>
                <ul>
                    <li><b><?= $user['first_name'].' '.$user['last_name'] ?></b></li>
                </ul>
            </nav>
            <section class="content">
                <?php if(isset($errors) and count($errors)): ?>
                    <div class="errors">
                        <ul style="list-style: none;">
                            <?php foreach($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <!-- enctype=multipart/form-data fuer BINARY_FILE_SENDEN zu _SERVER -->
                <form method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="<?= isset($title)? $title: ''?>">
                    </div>
                    <div>
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="select">Select</option>
                            <option value="political" <?= (isset($category) and $category == 'political')? 'selected': ''?>>Political</option>
                            <option value="sport" <?= (isset($category) and $category == 'sport')? 'selected': ''?>>Sport</option>
                            <option value="social" <?= (isset($category) and $category == 'social')? 'selected': ''?>>Social</option>
                        </select>
                    </div>
                    <div>
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10" <?= isset($content)? $content: ''?>></textarea> 
                    </div>
                    <div>
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image"> 
                    </div>
                    <div>
                        <input type="submit" value="Create Post">
                    </div>
                </form>
            </section>
        </main>
    </body>
</html>