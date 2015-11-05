<?php 
/**
 * @package     ANSEVE Contact Form Module
 * @autor		Andreas Vennemann
 * @website		http://anseve.de
 */

defined ('_JEXEC') or die;

$input = JFactory::getApplication()->input;
$check = $input->getInt('check', null);

if ($check == null) // Form not sent
{	
	// Default layout
	require JModuleHelper::getLayoutPath('mod_anseve_contactform');
} 
else if ($check === 1) // Form sent
{
	// Check Token
	JSession::checkToken() or die('Invalid Token');
	
	require_once __DIR__ . '/helper.php';
	$status = modIcContactFormHelper::sendMail($params);
	require JModuleHelper::getLayoutPath('mod_anseve_contactform');
}