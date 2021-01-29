<?php

require_once "init.php";

$user = new User;

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        
        $validate = new Validate;

        $validate->check($_POST, [
            'current_password' => [
                'required' => true,
                'min' => 3
            ],
            'new_password' => [
                'required' => true,
                'min' => 3
            ],
            'new_password_again' => [
                'required' => true,
                'min' => 3,
                'matches' => 'new_password'
            ]
        ]);

        if ($validate->passed()) {    
            if (password_verify(Input::get('current_password'), $user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('success', 'Password has been updated.');
                Redirect::to('index.php');
            } else {
                echo 'Current password is invalid';                
            }

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
        <label for="password">Current Password</label>
        <input type="text" name="current_password" id="password">
    </div>

    <div class=field>
        <label for="password">New Password</label>
        <input type="text" name="new_password" id="password">
    </div>

    <div class=field>
        <label for="password">New Password Again</label>
        <input type="text" name="new_password_again" id="password">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <div class=field>
        <button type="submit">Change</button>
    </div>
</form>