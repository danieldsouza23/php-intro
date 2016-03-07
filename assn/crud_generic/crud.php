<?php
require_once "words.php";
shuffle($WORDS);
?>
<!DOCTYPE html>
<html>
<head>
<title><?= $assignment_type ?>: <?= $title_singular ?> Database CRUD</title>
</head>
<body style="margin-left:5%; margin-bottom: 60px; margin-right: 5%; font-family: sans-serif;">
<h1><?= $assignment_type ?>: <?= $title_singular ?> Database CRUD</h1>
<p>
In this exam you will build a web based application to
track data about <?= strtolower($title_plural) ?>.
We will only allow logged in users
to track <?= strtolower($title_plural) ?>.
</p>
<?php if ( $assignment_type == 'Exam' ) { ?>
<h1><?= $assignment_type ?> Rules</h1>
<p>
In order for us to consider your exam for grading, you must read the
statement below and if you agree with the statement sign and date below
and turn the entire exam packet in at the end of the exam.
If you do not return this signed exam sheet before you leave the room,
your exam will not be graded and you will receive a zero on this exam.
</p>
<div style="border:2px solid black; padding: 5px; margin: 5px; width:100%"><b>
This examination represents my own work and I have neither
received nor given anyone any aid on this examination.
<pre>

SIGNATURE: ________________________________________________

PRINT NAME: __________________________________________________

Date:  _______________
</pre>
</b>
</div>
<p>
This exam is open-book, open notes, open network, and you can use
any of your prior work for the class to complete the exam.
You cannot listen to audio or watch any videos during the exam.
You cannot get any help from any other person. You also cannot give
any help to any other person. We will grade partial
solutions so you should hand in your work at the end of the
exam even is it is not 100% complete. Please do not discuss the
nature of the exam with anyone except the teaching staff until
we tell you that all students have completed the exam.
</p>
<?php } ?>
<h2 clear="all">General Specifications</h2>
<p>
Here are some general specifications for this <?= $assignment_type_lower ?>:
<ul>
<li>
Your name must be in the title tag of the HTML for all of the pages
for this <?= $assignment_type_lower ?>.
</li>
<li>
All data that comes from the users must be properly escaped
using the <b>htmlentities()</b> function in PHP.  You do not
need to escape text that is generated by your program.
</li>
<li>
You must follow the POST-Redirect-GET pattern for all POST requests.
This means when your program receives and processes a POST request,
it must not generate any HTML as the HTTP response to that request.
It must use the "header('Location: ...');" function and "return"
to send the location header and redirect the browser
to the same or a different page.
</li>
<li>
Please do not use HTML5 in-browser data
validation (i.e. type="number") for the fields
in this <?= $assignment_type_lower ?> as we want to make sure you can properly do server
side data validation.  And in general, even when you do client-side
data validation, you should still validate data on the server in case
the user is using a non-HTML5 browser.
</li>
</ul>
<?php if ( $reference ) { ?>
<h2>Sample Implementation</h2>
<p>
You can experiment with a reference implementation at:
</p>
<p>
<a href="<?= $reference ?>" target="_blank">Sample implementation</a>
</p>
<?php } ?>
<h2>Using the Autograder</h2>
<p>
This <?= $assignment_type_lower ?> will be automatically graded and so your web server will need an 
Internet-accessible URL so you can submit it for autograding.  To achieve this
you will need to install and use a piece of software called "ngrok".  Instructions
for installing and using ngrok are available at:
</p>
<p>
<a href="http://www.php-intro.com/ngrok.php" target="_blank">http://www.php-intro.com/ngrok.php</a>
</p>
<p>
Please see the process for handing in the <?= $assignment_type_lower ?> at the end of this document.
</p>
<p>
<b>Important:</b> The autograder will demand that your name is in the &lt;title&gt;
tag in the head are of your document.  If the autograder does not find your name,
it will run all the tests but will not treat the grade as official.
</p>
<h2>Creating <?= $title_singular ?> table</h2>
<p>
You can reuse or adapt a table from a previous assignment.   This assignment
will need a table as follows:
<pre>
    CREATE TABLE <?= $table_name ?> (
        <?= strtolower($table_name) ?>_id INTEGER NOT NULL KEY AUTO_INCREMENT,
<?php
$first = True;
foreach($fields as $field ) {
    if ( ! $first ) echo(",\n");
    $first = False;
    if ( $field[2] == 'i' ) {
        echo('        '.$field[1].' INTEGER');
    } else {
        echo('        '.$field[1].' VARCHAR(255)');
    }
}
echo("\n");
?>) ENGINE=InnoDB DEFAULT CHARSET=utf8;
</pre>

<h2>Protecting the add.php and edit.php</h2>
<p>
In order to protect the database from being modified without the user properly
logging in, the <b >add.php</b> and <b>edit.php</b> must first check the session to see
if the user's name is set and if the user's name is not set in the session
the they must stop immediately using the PHP die() function:
<pre>
    die("ACCESS DENIED");
</pre>
To test, navigate to <b>add.php</b> manually without logging in - it
should fail with "ACCESS DENIED".
</p>
<h2>Log in</h2>
<p>
If the user is not logged in, they will be presented a screen with a welcome 
and a link to <b>login.php</b> - they should not see the table of data.
<div style="border: 2px solid black; padding: 10px;">
<h2>Welcome to the <?= $title_plural ?> Database</h2>
<p><span style="color:blue; text-decoration: underline;">Please log in</span></p>
</div>
<p>
<a href="01-Login.png" target="_blank">
<img style="margin-left: 10px; float:right;"
alt="Image of the login screen"
width="300px" src="../crud_generic/01-Login.png" border="2"/>
</a>
<p>
<p>
The autograder will log in to your program with the following account 
and password:
<pre>
Account: umsi@umich.edu
Password: php123
</pre>
<p>
The login screen needs to have some error checking on its input
data.  If either the name or the password field is blank, you should
display a message of the form:
<pre style="color:red">
    User name and password are required
</pre>
If the password is non-blank and incorrect, you should put up a message
of the form:
<pre style="color:red">
    Incorrect password
</pre>
<p>
<b>Note:</b> Please name your form fields in <b>login.php</b> exactly 
as follows for autograding:
<pre>
User Name &lt;input type="text" name="email"&gt;&lt;br/&gt;
Password &lt;input type="text" name="pass"&gt;&lt;br/&gt;
</pre>

<h2><?= $title_singular ?> Database Main List</h2>
<p>
Once the user is logged in, they should should be redirected to <b>index.php</b>
where they will be shown see a list of
the <?= strtolower($title_plural) ?> in the database in a table similar to the
following:
<div style="border: 2px solid black; padding: 10px;">
<h2>Welcome to the <?= $title_plural ?> Database</h2>
<?php
$first = false;
$wcount = 0;
for($i=0; $i<4; $i++ ) {
    if ( ! $first ) {
        echo('<table border="1">'."\n<thead><tr>\n");
        foreach($fields as $field) {
          echo("<th>".htmlentities($field[0])."</th>\n");
        }
        echo("<th>Action</th>\n");
        echo("</tr></thead>\n");
        $first = true;
    }
    echo("<tr>");
    foreach($fields as $field) {
        $v1 = $field[2];
        if ( $v1 == 'i' ) {
            echo("<td>".rand(1,99)."</td>");
        } else {
            $wcount++; 
            echo("<td>".ucwords($WORDS[$wcount])."</td>");
        }
    }
    echo("<td>");
    echo('<span style="color:blue; text-decoration: underline;">Edit</span> / ');
    echo('<span style="color:blue; text-decoration: underline;">Delete</span>');
    echo("</td>\n");
    echo("</tr>\n");
}

if ( $first ) {
    echo("</table>\n");
} else {
    echo("<p>No rows found</p>\n");
}
?>
</p>
<p><span style="color:blue; text-decoration: underline;">Add New Entry</span></p>
<p><span style="color:blue; text-decoration: underline;">Logout</span></p>
</div>
<p>
If there are no rows in the table, do not print out the table, but simply
print out <b>"No rows found"</b>.
</p>
<p>
There should also be options to <b>Add a New Entry</b> and <b>Log Out</b> 
presented after the table.
</p>
<p>
If the <b>Logout link</b> is pressed the user should be sent to the
<b>logout.php</b> page which clears session variables and redirects
back to <b>index.php</b>.
</p>
<h2>Adding new Records</h2>
<p>
When the user asks to add a new record, they should be presented with a
screen that allows them to append a new <?= strtolower($title_singular) ?>.
Each <?= strtolower($title_singular) ?> will have the following fields:
<ul>
<?php
$numeric = false;
$length = false;
foreach($fields as $field) {
    echo ("<li>\n");
    $title = $field[0];
    echo($title."\n");
    $name = $field[1];
    $v1 = $field[2];
    $v2 = isset($field[3]) ? $field[3] : false;
    if ( $v1 == 'i' ) {
        echo(" - must be an integer - use is_numeric() to validate ");
        if ( $numeric === false ) $numeric = $title . " must be an integer";
    }
    if ( is_numeric($v1) && is_numeric($v2) ) {
        if ( $v1 == $v2 ) {
            $msg = "must be exactly ".$v1." characters long - use strlen() to validate";
        } else {
            $msg = "must be between ".$v1." and ".$v2." characters long - use strlen() to validate";
        }
        echo " - ".$msg;
        if ( $length === false ) $length = $title." ".$msg;
    }
    echo ("</li>\n");
}
?>
</ul>
<b>Important:</b> Make sure to name the fields in your forms using the lower case version 
of the field names so that the autograder can work:
<pre>
  &lt;input type="text" name="<?= $fields[0][1] ?>"&gt;
</pre>
</p>
<p>When processing an incoming POST, data must be validated.
All fields are required, if there is a missing (i.e. blank) field,
issue a message like:
<pre style="color: red;">
    All fields are required
</pre>
</p>
<?php
if ( $numeric !== false ) {
    echo("\n<p>If the user enters a non-numeric field, you should issue a message like:\n");
    echo('<pre style="color: red;">'."\n");
    echo("    ".$numeric);
    echo("\n</pre>\n</p>");
}
if ( $length !== false ) {
    echo("\n<p>If the user enters a field with an incorrect length, you should issues a message like:\n");
    echo('<pre style="color: red;">'."\n");
    echo("    ".$length);
    echo("\n</pre>\n</p>");
}
?>
<p>
If there are any errors on the input, do not add the record to the stored data.
Redirect the user back to the <b>add.php</b> script and display the error message
"flash style".
<pre>
    if ( ... at least one of the fields is empty ... ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    }

...

    if ( isset($_SESSION['error']) ) {
        echo('&lt;p style="color: red;"&gt;'.htmlentities($_SESSION['error'])."&lt;/p&gt;\n");
        unset($_SESSION['error']);
    }
</pre>
<p>
Note that only one of the error messages need to come out regardless of
how many errors the user makes in their input data.  Once you detect one
error in the input data, you can stop checking for further errors.
</p>
<p>
If the data validates and the add is successful, redirect to <b>index.php</b> with a 
successful flash message:
<pre>
</pre>
<pre style="color: green;">
   Record added
</pre>

<h2>Editing Records</h2>
<p>
When you edit a record, the prior data must be shown and properly escaped.  All of the 
data validation must be performed on the edit data as required in the <b>add.php</b>.
Make sure to include the "id" parameter (you may name this variable differently) on 
the redirect statement in the <b>edit.php</b> when an error is detected:
<pre>
    if ( ... a field is missing ... ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?<?= strtolower($table_name) ?>_id=".$_REQUEST['id']);
        return;
    }
</pre>
If the data validates and the edit is successful, redirect to <b>index.php</b> with a 
successful flash message:
<pre>
</pre>
<pre style="color: green;">
   Record edited
</pre>
<h2>Deleteing Records</h2>
<p>
When the user selects the "Delete" link from the list of 
<?= $title_plural ?> you should put up a form with "Delete" and
"Cancel" options.  
</p>
<img src="../crud_generic/02-Delete.png" border="2">
<p>
If the "Delete" button is pressed, the record 
is deleted and the user is redirected to <b>index.php</b> with a success message:
<pre style="color: green;">
   Record deleted
</pre>


<h1>What To Hand In</h1>
<p>
This <?= $assignment_type_lower ?> will be autograded by a link that you will be provided with in the LMS
system.   When you launch the autograder, it will prompt for a web-accessible URL
where it can access your web application.   Since your application is running
on localhost, you will need the <a href="http://www.php-intro.com/ngrok.php" 
target="_blank">Ngrok</a> application installed.
</p>
<hr/>
Provided by: <a href="http://www.php-intro.com/" target="_blank">www.php-intro.com</a>
<center>
<?php if ( $assignment_type == 'Exam' ) { ?>
Copyright Charles R. Severance - All Rights Reserved
<?php } else { ?>
Copyright Creative Commons Attribution 3.0 - Charles R. Severance
<?php } ?>
</center>
</body>
</html>
