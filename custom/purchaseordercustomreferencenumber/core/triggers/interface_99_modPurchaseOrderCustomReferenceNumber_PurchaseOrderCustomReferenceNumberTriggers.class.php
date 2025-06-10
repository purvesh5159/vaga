<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Copyright (C) 2024 SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    core/triggers/interface_99_modPurchaseOrderCustomReferenceNumber_PurchaseOrderCustomReferenceNumberTriggers.class.php
 * \ingroup purchaseordercustomreferencenumber
 * \brief   Example trigger.
 *
 * Put detailed description here.
 *
 * \remarks You can create other triggers by copying this one.
 * - File name should be either:
 *      - interface_99_modPurchaseOrderCustomReferenceNumber_MyTrigger.class.php
 *      - interface_99_all_MyTrigger.class.php
 * - The file must stay in core/triggers
 * - The class name must be InterfaceMytrigger
 */

require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';


/**
 *  Class of triggers for PurchaseOrderCustomReferenceNumber module
 */
class InterfacePurchaseOrderCustomReferenceNumberTriggers extends DolibarrTriggers
{
	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;

		$this->name = preg_replace('/^Interface/i', '', get_class($this));
		$this->family = "demo";
		$this->description = "PurchaseOrderCustomReferenceNumber triggers.";
		// 'development', 'experimental', 'dolibarr' or version
		$this->version = 'development';
		$this->picto = 'purchaseordercustomreferencenumber@purchaseordercustomreferencenumber';
	}

	/**
	 * Trigger name
	 *
	 * @return string Name of trigger file
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Trigger description
	 *
	 * @return string Description of trigger file
	 */
	public function getDesc()
	{
		return $this->description;
	}


	/**
	 * Function called when a Dolibarrr business event is done.
	 * All functions "runTrigger" are triggered if file
	 * is inside directory core/triggers
	 *
	 * @param string 		$action 	Event action code
	 * @param CommonObject 	$object 	Object
	 * @param User 			$user 		Object user
	 * @param Translate 	$langs 		Object langs
	 * @param Conf 			$conf 		Object conf
	 * @return int              		Return integer <0 if KO, 0 if no triggered ran, >0 if OK
	 */
	public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
	{
		if (!isModEnabled('purchaseordercustomreferencenumber')) {
			return 0; // If module is not enabled, we do nothing
		}

		// Normalize and log the action
		$action = trim((string) $action);
		dol_syslog("PurchaseOrderCustomReferenceNumber Trigger received action: '$action'", LOG_DEBUG);

		// Check if a specific method is defined for this action
		$methodName = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($action)))));
		$callback = array($this, $methodName);
		if (is_callable($callback)) {
			dol_syslog("Trigger '".$this->name."' calls method '$methodName' for action '$action'.", LOG_DEBUG);
			return call_user_func($callback, $action, $object, $user, $langs, $conf);
		}

		// Ensure only ORDER_SUPPLIER_CREATE is processed below
		if ($action !== 'ORDER_SUPPLIER_CREATE') {
			dol_syslog("Skipping action '$action' as it does not match ORDER_SUPPLIER_CREATE.", LOG_DEBUG);
			return 0;
		}
		if ($action === 'confirm_clone') {
			dol_syslog("Skipping trigger because action is 'confirm_clone'", LOG_DEBUG);
			return 0;
		}

		// This logic only runs for ORDER_SUPPLIER_CREATE
		dol_syslog("Executing ORDER_SUPPLIER_CREATE logic in PurchaseOrderCustomReferenceNumber trigger.", LOG_DEBUG);

		$conf->global->MAIN_DISABLE_PDF_AUTOUPDATE = 0;

		if ($action === 'ORDER_SUPPLIER_CREATE') {
		// Check if this is a clone operation
		if (!empty($object->context['createfromclone'])) {
			dol_syslog("Skipping ORDER_SUPPLIER_CREATE trigger because it's from a clone.", LOG_DEBUG);
			return 0;
		}

		if ($object->array_options['options_purchaseordertype'] == 'FPO') {
			$custompurchaseordertype = 'FPO';
			dol_include_once('/purchaseordercustomreferencenumber/class/purchaseordercustomreferencenumber.class.php');
			$purchaseordercustomreferenceobject = new PurchaseOrderCustomReferenceNumber($this->db);

			$num = $purchaseordercustomreferenceobject->getNextNumRefForfpo();
			$num = $num . '-R0';

			$sql = 'UPDATE ' . $this->db->prefix() . "commande_fournisseur";
			$sql .= " SET ref='" . $this->db->escape($num) . "'";
			$sql .= " WHERE rowid = " . ((int) $object->id);

			$resql = $this->db->query($sql);
			if (!$resql) {
				dol_print_error($this->db);
			}
		}

		if ($object->array_options['options_purchaseordertype'] == 'LPO') {
			$custompurchaseordertype = 'LPO';
			dol_include_once('/purchaseordercustomreferencenumber/class/purchaseordercustomreferencenumber.class.php');
			$purchaseordercustomreferenceobject = new PurchaseOrderCustomReferenceNumber($this->db);

			$num = $purchaseordercustomreferenceobject->getNextNumRefForlpo();
			$num = $num . '-R0';

			$sql = 'UPDATE ' . $this->db->prefix() . "commande_fournisseur";
			$sql .= " SET ref='" . $this->db->escape($num) . "'";
			$sql .= " WHERE rowid = " . ((int) $object->id);

			$resql = $this->db->query($sql);
			if (!$resql) {
				dol_print_error($this->db);
			}
		}
	}
	return 0;
	}

}
