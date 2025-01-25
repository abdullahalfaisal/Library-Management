<?php
function getAllTokens() {
    return ['1010', '2020', '3030', '4040', '5050', '6060', '7070', '8080', '9090', '0000'];
}

function validateToken($token) {
    $validTokens = getAllTokens();
    return in_array($token, $validTokens);
}
?>
