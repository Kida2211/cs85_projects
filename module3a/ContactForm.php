<!DOCTYPE html>
<html>
<head>
    <title>Contact Me</title>
</head>
<body>

<?php

// Function to validate and sanitize general input
function validateInput($data, $fieldName) {
    global $errorCount;
    if (empty($data)) {
        echo "\"$fieldName\" is a required field.<br />\n";
        ++$errorCount;
        $retval = "";
    } else {
        $retval = trim($data); // Remove surrounding whitespace
        $retval = stripslashes($retval); // Remove backslashes
    }
    return($retval);
}

// Function to validate and sanitize email input
function validateEmail($data, $fieldName) {
    global $errorCount;
    if (empty($data)) {
        echo "\"$fieldName\" is a required field.<br />\n";
        ++$errorCount;
        $retval = "";
    } else {
        $retval = filter_var($data, FILTER_SANITIZE_EMAIL); // Remove unwanted characters
        if (!filter_var($retval, FILTER_VALIDATE_EMAIL)) {
            echo "\"$fieldName\" is not a valid e-mail address.<br />\n";
            ++$errorCount;
        }
    }
    return($retval);
}

?>

</body>
</html>
