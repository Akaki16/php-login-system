<?php include 'includes/header.inc.php' ?>

<?php
    if (isset($_POST['logout'])) {
        redirect('index.php');
    }
?>

<div class="container text-center mt-5">
    <h1 class="text-white">Welcome</h1>
    <form class="mt-4" action="output.php" method="POST">
        <button name="logout" class="btn btn-danger" type="submit">
            Logout
        </button>
    </form>
</div>

<?php include 'includes/footer.inc.php' ?>