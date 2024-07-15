<?php
    if(isset($_SESSION['profile_msg'])) {
        //If any, show our main message and clear it's session's variable
        echo("<h3>" . $_SESSION['profile_msg'] . "</h3>");
        unset($_SESSION['profile_msg']);
    }
    echo("<h2>$username's account settings</h2>");
?>
<br>
<h3>Change password :</h3>
<form action="#" method="post" >
    <?php 
        if(isset($_SESSION['profile_error_msg'])) {
            //If any, show our error message and clear it's session's variable
            echo("<h3 class='error_msg'>" . $_SESSION['profile_error_msg'] . "</h3>");
            unset($_SESSION['profile_error_msg']);
        };
    ?>
    <h5>Current :</h5>
    <input type="password" name="current_pass" max=32 min=8>
    <br><br>
    <h5>New password :</h5>
    <input type="password" name="new_pass" max=32 min=8>
    <h5>New password (Re-type):</h5>
    <input type="password" name="new_pass-retype" max=32 min=8>
    <input type="submit" name="set_newpass" value="Upate password" class="btn btn-action btn-big">
</form>
<br>
<button class="btn btn-danger btn-big" onclick="Pop_DeleteAccount()">Delete my account</button>

<script src="./scripts/profile.js"></script>