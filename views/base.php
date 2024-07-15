<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">
    <meta content="An online account-based ToDoList!" name="description">

    <title>ToDoList-PHP</title>

    <!-- All our defaults stylesheet used by every pages. -->
    <link rel="stylesheet" href="./styles/variables.css">
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/popup.css">
    <link rel="stylesheet" href="./styles/animations.css">

    <!-- link our additional styles is set. -->
    <?php 
    if(isset($additionalStyles)) {
        foreach($additionalStyles as $style) {
            echo("<link rel=\"stylesheet\" href=\"" . $style . "\">");
        }
    }
    ?>

</head>
<body>
    <!-- Our default header, which is displayed on every page. -->
    <header>
        <a href="./">
            <img class="header-logo" src="./resources/todo-icon.png" alt="">
            <h1>ToDoList</h1>
        </a>
        <div>
            <?php
            if(isset($_SESSION['userId'])) {
                // If any session is currently set, we show an Disconnect button
                echo("<a href='./profile' class='btn btn-secondary'>Profile</a>");
                echo("<a href='./logout' class='btn'>Logout</a>");
            } else {
                //Otherwise, we show our login/register buttons
                echo("<a href='./login' class='btn btn-secondary'>Login</a>");
                echo("<a href='./register' class='btn btn-action'>Register</a>");
            }
            ?>
        </div>
        
    </header>
    
    <!-- Main section, aka, content section of the page -->
    <main>
        <!-- Page's content defined by our controllers. -->
        <?php echo($content);?>        
    </main>

    <script src="./scripts/classes/Popup.js"></script>
</body>
</html>