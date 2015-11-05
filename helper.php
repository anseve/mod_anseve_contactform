<?php 
/**
 * @package     ANSEVE Contact Form Module
 * @autor		Andreas Vennemann
 * @website		http://anseve.de
 * This Class get the values from the formular, validate value and send it to sender
 */

defined ('_JEXEC') or die; 

class modIcContactFormHelper
{
	static function sendMail($params)
	{
		// Get sitename, value
		$app   = JFactory::getApplication();
		$input = $app->input;
		
		$sitename = $app->getCfg('sitename');
		$name     = $input->getString('name', null);
		$email    = $input->getString('email', null);
		$subject  = $input->getString('subject', null);
		$secure   = $input->getString('secure', null);
		$message  = $input->getString('message', null);
		
		// If copy function activated get checkbox value
		if ($params->get('email_copy') == 1) 
		{
			$copy = $input->getInt('copy_mail', null);	
		}
					
		$validation = array();
		
		// If captcha is activated, check captcha
		if ($params->get('captcha') == 1)
		{
			JPluginHelper::importPlugin('captcha');
			$dispatcher = JDispatcher::getInstance();
			
			$captcha = $input->post->get('recaptcha_response_field');
			$captcha_response = $dispatcher->trigger('onCheckAnswer', $captcha);
		}
		
		// Honeypot must be empty
		if ($secure == null)
		{			
			// Check fields 	
			if ($name == null || $email == null || $subject == null || $message == null)
			{
				$validation = array(
					'check' => false,
					'info' => $params->get('errortextfields')
				);
				
				return $validation;
			} 
			else if (!preg_match( '/^([a-z0-9]+([-_\.]?[a-z0-9])+)@[a-z0-9äöü]+([-_\.]?[a-z0-9äöü])+\.[a-z]{2,4}$/i', $email))
			{
				// E-Mail Validation Error
				$validation = array(
					'check' => false,
					'info' => $params->get('errortextmail')
				);	
				
				return $validation;
			} 
			else if (isset($captcha_response[0]) && ! $captcha_response[0] && $params->get('captcha') == 1)
			{
				// Error Captcha	
				$validation = array(
					'check' => false,
					'info' => $params->get('captcha_error')
				);		
				
				return $validation;	
			} 
			else 
			{
				// Get mail and name from global configuration
				$config = JFactory::getConfig();
				$sender_global_mail = $config->get('config.mailfrom');
				$sender_global_name = $config->get('config.fromname');	

				// If module configuration sender mail or name is empty get global configuration sender mail, name
				$senderemail = ($params->get('senderemail')) ? $params->get('senderemail') : $sender_global_mail;
				$sendername  = ($params->get('sendername')) ? $params->get('sendername') :  $sender_global_name;
				$sender      = array($senderemail,  $sendername);

				// Get recipient mail 
				$recipientemail = $params->get('recipientemail');

				// Merge message 	  
				$messages_alt      = JText::sprintf("MOD_ANSEVE_CONTACT_MESSAGE_ALT", $sitename, $name, $email, $message);
				$messages_alt_copy = JText::sprintf("MOD_ANSEVE_CONTACT_MESSAGE_ALT_COPY", $sitename, $name, $email, $message);

				// Set sender, recipient, subject and message
				$mailer = JFactory::getMailer();
				$mailer->setSender($sender);
				$mailer->addRecipient($recipientemail);
				$mailer->setSubject($subject);
				$mailer->isHTML(false);
				$mailer->setBody($messages_alt);
				$send = $mailer->Send();
			  
				if ($send !== true) 
				{
					$validation = array(
						'check' => false,
						'info' => $params->get('errortext')
					);
					
					return $validation;
				} 
				else
				{
					// Send mail copy if checkbox checked
					if (isset($copy) && $copy === 1)
					{
						$mailer = JFactory::getMailer();
						$mailer->setSender($sender);
						$mailer->addRecipient(array($email, $name));
						$mailer->setSubject($subject);
						$mailer->isHTML(false);
						$mailer->setBody($messages_alt_copy);
						$send = $mailer->Send();

						if ($send !== true) 
						{
							$validation = array(
								'check' => false,
								'info' => $params->get('errortext')
							);

							return $validation;	
						}
					}
					
					$validation = array(
						'check' => true,
						'info' => $params->get('successtext')
					);
					
					return $validation;
				}
			}
			
		} 
		else
		{
			$validation = array(
				'check' => false,
				'info' => $params->get('honeypottext')
			);
			
			return $validation;
		}
	}
}