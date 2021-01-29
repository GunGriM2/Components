<?php
require_once "init.php";

#var_dump(Database::getInstance()->get('groups', ['id', '=', 2]));

$user = new User;
echo Session::flash('success');
if ($user->isLoggedIn()) {
    echo "Hi, <a href='#'>{$user->data()->username}</a>";
    echo "<p><a href='logout.php'>Logout</a></p>";
    echo "<p><a href='update.php'>Update profile</a></p>";
    echo "<p><a href='changepassword.php'>Change password</a></p>";

    if ($user->hasPermissions('admin')) {
        echo 'You are an admin!';
    }
} else {
    echo "<a href='login.php'>Login</a> or <a href='register.php'>Register</a>";
}
