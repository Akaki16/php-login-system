<?php include 'includes/header.inc.php' ?>

<?php
$errors = [];
$inputs = [];

if (isset($_POST['register'])) {
    // validate form fields
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username is required';
    } else {
        $inputs['username'] = htmlspecialchars($_POST['username']);
    }

    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required';
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        } else {
            $inputs['email'] = htmlspecialchars($_POST['email']);
        }
    }

    if (empty($_POST['password'])) {
        $errors['password'] = 'Password is required';
    } else {
        $inputs['password'] = htmlspecialchars($_POST['password']);
    }

    if (empty($_POST['repeat_password'])) {
        $errors['repeat_password'] = 'Password is required';
    } else {
        $inputs['repeat_password'] = htmlspecialchars($_POST['repeat_password']);
    }

    if (isset($inputs['repeat_password']) && isset($inputs['password'])) {
        if ($inputs['repeat_password'] !== $inputs['password']) {
            $errors['repeat_password'] = 'Password is not matching';
        }
    }

    if (empty($errors) && $inputs['repeat_password'] === $inputs['password']) {
        $users = get_users();

        $user_names = [];

        foreach ($users as $user) {
            array_push($user_names, strtolower($user['username']));
        }

        // hash user password
        $hashed_pwd = password_hash($inputs['password'], PASSWORD_BCRYPT);

        if (!in_array(strtolower($inputs['username']), $user_names)) {
            register_user(
                [
                    ':username' => $inputs['username'],
                    ':email' => $inputs['email'],
                    ':user_pwd' => $hashed_pwd
                ]
            );

            // redirect to the output.php page after 3 seconds
            redirect(
                dest: 'output.php',
                delay: 3
            );
        } else {
            $errors['message'] = "Account with ({$inputs['username']}) username already exsits";
            $inputs = [];
        }
    }
}
?>

<div class="container text-center mt-5">
    <h1 class="text-white">Create an account</h1>
</div>

<div class="container text-center mt-3">
    <?php if (isset($errors['message'])): ?>
        <div id="alert-message" class="alert alert-danger">
            <?php echo $errors['message'] ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <form action="index.php" method="POST">
        <div class="mb-5">
            <label for="username" class="form-label text-white">Username</label>
            <input autocomplete="off" type="text" class="form-control" id="username" name="username" placeholder="Please enter your username" value="<?php echo isset($inputs['username']) ? $inputs['username'] : '' ?>">
            <?php if (!empty($errors['username'])) : ?>
                <div class="form-text text-danger">
                    <?php echo $errors['username'] ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="email" class="form-label text-white">Email</label>
            <input autocomplete="off" type="text" class="form-control" name="email" placeholder="Please enter your email address" value="<?php echo isset($inputs['email']) ? $inputs['email'] : '' ?>">
            <?php if (!empty($errors['email'])) : ?>
                <div class="form-text text-danger">
                    <?php echo $errors['email'] ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="password" class="form-label text-white">Password</label>
            <input autocomplete="off" type="password" class="form-control" name="password" placeholder="Please enter your password" value="<?php echo isset($inputs['password']) ? $inputs['password'] : '' ?>">
            <?php if (!empty($errors['password'])) : ?>
                <div class="form-text text-danger">
                    <?php echo $errors['password'] ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="repeat_password" class="form-label text-white">Repeat Password</label>
            <input autocomplete="off" type="password" class="form-control" name="repeat_password" placeholder="Please re-type your password" value="<?php echo isset($inputs['repeat_password']) ? $inputs['repeat_password'] : '' ?>">
            <?php if (!empty($errors['repeat_password'])) : ?>
                <div class="form-text text-danger">
                    <?php echo $errors['repeat_password'] ?>
                </div>
            <?php endif; ?>
        </div>
        <p class="text-white">
            Already have an account? <a href="login.php">Log In</a>
        </p>
        <div class="mb-5">
            <button style="width: 100%;" name="register" class="btn btn-success" type="submit">
                Submit
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const alertMessage = document.getElementById('alert-message');

        setTimeout(() => {
            alertMessage.style.display = 'none';
        }, 3000);
    });
</script>

<?php include 'includes/footer.inc.php' ?>