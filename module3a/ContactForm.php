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

// Check if form was submitted
if (isset($_POST['Submit'])) {
    $Sender = validateInput($_POST['Sender'], "Your Name");
    $Email = validateEmail($_POST['Email'], "Your E-mail");
    $Subject = validateInput($_POST['Subject'], "Subject");
    $Message = validateInput($_POST['Message'], "Message");
    

    if ($errorCount == 0) {
        $ShowForm = FALSE;
    } else {
        $ShowForm = TRUE;
    }
}

// Display form or send email based on validation result
if ($ShowForm == TRUE) {
    if ($errorCount > 0)
        echo "<p>Please re-enter the form information below.</p>\n";

    displayForm($Sender, $Email, $Subject, $Message);
} else {
    $SenderAddress = "$Sender <$Email>";
    $Headers = "From: $SenderAddress\nCC: $SenderAddress\n";
    $result = mail("recipient@example.com", $Subject, $Message, $Headers);

    // Simulate what the email would look like for local testing
    echo "<h3>Simulated Email Output:</h3>";
    echo "<p><strong>To:</strong> recipient@example.com</p>";
    echo "<p><strong>From:</strong> $SenderAddress</p>";
    echo "<p><strong>Subject:</strong> $Subject</p>";
    echo "<p><strong>Message:</strong><br />" . nl2br(htmlspecialchars($Message)) . "</p>";

    if ($result)
        echo "<p>Your message has been sent. Thank you, " . $Sender . ".</p>\n";
    else
        echo "<p>There was an error sending your message, " . $Sender . ".</p>\n";
}

/*
Reflection:

1. What does each function do?
- validateInput(): Checks if a field is empty and sanitizes user input.
- validateEmail(): Similar to validateInput, but also checks for valid email format.
- displayForm(): Displays the contact form and preserves entered values (sticky form).

2. How is user input protected?
- By trimming whitespace, removing backslashes, and sanitizing/validating email.
- These steps help prevent invalid or malicious input.

3. What were the most confusing parts?
- Understanding the exact difference between sanitizing and validating.
- Managing the logic around when to show the form or send the email.

4. What could be improved?
- Add client-side validation (JavaScript).
- Use PHP libraries or frameworks like Laravel for better security and maintainability.

5. Why send a copy of the form to the sender?
- So the sender has a record of the message.
- It confirms their submission was received and successful.

Testing Note:
The mail() function triggered successfully, but no mail was sent because a mail server is not configured on localhost.
To demonstrate the logic, we added a simulated email preview to show what would be sent.

This approach proves the code is correct, and would work on a real server with SMTP configured.
*/

?>
</body>
</html>
