<?php
if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile')) {
    header("Location: target1.html");
} else {
    header("Location: target2.html");
}

echo "gogogo!";