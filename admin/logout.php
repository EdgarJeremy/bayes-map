<?php
require_once '../core/autoload.php';
session_destroy();
redirect('./login.php');