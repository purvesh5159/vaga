<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Copyright (C) 2006      Andre Cianfarani     <acianfa@free.fr>
 * Copyright (C) 2005-2013 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2007-2011 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2020      Josep Lluís Amador   <joseplluis@lliuretic.cat>
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

 if (!defined('NOTOKENRENEWAL')) {
	define('NOTOKENRENEWAL', 1); // Disables token renewal
}
if (!defined('NOREQUIREMENU')) {
	define('NOREQUIREMENU', '1');
}
if (!defined('NOREQUIREHTML')) {
	define('NOREQUIREHTML', '1');
}
if (!defined('NOREQUIREAJAX')) {
	define('NOREQUIREAJAX', '1');
}
if (empty($_GET['keysearch']) && !defined('NOREQUIREHTML')) {
	define('NOREQUIREHTML', '1');
}

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

$custompurchaseordertype = GETPOST('custompurchaseordertype');

dol_include_once('/purchaseordercustomreferencenumber/class/purchaseordercustomreferencenumber.class.php');
$object = new PurchaseOrderCustomReferenceNumber($db);
require_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.commande.class.php';
$commandefournisseurobject = new CommandeFournisseur($db);

$module = getDolGlobalString('COMMANDE_SUPPLIER_ADDON_NUMBER_CUSTOM', 'mod_custom_commande_fournisseur_muguet');
if ($module != 'mod_custom_commande_fournisseur_muguet') {    // Do not load module file for leopard
	if (substr($module, 0, 16) == 'mod_custom_commande_fournisseur_muguet' && substr($module, -3) == 'php') {
		$module = substr($module, 0, dol_strlen($module) - 4);
	}
	dol_include_once('/custom/purchaseordercustomreferencenumber/core/modules/purchaseordercustomreferencenumber/mod_custom_commande_fournisseur_muguet.php');
	$modCodePurchaseOrder = new mod_custom_commande_fournisseur_muguet();
	if (!empty($modCodePurchaseOrder->code_auto)) {
		$commandefournisseurobject->ref = $modCodePurchaseOrder->getNextValue($commandefournisseurobject, $commandefournisseurobject->type, $custompurchaseordertype);
	}
	unset($modCodePurchaseOrder);
}

$object->getNextNumRef();
print json_encode($commandefournisseurobject->ref);