<!DOCTYPE html>

<head>
    <title><?php echo $title ?></title>
</head>

<body>
    
<h1>Oops! There was an error processing your request.</h1>

<h2>What happened?</h2>
<p>You probably entered something into the previous form that doesn't make
   sense (like a blank event title, or a start date earlier than today).</p>

<h2>What went wrong?</h2>
<p>
<?php
    echo '(Error code: ' . $errno . ')<br />';
    switch ($errno) {
        case 1:
            echo 'You did not enter a title for the event.';
            break;
        case 2:
            echo 'You entered a \'from\' date that was before the \'to\' date.';
            break;
        case 3:
            echo 'You entered a \'from\' date that is before today\'s date.';
            break;
        case 4:
            echo 'You entered a \'from\' time that is on, or after, the \'to\' time.';
            break;
        case 5:
        case 6:
            echo 'You requested a repeating even with an invalid frequency.';
            break;
        case 7:
            echo 'You requested a repeating event with an \'end-repeat\' date that is before the original event\'s \'from\' date.';
            break;
        default:
            echo 'We\'re really not sure what it was, but you entered something invalid. (Please try again!)';
    }
?>
</p>

<h2>What do I do now?</h2>
<p>Please click the 'back' button in your web-browser to try again.</p>

</body>
</html>
