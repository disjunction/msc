<?php
if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mobile')) {
    header('Location: same_styles.html');
    die();
} else {
    echo 'hello world';
}