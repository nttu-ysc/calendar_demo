<?php include('header.php') ?>
<?php include('data.php') ?>
<?php session_start();
session_destroy() ?>
<?php include('navbar.php') ?>

<div id="signIn">
    <form>
        <h2>Sign In</h2>
        <div class="errors">
            <ul>
                <li></li>
            </ul>
        </div>
        <input type="email" name="email" placeholder="Enter E-mail">
        <input type="password" name="password" placeholder="Enter Password">
        <button class="btn">Sign In</button>
    </form>
</div>
<?php include('footer.php') ?>