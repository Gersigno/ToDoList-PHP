<h2>🔑 Login !</h2>
<form action="#" method="post">
    <p><?= $message ?></p>
    <label for="id-username">Username :</label>
    <input type="text" name="username" id="id-username" placeholder="Username" max=20 min=3>
    <?= '<p>' . $errors['username'] . '</p>'?>

    <label for="id-password">Password :</label>
    <input type="password" name="password" id="id-password" placeholder="Password" max=32 min=8>
    <?= '<p>' . $errors['password'] . '</p>'?>

    <input type="submit" name="login" value="Login" class="btn btn-action">
</form>