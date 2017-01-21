<?php
require 'config.php';
require 'index_class.php';

session_destroy();

header("location:index.php");

exit();