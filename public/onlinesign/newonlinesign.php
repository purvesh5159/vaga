<?php
/* Copyright (C) 2001-2002	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2006-2017	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2009-2012	Regis Houssin			<regis.houssin@inodbox.com>
 * Copyright (C) 2023		anthony Berton			<anthony.berton@bb2a.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *     	\file       htdocs/public/onlinesign/newonlinesign.php
 *		\ingroup    core
 *		\brief      File to offer a way to make an online signature for a particular Dolibarr entity
 *					Example of URL: https://localhost/public/onlinesign/newonlinesign.php?ref=PR...
 */

if (!defined('NOLOGIN')) {
	define("NOLOGIN", 1); // This means this output page does not require to be logged.
}
if (!defined('NOCSRFCHECK')) {
	define("NOCSRFCHECK", 1); // We accept to go on this page from external web site.
}
if (!defined('NOIPCHECK')) {
	define('NOIPCHECK', '1'); // Do not check IP defined into conf $dolibarr_main_restrict_ip
}
if (!defined('NOBROWSERNOTIF')) {
	define('NOBROWSERNOTIF', '1');
}

// For MultiCompany module.
// Do not use GETPOST here, function is not defined and define must be done before including main.inc.php
// Because 2 entities can have the same ref.
$entity = (!empty($_GET['entity']) ? (int) $_GET['entity'] : (!empty($_POST['entity']) ? (int) $_POST['entity'] : 1));
if (is_numeric($entity)) {
	define("DOLENTITY", $entity);
}

// Load Dolibarr environment
require '../../main.inc.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/payments.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';

// Add this after the existing require_once statements at the top
require_once DOL_DOCUMENT_ROOT.'/core/class/CMailFile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/mailmanspip.lib.php';

// Load translation files
$langs->loadLangs(array("main", "other", "dict", "bills", "companies", "errors", "members", "paybox", "propal", "commercial"));

// Security check
// No check on module enabled. Done later according to $validpaymentmethod

// Get parameters
$action = GETPOST('action', 'aZ09');
$cancel = GETPOST('cancel', 'alpha');
$confirm = GETPOST('confirm', 'alpha');


$refusepropal = GETPOST('refusepropal', 'alpha');
$message = GETPOST('message', 'aZ09');

// Input are:
// type ('invoice','order','contractline'),
// id (object id),
// amount (required if id is empty),
// tag (a free text, required if type is empty)
// currency (iso code)

$suffix = GETPOST("suffix", 'aZ09');
$source = GETPOST("source", 'alpha');
$ref = $REF = GETPOST("ref", 'alpha');
$urlok = '';
$urlko = '';

if (empty($source)) {
	$source = 'proposal';
}
if (!empty($refusepropal)) {
	$action = "refusepropal";
}

// Define $urlwithroot
//$urlwithouturlroot=preg_replace('/'.preg_quote(DOL_URL_ROOT,'/').'$/i','',trim($dolibarr_main_url_root));
//$urlwithroot=$urlwithouturlroot.DOL_URL_ROOT;		// This is to use external domain name found into config file
$urlwithroot = DOL_MAIN_URL_ROOT; // This is to use same domain name than current. For Paypal payment, we can use internal URL like localhost.


// Complete urls for post treatment
$SECUREKEY = GETPOST("securekey"); // Secure key

if (!empty($source)) {
	$urlok .= 'source='.urlencode($source).'&';
	$urlko .= 'source='.urlencode($source).'&';
}
if (!empty($REF)) {
	$urlok .= 'ref='.urlencode($REF).'&';
	$urlko .= 'ref='.urlencode($REF).'&';
}
if (!empty($SECUREKEY)) {
	$urlok .= 'securekey='.urlencode($SECUREKEY).'&';
	$urlko .= 'securekey='.urlencode($SECUREKEY).'&';
}
if (!empty($entity)) {
	$urlok .= 'entity='.urlencode($entity).'&';
	$urlko .= 'entity='.urlencode($entity).'&';
}
$urlok = preg_replace('/&$/', '', $urlok); // Remove last &
$urlko = preg_replace('/&$/', '', $urlko); // Remove last &

$creditor = $mysoc->name;

$type = $source;

if (!$action) {
	if ($source && !$ref) {
		httponly_accessforbidden($langs->trans('ErrorBadParameters')." - ref missing", 400, 1);
	}
}

// Check securitykey
$securekeyseed = '';
if ($source == 'proposal') {
	$securekeyseed = getDolGlobalString('PROPOSAL_ONLINE_SIGNATURE_SECURITY_TOKEN');
} elseif ($source == 'contract') {
	$securekeyseed = getDolGlobalString('CONTRACT_ONLINE_SIGNATURE_SECURITY_TOKEN');
} elseif ($source == 'fichinter') {
	$securekeyseed = getDolGlobalString('FICHINTER_ONLINE_SIGNATURE_SECURITY_TOKEN');
} elseif ($source == 'societe_rib') {
	$securekeyseed = getDolGlobalString('SOCIETE_RIB_ONLINE_SIGNATURE_SECURITY_TOKEN');
}
if (!dol_verifyHash($securekeyseed.$type.$ref.(isModEnabled('multicompany') ? $entity : ''), $SECUREKEY, '0')) {
	httponly_accessforbidden('Bad value for securitykey. Value provided '.dol_escape_htmltag($SECUREKEY).' does not match expected value for ref='.dol_escape_htmltag($ref), 403, 1);
}

if ($source == 'proposal') {
	require_once DOL_DOCUMENT_ROOT.'/comm/propal/class/propal.class.php';
	$object = new Propal($db);
	$result= $object->fetch(0, $ref, '', $entity);
} elseif ($source == 'contract') {
	require_once DOL_DOCUMENT_ROOT.'/contrat/class/contrat.class.php';
	$object = new Contrat($db);
	$result= $object->fetch(0, $ref);
} elseif ($source == 'fichinter') {
	require_once DOL_DOCUMENT_ROOT.'/fichinter/class/fichinter.class.php';
	$object = new Fichinter($db);
	$result= $object->fetch(0, $ref);
} elseif ($source == 'societe_rib') {
	require_once DOL_DOCUMENT_ROOT.'/societe/class/companybankaccount.class.php';
	$object = new CompanyBankAccount($db);
	$result= $object->fetch($ref);
} else {
	httponly_accessforbidden($langs->trans('ErrorBadParameters')." - Bad value for source. Value not supported.", 400, 1);
}

// Initialize technical object to manage hooks of page. Note that conf->hooks_modules contains array of hook context
$hookmanager->initHooks(array('onlinesign'));

$error = 0;


/**
 * Function to send email when proposal is signed purvesh
 */
function sendProposalSignedEmail($object, $langs, $mysoc) {
    global $conf, $db, $user;
    
    // Get client email
    $result = $object->fetch_thirdparty();
    if ($result <= 0) {
        dol_syslog("Failed to fetch thirdparty for proposal ".$object->ref, LOG_ERR);
        return false;
    }
    
    $client_email = $object->thirdparty->email;
    if (empty($client_email)) {
        dol_syslog("No email found for thirdparty ".$object->thirdparty->name, LOG_WARNING);
        return false;
    }
    
    // Email subject
    $subject = $langs->trans("ProposalSignedEmailSubject", $object->ref, $mysoc->name);
    if (empty($subject)) {
        $subject = "Proposal ".$object->ref." has been signed - ".$mysoc->name;
    }
	global $dolibarr_main_url_root;
    
    // Email body
    $message = '<html><body>';
	$message .= '<p>Dear '.$object->thirdparty->name.',</p>';
	$message .= '<p>We are pleased to inform you that your proposal <strong>'.$object->ref.'</strong> has been successfully signed.</p>';
	$message .= '<p><strong>Proposal Details:</strong><br>';
	$message .= 'Reference Number: '.$object->ref.'<br>';
	$message .= 'Amount: '.price($object->total_ht, 2, $langs, 1, -1, -1, $conf->currency).'<br>';
	$message .= 'Date: '.dol_print_date(dol_now(), 'day').'</p>';
	$message .= '<p>Please find attached the signed proposal document.<br>';
	$message .= 'We will now proceed with the next steps as outlined in the proposal.<br>';
	$message .= 'Thank you for choosing our services.</p>';
	$message .= '<p>Best regards,<br>'.$mysoc->name.'<br>';
	if (!empty($mysoc->phone)) $message .= 'Phone: '.$mysoc->phone.'<br>';
	if (!empty($mysoc->email)) $message .= 'Email: '.$mysoc->email.'<br>';
	$message .= '</p>';

	// Image at the end
	$image_url = $dolibarr_main_url_root.'/email_signature.png'; // Use full absolute URL
	$message .= '<p><img src="'.$image_url.'" alt="Signature" style="max-width:70%;"></p>';

	$message .= '</body></html>';

    
    // Get sender email
    $from = $mysoc->email;
    if (empty($from)) {
        $from = getDolGlobalString('MAIN_MAIL_EMAIL_FROM');
    }
    
    if (empty($from)) {
        dol_syslog("No sender email configured", LOG_ERR);
        return false;
    }
    
    // Prepare attachment - Fixed approach
    $attachedfiles = array();
    $filepath = '';
    $filename = '';
    
    // Method 1: Try to get the last main document
    if (!empty($object->last_main_doc)) {
        $filepath = DOL_DATA_ROOT.'/'.$object->last_main_doc;
        if (dol_is_file($filepath)) {
            $filename = 'Signed_Proposal_'.$object->ref.'.pdf';
        }
    }
    
    // Method 2: If no last_main_doc, try to find the PDF in documents directory
    if (empty($filepath) || !dol_is_file($filepath)) {
        // Get document directory for this proposal
        $upload_dir = $conf->propal->multidir_output[$object->entity ?? 1] . "/" . dol_sanitizeFileName($object->ref);
        
        if (dol_is_dir($upload_dir)) {
            $files = dol_dir_list($upload_dir, "files", 0, '\.pdf$', '', 'date', SORT_DESC);
            if (!empty($files) && is_array($files)) {
                foreach ($files as $file) {
                    if ($file['type'] == 'file') {
                        $filepath = $file['fullname'];
                        $filename = 'Signed_Proposal_'.$object->ref.'.pdf';
                        break;
                    }
                }
            }
        }
    }
    
    // Method 3: Generate PDF if not found
    if (empty($filepath) || !dol_is_file($filepath)) {
        // Generate the PDF
        $result = $object->generateDocument($object->model_pdf, $langs);
        if ($result <= 0) {
            dol_syslog("Failed to generate PDF for proposal ".$object->ref, LOG_ERR);
            return false;
        }
        
        // Try to get the generated file path again
        if (!empty($object->last_main_doc)) {
            $filepath = DOL_DATA_ROOT.'/'.$object->last_main_doc;
            $filename = 'Signed_Proposal_'.$object->ref.'.pdf';
        }
    }
    
    // Verify we have a valid PDF file
    if (empty($filepath) || !dol_is_file($filepath)) {
        dol_syslog("No PDF file found for proposal ".$object->ref, LOG_ERR);
        return false;
    }
    
    // Send the email using CMailFile - Simplified approach
    include_once DOL_DOCUMENT_ROOT.'/core/class/CMailFile.class.php';

	$filepath_array = array($filepath);
	$filename_array = array($filename);
	$mimetype_array = array('application/pdf');

	$mailfile = new CMailFile(
		$subject,
		$from,
		$from,
		$message,
		$filepath_array,
		$mimetype_array,
		$filename_array,
		'',
		'',
		0,   // delivery receipt
		-1,  // msgid
		'',  // errors_to
		'',  // cc
		'',  // bcc
		'utf-8'
	);

    
    // Set attachment name properly
    if (!empty($filename)) {
        $mailfile->attachments_name = array($filename);
        $mailfile->attachments_mime = array('application/pdf');
    }
    
    $result = $mailfile->sendfile();
    
    if ($result) {
        dol_syslog("Email sent successfully to ".$client_email." for signed proposal ".$object->ref, LOG_INFO);
        
        // Log the email in Dolibarr's events (optional)
        if (class_exists('ActionComm')) {
            $actioncomm = new ActionComm($db);
            $actioncomm->type_code = 'AC_EMAIL';
            $actioncomm->code = 'AC_EMAIL';
            $actioncomm->label = 'Email sent for signed proposal '.$object->ref;
            $actioncomm->note_private = 'Email sent to: '.$client_email."\nSubject: ".$subject;
            $actioncomm->fk_element = $object->id;
            $actioncomm->elementtype = 'propal';
            $actioncomm->datep = dol_now();
            $actioncomm->userownerid = $user->id;
            $actioncomm->percentage = 100;
            $actioncomm->create($user);
        }
        
        return true;
    } else {
        $error_msg = $mailfile->error ?? 'Unknown error';
        dol_syslog("Failed to send email to ".$client_email." for signed proposal ".$object->ref.". Error: ".$error_msg, LOG_ERR);
        return false;
    }
}


/**
 * Function to send email when proposal is refused purvesh
 */
function sendProposalRefusedEmail($object, $langs, $mysoc) {
    global $conf, $db, $dolibarr_main_url_root;

    // Get client email
    $result = $object->fetch_thirdparty($object->socid);
    if ($result <= 0) {
        dol_syslog("Failed to fetch thirdparty for proposal ".$object->ref, LOG_ERR);
        return false;
    }

    $client_email = $object->thirdparty->email;
    if (empty($client_email)) {
        dol_syslog("No email found for thirdparty ".$object->thirdparty->name, LOG_WARNING);
        return false;
    }

    // Email subject
    $subject = $langs->trans("ProposalRefusedEmailSubject", $object->ref, $mysoc->name);
    if (empty($subject)) {
        $subject = "Proposal ".$object->ref." status update - ".$mysoc->name;
    }

    // Email body - HTML
    $message = '<html><body>';
    $message .= '<p>Dear '.$object->thirdparty->name.',</p>';
    $message .= '<p>We have received notification that proposal <strong>'.$object->ref.'</strong> has been declined.</p>';
    $message .= '<p><strong>Proposal Details:</strong><br>';
    $message .= '- Reference Number: '.$object->ref.'<br>';
    $message .= '- Amount: $ '.number_format($object->total_ht, 2, '.', '').' plus tax<br>';
    $message .= '- Date: '.dol_print_date(dol_now(), 'day').'</p>';
    $message .= '<p>We understand that our proposal may not have met your current requirements. ';
    $message .= 'We would appreciate any feedback you might have to help us improve our future proposals.</p>';
    $message .= '<p>If you would like to discuss alternative solutions or have any questions, ';
    $message .= 'please don\'t hesitate to contact us.</p>';
    $message .= '<p>We hope to have the opportunity to work with you in the future.</p>';
    $message .= '<p>Best regards,<br>';
    $message .= $mysoc->name.'<br>';
    if (!empty($mysoc->phone)) $message .= 'Phone: '.$mysoc->phone.'<br>';
    if (!empty($mysoc->email)) $message .= 'Email: '.$mysoc->email.'<br>';
    $message .= '</p>';

	// Image at the end
	$image_url = $dolibarr_main_url_root.'/email_signature.png'; // Use full absolute URL
	$message .= '<p><img src="'.$image_url.'" alt="Signature" style="max-width:70%;"></p>';

	$message .= '</body></html>';

    
    // Get sender email
    $from = $mysoc->email;
    if (empty($from)) {
        $from = getDolGlobalString('MAIN_MAIL_EMAIL_FROM');
    }
    
    if (empty($from)) {
        dol_syslog("No sender email configured", LOG_ERR);
        return false;
    }
    
    // Prepare attachment - Fixed approach
    $attachedfiles = array();
    $filepath = '';
    $filename = '';
    
    // Method 1: Try to get the last main document
    if (!empty($object->last_main_doc)) {
        $filepath = DOL_DATA_ROOT.'/'.$object->last_main_doc;
        if (dol_is_file($filepath)) {
            $filename = 'Declined_Proposal_'.$object->ref.'.pdf';
        }
    }
    
    // Method 2: If no last_main_doc, try to find the PDF in documents directory
    if (empty($filepath) || !dol_is_file($filepath)) {
        // Get document directory for this proposal
        $upload_dir = $conf->propal->multidir_output[$object->entity ?? 1] . "/" . dol_sanitizeFileName($object->ref);
        
        if (dol_is_dir($upload_dir)) {
            $files = dol_dir_list($upload_dir, "files", 0, '\.pdf$', '', 'date', SORT_DESC);
            if (!empty($files) && is_array($files)) {
                foreach ($files as $file) {
                    if ($file['type'] == 'file') {
                        $filepath = $file['fullname'];
                        $filename = 'Signed_Proposal_'.$object->ref.'.pdf';
                        break;
                    }
                }
            }
        }
    }
    
    // Method 3: Generate PDF if not found
    if (empty($filepath) || !dol_is_file($filepath)) {
        // Generate the PDF
        $result = $object->generateDocument($object->model_pdf, $langs);
        if ($result <= 0) {
            dol_syslog("Failed to generate PDF for proposal ".$object->ref, LOG_ERR);
            return false;
        }
        
        // Try to get the generated file path again
        if (!empty($object->last_main_doc)) {
            $filepath = DOL_DATA_ROOT.'/'.$object->last_main_doc;
            $filename = 'Signed_Proposal_'.$object->ref.'.pdf';
        }
    }
    
    // Verify we have a valid PDF file
    if (empty($filepath) || !dol_is_file($filepath)) {
        dol_syslog("No PDF file found for proposal ".$object->ref, LOG_ERR);
        return false;
    }
    
    // Send the email using CMailFile - Simplified approach
    include_once DOL_DOCUMENT_ROOT.'/core/class/CMailFile.class.php';

	$filepath_array = array($filepath);
	$filename_array = array($filename);
	$mimetype_array = array('application/pdf');

	$mailfile = new CMailFile(
		$subject,
		$from,
		$from,
		$message,
		$filepath_array,
		$mimetype_array,
		$filename_array,
		'',
		'',
		0,   // delivery receipt
		-1,  // msgid
		'',  // errors_to
		'',  // cc
		'',  // bcc
		'utf-8'
	);

    
    // Set attachment name properly
    if (!empty($filename)) {
        $mailfile->attachments_name = array($filename);
        $mailfile->attachments_mime = array('application/pdf');
    }
    
    $result = $mailfile->sendfile();

    if ($result) {
        dol_syslog("Email sent successfully to ".$client_email." for refused proposal ".$object->ref, LOG_INFO);
        return true;
    } else {
        dol_syslog("Failed to send email to ".$client_email." for refused proposal ".$object->ref.". Error: ".$mail->error, LOG_ERR);
        return false;
    }
}


/*
 * Actions
 */

if ($action == 'confirm_refusepropal' && $confirm == 'yes') {
	$db->begin();

	$sql  = "UPDATE ".MAIN_DB_PREFIX."propal";
	$sql .= " SET fk_statut = ".((int) $object::STATUS_NOTSIGNED).", note_private = '".$db->escape($object->note_private)."', date_signature='".$db->idate(dol_now())."'";
	$sql .= " WHERE rowid = ".((int) $object->id);

	dol_syslog(__FILE__, LOG_DEBUG);
	$resql = $db->query($sql);
	if (!$resql) {
		$error++;
	}

	if (!$error) {
		$db->commit();

		$message = 'refused';
		setEventMessages("PropalRefused", null, 'warnings');

		  // Send refusal email purvesh
		  $email_result = sendProposalRefusedEmail($object, $langs, $mysoc);
		  if ($email_result) {
			  setEventMessages("EmailSentToClient", null, 'mesgs');
		  } else {
			  setEventMessages("ErrorSendingEmail", null, 'warnings');
		  }

		if (method_exists($object, 'call_trigger')) {
			// Online customer is not a user, so we use the use that validates the documents
			$user = new User($db);
			$user->fetch($object->user_validation_id);
			$object->context = array('closedfromonlinesignature' => 'closedfromonlinesignature');
			$result = $object->call_trigger('PROPAL_CLOSE_REFUSED', $user);
			if ($result < 0) {
				$error++;
			}
		}
	} else {
		$db->rollback();
	}

	$object->fetch(0, $ref);
}


/*
 * View
 */

$form = new Form($db);
$head = '';
if (getDolGlobalString('MAIN_SIGN_CSS_URL')) {
	$head = '<link rel="stylesheet" type="text/css" href="' . getDolGlobalString('MAIN_SIGN_CSS_URL').'?lang='.$langs->defaultlang.'">'."\n";
}

$conf->dol_hide_topmenu = 1;
$conf->dol_hide_leftmenu = 1;

$replacemainarea = (empty($conf->dol_hide_leftmenu) ? '<div>' : '').'<div>';
llxHeader($head, $langs->trans("OnlineSignature"), '', '', 0, 0, '', '', '', 'onlinepaymentbody', $replacemainarea, 1);

if ($action == 'refusepropal') {
	print $form->formconfirm($_SERVER["PHP_SELF"].'?ref='.urlencode($ref).'&securekey='.urlencode($SECUREKEY).(isModEnabled('multicompany') ? '&entity='.$entity : ''), $langs->trans('RefusePropal'), $langs->trans('ConfirmRefusePropal', $object->ref), 'confirm_refusepropal', '', '', 1);
}

// Check link validity for param 'source' to avoid use of the examples as value
if (!empty($source) && in_array($ref, array('member_ref', 'contractline_ref', 'invoice_ref', 'order_ref', 'proposal_ref', ''))) {
	$langs->load("errors");
	dol_print_error_email('BADREFINONLINESIGNFORM', $langs->trans("ErrorBadLinkSourceSetButBadValueForRef", $source, $ref));
	// End of page
	llxFooter();
	$db->close();
	exit;
}

print '<span id="dolpaymentspan"></span>'."\n";
print '<div class="center">'."\n";
print '<form id="dolpaymentform" class="center" name="paymentform" action="'.$_SERVER["PHP_SELF"].'" method="POST">'."\n";
print '<input type="hidden" name="token" value="'.newToken().'">'."\n";
print '<input type="hidden" name="action" value="dosign">'."\n";
print '<input type="hidden" name="tag" value="'.GETPOST("tag", 'alpha').'">'."\n";
print '<input type="hidden" name="suffix" value="'.GETPOST("suffix", 'alpha').'">'."\n";
print '<input type="hidden" name="securekey" value="'.$SECUREKEY.'">'."\n";
print '<input type="hidden" name="entity" value="'.$entity.'" />';
print '<input type="hidden" name="page_y" value="" />';
print '<input type="hidden" name="source" value="'.$source.'" />';
print '<input type="hidden" name="ref" value="'.$ref.'" />';
print "\n";
print '<!-- Form to sign -->'."\n";

print '<table id="dolpublictable" summary="Payment form" class="center">'."\n";

// Show logo (search order: logo defined by ONLINE_SIGN_LOGO_suffix, then ONLINE_SIGN_LOGO_, then small company logo, large company logo, theme logo, common logo)
// Define logo and logosmall
$logosmall = $mysoc->logo_small;
$logo = $mysoc->logo;
$paramlogo = 'ONLINE_SIGN_LOGO_'.$suffix;
if (!empty($conf->global->$paramlogo)) {
	$logosmall = $conf->global->$paramlogo;
} elseif (getDolGlobalString('ONLINE_SIGN_LOGO')) {
	$logosmall = $conf->global->ONLINE_SIGN_LOGO;
}
//print '<!-- Show logo (logosmall='.$logosmall.' logo='.$logo.') -->'."\n";
// Define urllogo
$urllogo = '';
$urllogofull = '';
if (!empty($logosmall) && is_readable($conf->mycompany->dir_output.'/logos/thumbs/'.$logosmall)) {
	$urllogo = DOL_URL_ROOT.'/viewimage.php?modulepart=mycompany&amp;entity='.$conf->entity.'&amp;file='.urlencode('logos/thumbs/'.$logosmall);
	$urllogofull = $dolibarr_main_url_root.'/viewimage.php?modulepart=mycompany&entity='.$conf->entity.'&file='.urlencode('logos/thumbs/'.$logosmall);
} elseif (!empty($logo) && is_readable($conf->mycompany->dir_output.'/logos/'.$logo)) {
	$urllogo = DOL_URL_ROOT.'/viewimage.php?modulepart=mycompany&amp;entity='.$conf->entity.'&amp;file='.urlencode('logos/'.$logo);
	$urllogofull = $dolibarr_main_url_root.'/viewimage.php?modulepart=mycompany&entity='.$conf->entity.'&file='.urlencode('logos/'.$logo);
}
// Output html code for logo
if ($urllogo) {
	print '<div class="backgreypublicpayment">';
	print '<div class="logopublicpayment">';
	print '<img id="dolpaymentlogo" src="'.$urllogo.'"';
	print '>';
	print '</div>';
	if (!getDolGlobalString('MAIN_HIDE_POWERED_BY')) {
		print '<div class="poweredbypublicpayment opacitymedium right"><a class="poweredbyhref" href="https://www.dolibarr.org?utm_medium=website&utm_source=poweredby" target="dolibarr" rel="noopener">'.$langs->trans("PoweredBy").'<br><img class="poweredbyimg" src="'.DOL_URL_ROOT.'/theme/dolibarr_logo.svg" width="80px"></a></div>';
	}
	print '</div>';
}
if ($source == 'proposal' && getDolGlobalString('PROPOSAL_IMAGE_PUBLIC_SIGN')) {
	print '<div class="backimagepublicproposalsign">';
	print '<img id="idPROPOSAL_IMAGE_PUBLIC_INTERFACE" src="' . getDolGlobalString('PROPOSAL_IMAGE_PUBLIC_SIGN').'">';
	print '</div>';
}

// Output introduction text
$text = '';
if (getDolGlobalString('ONLINE_SIGN_NEWFORM_TEXT')) {
	$reg = array();
	if (preg_match('/^\((.*)\)$/', $conf->global->ONLINE_SIGN_NEWFORM_TEXT, $reg)) {
		$text .= $langs->trans($reg[1])."<br>\n";
	} else {
		$text .= getDolGlobalString('ONLINE_SIGN_NEWFORM_TEXT') . "<br>\n";
	}
	$text = '<tr><td align="center"><br>'.$text.'<br></td></tr>'."\n";
}
if (empty($text)) {
	if ($source == 'proposal') {
		$text .= '<tr><td class="textpublicpayment"><br><strong>'.$langs->trans("WelcomeOnOnlineSignaturePageProposal", $mysoc->name).'</strong></td></tr>'."\n";
		$text .= '<tr><td class="textpublicpayment opacitymedium">'.$langs->trans("ThisScreenAllowsYouToSignDocFromProposal", $creditor).'<br><br></td></tr>'."\n";
	} elseif ($source == 'contract') {
		$text .= '<tr><td class="textpublicpayment"><br><strong>'.$langs->trans("WelcomeOnOnlineSignaturePageContract", $mysoc->name).'</strong></td></tr>'."\n";
		$text .= '<tr><td class="textpublicpayment opacitymedium">'.$langs->trans("ThisScreenAllowsYouToSignDocFromContract", $creditor).'<br><br></td></tr>'."\n";
	} elseif ($source == 'fichinter') {
		$text .= '<tr><td class="textpublicpayment"><br><strong>'.$langs->trans("WelcomeOnOnlineSignaturePageFichinter", $mysoc->name).'</strong></td></tr>'."\n";
		$text .= '<tr><td class="textpublicpayment opacitymedium">'.$langs->trans("ThisScreenAllowsYouToSignDocFromFichinter", $creditor).'<br><br></td></tr>'."\n";
	} else {
		$text .= '<tr><td class="textpublicpayment"><br><strong>'.$langs->trans("WelcomeOnOnlineSignaturePage".dol_ucfirst($source), $mysoc->name).'</strong></td></tr>'."\n";
		$text .= '<tr><td class="textpublicpayment opacitymedium">'.$langs->trans("ThisScreenAllowsYouToSignDocFrom".dol_ucfirst($source), $creditor).'<br><br></td></tr>'."\n";
	}
}
print $text;

// Output payment summary form
print '<tr><td align="center">';
print '<table with="100%" id="tablepublicpayment">';
if ($source == 'proposal') {
	print '<tr><td align="left" colspan="2" class="opacitymedium">'.$langs->trans("ThisIsInformationOnDocumentToSignProposal").' :</td></tr>'."\n";
} elseif ($source == 'contract') {
	print '<tr><td align="left" colspan="2" class="opacitymedium">'.$langs->trans("ThisIsInformationOnDocumentToSignContract").' :</td></tr>'."\n";
} elseif ($source == 'fichinter') {
	print '<tr><td align="left" colspan="2" class="opacitymedium">'.$langs->trans("ThisIsInformationOnDocumentToSignFichinter").' :</td></tr>'."\n";
} else {
	print '<tr><td align="left" colspan="2" class="opacitymedium">'.$langs->trans("ThisIsInformationOnDocumentToSign".dol_ucfirst($source)).' :</td></tr>'."\n";
}
$found = false;
$error = 0;

// Signature on commercial proposal
if ($source == 'proposal') {
	$found = true;
	$langs->load("proposal");

	$result = $object->fetch_thirdparty($object->socid);

	// Creditor
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Creditor");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$creditor.'</b>';
	print '<input type="hidden" name="creditor" value="'.$creditor.'">';
	print '</td></tr>'."\n";

	// Debitor
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("ThirdParty");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$object->thirdparty->name.'</b>';
	print '</td></tr>'."\n";

	// Amount  including tax 

	//  $amount = '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Amount");
	//  $amount .= '</td><td class="CTableRow2">';
	//  $amount .= '<b>'.price($object->total_ttc, 0, $langs, 1, -1, -1, $conf->currency).'</b>';
	//  if ($object->multicurrency_code != $conf->currency) {
	//  	$amount .= ' ('.price($object->multicurrency_total_ttc, 0, $langs, 1, -1, -1, $object->multicurrency_code).')';
	//  }
	//  $amount .= '</td></tr>'."\n";


	// Amount  excluding tax  VSN- 2024-12-28 

	  $amount = '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Amount");
	  $amount .= '</td><td class="CTableRow2">';
	  //$amount .= '<b>'.price($object->total_ht , 2, $langs, 1, -1, -1, $conf->currency).'</b>';
	  //$amount .= '<b>'.price(number_format($object->total_ht, 2, '.', '') , 2, $langs, 1, -1, -1, $conf->currency).'</b>';
	 $amount .= '<b> $ '.number_format($object->total_ht, 2, '.', '').'</b>';   //working
	  if ($object->multicurrency_code != $conf->currency) {
	  	$amount .= ' ('.price($object->multicurrency_total_ht, 2, $langs, 1, -1, -1, $object->multicurrency_code).')';
	  }
	  $amount .= ' plus tax</td></tr>'."\n";

	// Call Hook amountPropalSign
	$parameters = array('source' => $source);
	$reshook = $hookmanager->executeHooks('amountPropalSign', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
	if (empty($reshook)) {
		$amount .= $hookmanager->resPrint;
	} elseif ($reshook > 0) {
		$amount = $hookmanager->resPrint;
	}

	print $amount;

	// Object
	$text = '<b>'.$langs->trans("SignatureProposalRef", $object->ref).'</b>';
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Designation");
	print '</td><td class="CTableRow2">'.$text;

	$last_main_doc_file = $object->last_main_doc;

	if ($object->status == $object::STATUS_VALIDATED) {
		if (empty($last_main_doc_file) || !dol_is_file(DOL_DATA_ROOT.'/'.$object->last_main_doc)) {
			// It seems document has never been generated, or was generated and then deleted.
			// So we try to regenerate it with its default template.
			$defaulttemplate = '';		// We force the use an empty string instead of $object->model_pdf to be sure to use a "main" default template and not the last one used.
			$object->generateDocument($defaulttemplate, $langs);
		}

		$directdownloadlink = $object->getLastMainDocLink('proposal');
		if ($directdownloadlink) {
			print '<br><a href="'.$directdownloadlink.'">';
			print img_mime($object->last_main_doc, '');
			print $langs->trans("DownloadDocument").'</a>';
		}
	} else {
		if ($object->status == $object::STATUS_NOTSIGNED) {
			$directdownloadlink = $object->getLastMainDocLink('proposal');
			if ($directdownloadlink) {
				print '<br><a href="'.$directdownloadlink.'">';
				print img_mime($last_main_doc_file, '');
				print $langs->trans("DownloadDocument").'</a>';
			}
		} elseif ($object->status == $object::STATUS_SIGNED || $object->status == $object::STATUS_BILLED) {
			if (preg_match('/_signed-(\d+)/', $last_main_doc_file)) {	// If the last main doc has been signed
				$last_main_doc_file_not_signed = preg_replace('/_signed-(\d+)/', '', $last_main_doc_file);

				$datefilesigned = dol_filemtime($last_main_doc_file);
				$datefilenotsigned = dol_filemtime($last_main_doc_file_not_signed);

				if (empty($datefilenotsigned) || $datefilesigned > $datefilenotsigned) {
					$directdownloadlink = $object->getLastMainDocLink('proposal');
					if ($directdownloadlink) {
						print '<br><a href="'.$directdownloadlink.'">';
						print img_mime($object->last_main_doc, '');
						print $langs->trans("DownloadDocument").'</a>';
					}
				}
			}
		}
	}

	print '<input type="hidden" name="source" value="'.GETPOST("source", 'alpha').'">';
	print '<input type="hidden" name="ref" value="'.$object->ref.'">';
	print '</td></tr>'."\n";
} elseif ($source == 'contract') { // Signature on contract
	$found = true;
	$langs->load("contract");

	$result = $object->fetch_thirdparty($object->socid);

	// Proposer
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Proposer");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$creditor.'</b>';
	print '<input type="hidden" name="creditor" value="'.$creditor.'">';
	print '</td></tr>'."\n";

	// Target
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("ThirdParty");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$object->thirdparty->name.'</b>';
	print '</td></tr>'."\n";

	// Object
	$text = '<b>'.$langs->trans("SignatureContractRef", $object->ref).'</b>';
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Designation");
	print '</td><td class="CTableRow2">'.$text;

	$last_main_doc_file = $object->last_main_doc;

	if (empty($last_main_doc_file) || !dol_is_file(DOL_DATA_ROOT.'/'.$object->last_main_doc)) {
		// It seems document has never been generated, or was generated and then deleted.
		// So we try to regenerate it with its default template.
		$defaulttemplate = '';		// We force the use an empty string instead of $object->model_pdf to be sure to use a "main" default template and not the last one used.
		$object->generateDocument($defaulttemplate, $langs);
	}

	$directdownloadlink = $object->getLastMainDocLink('contract');
	if ($directdownloadlink) {
		print '<br><a href="'.$directdownloadlink.'">';
		print img_mime($object->last_main_doc, '');
		if ($message == "signed") {
			print $langs->trans("DownloadSignedDocument").'</a>';
		} else {
			print $langs->trans("DownloadDocument").'</a>';
		}
	}


	print '<input type="hidden" name="source" value="'.GETPOST("source", 'alpha').'">';
	print '<input type="hidden" name="ref" value="'.$object->ref.'">';
	print '</td></tr>'."\n";
} elseif ($source == 'fichinter') {
	// Signature on fichinter
	$found = true;
	$langs->load("fichinter");

	$result = $object->fetch_thirdparty($object->socid);

	// Proposer
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Proposer");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$creditor.'</b>';
	print '<input type="hidden" name="creditor" value="'.$creditor.'">';
	print '</td></tr>'."\n";

	// Target
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("ThirdParty");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$object->thirdparty->name.'</b>';
	print '</td></tr>'."\n";

	// Object
	$text = '<b>'.$langs->trans("SignatureFichinterRef", $object->ref).'</b>';
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Designation");
	print '</td><td class="CTableRow2">'.$text;

	$last_main_doc_file = $object->last_main_doc;

	if (empty($last_main_doc_file) || !dol_is_file(DOL_DATA_ROOT.'/'.$object->last_main_doc)) {
		// It seems document has never been generated, or was generated and then deleted.
		// So we try to regenerate it with its default template.
		$defaulttemplate = '';		// We force the use an empty string instead of $object->model_pdf to be sure to use a "main" default template and not the last one used.
		$object->generateDocument($defaulttemplate, $langs);
	}

	$directdownloadlink = $object->getLastMainDocLink('fichinter');
	if ($directdownloadlink) {
		print '<br><a href="'.$directdownloadlink.'">';
		print img_mime($object->last_main_doc, '');
		if ($message == "signed") {
			print $langs->trans("DownloadSignedDocument").'</a>';
		} else {
			print $langs->trans("DownloadDocument").'</a>';
		}
	}
	print '<input type="hidden" name="source" value="'.GETPOST("source", 'alpha').'">';
	print '<input type="hidden" name="ref" value="'.$object->ref.'">';
	print '</td></tr>'."\n";
} elseif ($source == 'societe_rib') {
	$found = true;
	$langs->loadLangs(array("companies", "commercial", "withdrawals"));

	$result = $object->fetch_thirdparty();

	// Proposer
	print '<tr class="CTableRow2"><td class="CTableRow2">' . $langs->trans("Proposer");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>' . $creditor . '</b>';
	print '<input type="hidden" name="creditor" value="' . $creditor . '">';
	print '</td></tr>' . "\n";

	// Target
	print '<tr class="CTableRow2"><td class="CTableRow2">' . $langs->trans("ThirdParty");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>' . $object->thirdparty->name . '</b>';
	print '</td></tr>' . "\n";

	// Object
	$text = '<b>' . $langs->trans("Signature" . dol_ucfirst($source) . "Ref", $object->ref) . '</b>';
	print '<tr class="CTableRow2"><td class="CTableRow2">' . $langs->trans("Designation");
	print '</td><td class="CTableRow2">' . $text;

	$last_main_doc_file = $object->last_main_doc;
	$diroutput = $conf->societe->multidir_output[$object->thirdparty->entity].'/'
			.dol_sanitizeFileName($object->thirdparty->id).'/';
	if ((empty($last_main_doc_file) ||
		!dol_is_file($diroutput
			.$langs->transnoentitiesnoconv("SepaMandateShort").' '.$object->id."-".dol_sanitizeFileName($object->rum).".pdf"))
		&& 	$message != "signed") {
		// It seems document has never been generated, or was generated and then deleted.
		// So we try to regenerate it with its default template.
		//$defaulttemplate = 'sepamandate';
		$defaulttemplate = getDolGlobalString("BANKADDON_PDF");

		$object->setDocModel($user, $defaulttemplate);
		$moreparams = array(
			'use_companybankid'=>$object->id,
			'force_dir_output'=>$diroutput
		);
		$result = $object->thirdparty->generateDocument($defaulttemplate, $langs, 0, 0, 0, $moreparams);
		$object->last_main_doc=$object->thirdparty->last_main_doc;
	}
	$directdownloadlink = $object->getLastMainDocLink('company');
	if ($directdownloadlink) {
		print '<br><a href="'.$directdownloadlink.'">';
		print img_mime($object->last_main_doc, '');
		if ($message == "signed") {
			print $langs->trans("DownloadSignedDocument").'</a>';
		} else {
			print $langs->trans("DownloadDocument").'</a>';
		}
	}
} else {
	$found = true;
	$langs->load('companies');

	if (!empty($object->socid) || !empty($object->fk_soc)) {
		$result = $object->fetch_thirdparty();
	}

	// Proposer
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Proposer");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$creditor.'</b>';
	print '<input type="hidden" name="creditor" value="'.$creditor.'">';
	print '</td></tr>'."\n";

	// Target
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("ThirdParty");
	print '</td><td class="CTableRow2">';
	print img_picto('', 'company', 'class="pictofixedwidth"');
	print '<b>'.$object->thirdparty->name.'</b>';
	print '</td></tr>'."\n";

	// Object
	$text = '<b>'.$langs->trans("Signature".dol_ucfirst($source)."Ref", $object->ref).'</b>';
	print '<tr class="CTableRow2"><td class="CTableRow2">'.$langs->trans("Designation");
	print '</td><td class="CTableRow2">'.$text;

	$last_main_doc_file = $object->last_main_doc;

	if (empty($last_main_doc_file) || !dol_is_file(DOL_DATA_ROOT.'/'.$object->last_main_doc)) {
		// It seems document has never been generated, or was generated and then deleted.
		// So we try to regenerate it with its default template.
		$defaulttemplate = '';		// We force the use an empty string instead of $object->model_pdf to be sure to use a "main" default template and not the last one used.
		$object->generateDocument($defaulttemplate, $langs);
	}

	$directdownloadlink = $object->getLastMainDocLink($source);
	if ($directdownloadlink) {
		print '<br><a href="'.$directdownloadlink.'">';
		print img_mime($object->last_main_doc, '');
		if ($message == "signed") {
			print $langs->trans("DownloadSignedDocument").'</a>';
		} else {
			print $langs->trans("DownloadDocument").'</a>';
		}
	}
}

// Call Hook addFormSign
$parameters = array('source' => $source);
$reshook = $hookmanager->executeHooks('addFormSign', $parameters, $object, $action); // Note that $action and $object may have been modified by hook

if (!$found && !$mesg) {
	$mesg = $langs->transnoentitiesnoconv("ErrorBadParameters");
}

if ($mesg) {
	print '<tr><td class="center" colspan="2"><br><div class="warning">'.dol_escape_htmltag($mesg).'</div></td></tr>'."\n";
}

print '</table>'."\n";
print "\n";

if ($action != 'dosign') {
	if ($found && !$error) {
		// We are in a management option and no error
	} else {
		dol_print_error_email('ERRORNEWONLINESIGN');
	}
} else {
	// Print
}

print '</td></tr>'."\n";
print '<tr><td class="center">';


if ($action == "dosign" && empty($cancel)) {
	print '<div class="tablepublicpayment">';
	print '<input type="text" class="paddingleftonly marginleftonly paddingrightonly marginrightonly marginbottomonly" id="name"  placeholder="'.$langs->trans("Lastname").'" autofocus>';
	print '<div id="signature" style="border:solid;"></div>';
	print '</div>';
	print '<input type="button" class="small noborderbottom cursorpointer buttonreset" id="clearsignature" value="'.$langs->trans("ClearSignature").'">';

	// Do not use class="reposition" here: It breaks the submit and there is a message on top to say it's ok, so going back top is better.
	print '<div>';
	print '<input type="button" class="button marginleftonly marginrightonly" id="signbutton" value="'.$langs->trans("Sign").'">';
	print '<input type="submit" class="button butActionDelete marginleftonly marginrightonly" name="cancel" value="'.$langs->trans("Cancel").'">';
	print '</div>';

	// Add js code managed into the div #signature
	print '<script language="JavaScript" type="text/javascript" src="'.DOL_URL_ROOT.'/includes/jquery/plugins/jSignature/jSignature.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	  $("#signature").jSignature({ color:"#000", lineWidth:0, '.(empty($conf->dol_optimize_smallscreen) ? '' : 'width: 280, ').'height: 180});

	  $("#signature").on("change",function(){
		$("#clearsignature").css("display","");
		$("#signbutton").attr("disabled",false);
		if(!$._data($("#signbutton")[0], "events")){
			$("#signbutton").on("click",function(){
				console.log("We click on button sign");
				document.body.style.cursor = \'wait\';
				/* $("#signbutton").val(\''.dol_escape_js($langs->transnoentities('PleaseBePatient')).'\'); */
				var signature = $("#signature").jSignature("getData", "image");
				var name = document.getElementById("name").value;
				$.ajax({
					type: "POST",
					url: "'.DOL_URL_ROOT.'/core/ajax/onlineSign.php",
					dataType: "text",
					data: {
						"action" : "importSignature",
						"token" : \''.newToken().'\',
						"signaturebase64" : signature,
						"onlinesignname" : name,
						"ref" : \''.dol_escape_js($REF).'\',
						"securekey" : \''.dol_escape_js($SECUREKEY).'\',
						"mode" : \''.dol_escape_htmltag($source).'\',
						"entity" : \''.dol_escape_htmltag($entity).'\',
					},
					success: function(response) {
						if(response == "success"){
							console.log("Success on saving signature");
							window.location.replace("'.$_SERVER["PHP_SELF"].'?ref='.urlencode($ref).'&source='.urlencode($source).'&message=signed&securekey='.urlencode($SECUREKEY).(isModEnabled('multicompany') ? '&entity='.$entity : '').'");
						}else{
							console.error(response);
						}
					},
				});
			});
		}
	  });

	  $("#clearsignature").on("click",function(){
		$("#signature").jSignature("clear");
		$("#signbutton").attr("disabled",true);
		// document.getElementById("onlinesignname").value = "";
	  });

	  $("#signbutton").attr("disabled",true);
	});
	</script>';
} else {
	if ($source == 'proposal') {
		if ($object->status == $object::STATUS_SIGNED) {
			print '<br>';
			if ($message == 'signed') {
				print img_picto('', 'check', '', false, 0, 0, '', 'size2x').'<br>';
				print '<span class="ok">'.$langs->trans("PropalSigned").'</span>';
				// Send refusal email purvesh
				$email_result = sendProposalSignedEmail($object, $langs, $mysoc);
				if ($email_result) {
					setEventMessages("EmailSentToClient", null, 'mesgs');
				} else {
					setEventMessages("ErrorSendingEmail", null, 'warnings');
				}
			} else {
				print img_picto('', 'check', '', false, 0, 0, '', 'size2x').'<br>';
				print '<span class="ok">'.$langs->trans("PropalAlreadySigned").'</span>';
			}
		} elseif ($object->status == $object::STATUS_NOTSIGNED) {
			print '<br>';
			if ($message == 'refused') {
				print img_picto('', 'cross', '', false, 0, 0, '', 'size2x').'<br>';
				print '<span class="ok">'.$langs->trans("PropalRefused").'</span>';
			} else {
				print img_picto('', 'cross', '', false, 0, 0, '', 'size2x').'<br>';
				print '<span class="warning">'.$langs->trans("PropalAlreadyRefused").'</span>';
			}
		} else {
			print '<input type="submit" class="butAction small wraponsmartphone marginbottomonly marginleftonly marginrightonly reposition" value="'.$langs->trans("SignPropal").'">';
			print '<input name="refusepropal" type="submit" class="butActionDelete small wraponsmartphone marginbottomonly marginleftonly marginrightonly reposition" value="'.$langs->trans("RefusePropal").'">';
		}
	} elseif ($source == 'contract') {
		if ($message == 'signed') {
			print '<span class="ok">'.$langs->trans("ContractSigned").'</span>';
		} else {
			print '<input type="submit" class="butAction small wraponsmartphone marginbottomonly marginleftonly marginrightonly reposition" value="'.$langs->trans("SignContract").'">';
		}
	} elseif ($source == 'fichinter') {
		if ($message == 'signed') {
			print '<span class="ok">'.$langs->trans("FichinterSigned").'</span>';
		} else {
			print '<input type="submit" class="butAction small wraponsmartphone marginbottomonly marginleftonly marginrightonly reposition" value="'.$langs->trans("SignFichinter").'">';
		}
	} else {
		if ($message == 'signed') {
			print '<span class="ok">'.$langs->trans(dol_ucfirst($source)."Signed").'</span>';
		} else {
			print '<input type="submit" class="butAction small wraponsmartphone marginbottomonly marginleftonly marginrightonly reposition" value="'.$langs->trans("Sign".dol_ucfirst($source)).'">';
		}
	}
}
print '</td></tr>'."\n";
print '</table>'."\n";
print '</form>'."\n";
print '</div>'."\n";
print '<br>';


htmlPrintOnlineFooter($mysoc, $langs);

llxFooter('', 'public');

$db->close();
