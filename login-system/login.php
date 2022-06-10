<?php include 'includes/header.inc.php' ?>

<?php
    $errors = [];
    $inputs = [];

    if (isset($_POST['login'])) {
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

        if (empty($errors)) {
            $user = get_user([$inputs['email']]);

            if ($user && login_user($inputs['password'], $user['pwd'])) {
                // redirect to the output.php page after 3 seconds
                redirect(
                    dest: 'output.php',
                    delay: 3
                );
            } else {
                $errors['message'] = 'Invalid email or password';
                $inputs = [];
            }
        }
    }
?>

<div class="container text-center mt-5">
    <h1 class="text-white">Log In and explore beautiful content</h1>
</div>

<div class="container text-center mt-3">
    <?php if (isset($errors['message'])): ?>
        <div id="alert-message" class="alert alert-danger">
            <?php echo $errors['message'] ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <form action="login.php" method="POST">
        <div class="mb-5">
            <label for="email" class="form-label text-white">Email</label>
            <input autocomplete="off" type="text" class="form-control" name="email" placeholder="Enter your email address" value="<?php echo isset($inputs['email']) ? $inputs['email'] : '' ?>">
            <?php if (!empty($errors['email'])): ?>
                <div class="form-text text-danger">
                    <?php echo $errors['email'] ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-5">
            <label for="password" class="form-label text-white">Password</label>
            <input autocomplete="off" type="password" class="form-control" name="password" placeholder="Enter your password" value="<?php echo isset($inputs['password']) ? $inputs['password'] : '' ?>">
            <?php if (!empty($errors['password'])): ?>
                <div class="form-text text-danger">
                    <?php echo $errors['password'] ?>
                </div>
            <?php endif; ?>
        </div>
        <p class="text-white">
            Don't have an account yet? <a href="index.php">Register</a>
        </p>
        <div class="mb-5">
            <button style="width: 100%;" class="btn btn-success" name="login" type="submit">
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