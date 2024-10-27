
<?php 

// session fuer login user(speichert die Infos und zugreif unterschieldliche pages wie koockie)
// sessions speichern in $_session as array
    session_start();
/* 1 */
    const BASE_URL = 'http://localhost/ihk_projekt/';
    /* 2  AUFRUF FILES  */
    function asset($file){
        return BASE_URL.'assets/'.$file;
    }
     /* 3 ARRAY => AUSGEBEN-TEST */
    function dd($data){
        die('<pre>'.var_export($data, true).'</pre>');
    }
    /* 8 Azuruck in website  */
    /* path ist die richtug der adresse  */
    function redirect($path){
        /* function_heaser treibt redirect */
        header("location: $path");
        /* aufruf exit_function nach redirect */
        exit();
    }
    /* 5 AUFRUF => ZUSAMMENFASSUNG-SUMMARY  */

    function get_excerpt($content,$count=200){
        return substr($content,0,$count).'...';
    }
    /* 4 JASON => ARRAY-AUSGABE */
    function get_data($data_file){
        $file_adress = './database/'.$data_file.'.json';
        $file = fopen($file_adress, "r+");
        $database = fread($file,filesize($file_adress));
        fclose($file);
        /* mit TRUE => ARRAY ---- ohne TRUE => OBJECT */
        return json_decode($database, true);
    }
    // 17 function fuer delete.php
    function set_data($data_file, $new_data){
        //fwrite(): Argument_2($new_data) must be of type string, not array => $new_data:json
        $new_data = json_encode($new_data);
        $file_adress = './database/'.$data_file.'.json';
        // W+ löscht alte DATA und FILE eröffnet ohne data
        $file = fopen($file_adress,"w+");
        $database = fwrite($file,$new_data);
        fclose($file);
        return true;
    }
    /*  6 uasort_function richtet funcktion ein  */
    function get_posts_order_by_views($posts){
        /* uasort_function return true oder false */
        uasort($posts, function($first,$second){
            /* wenn first großer als second ist, return -1: first hat vorrang */
            if($first['view'] > $second['view']){
                return -1;
            }else{
                return 1;
            }
        });
        /* array_values aendert keys auf null => reset: erste key wird auf null gestellt */
        $posts = array_values($posts);
        return count($posts)? $posts: null;
    }
    /* 7 sort posts wegen datum  */
   function get_posts_order_by_data($posts){
    uasort($posts, function($first,$second){
        /*  strtotime => wandelt datum in sekunden wie eine zahl */
        if(strtotime($first['date']) > strtotime($second['date'])){
            return -1;
        }else{
            return 1;
        }
    });
    $posts = array_values($posts);
    return count($posts)? $posts: null;
   }
   // 20 sort_last_id fuer create_post_function
   function get_last_post($posts){
    uasort($posts, function($first,$second){
        if($first['id'] > $second['id']){
            return -1;
        }else{
            return 1;
        }
    });
    $posts = array_values($posts);
    return $posts[0];
   }
    // 9 function fuer single.php mit ID 
   function get_post_by_id($posts,$id){
    //  array_filter() return neue ARRAY  
    $post = array_filter($posts, function($post)use($id){
        if($post['id'] == $id){
            return true;
        }else{
            return false;
        }
    });
    //  array_values($post) reset keys 
    $post = array_values($post);
    //  nur ein VALUE(ID) als ruekgabe  
    return (count($post))? $post[0]: null;
   }
   // 10 function fuer suchen ein wotr in website.php fuer search.php
   function get_posts_by_word($posts,$search){
    $search = trim($search);
    $posts = array_filter($posts,function($post)use($search){
        // function_strpos => vergleicht eingabe_wort mit text gibt array_nummer oder false zurueck
        // === -> genau
        if(strpos($post['title'],$search)!== false or strpos($post['content'],$search) !== false){
            return true;
        }else{
            return false;
        }
    });
    $posts = array_values($posts);
    return count($posts)? $posts: null;
   }
   // 11 function_filter_category
   function get_posts_by_category($posts, $category){
    $posts =array_filter($posts, function($post)use($category){
        if($post['category'] == $category){
            return true;
        }else{
            return false;
        }
    });
    $posts = array_values($posts);
    return count($posts)? $posts: null;
   } 
   // 18 nutz set_data fuer filterd_data und speicher in database.json
   function delete_post($posts, $id){
    $posts = array_filter($posts, function($post)use($id){
        // ungezielte ID soll nicht löschen
        if($post['id'] != $id){
            return true;
        }else{
            // gezielte ID soll und image löschen
            delete_image($post['image']);
            return false;
        }
    });
    $posts = array_values($posts);
    set_data('posts',$posts);
    return true;
   }
    // 21 function fuer create_post in create.php
    function create_post($posts,$title,$category,$content,$image){
        $last_post = get_last_post($posts);
        $id = $last_post['id'] + 1;
        $image_name = upload_image($image);
        $new_post =[
            'id' => $id,
            'title' => $title,
            'category' => $category,
            'content' => $content,
            'view' => 0,
            'image' => $image_name,
            'date' => date('Y-m-d H:i:s' )
        ];
        $posts[] = $new_post; 
        set_data('posts', $posts);
        return true;

    }
   // 19 validate fuer create-posts in create.php eingabe_post
   function validate_post($title,$category,$content,$image){
    $errors = [];
    if(empty($title)){
        $errors[] = 'Please enter Title';
    }elseif(strlen($title)<3){
        $errors[] = 'Title must be bigger than 3 Char';
    }
    if(empty($category)){
        $errors[] = 'Please select Category';
    }elseif(!in_array($category, ['political', 'sport', 'social'])){
        $errors[] = 'selected Category is invalid';
    }
    if(empty($content)){
        $errors[] = 'Please enter Content';
    }elseif(strlen($content)<10){
        $errors[] = 'Title must be bigger than 10 Char';
    }
    // verhindern kein text statt image schicken mit is_array_funktion
    /*
            array (
                'name' => 'Screenshot 2024-02-27 110433.png',
                'type' => 'image/png',
                'tmp_name' => 'C:\\xampp\\tmp\\phpB3.tmp',
                'error' => 0,
                'size' => 15879,
            )
        */
    if(!is_array($image)){
        $errors[] = "selected Image is invalid";
    }elseif(empty($image['name'])){
        $errors[] = "please fill image field";
    }elseif($image['size'] > 500000){
        $errors[] = "image size should be smaller then 5MB";
    }elseif(!in_array($image['type'],['image/jpeg', 'image/jpg', 'image/png', 'image/gig', 'image/gif'])){
        $errors[] = "selected image is invalid";
    }
    return $errors;
   }
   // 24 funktion fuer bearbeiten post in panel.php
   function edit_post($posts,$id,$title,$category,$content,$image){
    $posts = array_map(function($post)use($id,$title,$category,$content,$image){
        if($post['id'] == $id){
            $post['title'] = $title;
            $post['category'] = $category;
            $post['content'] = $content;
            if(!empty($image['name'])){
                delete_image($post['image']);
                $post['image'] = upload_image($image);
            }
        }
        return $post;
    }, $posts);
    set_data('posts',$posts);
    return true;
   }
   // 25 testen ob bearbeiten gültig ist oder nicht
  function validate_edit_post($title,$category,$content,$image){
    $errors = [];
    if(empty($title)){
        $errors[] = 'Please enter Title';
    }elseif(strlen($title)<3){
        $errors[] = 'Title must be bigger than 3 Char';
    }
    if(empty($category)){
        $errors[] = 'Please select Category';
    }elseif(!in_array($category, ['political', 'sport', 'social'])){
        $errors[] = 'selected Category is invalid';
    }
    if(empty($content)){
        $errors[] = 'Please enter Content';
    }elseif(strlen($content)<10){
        $errors[] = 'Title must be bigger than 10 Char';
    }
    if(!empty($image['name'])){
        if(!is_array($image)){
            $errors[] = "selected Image is invalid";
        }elseif($image['size'] > 500000){
            $errors[] = "image size should be smaller then 5MB";
        }elseif(!in_array($image['type'],['image/jpeg', 'image/jpg', 'image/png', 'image/gig', 'image/gif'])){
            $errors[] = "selected image is invalid";
        }
    }
    
    return $errors;
   }
   // 12 function fuer login.php => einlogen
   function login($users,$email,$password){
    $user = array_filter($users, function($user)use($email,$password){
        if($user['email'] == $email and $user['password'] == $password){
            return true;
        }else{
            return false;
        }
    });
    $user = array_values($user);
    return count($user)? $user[0]: null;
   }
   // 13  validation  bevor einlogen in panel.php und login,php
   function validate_login($email, $password){
    $errors = [];
    if(empty($email)){
        $errors[]= 'Please fill email field';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[]= 'Email is invalid';
    }
    if(empty($password)){
        $errors[]= 'Please fill password field';
    }
    return $errors;
   }
   // 14 nach login kann panel.php sehen
   function authenticated(){
    if(isset($_SESSION['user'])){
        return true;
    }else{
        return false;
    }
   }
   // 15 logout => mit unset-funktion oder session-destroy
   function logout(){
    unset($_SESSION['user']);
    redirect('./login.php');
   }
   // 16 eingelogter-user zeigen in panel.php
   function get_user_data(){
    if(authenticated()){
        return $_SESSION['user'];
    }else{
        return null;
    }
   }
  // 22 funktio fuer image-upload in create.php
  function upload_image($file){
    //directory_pfad fuer speicher file
    $dir = 'assets/images/';
    //new_nam fuer upload_image
    $name = $file['name'];
    // suffix wie jpg oder png bekommen und in extension speichern
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $new_name = time().'.'.$extension;
    //pfad temp_gespeicherte_file von server bekommen (tmp_name)
    $tmp = $file['tmp_name'];
    
    if(move_uploaded_file($tmp,$dir.$new_name)){
        return "images/$new_name";
    }else{
        return '';
    }

  } 
  // 23 funcktion fuer delete_image in panel.php
  function delete_image($image){
    // testen ob das image existiert oder nicht
    if(file_exists('assets/'.$image)){
        // delete image
        unlink('assets/'.$image);
        return true;
    }
    else{
        return false;
    }
  }
  