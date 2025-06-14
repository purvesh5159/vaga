<?php
/* Copyright (C) 2015       Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2015       Alexandre Spangaro      <aspangaro@open-dsi.fr>
 * Copyright (C) 2016-2023  Philippe Grand          <philippe.grand@atoo-net.com>
 * Copyright (C) 2018-2020  Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2018       Francis Appels          <francis.appels@z-application.com>
 * Copyright (C) 2019       Markus Welters          <markus@welters.de>
 * Copyright (C) 2019       Rafael Ingenleuf        <ingenleuf@welters.de>
 * Copyright (C) 2020       Marc Guenneugues        <marc.guenneugues@simicar.fr>
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
 *	\file       htdocs/core/modules/expensereport/doc/pdf_standard.modules.php
 *	\ingroup    expensereport
 *	\brief      File of class to generate expense report from standard model
 */

require_once DOL_DOCUMENT_ROOT.'/core/modules/expensereport/modules_expensereport.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/pdf.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/date.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/bank.lib.php';
require_once DOL_DOCUMENT_ROOT.'/compta/bank/class/account.class.php';
require_once DOL_DOCUMENT_ROOT.'/user/class/userbankaccount.class.php';

/**
 *	Class to generate expense report based on standard model
 */
class pdf_standard extends ModeleExpenseReport
{
	/**
	 * @var DoliDb Database handler
	 */
	public $db;

	/**
	 * @var string model name
	 */
	public $name;

	/**
	 * @var string model description (short text)
	 */
	public $description;

	/**
	 * @var int     Save the name of generated file as the main doc when generating a doc with this template
	 */
	public $update_main_doc_field;

	/**
	 * @var string document type
	 */
	public $type;

	/**
	 * Dolibarr version of the loaded document
	 * @var string
	 */
	public $version = 'dolibarr';

	public $posxpiece;
	public $posxcomment;
	public $posxtva;
	public $posxup;
	public $posxqty;
	public $posxtype;

	/**
	 * @var int posx date
	 */
	public $posxdate;
	public $posxprojet;
	public $postotalht;
	public $postotalttc;


	/**
	 *  Constructor
	 *
	 *  @param      DoliDB      $db      Database handler
	 */
	public function __construct($db)
	{
		global $conf, $langs, $mysoc, $user;

		// Translations
		$langs->loadLangs(array("main", "trips", "projects"));

		$this->db = $db;
		$this->name = "";
		$this->description = $langs->trans('PDFStandardExpenseReports');
		$this->update_main_doc_field = 1; // Save the name of generated file as the main doc when generating a doc with this template

		// Page size for A4 format
		$this->type = 'pdf';
		$formatarray = pdf_getFormat();
		$this->page_largeur = $formatarray['width'];
		$this->page_hauteur = $formatarray['height'];
		$this->format = array($this->page_largeur, $this->page_hauteur);
		$this->marge_gauche = getDolGlobalInt('MAIN_PDF_MARGIN_LEFT', 10);
		$this->marge_droite = getDolGlobalInt('MAIN_PDF_MARGIN_RIGHT', 10);
		$this->marge_haute = getDolGlobalInt('MAIN_PDF_MARGIN_TOP', 10);
		$this->marge_basse = getDolGlobalInt('MAIN_PDF_MARGIN_BOTTOM', 10);

		$this->option_logo = 1; // Display logo
		$this->option_tva = 1; // Manage the vat option FACTURE_TVAOPTION
		$this->option_modereg = 1; // Display payment mode
		$this->option_condreg = 1; // Display payment terms
		$this->option_multilang = 1; // Available in several languages
		$this->option_escompte = 0; // Displays if there has been a discount
		$this->option_credit_note = 0; // Support credit notes
		$this->option_freetext = 1; // Support add of a personalised text
		$this->option_draft_watermark = 1; // Support add of a watermark on drafts

		// Get source company
		$this->emetteur = $mysoc;

		if (empty($this->emetteur->country_code)) {
			$this->emetteur->country_code = substr($langs->defaultlang, -2); // By default, if was not defined
		}

		// Define position of columns
				//$this->posxdate=88;
		//$this->posxtype=107;
		//$this->posxprojet=120;
		
		$this->posxpiece 	= $this->marge_gauche + 1;
		$this->posxcomment 	= $this->marge_gauche + 10;
		$this->posxqty 		= 88;   // Quantity
		$this->posxup 		= 100;  // Unit Price
		$this->postotalht 	= 120;  // Excl Tax
		$this->posxtva 		= 145;  // Adjusted for new column GST %
		$this->posxgstvalue = 160;  // Adjusted for new column GST VALUE
		$this->postotalttc 	= 185;  // Including Tax
		
		// if (!isModEnabled('project')) {
		//     $this->posxtva-=20;
		//     $this->posxup-=20;
		//     $this->posxqty-=20;
		//     $this->postotalttc-=20;
		// }
		
		if ($this->page_largeur < 210) { // To work with US executive format
			$this->posxdate -= 20;
			$this->posxtype -= 20;
			$this->posxprojet -= 20;
			$this->posxtva -= 20;
			$this->posxup -= 20;
			$this->posxqty -= 20;
			$this->postotalttc -= 20;
		}

		$this->tva = array();
		$this->tva_array = array();
		$this->localtax1 = array();
		$this->localtax2 = array();
		$this->atleastoneratenotnull = 0;
		$this->atleastonediscount = 0;
	}


	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
	/**
	 *  Function to build pdf onto disk
	 *
	 *  @param	ExpenseReport	$object				Object to generate
	 *  @param	Translate		$outputlangs		Lang output object
	 *  @param	string			$srctemplatepath	Full path of source filename for generator using a template file
	 *  @param	int				$hidedetails		Do not show line details
	 *  @param	int				$hidedesc			Do not show desc
	 *  @param	int				$hideref			Do not show ref
	 *  @return int             					1=OK, 0=KO
	 */
	public function write_file($object, $outputlangs, $srctemplatepath = '', $hidedetails = 0, $hidedesc = 0, $hideref = 0)
	{
		// phpcs:enable
		global $user, $langs, $conf, $mysoc, $db, $hookmanager;		

		if (!is_object($outputlangs)) {
			$outputlangs = $langs;
		}
		// For backward compatibility with FPDF, force output charset to ISO, because FPDF expect text to be encoded in ISO
		if (getDolGlobalString('MAIN_USE_FPDF')) {
			$outputlangs->charset_output = 'ISO-8859-1';
		}

		// Load traductions files required by page
		$outputlangs->loadLangs(array("main", "trips", "projects", "dict", "bills", "banks"));

		$nblines = count($object->lines);

		if ($conf->expensereport->dir_output) {
			// Definition of $dir and $file
			if ($object->specimen) {
				$dir = $conf->expensereport->dir_output;
				$file = $dir."/SPECIMEN.pdf";
			} else {
				$objectref = dol_sanitizeFileName($object->ref);
				$dir = $conf->expensereport->dir_output."/".$objectref;
				$file = $dir."/".$objectref.".pdf";
			}

			if (!file_exists($dir)) {
				if (dol_mkdir($dir) < 0) {
					$this->error = $langs->transnoentities("ErrorCanNotCreateDir", $dir);
					return 0;
				}
			}

			if (file_exists($dir)) {
				// Add pdfgeneration hook
				if (!is_object($hookmanager)) {
					include_once DOL_DOCUMENT_ROOT.'/core/class/hookmanager.class.php';
					$hookmanager = new HookManager($this->db);
				}
				$hookmanager->initHooks(array('pdfgeneration'));
				$parameters = array('file'=>$file, 'object'=>$object, 'outputlangs'=>$outputlangs);
				global $action;
				$reshook = $hookmanager->executeHooks('beforePDFCreation', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks

				// Create pdf instance
				$pdf = pdf_getInstance($this->format);
				$default_font_size = pdf_getPDFFontSize($outputlangs); // Must be after pdf_getInstance
				$heightforinfotot = 40; // Height reserved to output the info and total part
				$heightforfreetext = (isset($conf->global->MAIN_PDF_FREETEXT_HEIGHT) ? $conf->global->MAIN_PDF_FREETEXT_HEIGHT : 5); // Height reserved to output the free text on last page
				$heightforfooter = $this->marge_basse + 12; // Height reserved to output the footer (value include bottom margin)
				if (getDolGlobalString('MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS')) {
					$heightforfooter += 6;
				}

				$pdf->SetAutoPageBreak(1, 0);

				if (class_exists('TCPDF')) {
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
				}
				$pdf->SetFont(pdf_getPDFFont($outputlangs));
				// Set path to the background PDF File
				if (getDolGlobalString('MAIN_ADD_PDF_BACKGROUND')) {
					$pagecount = $pdf->setSourceFile($conf->mycompany->dir_output.'/' . getDolGlobalString('MAIN_ADD_PDF_BACKGROUND'));
					$tplidx = $pdf->importPage(1);
				}

				$pdf->Open();
				$pagenb = 0;
				$pdf->SetDrawColor(128, 128, 128);

				$pdf->SetTitle($outputlangs->convToOutputCharset($object->ref));
				$pdf->SetSubject($outputlangs->transnoentities("Trips"));
				$pdf->SetCreator("Dolibarr ".DOL_VERSION);
				$pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
				$pdf->SetKeyWords($outputlangs->convToOutputCharset($object->ref)." ".$outputlangs->transnoentities("Trips"));
				if (getDolGlobalString('MAIN_DISABLE_PDF_COMPRESSION')) {
					$pdf->SetCompression(false);
				}

				$pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right

				// New page
				$pdf->AddPage();
				if (!empty($tplidx)) {
					$pdf->useTemplate($tplidx);
				}
				$pagenb++;
				$this->_pagehead($pdf, $object, 1, $outputlangs);
				$pdf->SetFont('', '', $default_font_size - 1);
				$pdf->MultiCell(0, 3, ''); // Set interline to 3
				
				$pdf->SetTextColor(0, 0, 0);

				$tab_top = 95;
				$tab_top_newpage = (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD') ? 65 : 10);

				$tab_height = $this->page_hauteur - $tab_top - $heightforfooter - $heightforfreetext;

				// Show notes
				$notetoshow = empty($object->note_public) ? '' : $object->note_public;
				if (getDolGlobalString('MAIN_ADD_SALE_REP_SIGNATURE_IN_NOTE')) {
					// Get first sale rep
					if (is_object($object->thirdparty)) {
						$salereparray = $object->thirdparty->getSalesRepresentatives($user);
						$salerepobj = new User($this->db);
						$salerepobj->fetch($salereparray[0]['id']);
						if (!empty($salerepobj->signature)) {
							$notetoshow = dol_concatdesc($notetoshow, $salerepobj->signature);
						}
					}
				}
				
				if ($notetoshow) {
					$substitutionarray = pdf_getSubstitutionArray($outputlangs, null, $object);
					complete_substitutions_array($substitutionarray, $outputlangs, $object);
					$notetoshow = make_substitutions($notetoshow, $substitutionarray, $outputlangs);
					$notetoshow = convertBackOfficeMediasLinksToPublicLinks($notetoshow);

					$tab_top = 95;

					$pdf->SetFont('', '', $default_font_size - 1);
					$pdf->writeHTMLCell(190, 3, $this->posxpiece - 1, $tab_top, dol_htmlentitiesbr($notetoshow), 0, 1);
					$nexY = $pdf->GetY();
					$height_note = $nexY - $tab_top;

					// Rect takes a length in 3rd parameter
					$pdf->SetDrawColor(192, 192, 192);
					$pdf->Rect($this->marge_gauche, $tab_top - 1, $this->page_largeur - $this->marge_gauche - $this->marge_droite, $height_note + 1);

					$tab_height = $tab_height - $height_note;
					$tab_top = $nexY + 6;
				} else {
					$height_note = 0;
				}
				
					//Fetch user extra fields based on user ID or row ID
					//var_dump($object);
					//$u = new User($this->db);
					//$u->fetch($object->rowid);
					//echo $u->fk_object;
					
					//VSN  added to show custom fields in the pdf.
					// Extrafields in PDF //VSN
					$extranote = $this->getExtrafieldsInHtml($object, $outputlangs);					
					if (!empty($extranote)) {					
						//$extrafieldstoshow = dol_concatdesc($notetoshow, $extranote);
						$usr = new User($this->db);
						$user_rowid_sql = "SELECT rowid FROM vg_user where login = '".$user->login ."'";  
						// Adjust if needed to filter for a specific user
						$user_rowid_result = $db->query($user_rowid_sql);
						$user_rowid_row = $db->fetch_array($user_rowid_result);
						$fk_object = $user_rowid_row['rowid'];  // Extract the rowid value
						$sql = "SELECT vaga_department, vaga_division, vaga_band FROM vg_user_extrafields WHERE fk_object = " .$fk_object; //$object->id;
						$result = $db->query($sql);
						$row = $db->fetch_array($result);
						//print_r($row);
						$department = $row['vaga_department'];
						$division = $row['vaga_division'];
						$band = $row['vaga_band'];
						//echo $department  .$division .$band;
						
						$extrafieldstoshow = str_replace(["<br>"], ', ', $extranote);
						$iniY = $tab_top + 7;
						$initialY = $tab_top + 7;
						$nexY = $tab_top + 7;
				
						$tab_top = 95;
						$tab_top = $nexY + 1;
						//$pdf->writeHTMLCell(190, 3, $this->posxpiece - 1, $tab_top, dol_htmlentitiesbr($extrafieldstoshow) .",Dept: " .$department  .", Division: " .$division .", Band: " .$band, 0, 1);
						
						//working
						//$pdf->writeHTMLCell(190, 3, $this->posxpiece - 1, $tab_top, "<b>Emp.Code:</b> " .$user->login .", <b>Dept:</b> " .$department  .", <b>Division:</b> " .$division .", <b>Band:</b> " .$band, 0, 1);
						
						$nexY = $pdf->GetY();
						$height_note = $nexY - $tab_top;
						// Rect takes a length in 3rd parameter
						$pdf->SetDrawColor(192, 192, 192);
						//$pdf->Rect($this->marge_gauche, $tab_top - 1, $this->page_largeur - $this->marge_gauche - $this->marge_droite, $height_note + 1);
						$tab_height = $tab_height - $height_note;
						$tab_top = $nexY + 6;
					} else {
						$height_note = 0;
					}
					
				$tab_top = $nexY + 19;
				$iniY = $tab_top + 9;
				$initialY = $tab_top + 7;
				$nexY = $tab_top + 7;

				$showpricebeforepagebreak = 1;
				$pdf->setTopMargin($tab_top_newpage);
				// Loop on each lines
				$i = 0;
				while ($i < $nblines) {
					$pdf->SetFont('', '', $default_font_size - 2); // Into loop to work with multipage
					$pdf->SetTextColor(0, 0, 0);

					$pdf->setTopMargin($tab_top_newpage);
					if (empty($showpricebeforepagebreak) && ($i !== ($nblines - 1))) {
						$pdf->setPageOrientation('', 1, $heightforfooter); // The only function to edit the bottom margin of current page to set it.
					} else {
						$pdf->setPageOrientation('', 1, $heightforfooter + $heightforfreetext + $heightforinfotot); // The only function to edit the bottom margin of current page to set it.
					}

					$pageposbefore = $pdf->getPage();
					$curY = $nexY;
					$pdf->startTransaction();
					$this->printLine($pdf, $object, $i, $curY, $default_font_size, $outputlangs, $hidedetails);
					$pageposafter = $pdf->getPage();
					if ($pageposafter > $pageposbefore) {
						// There is a pagebreak
						$pdf->rollbackTransaction(true);

						$pageposafter = $pageposbefore;
						//print $pageposafter.'-'.$pageposbefore;exit;
						if (empty($showpricebeforepagebreak)) {
							$pdf->AddPage('', '', true);
							if (!empty($tplidx)) {
								$pdf->useTemplate($tplidx);
							}
							if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
								$this->_pagehead($pdf, $object, 0, $outputlangs);
							}
							$pdf->setPage($pageposafter + 1);
							$showpricebeforepagebreak = 1;
							$nexY = $tab_top_newpage;
							$nexY += ($pdf->getFontSize() * 1.3); // Add space between lines
							$pdf->SetFont('', '', $default_font_size - 2); // Into loop to work with multipage
							$pdf->SetTextColor(0, 0, 0);

							$pdf->setTopMargin($tab_top_newpage);
							continue;
						} else {
							$pdf->setPageOrientation('', 1, $heightforfooter);
							$showpricebeforepagebreak = 0;
						}

						$this->printLine($pdf, $object, $i, $curY, $default_font_size, $outputlangs, $hidedetails);
						$pageposafter = $pdf->getPage();
						$posyafter = $pdf->GetY();
						//var_dump($posyafter); var_dump(($this->page_hauteur - ($heightforfooter+$heightforfreetext+$heightforinfotot))); exit;
						if ($posyafter > ($this->page_hauteur - ($heightforfooter + $heightforfreetext + $heightforinfotot))) {
							// There is no space left for total+free text
							if ($i == ($nblines - 1)) {
								// No more lines, and no space left to show total, so we create a new page
								$pdf->AddPage('', '', true);
								if (!empty($tplidx)) {
									$pdf->useTemplate($tplidx);
								}
								if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
									$this->_pagehead($pdf, $object, 0, $outputlangs);
								}
								$pdf->setPage($pageposafter + 1);
							}
						} else {
							// We found a page break
							// Allows data in the first page if description is long enough to break in multiples pages
							if (getDolGlobalString('MAIN_PDF_DATA_ON_FIRST_PAGE')) {
								$showpricebeforepagebreak = 1;
							} else {
								$showpricebeforepagebreak = 0;
							}
						}
					} else { // No pagebreak
						$pdf->commitTransaction();
					}
					$i++;
					//nexY
					$nexY = $pdf->GetY();
					$pageposafter = $pdf->getPage();
					$pdf->setPage($pageposbefore);
					$pdf->setTopMargin($this->marge_haute);
					$pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.

					//$nblineFollowComment = 1;
					// Search number of lines coming to know if there is enough room
					// if ($i < ($nblines - 1))	// If it's not last line
					// {
					//     //Fetch current description to know on which line the next one should be placed
					// 	$follow_comment = $object->lines[$i]->comments;
					// 	$follow_type = $object->lines[$i]->type_fees_code;

					// 	//on compte le nombre de ligne afin de verifier la place disponible (largeur de ligne 52 caracteres)
					// 	$nbLineCommentNeed = dol_nboflines_bis($follow_comment,52,$outputlangs->charset_output);
					// 	$nbLineTypeNeed = dol_nboflines_bis($follow_type,4,$outputlangs->charset_output);

					//     $nblineFollowComment = max($nbLineCommentNeed, $nbLineTypeNeed);
					// }

					//$nexY+=$nblineFollowComment*($pdf->getFontSize()*1.3);    // Add space between lines
					$nexY += ($pdf->getFontSize() * 1.3); // Add space between lines

					// Detect if some page were added automatically and output _tableau for past pages
					while ($pagenb < $pageposafter) {
						$pdf->setPage($pagenb);
						$pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.
						if ($pagenb == 1) {
							$this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforfooter, 0, $outputlangs, 0, 1);
						} else {
							$this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforfooter, 0, $outputlangs, 0, 1); // amount in CAN Dollars currency
						}
						$this->_pagefoot($pdf, $object, $outputlangs, 1);
						$pagenb++;
						$pdf->setPage($pagenb);
						$pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.
						if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
							$this->_pagehead($pdf, $object, 0, $outputlangs);
						}
						if (!empty($tplidx)) {
							$pdf->useTemplate($tplidx);
						}
					}
					if (isset($object->lines[$i + 1]->pagebreak) && $object->lines[$i + 1]->pagebreak) {
						if ($pagenb == 1) {
							$this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforfooter, 0, $outputlangs, 0, 1);
						} else {
							$this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforfooter, 0, $outputlangs, 0, 1); // amount in CAN Dollars currency
						}
						$this->_pagefoot($pdf, $object, $outputlangs, 1);
						// New page
						$pdf->AddPage();
						if (!empty($tplidx)) {
							$pdf->useTemplate($tplidx);
						}
						$pagenb++;
						if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
							$this->_pagehead($pdf, $object, 0, $outputlangs);
						}
					}
				}

				// Show square
				if ($pagenb == 1) {
					$this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforinfotot - $heightforfreetext - $heightforfooter, 0, $outputlangs, 0, 0);
					$bottomlasttab = $this->page_hauteur - $heightforinfotot - $heightforfreetext - $heightforfooter + 1;
				} else {
					$this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforinfotot - $heightforfreetext - $heightforfooter, 0, $outputlangs, 0, 0);
					$bottomlasttab = $this->page_hauteur - $heightforinfotot - $heightforfreetext - $heightforfooter + 1;
				}

				$pdf->SetFont('', '', 10);

				// Show total area box
				$posy = $bottomlasttab + 5;
				$posy_start_of_totals = $posy;
				$pdf->SetXY(130, $posy);
				$pdf->MultiCell(76, 5, $outputlangs->transnoentities("TotalHT"), 1, 'L');
				$pdf->SetXY(180, $posy);
				$pdf->MultiCell($this->page_largeur - $this->marge_gauche - 180, 5, price($object->total_ht), 1, 'R');
				$pdf->SetFillColor(248, 248, 248);

				if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
					// TODO Show vat amout per tax level
					$posy += 5;
					$pdf->SetXY(130, $posy);
					$pdf->SetTextColor(0, 0, 60);
					$pdf->MultiCell(76, 5, $outputlangs->transnoentities("TotalVAT"), 1, 'L');
					$pdf->SetXY(180, $posy);
					$pdf->MultiCell($this->page_largeur - $this->marge_gauche - 180, 5, price($object->total_tva), 1, 'R');
				}

				$posy += 5;
				$pdf->SetXY(130, $posy);
				$pdf->SetFont('', 'B', 10);
				$pdf->SetTextColor(0, 0, 60);
				$pdf->MultiCell(76, 5, $outputlangs->transnoentities("TotalTTC"), 1, 'L');
				$pdf->SetXY(180, $posy);
				$pdf->MultiCell($this->page_largeur - $this->marge_gauche - 180, 5, price($object->total_ttc), 1, 'R');

				// show payments zone
				$sumPayments = $object->getSumPayments();
				if ($sumPayments > 0 && !getDolGlobalString('PDF_EXPENSEREPORT_NO_PAYMENT_DETAILS')) {
					$posy = $this->tablePayments($pdf, $object, $posy_start_of_totals, $outputlangs);
				}

				// Page footer
				$this->_pagefoot($pdf, $object, $outputlangs);
				
				if (method_exists($pdf, 'AliasNbPages')) {
					$pdf->AliasNbPages();
				}
				$pdf->MultiCell(0, 3, 'Internal Form: VAGA/013/01.01.2023',0,'L'); // Set interline to 3
				$pdf->Close();

				$pdf->Output($file, 'F');

				// Add pdfgeneration hook
				$hookmanager->initHooks(array('pdfgeneration'));
				$parameters = array('file'=>$file, 'object'=>$object, 'outputlangs'=>$outputlangs);
				global $action;
				$reshook = $hookmanager->executeHooks('afterPDFCreation', $parameters, $this, $action); // Note that $action and $object may have been modified by some hooks
				if ($reshook < 0) {
					$this->error = $hookmanager->error;
					$this->errors = $hookmanager->errors;
				}

				dolChmod($file);

				$this->result = array('fullpath'=>$file);

				return 1; // No error
			} else {
				$this->error = $langs->trans("ErrorCanNotCreateDir", $dir);
				return 0;
			}
		} else {
			$this->error = $langs->trans("ErrorConstantNotDefined", "EXPENSEREPORT_OUTPUTDIR");
			return 0;
		}
	}

	/**
	 * @param   TCPDF       	$pdf                Object PDF
	 * @param   ExpenseReport	$object             Object to show
	 * @param   int         	$linenumber         line number
	 * @param   int         	$curY               current y position
	 * @param   int         	$default_font_size  default siez of font
	 * @param   Translate   	$outputlangs        Object lang for output
	 * @param	int				$hidedetails		Hide details (0=no, 1=yes, 2=just special lines)
	 * @return  void
	 */
	protected function printLine(&$pdf, $object, $linenumber, $curY, $default_font_size, $outputlangs, $hidedetails = 0)
	{
		global $conf;
		$pdf->SetFont('', '', $default_font_size - 1);
		$pdf->SetTextColor(0, 0, 0);


		//posxpiece 	= $this->marge_gauche + 1;
		//posxcomment 	= $this->marge_gauche + 10;
		//posxqty 		= 90;   // Quantity
		//posxup 		= 105;  // Unit Price
		//postotalht 	= 120;  // Excl Tax
		//posxtva 		= 145;  // Adjusted for new column GST %
		//posxgstvalue  = 160;  // Adjusted for new column GST VALUE
		//postotalttc 	= 185;  // Including Tax
		
		
		//1.  Accountancy piece // SERIAL NUMBER | VSN
		$pdf->SetXY($this->posxpiece, $curY);
		$pdf->writeHTMLCell($this->posxcomment - $this->posxpiece - 0.8, 4, $this->posxpiece - 1, $curY, $linenumber + 1, 0, 1);

		// Date
		//$pdf->SetXY($this->posxdate -1, $curY);
		//$pdf->MultiCell($this->posxtype-$this->posxdate-0.8, 4, dol_print_date($object->lines[$linenumber]->date,"day",false,$outputlangs), 0, 'C');

		// Type
		$pdf->SetXY($this->posxtype - 1, $curY);
		$nextColumnPosX = $this->posxup;
		if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
			$nextColumnPosX = $this->posxtva;
		}
		if (isModEnabled('project')) {
			$nextColumnPosX = $this->posxprojet;
		}

		$expensereporttypecode = $object->lines[$linenumber]->type_fees_code;
		$expensereporttypecodetoshow = ($outputlangs->trans(($expensereporttypecode)) == $expensereporttypecode ? $object->lines[$linenumber]->type_fees_libelle : $outputlangs->trans($expensereporttypecode));

		if ($expensereporttypecodetoshow == $expensereporttypecode) {
			$expensereporttypecodetoshow = preg_replace('/^(EX_|TF_)/', '', $expensereporttypecodetoshow);
		}
		//$expensereporttypecodetoshow = dol_trunc($expensereporttypecodetoshow, 9);
		//$pdf->MultiCell($nextColumnPosX-$this->posxtype-0.8, 4, $expensereporttypecodetoshow, 0, 'C');

		// Project
		//if (isModEnabled('project'))
		//{
		//    $pdf->SetFont('','', $default_font_size - 1);
		//    $pdf->SetXY($this->posxprojet, $curY);
		//    $pdf->MultiCell($this->posxtva-$this->posxprojet-0.8, 4, $object->lines[$linenumber]->projet_ref, 0, 'C');
		//}

		// 3 Quantity
		$pdf->SetXY($this->posxqty, $curY);
		$pdf->MultiCell($this->posxup - $this->posxqty - 0.8, 4, $object->lines[$linenumber]->qty, 0, 'C');

		// 4. Unit price
		$pdf->SetXY($this->posxup, $curY);
		//$pdf->MultiCell($this->posxtva - $this->posxup - 0.8, 4, price($object->lines[$linenumber]->value_unit), 0, 'R');
		//$pdf->MultiCell($this->posxtva - $this->posxup - 0.8, 4, price($object->lines[$linenumber]->value_unit), 0, 'R');
		// Assuming $object->lines[$linenumber]->value_unit represents the total unit price including tax
		// And $object->lines[$linenumber]->vat_rate represents the tax rate for the item
		$totalamt_excl_tax = price($object->lines[$linenumber]->total_ht); //11.3
		$totalamt_incl_tax = price($object->lines[$linenumber]->total_ttc); //11.3
		$qty = $object->lines[$linenumber]->qty;
		
		// Calculate net unit price by subtracting tax from total unit price
		$net_unit_price = number_format($totalamt_excl_tax / $qty,2) ;
		//$pdf->MultiCell($this->posxtva - $this->posxup - 0.8, 4, price($object->lines[$linenumber]->net_unit_price), 0, 'R');s		
		$pdf->MultiCell($this->postotalht - $this->posxup - 0.8, 4, $net_unit_price, 0, 'R');

		//5. Without Tax
		$pdf->SetXY($this->postotalht, $curY);
		$pdf->MultiCell($this->posxtva - $this->postotalht - 0.8, 4, price($object->lines[$linenumber]->total_ht), 0, 'R');
	
		//6. GST Rate %
		if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
			$vat_rate = pdf_getlinevatrate($object, $linenumber, $outputlangs, $hidedetails);
			$pdf->SetXY($this->posxtva, $curY);
			$pdf->MultiCell($this->posxgstvalue - $this->posxtva - 0.8, 4, $vat_rate, 0, 'R');
		}
		
		//7. GST Value
		if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
			$vat_rate = pdf_getlinevatrate($object, $linenumber, $outputlangs, $hidedetails);
			$pdf->SetXY($this->posxgstvalue, $curY);
			//$pdf->MultiCell($this->postotalttc - $this->posxgstvalue - 0.8, 4, ($vat_rate * price($object->lines[$linenumber]->value_unit)/100) , 0, 'R');
			$price_with_vat =  $totalamt_incl_tax - $totalamt_excl_tax;
		    $formatted_price_with_vat = number_format($price_with_vat, 2);
			$pdf->MultiCell($this->postotalttc - $this->posxgstvalue - 0.8, 4, $formatted_price_with_vat, 0, 'R');
		}
		
		// Total without taxes
		// $pdf->SetXY($this->postotalht, $curY);
		// $pdf->MultiCell($this->postotalttc - $this->postotalht - 0.8, 4, price($object->lines[$linenumber]->total_ht), 0, 'R');

		// 8. Total with all taxes
		$pdf->SetXY($this->postotalttc - 1, $curY);
		//$pdf->MultiCell($this->page_largeur - $this->marge_droite - $this->postotalttc + 1, 4, price($object->lines[$linenumber]->total_ttc), 0, 'R');
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $this->postotalttc + 1, 4, price($object->lines[$linenumber]->total_ttc), 0, 'R');

		// 2. Comments
		$pdf->SetXY($this->posxcomment, $curY);
		$comment = $outputlangs->trans("Date").':'.dol_print_date($object->lines[$linenumber]->date , "day", false, $outputlangs).' ';
		$comment .= '<br>' .$outputlangs->trans("Type").':'.$expensereporttypecodetoshow.'<br>';
		if (!empty($object->lines[$linenumber]->projet_ref)) {
			$comment .= $outputlangs->trans("Project").':'.$object->lines[$linenumber]->projet_ref.'<br>';
		}
		
		$comment .= $object->lines[$linenumber]->comments;	
		$pdf->writeHTMLCell($this->posxqty - $this->posxcomment - 0.8, 4, $this->posxcomment - 1, $curY, $comment, 0, 1);		
		
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
	/**
	 *  Show top header of page.
	 *
	 *  @param	TCPDF			$pdf     		Object PDF
	 *  @param  ExpenseReport	$object     	Object to show
	 *  @param  int	    		$showaddress    0=no, 1=yes
	 *  @param  Translate		$outputlangs	Object lang for output
	 *  @return	void
	 */
	protected function _pagehead(&$pdf, $object, $showaddress, $outputlangs)
	{
		// global $conf, $langs, $hookmanager;
		global $user, $langs, $conf, $mysoc, $db, $hookmanager;

		// Load traductions files required by page
		$outputlangs->loadLangs(array("main", "trips", "companies"));

		$default_font_size = pdf_getPDFFontSize($outputlangs);

		/*
		// ajout du fondu vert en bas de page à droite
		$image_fondue = $conf->mycompany->dir_output.'/fondu_vert_.jpg';
		$pdf->Image($image_fondue,20,107,200,190);

		pdf_pagehead($pdf,$outputlangs,$this->page_hauteur);
		*/

		// Draft watermark
		if ($object->fk_statut == 0 && getDolGlobalString('EXPENSEREPORT_DRAFT_WATERMARK')) {
			pdf_watermark($pdf, $outputlangs, $this->page_hauteur, $this->page_largeur, 'mm', $conf->global->EXPENSEREPORT_DRAFT_WATERMARK);
		}

		$pdf->SetTextColor(0, 0, 60);
		$pdf->SetFont('', 'B', $default_font_size + 3);

		$posy = $this->marge_haute;
		$posx = $this->page_largeur - $this->marge_droite - 100;

		$pdf->SetXY($this->marge_gauche, $posy);

		// Logo
		$logo = $conf->mycompany->dir_output.'/logos/'.$this->emetteur->logo;
		if ($this->emetteur->logo) {
			if (is_readable($logo)) {
				$height = pdf_getHeightForLogo($logo);
				$pdf->Image($logo, $this->marge_gauche, $posy, 0, $height); // width=0 (auto)
			} else {
				$pdf->SetTextColor(200, 0, 0);
				$pdf->SetFont('', 'B', $default_font_size - 2);
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorLogoFileNotFound", $logo), 0, 'L');
				$pdf->MultiCell(100, 3, $outputlangs->transnoentities("ErrorGoToGlobalSetup"), 0, 'L');
			}
		} else {
			$text = $this->emetteur->name;
			$pdf->MultiCell(100, 4, $outputlangs->convToOutputCharset($text), 0, 'L');
		}

		$pdf->SetFont('', 'B', $default_font_size + 4);
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 6, $langs->trans("ExpenseReport"), 0, 'R');

		$pdf->SetFont('', '', $default_font_size - 1);

		// Ref complete
		$posy += 8;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		//$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 3, $outputlangs->transnoentities("Ref")." : ".$object->ref, '', 'R');
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 3, "Claim # : ".$object->ref, '', 'R');

		// Date start period
		$posy += 5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 3, $outputlangs->transnoentities("DateStart")." : ".($object->date_debut > 0 ? dol_print_date($object->date_debut, "day", false, $outputlangs) : ''), '', 'R');

		// Date end period
		$posy += 5;
		$pdf->SetXY($posx, $posy);
		$pdf->SetTextColor(0, 0, 60);
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 3, $outputlangs->transnoentities("DateEnd")." : ".($object->date_fin > 0 ? dol_print_date($object->date_fin, "day", false, $outputlangs) : ''), '', 'R');

		// Status Expense Report
		$posy += 6;
		$pdf->SetXY($posx, $posy);
		$pdf->SetFont('', 'B', $default_font_size + 2);
		$pdf->SetTextColor(111, 81, 124);
		$pdf->MultiCell($this->page_largeur - $this->marge_droite - $posx, 3, $outputlangs->transnoentities($object->labelStatusShort[$object->status]), '', 'R');

		if ($showaddress) {
			// Sender properties
			$carac_emetteur = '';
			$carac_emetteur .= ($carac_emetteur ? "\n" : '').$outputlangs->convToOutputCharset($this->emetteur->address);
			$carac_emetteur .= ($carac_emetteur ? "\n" : '').$outputlangs->convToOutputCharset($this->emetteur->zip).' '.$outputlangs->convToOutputCharset($this->emetteur->town);
			$carac_emetteur .= "\n";
			if ($this->emetteur->phone) {
				$carac_emetteur .= ($carac_emetteur ? "\n" : '').$outputlangs->transnoentities("Phone")." : ".$outputlangs->convToOutputCharset($this->emetteur->phone);
			}
			if ($this->emetteur->fax) {
				$carac_emetteur .= ($carac_emetteur ? ($this->emetteur->tel ? " - " : "\n") : '').$outputlangs->transnoentities("Fax")." : ".$outputlangs->convToOutputCharset($this->emetteur->fax);
			}
			if ($this->emetteur->email) {
				$carac_emetteur .= ($carac_emetteur ? "\n" : '').$outputlangs->transnoentities("Email")." : ".$outputlangs->convToOutputCharset($this->emetteur->email);
			}
			if ($this->emetteur->url) {
				$carac_emetteur .= ($carac_emetteur ? "\n" : '').$outputlangs->transnoentities("Web")." : ".$outputlangs->convToOutputCharset($this->emetteur->url);
			}

			// Receiver Properties
			$receiver = new User($this->db);
			$receiver->fetch($object->fk_user_author);
			$receiver_account = new UserBankAccount($this->db);
			$receiver_account->fetch(0, '', $object->fk_user_author);
			$expense_receiver = '';
			$expense_receiver .= ($expense_receiver ? "\n" : '').$outputlangs->convToOutputCharset($receiver->address);
			$expense_receiver .= ($expense_receiver ? "\n" : '').$outputlangs->convToOutputCharset($receiver->zip).' '.$outputlangs->convToOutputCharset($receiver->town);
			$expense_receiver .= "\n";
			
			if ($receiver->email) {
				$expense_receiver .= ($expense_receiver ? "\n" : '').$outputlangs->transnoentities("Email")." : ".$outputlangs->convToOutputCharset($receiver->email);
			}
			if ($receiver_account->iban) {
				$expense_receiver .= ($expense_receiver ? "\n" : '').$outputlangs->transnoentities("IBAN")." : ".$outputlangs->convToOutputCharset($receiver_account->iban);
			}

			// Show sender
			$posy = 50;
			$posx = $this->marge_gauche;
			$hautcadre = 40;
			if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
				$posx = 118;
			}

			// Show sender frame
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('', 'B', $default_font_size - 2);
			$pdf->SetXY($posx, $posy - 5);
			//$pdf->MultiCell(80, 5, $outputlangs->transnoentities("TripSociete"), '', 'L');
			$pdf->MultiCell(80, 5, "Claim Location:", '', 'L');
			$pdf->SetXY($posx, $posy);
			$pdf->SetFillColor(224, 224, 224);
			$pdf->MultiCell(82, $hautcadre, "", 0, 'R', 1);
			$pdf->SetTextColor(0, 0, 60);

			// Show sender information
			if (!getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
				$pdf->SetXY($posx + 2, $posy + 3);
				$pdf->SetFont('', 'B', $default_font_size);
				$pdf->MultiCell(80, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, 'L');
				$pdf->SetXY($posx + 2, $posy + 8);
				$pdf->SetFont('', '', $default_font_size - 1);
				$pdf->MultiCell(80, 4, $carac_emetteur, 0, 'L');
			} else {
				$pdf->SetXY($posx + 2, $posy + 3);
				$pdf->SetFont('', 'B', $default_font_size);
				$pdf->MultiCell(80, 4, $outputlangs->convToOutputCharset(dolGetFirstLastname($receiver->firstname, $receiver->lastname)), 0, 'L');
				$pdf->SetXY($posx + 2, $posy + 8);
				$pdf->SetFont('', '', $default_font_size - 1);
				$pdf->MultiCell(80, 4, $expense_receiver, 0, 'L');
			}

			// Show recipient
			$posy = 50;
			$posx = 100;
			if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
				$posx = $this->marge_gauche;
			}

			// Show recipient frame
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('', 'B', 8);
			$pdf->SetXY($posx, $posy - 5);
			//$pdf->MultiCell(80, 5, $outputlangs->transnoentities("TripNDF")." :", 0, 'L');  //INFORMATION EXPENSE REPORT heading
			$pdf->MultiCell(80, 5, "Claimer Information:", 0, 'L');  //INFORMATION EXPENSE REPORT heading
			$pdf->rect($posx, $posy, $this->page_largeur - $this->marge_gauche - $posx, $hautcadre);

			// Informations for expense report (dates and users workflow)
			if ($object->fk_user_author > 0) {
				
				// ----------------------------------------------------------------
						$posy += 3;
						$pdf->SetXY($posx + 2, $posy);
						$pdf->SetFont('', '', 10);

						$usr = new User($this->db);
						$user_rowid_sql = "SELECT rowid FROM vg_user where login = '".$user->login ."'";  
						// Adjust if needed to filter for a specific user
						$user_rowid_result = $db->query($user_rowid_sql);
						$user_rowid_row = $db->fetch_array($user_rowid_result);
						$fk_object = $user_rowid_row['rowid'];  // Extract the rowid value
						$sql = "SELECT vaga_department, vaga_division, vaga_band FROM vg_user_extrafields WHERE fk_object = " .$fk_object; //$object->id;
						$result = $db->query($sql);
						$row = $db->fetch_array($result);
						//print_r($row);
						$department = $row['vaga_department'];
						$division = $row['vaga_division'];
						$band = $row['vaga_band'];
						//echo $department  .$division .$band;
						
						$extrafieldstoshow = str_replace(["<br>"], ', ', $extranote);				

						//$pdf->writeHTMLCell(190, 3, $this->posxpiece - 1, $tab_top, "<b>Emp.Code:</b> " .$user->login .", <b>Dept:</b> " .$department  .", <b>Division:</b> " .$division .", <b>Band:</b> " .$band, 0, 1);
						$empdetails = "<b>Emp.Code:</b> " .$user->login .", <b>Dept:</b> " .$department  .", <b>Division:</b> " .$division .", <b>Band:</b> " .$band;
						$pdf->writeHTMLCell(102, 4, $posx+2, $posy, "<b>Emp.Code:</b> " .$user->login .", <b>Dept:</b> " .$department  .", <br><b>Division:</b> " .$division .", <b>Band:</b> " .$band, 0, 1);						
				
				// ----------------------------------------------------------------
				
				$userfee = new User($this->db);
				$userfee->fetch($object->fk_user_author);
				$posy += 11;
				$pdf->SetXY($posx + 2, $posy);
				$pdf->SetFont('', '', 10);
				$pdf->MultiCell(96, 4, $outputlangs->transnoentities("AUTHOR")." : ".dolGetFirstLastname($userfee->firstname, $userfee->lastname), 0, 'L');
				$posy = $pdf->GetY() + 1;
				$pdf->SetXY($posx + 2, $posy);
				$pdf->MultiCell(96, 4, $outputlangs->transnoentities("DateCreation")." : ".dol_print_date($object->date_create, "day", false, $outputlangs), 0, 'L');
			}

			if ($object->fk_statut == 99) {
				if ($object->fk_user_refuse > 0) {
					$userfee = new User($this->db);
					$userfee->fetch($object->fk_user_refuse);
					$posy += 6;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("REFUSEUR")." : ".dolGetFirstLastname($userfee->firstname, $userfee->lastname), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("MOTIF_REFUS")." : ".$outputlangs->convToOutputCharset($object->detail_refuse), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("DATE_REFUS")." : ".dol_print_date($object->date_refuse, "day", false, $outputlangs), 0, 'L');
				}
			} elseif ($object->fk_statut == 4) {
				if ($object->fk_user_cancel > 0) {
					$userfee = new User($this->db);
					$userfee->fetch($object->fk_user_cancel);
					$posy += 6;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("CANCEL_USER")." : ".dolGetFirstLastname($userfee->firstname, $userfee->lastname), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("MOTIF_CANCEL")." : ".$outputlangs->convToOutputCharset($object->detail_cancel), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("DATE_CANCEL")." : ".dol_print_date($object->date_cancel, "day", false, $outputlangs), 0, 'L');
				}
			} else {
				if ($object->fk_user_approve > 0) {
					$userfee = new User($this->db);
					$userfee->fetch($object->fk_user_approve);
					$posy += 6;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("VALIDOR")." : ".dolGetFirstLastname($userfee->firstname, $userfee->lastname), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("DateApprove")." : ".dol_print_date($object->date_approve, "day", false, $outputlangs), 0, 'L');
				}
			}

			if ($object->fk_statut == 6) {
				if ($object->fk_user_paid > 0) {
					$userfee = new User($this->db);
					$userfee->fetch($object->fk_user_paid);
					$posy += 6;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("AUTHORPAIEMENT")." : ".dolGetFirstLastname($userfee->firstname, $userfee->lastname), 0, 'L');
					$posy += 5;
					$pdf->SetXY($posx + 2, $posy);
					$pdf->MultiCell(96, 4, $outputlangs->transnoentities("DATE_PAIEMENT")." : ".dol_print_date($object->date_paiement, "day", false, $outputlangs), 0, 'L');
				}
			}
		}
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
	/**
	 *   Show table for lines
	 *
	 *   @param     TCPDF		$pdf     		Object PDF
	 *   @param		int			$tab_top		Tab top
	 *   @param		int			$tab_height		Tab height
	 *   @param		int			$nexY			next y
	 *   @param		Translate	$outputlangs	Output langs
	 *   @param		int			$hidetop		1=Hide top bar of array and title, 0=Hide nothing, -1=Hide only title
	 *   @param		int			$hidebottom		Hide bottom bar of array
	 *   @param		string		$currency		Currency code
	 *   @return	void
	 */
	protected function _tableau(&$pdf, $tab_top, $tab_height, $nexY, $outputlangs, $hidetop = 0, $hidebottom = 0, $currency = '')
	{
		global $conf;

		// Force to disable hidetop and hidebottom
		$hidebottom = 0;
		if ($hidetop) {
			$hidetop = -1;
		}

		$currency = !empty($currency) ? $currency : $conf->currency;
		$default_font_size = pdf_getPDFFontSize($outputlangs);

		// Amount in (at tab_top - 1)
		$pdf->SetTextColor(0, 0, 0);
		
		$titre = $outputlangs->transnoentities("AmountInCurrency", $outputlangs->transnoentitiesnoconv("Currency".$currency));
		$pdf->SetXY($this->page_largeur - $this->marge_droite - ($pdf->GetStringWidth($titre) + 4), $tab_top - 4);
		$pdf->MultiCell(($pdf->GetStringWidth($titre) + 3), 2, $titre);

		$pdf->SetDrawColor(128, 128, 128);

		// Rect takes a length in 3rd parameter
		$pdf->Rect($this->marge_gauche, $tab_top, $this->page_largeur - $this->marge_gauche - $this->marge_droite, $tab_height);
		// line prend une position y en 3eme param
		if (empty($hidetop)) {
			$pdf->line($this->marge_gauche, $tab_top + 5, $this->page_largeur - $this->marge_droite, $tab_top + 5);
		}

		$pdf->SetFont('', 'B', 8);
		//--------------------------------------------------------------------------------------------
		// TABLE HEADING STARTS HERE 
		// 1. Accountancy piece  Serial number  heading
		if (empty($hidetop)) {
			$pdf->SetXY($this->posxpiece - 1, $tab_top + 1);
			$pdf->MultiCell($this->posxcomment - $this->posxpiece - 0.8, 1, 'SL#', '', 'R');  //VSN
		}

		// 2. Comments DESCRIPTION
		$pdf->line($this->posxcomment - 1, $tab_top, $this->posxcomment - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->posxcomment - 1, $tab_top + 1);
			$pdf->MultiCell($this->posxqty - $this->posxcomment - 0.8, 1, $outputlangs->transnoentities("Description"), '', 'L');
		}
		
		// 3. Quantity
		$pdf->line($this->posxqty - 1, $tab_top, $this->posxqty - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->posxqty - 0.8, $tab_top + 1);
			$pdf->MultiCell($this->posxup - $this->posxqty - 1, 2, $outputlangs->transnoentities("Qty"), '', 'C');
		}

		// 4. Unit Price
		$pdf->line($this->posxup - 1, $tab_top, $this->posxup - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->posxup - 0.8, $tab_top + 1);			
			$pdf->MultiCell($this->postotalht - $this->posxup + 1, 2, $outputlangs->transnoentities("Unit Price"), '', 'C');
		}
       
		// 5. Total without taxes
		$pdf->line($this->postotalht - 1, $tab_top, $this->postotalht - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->postotalht - 0.8, $tab_top + 1);
			$pdf->MultiCell($this->posxtva - $this->postotalht	 + 1, 2, $outputlangs->transnoentities("TotalHT"), '', 'C');
		}

		// 6. GST %
		if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
			$pdf->line($this->posxtva - 1, $tab_top, $this->posxtva - 1, $tab_top + $tab_height);
			if (empty($hidetop)) {
				$pdf->SetXY($this->posxtva - 0.8, $tab_top + 1);
				$pdf->MultiCell($this->posxgstvalue - $this->posxtva - 1, 2, $outputlangs->transnoentities("VAT"), '', 'C');
			}
		}
			  
		// 7. GST Value
		$pdf->line($this->posxgstvalue - 1, $tab_top, $this->posxgstvalue - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->posxgstvalue - 0.8, $tab_top + 1);
			//$pdf->MultiCell($this->postotalttc - $this->posxup - 1, 2, $outputlangs->transnoentities("PriceUTTC"), '', 'C');
			$pdf->MultiCell($this->postotalttc - $this->posxgstvalue - 1, 2, "GST Value", '', 'C');
		}
			  
		// 8. Total with all taxes
		$pdf->line($this->postotalttc - 1, $tab_top, $this->postotalttc - 1, $tab_top + $tab_height);
		if (empty($hidetop)) {
			$pdf->SetXY($this->postotalttc - 0.8, $tab_top + 1);
			//$pdf->MultiCell($this->postotalttc - $this->posxup - 1, 2, $outputlangs->transnoentities("PriceUTTC"), '', 'C');
			//$pdf->MultiCell($this->postotalttc - $this->posxup - 1, 2, "Total (Inc. Tax)", '', 'C');
			$pdf->MultiCell($this->page_largeur - $this->marge_droite - $this->postotalttc + 1, 2, $outputlangs->transnoentities("TotalTTC"), '', 'R');
		}
			

				//			// Total without taxes
				//			$pdf->line($this->postotalht - 1, $tab_top, $this->postotalht - 1, $tab_top + $tab_height);
				//			if (empty($hidetop)) {
				//				$pdf->SetXY($this->postotalht - 0.8, $tab_top + 1);
				//				$pdf->MultiCell($this->postotalttc - $this->postotalht + 1, 2, $outputlangs->transnoentities("TotalHT"), '', 'C');
				//			}
				//			
				//			// Total with all taxes
				//			$pdf->line($this->postotalttc, $tab_top, $this->postotalttc, $tab_top + $tab_height);
				//			if (empty($hidetop)) {
				//				$pdf->SetXY($this->postotalttc - 0.8, $tab_top + 1);
				//				$pdf->MultiCell($this->page_largeur - $this->marge_droite - $this->postotalttc + 1, 2, $outputlangs->transnoentities("TotalTTC"), '', 'R');
				//			}
		$pdf->SetFont('', '', 8);
		$pdf->SetTextColor(0, 0, 0);
	}

	/**
	 *  Show payments table
	 *
	 *  @param	TCPDF			$pdf            Object PDF
	 *  @param  ExpenseReport	$object         Object expensereport
	 *  @param  int				$posy           Position y in PDF
	 *  @param  Translate		$outputlangs    Object langs for output
	 *  @return int             				Return integer <0 if KO, >0 if OK
	 */
	protected function tablePayments(&$pdf, $object, $posy, $outputlangs)
	{
		global $conf;

		$sign = 1;
		$tab3_posx = $this->marge_gauche;
		$tab3_top = $posy;
		$tab3_width = 88;
		$tab3_height = 5;

		$default_font_size = pdf_getPDFFontSize($outputlangs);
		$pdf->SetFont('', '', $default_font_size - 2); //VSN
		$title = $outputlangs->transnoentities("PaymentsAlreadyDone");
		
		$pdf->SetXY($tab3_posx, $tab3_top - 4);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(60, 3, $title, 0, 'L', 0);

		$pdf->line($tab3_posx, $tab3_top, $tab3_posx + $tab3_width + 2, $tab3_top); // Top border line of table title
		$pdf->SetFont('', 'B', $default_font_size - 2); //VSN
		$pdf->SetXY($tab3_posx, $tab3_top + 1);
		$pdf->MultiCell(20, 3, $outputlangs->transnoentities("Date"), 0, 'L', 0);
		$pdf->SetXY($tab3_posx + 19, $tab3_top + 1); // Old value 17
		$pdf->MultiCell(15, 3, $outputlangs->transnoentities("Amount"), 0, 'C', 0);
		$pdf->SetXY($tab3_posx + 35, $tab3_top + 1);
		$pdf->MultiCell(30, 3, $outputlangs->transnoentities("Type") .$outputlangs->transnoentities("/Check #"), 0, 'L', 0);
		
		
		//print_r($outputlangs);
		
		//$pdf->MultiCell(30, 3, $outputlangs->transnoentities("ChequeNumber"), 0, 'L', 0);
		if (isModEnabled("banque")) {
			$pdf->SetXY($tab3_posx + 65, $tab3_top + 1);
			$pdf->MultiCell(25, 3, $outputlangs->transnoentities("BankAccount"), 0, 'L', 0);
		}
		
		$pdf->SetFont('', '', $default_font_size - 2); //VSN
		$pdf->line($tab3_posx, $tab3_top + $tab3_height, $tab3_posx + $tab3_width + 2, $tab3_top + $tab3_height); // Bottom border line of table title

		$y = 0;

		// Loop on each payment
		// TODO create method on expensereport class to get payments
		// Payments already done (from payment on this expensereport)
		$sql = "SELECT p.rowid, p.num_payment, p.datep as dp, p.amount, p.fk_bank,";
		$sql .= "c.code as p_code, c.libelle as payment_type,";
		$sql .= "ba.rowid as baid, ba.ref as baref, ba.label, ba.number as banumber, ba.account_number, ba.fk_accountancy_journal";
		$sql .= " FROM ".MAIN_DB_PREFIX."expensereport as e, ".MAIN_DB_PREFIX."payment_expensereport as p";
		$sql .= " LEFT JOIN ".MAIN_DB_PREFIX."c_paiement as c ON p.fk_typepayment = c.id";
		$sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'bank as b ON p.fk_bank = b.rowid';
		$sql .= ' LEFT JOIN '.MAIN_DB_PREFIX.'bank_account as ba ON b.fk_account = ba.rowid';
		$sql .= " WHERE e.rowid = ".((int) $object->id);
		$sql .= " AND p.fk_expensereport = e.rowid";
		$sql .= ' AND e.entity IN ('.getEntity('expensereport').')';
		$sql .= " ORDER BY dp";

		$resql = $this->db->query($sql);
		if ($resql) {
			$num = $this->db->num_rows($resql);
			$totalpaid = 0;
			$i = 0;
			while ($i < $num) {
				$y += $tab3_height;
				$row = $this->db->fetch_object($resql);
				$pdf->SetXY($tab3_posx, $tab3_top + $y + 1);
				$pdf->MultiCell(20, 3, dol_print_date($this->db->jdate($row->dp), 'day', false, $outputlangs, true), 0, 'L', 0);
				$pdf->SetXY($tab3_posx + 17, $tab3_top + $y + 1);
				$pdf->MultiCell(15, 3, price($sign * $row->amount, 0, $outputlangs), 0, 'R', 0);
				$pdf->SetXY($tab3_posx + 35, $tab3_top + $y + 1);
				$oper = $outputlangs->transnoentitiesnoconv("PaymentTypeShort".$row->p_code);
				$chkno = $row->num_payment;

				$pdf->MultiCell(40, 3, $oper ." (" .$chkno .")", 0, 'L', 0); //VSN
				if (isModEnabled("banque")) {
					$pdf->SetXY($tab3_posx + 65, $tab3_top + $y + 1);
					$pdf->MultiCell(30, 3, $row->baref, 0, 'L', 0);
				}

				$pdf->line($tab3_posx, $tab3_top + $y + $tab3_height, $tab3_posx + $tab3_width + 2, $tab3_top + $y + $tab3_height); // Bottom line border of table
				$totalpaid += $row->amount;
				$i++;
			}
			if ($num > 0 && $object->paid == 0) {		
				$y += $tab3_height;
				$pdf->SetXY($tab3_posx + 17, $tab3_top + $y);
				$pdf->MultiCell(15, 3, price($totalpaid), 0, 'R', 0);
				$pdf->SetXY($tab3_posx + 35, $tab3_top + $y);
				$pdf->MultiCell(30, 4, $outputlangs->transnoentitiesnoconv("AlreadyPaid"), 0, 'L', 0);
				
				$pdf->line($tab3_posx+20, $tab3_top + $y + 4, $tab3_posx + $tab3_width + 2, $tab3_top+ $y + 4); //VSN
				
				$y += $tab3_height - 1;
				$pdf->SetXY($tab3_posx + 17, $tab3_top + $y);
				$pdf->MultiCell(15, 3, price($object->total_ttc), 0, 'R', 0);
				$pdf->SetXY($tab3_posx + 35, $tab3_top + $y);
				$pdf->MultiCell(30, 4, $outputlangs->transnoentitiesnoconv("AmountExpected"), 0, 'L', 0);
				$pdf->line($tab3_posx+20, $tab3_top + $y + 4, $tab3_posx + $tab3_width + 2, $tab3_top+ $y + 4); //VSN
				
				
				$y += $tab3_height - 1;
				$remaintopay = $object->total_ttc - $totalpaid;
				$pdf->SetXY($tab3_posx + 17, $tab3_top + $y);
				$pdf->MultiCell(15, 3, price($remaintopay), 0, 'R', 0);
				$pdf->SetXY($tab3_posx + 35, $tab3_top + $y);
				$pdf->MultiCell(30, 4, $outputlangs->transnoentitiesnoconv("RemainderToPay"), 0, 'L', 0);
				$pdf->line($tab3_posx+20, $tab3_top + $y + 4, $tab3_posx + $tab3_width + 2, $tab3_top+ $y + 4); //VSN
			}
		} else {
			$this->error = $this->db->lasterror();
			return -1;
		}
		return -1;
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
	/**
	 *  Show footer of page. Need this->emetteur object
	 *
	 *  @param  TCPDF			$pdf     			PDF
	 *  @param  ExpenseReport	$object				Object to show
	 *  @param  Translate		$outputlangs		Object lang for output
	 *  @param  int				$hidefreetext		1=Hide free text
	 *  @return int									Return height of bottom margin including footer text
	 */
	protected function _pagefoot(&$pdf, $object, $outputlangs, $hidefreetext = 0)
	{
		$showdetails = getDolGlobalInt('MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS', 0);
		//return pdf_pagefoot($pdf, $outputlangs, 'EXPENSEREPORT_FREE_TEXT', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);
		$footerContent = pdf_pagefoot($pdf, $outputlangs, 'EXPENSEREPORT_FREE_TEXT', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext);

		// Add state information with label
		$footerContent .= $outputlangs->transnoentities('State') . ': ' . $state . "\n";

		return $footerContent;
	}
}

		// unused tablule method code
		
		// Date
		//$pdf->line($this->posxdate-1, $tab_top, $this->posxdate-1, $tab_top + $tab_height);
		//if (empty($hidetop))
		//{
		//	$pdf->SetXY($this->posxdate-1, $tab_top+1);
		//	$pdf->MultiCell($this->posxtype-$this->posxdate-1,2, $outputlangs->transnoentities("Date"),'','C');
		//}

		// Type
		//$pdf->line($this->posxtype-1, $tab_top, $this->posxtype-1, $tab_top + $tab_height);
		//if (empty($hidetop))
		//{
		//	$pdf->SetXY($this->posxtype-1, $tab_top+1);
		//	$pdf->MultiCell($this->posxprojet-$this->posxtype - 1, 2, $outputlangs->transnoentities("Type"), '', 'C');
		//}

		//if (isModEnabled('project'))
		//{
		//    // Project
		//    $pdf->line($this->posxprojet - 1, $tab_top, $this->posxprojet - 1, $tab_top + $tab_height);
		//	if (empty($hidetop)) {
		//        $pdf->SetXY($this->posxprojet - 1, $tab_top + 1);
		//        $pdf->MultiCell($this->posxtva - $this->posxprojet - 1, 2, $outputlangs->transnoentities("Project"), '', 'C');
		//	}
		//}