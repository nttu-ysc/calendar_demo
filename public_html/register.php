<?php include('header.php') ?>
<?php include('data.php') ?>
<?php include('navbar.php') ?>

<div id="signUp">
    <form>
        <h2>Sign Up</h2>
        <div class="errors">
            <ul>
                <li></li>
            </ul>
        </div>
        <input type="text" name="name" placeholder="Enter User Name">
        <input type="email" name="email" placeholder="Enter E-mail">
        <input type="password" name="password" placeholder="Enter Password">
        <input type="password" name="confirmPassword" placeholder="Confirm Password">
        <button type="submit" class="btn">Sign Up</button>
    </form>
</div>
<?php include('footer.php') ?>