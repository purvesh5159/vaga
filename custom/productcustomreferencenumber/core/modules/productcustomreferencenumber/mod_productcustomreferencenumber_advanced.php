<?php
/* Copyright (C) 2003-2007  Rodolphe Quiedeville        <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2007  Laurent Destailleur         <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2009  Regis Houssin               <regis.houssin@inodbox.com>
 * Copyright (C) 2008       Raphael Bertrand (Resultic) <raphael.bertrand@resultic.fr>
 * Copyright (C) 2019       Frédéric France             <frederic.france@netlogic.fr>
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
 * or see https://www.gnu.org/
 */

/**
 * \file       htdocs/core/modules/productcustomreferencenumber/mod_productcustomreferencenumber_advanced.php
 * \ingroup    productcustomreferencenumber
 * \brief      File containing class for advanced numbering model of ProductCustomReferenceNumber
 */

dol_include_once('/productcustomreferencenumber/core/modules/productcustomreferencenumber/modules_productcustomreferencenumber.php');


/**
 *	Class to manage the Advanced numbering rule for ProductCustomReferenceNumber
 */
class mod_productcustomreferencenumber_advanced extends ModeleNumRefProductCustomReferenceNumber
{
	/**
	 * Dolibarr version of the loaded document
	 * @var string
	 */
	public $version = 'dolibarr'; // 'development', 'experimental', 'dolibarr'

	/**
	 * @var string Error message
	 */
	public $error = '';

	/**
	 * @var string name
	 */
	public $name = 'advanced';


	/**
	 *  Returns the description of the numbering model
	 *
	 *  @param      Translate   $langs Translate Object
	 *  @return     string             Text with description
	 */
	public function info($langs)
	{
		global $db;

		$langs->load("bills");

		$form = new Form($db);

		$text = $langs->trans('GenericNumRefModelDesc')."<br>\n";
		$text .= '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
		$text .= '<input type="hidden" name="token" value="'.newToken().'">';
		$text .= '<input type="hidden" name="action" value="updateMask">';
		$text .= '<input type="hidden" name="maskconst" value="PRODUCTCUSTOMREFERENCENUMBER_MYOBJECT_ADVANCED_MASK">';
		$text .= '<table class="nobordernopadding centpercent">';

		$tooltip = $langs->trans("GenericMaskCodes", $langs->transnoentities("ProductCustomReferenceNumber"), $langs->transnoentities("ProductCustomReferenceNumber"));
		$tooltip .= $langs->trans("GenericMaskCodes2");
		$tooltip .= $langs->trans("GenericMaskCodes3");
		$tooltip .= $langs->trans("GenericMaskCodes4a", $langs->transnoentities("ProductCustomReferenceNumber"), $langs->transnoentities("ProductCustomReferenceNumber"));
		$tooltip .= $langs->trans("GenericMaskCodes5");

		// Parametrage du prefix
		$text .= '<tr><td>'.$langs->trans("Mask").':</td>';
		$text .= '<td class="right">'.$form->textwithpicto('<input type="text" class="flat minwidth175" name="maskvalue" value="'.getDolGlobalString('PRODUCTCUSTOMREFERENCENUMBER_MYOBJECT_ADVANCED_MASK').'">', $tooltip, 1, 1).'</td>';
		$text .= '<td class="left" rowspan="2">&nbsp; <input type="submit" class="button button-edit" value="'.$langs->trans("Modify").'" name="Button"></td>';
		$text .= '</tr>';

		$text .= '</table>';
		$text .= '</form>';

		return $text;
	}

	/**
	 *  Return an example of numbering
	 *
	 *  @return     string      Example
	 */
	public function getExample()
	{
		global $conf, $db, $langs, $mysoc;

		$object = new ProductCustomReferenceNumber($db);
		$object->initAsSpecimen();

		/*$old_code_client = $mysoc->code_client;
		$old_code_type = $mysoc->typent_code;
		$mysoc->code_client = 'CCCCCCCCCC';
		$mysoc->typent_code = 'TTTTTTTTTT';*/

		$numExample = $this->getNextValue($object);

		/*$mysoc->code_client = $old_code_client;
		$mysoc->typent_code = $old_code_type;*/

		if (!$numExample) {
			$numExample = $langs->trans('NotConfigured');
		}
		return $numExample;
	}

	/**
	 * 	Return next free value
	 *
	 *  @param  Object		$object		Object we need next value for
	 *  @return string      			Value if KO, <0 if KO
	 */
	public function getNextValue($object)
	{
		global $db, $conf;

		require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';

		// We get cursor rule
		$mask = getDolGlobalString('PRODUCTCUSTOMREFERENCENUMBER_MYOBJECT_ADVANCED_MASK');

		if (!$mask) {
			$this->error = 'NotConfigured';
			return 0;
		}

		$date = $object->date;

		$numFinal = get_next_value($db, $mask, 'productcustomreferencenumber_productcustomreferencenumber', 'ref', '', null, $date);

		return  $numFinal;
	}
}
