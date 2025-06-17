<?php
function validateInput($data, $type = 'text', $minLength = 1, $maxLength = 255) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    if (empty($data)) {
        return false;
    }
    
    switch ($type) {
        case 'email':
            if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            break;
        case 'password':
            if (strlen($data) < 8) {
                return false;
            }
            break;
        default:
            if (strlen($data) < $minLength || strlen($data) > $maxLength) {
                return false;
            }
    }
    
    return $data;
}
?>