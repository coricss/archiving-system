<?php 

include_once('../database/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\EXCEPTION;

require_once('../assets/plugins/PHPMailer/src/PHPMailer.php');
require_once('../assets/plugins/PHPMailer/src/SMTP.php');
require_once('../assets/plugins/PHPMailer/src/Exception.php');


function generateEmail($request_id, $receiver, $receiverCC, $receiverBCC, $message) {

  $mail = new PHPMailer(true);
  $code = random_int(100000, 999999);
  
  $subject = 'File Request: '.$request_id;


  try {
      //Server settings
      // $mail->SMTPDebug = 3;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'ieti.system2023@gmail.com';                     //SMTP username
      $mail->Password   = 'qexfebxxlivlwkky'; //IETI_2023                              //SMTP password
      $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
      

      $mail->setFrom('ieti.system2023@gmail.com', 'IETI | Digital Archive Management System'); //Sender
      $mail->addAddress($receiver);     //Add a recipient
      foreach($receiverCC as $email)
      {
        $mail->AddCC($email); // $mail->addCC(''); //Add CC ADMINS
      }
      
      $mail->addBCC($receiverBCC); //Add BCC DIRECTOR

      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject =  $subject;
      $mail->Body    =  
      "
      <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
      <html>
      
      <head>
          <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
          <meta name='viewport' content='width=device-width, initial-scale=1.0' />
          <title>City College of Calamba</title>
          <style>
              /* A simple css reset */
              body,table,thead,tbody,tr,td,img {
                  padding: 0;
                  margin: 0;
                  border: none;
                  border-spacing: 0px;
                  border-collapse: collapse;
                  vertical-align: top;
              }
              
      
              /* Add some padding for small screens */
              .wrapper {
                  padding-left: 10px;
                  padding-right: 10px;
              }
      
              h1,h2,h3,h4,h5,h6,p {
                  margin: 0;
                  padding: 0;
                  padding-bottom: 20px;
                  line-height: 1.6;
                  font-family: 'Helvetica', 'Arial', sans-serif;
              }
      
              p,a,li {
                  font-family: 'Helvetica', 'Arial', sans-serif;
              }
      
              img {
                  width: 100%;
                  display: block;
              }
      
              @media only screen and (max-width: 620px) {
      
                  .wrapper .section {
                      width: 100%;
                  }
      
                  .wrapper .column {
                      width: 100%;
                      display: block;
                  }
              }
          </style>
      </head>
      
      <body>
        
        <h3>Greetings,</h3>
            
        <p style='text-align:justify;'>
          $message
        </p>
        <br><br><br><br><br>
        <p><b style='color: red;'>This is a system generated email. Please do not reply.</b></p> 
        </td>
                                              
      </body>
      </html>
      ";
      $mail->send();
  } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }

}

function sendCode($receiver, $code) {

  $mail = new PHPMailer(true);
  $subject = 'Recovery Code';
  $message = 'Your recovery code is: <b>'.$code.'</b>';

    try {
        //Server settings
        // $mail->SMTPDebug = 3;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'ieti.system2023@gmail.com';                     //SMTP username
        $mail->Password   = 'qexfebxxlivlwkky'; //IETI_2023                              //SMTP password
        $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        

        $mail->setFrom('ieti.system2023@gmail.com', 'IETI | Digital Archive Management System'); //Sender
        $mail->addAddress($receiver);     //Add a recipient

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject =  $subject;
        $mail->Body    =  
        "
        <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
        <html>
        
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <title>City College of Calamba</title>
            <style>
                /* A simple css reset */
                body,table,thead,tbody,tr,td,img {
                    padding: 0;
                    margin: 0;
                    border: none;
                    border-spacing: 0px;
                    border-collapse: collapse;
                    vertical-align: top;
                }
                
        
                /* Add some padding for small screens */
                .wrapper {
                    padding-left: 10px;
                    padding-right: 10px;
                }
        
                h1,h2,h3,h4,h5,h6,p {
                    margin: 0;
                    padding: 0;
                    padding-bottom: 20px;
                    line-height: 1.6;
                    font-family: 'Helvetica', 'Arial', sans-serif;
                }
        
                p,a,li {
                    font-family: 'Helvetica', 'Arial', sans-serif;
                }
        
                img {
                    width: 100%;
                    display: block;
                }
        
                @media only screen and (max-width: 620px) {
        
                    .wrapper .section {
                        width: 100%;
                    }
        
                    .wrapper .column {
                        width: 100%;
                        display: block;
                    }
                }
            </style>
        </head>
        
        <body>
        
        <h3>Greetings,</h3>
            
        <p style='text-align:justify;'>
            $message
        </p>
        <br><br><br><br><br>
        <p><b style='color: red;'>If you did not request this code, it is possible that someone else is trying to access your account. <b>Do not forward or give this code to anyone.</b></p> 
        </td>
                                                
        </body>
        </html>
        ";
    $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>