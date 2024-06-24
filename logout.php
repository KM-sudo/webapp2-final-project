<?php
session_start();

session_destroy();

header("Location: login.php");
exit;

header("Location: post.php");
exit;

header("Location: postdetails.php");
exit;