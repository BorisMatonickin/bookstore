<?php
    class Email {
        /*
         * registry object reference
         */
        private $_registry;
        
        /*
         * PHP mailer reference
         */
        private $_mail;
        
        /*
         * session object reference
         */
        private $_session;
        
        /*
         * object constructor, loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
            require_once('PHPMailer/class.phpmailer.php');
            $this->_mail = new PHPMailer();
            require_once('Session.php');
            $this->_session = new Session();
        }
        
        /*
         * sends email to registered users to activate their account
         * @param string $name - name of the user
         * @param string $email - email address of the user
         * @param string - hashed activation code
         */
        public function sendActivationCode($name, $email, $activationCode) {
            $toName = "{$name}";
            $to = "{$email}";
            $subject = 'Account Activation';
            $message = "Thank you for registering at bookstore.com, To activate your account please click the link below.\n\n";
            $message .= $this->_registry->getSetting('protocol') . 'localhost/bookstore/registration/activate/' . urlencode($email) . '/' . $activationCode;
            $fromName = 'Admin';
            $from = 'admin@bookstore.com';
            $this->_mail->FromName = $fromName;
            $this->_mail->From = $from;
            $this->_mail->AddAddress($to, $toName);
            $this->_mail->Subject = $subject;
            $this->_mail->Body = $message;
            if (!$this->_mail->Send()) {
                $this->_session->flash('message', '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>');
                $this->_registry->redirectTo();
            } else {
                $this->_session->flash('message', '<h4>Thank you for registering! A confirmation email with activation code has been send to your email.</h4>');
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * sends email with identification token for reseting user password
         * @param string $email - user email address
         * @param string $passToken - token
         */
        public function sendPasswordToken($email, $passToken) {
            $to = "{$email}";
            $subject = 'Reset Password';
            $url = $this->_registry->getSetting('protocol') . 'localhost/bookstore/authenticate/reset-password/' . $passToken;
            $message = "This email is in response to a forgotten password reset request at 'bestseller.com'. If you did 
                        make this request, click the following link to be able to access your account: $url 
                        For security purposes, you have 15 minutes to do this. If you do not click this link within 
                        15 minutes, you'll need to request a password reset again. If you have not forgotten your password, 
                        you can safely ignore this message and you will still be able to login with your existing password.";
            $fromName = 'Admin';
            $from = 'admin@bookstore.com';
            $this->_mail->FromName = $fromName;
            $this->_mail->From = $from;
            $this->_mail->Addaddress($to);
            $this->_mail->Subject = $subject;
            $this->_mail->Body = $message;
            if (!$this->_mail->Send()) {
                $this->_session->flash('message', '<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>');
                $this->_registry->redirectTo();
            } else {
                $this->_session->flash('message', '<h4>You will receive an access code via email. Click the link in that email to gain access to the site. 
					Once you have done that, you may then change your password.</h4>');
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * handles sending email to admin from submitted contact form
         * @param string $name - the name of the sender
         * @param string $email - the email of the sender
         * @param string $message - the message
         */
        public function sendMailToAdmin($name, $email, $message) {
            $to = 'admin@bookstore.com';
            $subject = 'User Inquiry';
            $body = $message;
            $fromName = $name;
            $from = $email;
            $this->_mail->FromName = $fromName;
            $this->_mail->From = $from;
            $this->_mail->AddAddress($to);
            $this->_mail->Subject = $subject;
            $this->_mail->Body = $body;
            if (!$this->_mail->Send()) {
                $this->_session->flash('message', '<p class="error">Your message was not send due to system error. Please try again later.</p>');
                $this->_registry->redirectTo();
            } else {
                $this->_session->flash('message', '<h4>Thank you for contacting us. We will give our best and reply as soon is possible.</h4>');
                $this->_registry->redirectTo();
            }
        }
        
        /*
         * handles sending email upon changing email address through admin panel
         * @param int $userId - id of the user needed for redirection
         * @param string $name - the name of the user
         * @param string $email - email address of the user
         * @param string $activationCode
         */
        public function sendMailOnEmailUpdate($userId, $name, $email, $activationCode) {
            $toName = "{$name}";
            $to = "{$email}";
            $subject = 'Account Reactivation - Email Address Change';
            $message = "You are receiving this email because you requested the change of email address from system administrator. Below is the link "
                    . "for activation of your account with new email address. If this request is not comming from you or is maded by mistake, please "
                    . "DO NOT CLICK THE LINK BELOW and contact system administrator immediately!\n\n";
            $message .= $this->_registry->getSetting('protocol') . 'localhost/bookstore/registration/activate/' . urlencode($email) . '/' . $activationCode;
            $fromName = 'Admin';
            $from = 'admin@bookstore.php';
            $this->_mail->FromName = $fromName;
            $this->_mail->From = $from;
            $this->_mail->Addaddress($to, $toName);
            $this->_mail->Subject = $subject;
            $this->_mail->Body = $message;
            if (!$this->_mail->Send()) {
                $this->_session->flash('message', '<p class="stock">An error occured. Email was not send due to system error.</p>');
                $this->_registry->redirectTo('admin/customers/view/' . $userId);
            } else {
                $this->_session->flash('message', '<p class="success">Email with activation code was send to the user successfully.</p>');
                $this->_registry->redirectTo('admin/customers/view/' . $userId);
            }
        }
    }