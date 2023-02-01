<?php
    $imgSend = false;
    $name = "";
    $image = $_FILES['image'];
    $current_url = $current_url = "http://" . $_SERVER['HTTP_HOST'];

    if(isset($image) && $image['error'] === 0) {
        if($image['size'] <= 400000) {
            $informationsImage = pathinfo($image['name']);
            $extensionsImage = $informationsImage['extension'];
            $allExtesions = ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'webp'];
            if(in_array($extensionsImage, $allExtesions)) {
                $name = rand().rand();
                move_uploaded_file($image['tmp_name'], 'uploads/'.$name.".".$extensionsImage);
                $imgSend = true;
            }
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/default.css">
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="style.css">
        <title>ShareFiles - Hébergez gratuitement vos images et en illimité</title>
    </head>
    <body>

        <header>
            <a href="#">
                <span>ShareFiles</span>
            </a>
        </header>

        <section>
            <h1>
                <?php
                echo $imgsend;
                    if($imgSend === true) {
                       echo "<img src='./uploads/{$name}.{$extensionsImage}' alt='image' />";  
                    } else {
                        echo "<i class='fas fa-paper-plane'></i>";
                    }
                ?>
            </h1>
            <form method="post" action="index.php" enctype="multipart/form-data">
                <?php 
                    if($imgSend === true) {
                        echo "<input class='input_url' type='text' value='{$current_url}/shareFiles/uploads/{$name}.{$extensionsImage}' />";
                    } else {
                        echo "
                        <p>
                            <label for='image'>Sélectionnez votre fichier<label><br>
                            <input type='file' name='image' id='image'>
                        </p>
                        <p id='send'>
                            <button type='submit'>Envoyer <i class='fas         fa-long-arrow-alt-right'></i></button>
                        </p>";
                    }
                ?>
            </form>
        </section>
        
    </body>
</html>