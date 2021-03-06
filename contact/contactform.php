
<?php
//start of php code

//necessary functions
//cleans string because _POST ones can be dirty with bunch of unnecessary information
function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

//if there's a POST request via submit form, and the email has been filled out.
//You can leave it as it is, as long as you don't change the <input> name in form.html
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED

    // I... I forgot your main email x.x but I just directed it to your portfolio site email for now. Change it to your test purpose email.
    // of course, change it to your friend's email for production launch.
    $email_to = "leticia.brand@live.com";
    // This will be the email's subject. You can either make the user set the title of email, or leave it as hardcoded.
    // One benefit of putting it as hardcoded is that your friend will be able to filter out all these automatic emails by title to one inbox.
    $email_subject = "Automatic Email From Website"; //this will be overridden below. Just a placeholder.
    
    // This is for when the submission went wrong. You could just leave it as it is, or modify it, or just not provide any error displays. The problem with having no error displayed is of course, the user won't know if he/she fucked it up.
    // One another elegant way to do this would be to keep the user from making an invalid request in the first place by putting a javascript conditional function at form.html, instead of checking validity in php(server).
    // I put in some sample of how validity could be checked from html/javascript at form.html. Take a look at function verifycontents().
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    // if it was an invalid post request (ex : someone using curl or browser address explicitly to hack/screw with the system), just die.
    if(!isset($_POST['subject'])||
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
    //this is the part that you put the form values(<input> values) by accessing each as their names.
    // $somethingsomething is obviously a variable. PHP sucks so bad that they need a lot of money to work so their variables always demand a dollar before using them lmao
    $subject = $_POST['subject'];
    $name = $_POST['name']; 
    $email_from = $_POST['email']; 
    $comments = $_POST['comments']; 



  
    //below is just some bunch of code for input validation. Again, it's more elegant to do it in html javascript functions.

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
 
  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    
 
     
    //This is the part where you craft the email message.
    //note that .= is not the same as = because .= adds the right one to left one whereas = replaces right value to left value.

    $email_subject = "Contato de ".clean_string($subject);
    if(clean_string($subject)=="or�amento ou outros"){
        $email_subject = "Contato para ".clean_string($subject);
    }

    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
    


    //this is the part where the mailing magic happens.
    //headers require where it was from, saying "From: sampleemailsender@email.com\r\nReply-To: sampleemailsender@email.com\r\nX-Mailer: PHP/5.6orwhateverversionnumber". The code below does it automatically for you.
    //email_to is where the email is going to be sent.
    //email_subject is title of email.
    //email_message is email content.


    //also, you did a good job reading this far down, you're a good cat. I'm proud of you. *pat pat*.


    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);  
?>

<!-- PHP code got interrupted by putting '?>'. Then, it becomes an html document. It's shown to the user. You can even put javascript and such so it doesn't just show some soulless blank page with some sentences. If you need help with it, I'll be glad to help.  -->
 





<!-- include your own success html here -->
 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Enviado!</title>
      <link rel="STYLESHEET" type="text/css" href="contact.css">
</head>
<body>

<h2>Obrigado pelo contato!</h2>
<p>Retornarei assim que poss�vel!</p>

<br>Thank you for contacting us. We will be in touch with you very soon :3<br>
<img src = "http://i.imgur.com/oIabO8I.gif" />

</body>
</html>




<!-- Don't erase this bottom part, this is needed to close the "if" statement from above :) -->
<?php 
}
//this one is actually closure from the "if" statement from way up there. It's because we want to include an html right above here after the email is sent.
?>