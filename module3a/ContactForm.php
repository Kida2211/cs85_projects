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

// Function to display the contact form with sticky input values
function displayForm($Sender, $Email, $Subject, $Message) {
?>
    <h2 style="text-align:center">Contact Me</h2>
    <form name="contact" action="ContactForm.php" method="post">
        <p>Your Name:
            <input type="text" name="Sender" value="<?php echo $Sender; ?>" />
        </p>
        <p>Your E-mail:
            <input type="text" name="Email" value="<?php echo $Email; ?>" />
        </p>
        <p>Subject:
            <input type="text" name="Subject" value="<?php echo $Subject; ?>" />
        </p>
        <p>Message:<br />
            <textarea name="Message"><?php echo $Message; ?></textarea>
        </p>
        <p>
            <input type="reset" value="Clear Form" />&nbsp;&nbsp;
            <input type="submit" name="Submit" value="Send Form" />
        </p>
    </form>
<?php
}

// Initialize variables
$ShowForm = TRUE;
$errorCount = 0;
$Sender = "";
$Email = "";
$Subject = "";
$Message = "";

?>

</body>
</html>
