<?php
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function redirectTo($url) {
    header("Location: $url");
    exit();
}

function displayError($message) {
    echo "<div class='error'>$message</div>";
}

function displaySuccess($message) {
    echo "<div class='success'>$message</div>";
}
?>