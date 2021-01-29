<?php
require_once "init.php";

$user = new User;

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        
        $validate = new Validate;

        $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15,
            ]
        ]);

        if ($validate->passed()) {
            $user->update(['username' => Input::get('username')]);
            Redirect::to('update.php');
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . '<br>';
            }
        }

    }
}

?>

<form action="" method="POST"  >
    <div class=field>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo $user->data()->username; ?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div class=field>
        <button type="submit">Update</button>
    </div>
</form>