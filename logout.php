<?php
session_start();

// Xóa tất cả session
session_unset();
session_destroy();

// Chuyển hướng về trang login
header("Location: login.php");
exit();
?> 