<?php
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
require_once DOL_DOCUMENT_ROOT . '/core/class/html.form.class.php';

dol_include_once('/purchaseordercustomreferencenumber/class/purchaseordercustomreferencenumber.class.php');
Class FormCustomProductType
{
    
    /**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string		A hash value of the custom product type. Duplicate of ref but for public purposes.
	 */
	public $track_id;

	/**
	 * @var string 		Email $trackid. Used also for the $keytoavoidconflict to name session vars to upload files.
	 */
	public $trackid;

	/**
	 * @var int ID
	 */
	public $fk_user_create;

	public $message;
	public $topic_title;

	public $action;

	public $withtopic;
	public $withemail;

	/**
	 * @var int $withsubstit Show substitution array
	 */
	public $withsubstit;

	public $withfile;
	public $withfilereadonly;

	public $backtopage;

	public $ispublic;  // to show information or not into public form

	public $withtitletopic;
	public $withtopicreadonly;
	public $withreadid;

	public $withcompany;  // to show company drop-down list
	public $withfromsocid;
	public $withfromcontactid;
	public $withnotifytiersatcreate;
	public $withusercreate;  // to show name of creating user in form
	public $withcreatereadonly;

	/**
	 * @var int withextrafields
	 */
	public $withextrafields;

	public $withref;  // to show ref field
	public $withcancel;

	public $type_code;
	public $category_code;
	public $severity_code;


	/**
	 *
	 * @var array $substit Substitutions
	 */
	public $substit = array();
	public $param = array();

	/**
	 * @var string Error code (or message)
	 */
	public $error;
	public $errors = array();


	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $conf;

		$this->db = $db;

		$this->action = 'add';

		$this->withcompany = isModEnabled("societe");
		$this->withfromsocid = 0;
		$this->withfromcontactid = 0;
		$this->withreadid=0;
		//$this->withtitletopic='';
		$this->withnotifytiersatcreate = 0;
		$this->withusercreate = 1;
		$this->withcreatereadonly = 1;
		$this->withemail = 0;
		$this->withref = 0;
		$this->withextrafields = 0;  // to show extrafields or not
		//$this->withtopicreadonly=0;
	}

    public function selectCustomPurchaseOrderType($selected = '', $htmlname = 'customproducttype', $filtertype = '', $format = 0, $empty = 0, $noadmininfo = 0, $maxlength = 0, $morecss = '', $multiselect = 0)
	{
		global $langs, $user;

		$selected = is_array($selected) ? $selected : (!empty($selected) ? explode(',', $selected) : array());
		$customproducttypestat = new PurchaseOrderCustomReferenceNumber($this->db);

		dol_syslog(get_class($this) . "::custom_product_type_select " . implode(';', $selected) . ", " . $htmlname . ", " . $filtertype . ", " . $format . ", " . $multiselect, LOG_DEBUG);

		$filterarray = array();

		if ($filtertype != '' && $filtertype != '-1') {
			$filterarray = explode(',', $filtertype);
		}

		$customproducttypestat->loadCacheTypesCustomPurchaseOrderReferenceNumber();

		$out = '';

		$out .= '<select id="select'.$htmlname.'" class="flat minwidth100'.($morecss ? ' '.$morecss : '').'" name="'.$htmlname.($multiselect ? '[]' : '').'"'.($multiselect ? ' multiple' : '').'>';
		if ($empty) {
			$out .= '<option value="">&nbsp;</option>';
		}

		if (is_array($customproducttypestat->cache_types_custom_purchase_order) && count($customproducttypestat->cache_types_custom_purchase_order)) {
			foreach ($customproducttypestat->cache_types_custom_purchase_order as $id => $arraytypes) {
				// On passe si on a demande de filtrer sur des modes de paiments particuliers
				if (count($filterarray) && !in_array($arraytypes['type'], $filterarray)) {
					continue;
				}

				// If 'showempty' is enabled we discard empty line because an empty line has already been output.
				if ($empty && empty($arraytypes['code'])) {
					continue;
				}

				if ($format == 0) {
					$out .= '<option value="'.$id.'"';
				}

				if ($format == 1) {
					$out .= '<option value="'.$arraytypes['code'].'"';
				}

				if ($format == 2) {
					$out .= '<option value="'.$arraytypes['code'].'"';
				}

				if ($format == 3) {
					$out .= '<option value="'.$id.'"';
				}

				// If text is selected, we compare with code, otherwise with id
				if (in_array($arraytypes['code'], $selected)) {
					$out .= ' selected="selected"';
				} elseif (in_array($id, $selected)) {
					$out .= ' selected="selected"';
				} elseif ($arraytypes['use_default'] == "1" && !$selected && !$empty) {
					$out .= ' selected="selected"';
				}

				$out .= '>';

				$value = '&nbsp;';
				if ($format == 0) {
					$value = ($maxlength ? dol_trunc($arraytypes['label'], $maxlength) : $arraytypes['label']);
				} elseif ($format == 1) {
					$value = $arraytypes['code'];
				} elseif ($format == 2) {
					$value = ($maxlength ? dol_trunc($arraytypes['label'], $maxlength) : $arraytypes['label']);
				} elseif ($format == 3) {
					$value = $arraytypes['code'];
				}

				$out .= $value ? $value : '&nbsp;';
				$out .= '</option>';
			}
		}
		$out .= '</select>';
		if (isset($user->admin) && $user->admin && !$noadmininfo) {
			$out .= info_admin($langs->trans("YouCanChangeValuesForThisListFromDictionarySetup"), 1);
		}

		$out .= ajax_combobox('select'.$htmlname);

		print $out;
	}

}

