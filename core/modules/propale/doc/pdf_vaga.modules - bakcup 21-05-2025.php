<?php
/*
Variable Name    Description
$this->page_largeur    Width of the PDF page in user units (usually millimeters).
$this->page_hauteur    Height of the PDF page in user units (usually millimeters).
$this->marge_gauche    Left margin of the PDF page in user units.
$this->marge_droite    Right margin of the PDF page in user units.
$this->marge_haute    Top margin of the PDF page in user units.
$this->marge_basse    Bottom margin of the PDF page in user units.
$this->emetteur    Contains information about the sender (company or entity issuing the document).
$this->recipient    Contains information about the recipient (customer or entity receiving the document).
$this->posxdesc    X position for the description column.
$this->posxtva    X position for the VAT column.
$this->posxup    X position for the unit price column.
$this->posxqty    X position for the quantity column.
$this->posxunit    X position for the unit column.
$this->posxdiscount    X position for the discount column.
$this->posxprogress    X position for the progress column.
$this->postotalht    X position for the total amount excluding tax.
$this->tabTitleHeight    Height of the table title row.
$this->tva    Array containing VAT rates.
$this->tva_array    Array containing detailed VAT information.
$this->localtax1    Array containing local tax 1 information.
$this->localtax2    Array containing local tax 2 information.
$this->atleastoneratenotnull    Indicates if there is at least one VAT rate that is not null.
$this->atleastonediscount    Indicates if there is at least one discount applied.
$this->option_logo    Flag to indicate whether to display the logo.
$this->option_tva    Flag to indicate whether to manage the VAT option.
$this->option_modereg    Flag to indicate whether to display the payment mode.
$this->option_condreg    Flag to indicate whether to display the payment terms.
$this->option_multilang    Flag to indicate whether the document is available in multiple languages.
$this->option_escompte    Flag to indicate whether to display discounts.
$this->option_credit_note    Flag to indicate whether to support credit notes.
$this->option_freetext    Flag to indicate whether to support adding personalized text.
$this->option_draft_watermark    Flag to indicate whether to support adding a watermark on drafts.
$this->watermark    Text of the watermark to be displayed on drafts.


MULTICELL PARAMETERS
--------------------
MultiCell(float $w, float $h, string $txt, [mixed $border], [string $align], [int $fill], [int $ln], [float $x], [float $y], [boolean $reseth], [int $stretch], [boolean $ishtml], [boolean $autopadding], [float $maxh], [string $valign], [boolean $fitcell])


$w (float): The width of the cells. If the text is longer than the cell width, it will wrap to the next line. A value of 0 extends the cell to the right margin.
$h (float): The height of the cells.
$txt (string): The string of text to print. Line breaks can be added using \n.
$border (mixed): Indicates if borders should be drawn around the cell:
0: No border
1: Frame border
A string: A combination of letters specifying which borders to draw (e.g., 'LRTB' for left, right, top, and bottom).
$align (string): The text alignment. Possible values:
L: Left
C: Center
R: Right
J: Justified
$fill (int): Indicates whether the cell background should be painted (1) or not (0).
$ln (int): Indicates where the current position should go after the call:
0: To the right
1: To the beginning of the next line
2: Below
$x (float): X position where the cell starts. If not specified, the current position is used.
$y (float): Y position where the cell starts. If not specified, the current position is used.
$reseth (boolean): Whether to reset the last cell height (true) or not (false).
$stretch (int): Font stretching mode:
0: No stretching
1: Horizontally scaling
2: Spacing
3: Character spacing
4: Word spacing
$ishtml (boolean): Indicates if the text is HTML (true) or plain text (false).
$autopadding (boolean): Indicates if cell padding should be automatically adjusted (true) or not (false).
$maxh (float): Maximum height of the cell. If the text doesn’t fit, it will be truncated.
$valign (string): Vertical alignment. Possible values:
T: Top
M: Middle
B: Bottom
$fitcell (boolean): Indicates if the cell width should be fitted to the text (true) or not (false).
-----------



writeHTMLCell  Parameters Explanation
$w (float): Width of the cell. Use 0 for the remaining page width.
$h (float): Height of the cell. Use 0 for automatic height.
$x (float): X position of the cell from the left margin. Use '' to continue from the current X position.
$y (float): Y position of the cell from the top margin. Use '' to continue from the current Y position.
$html (string): The HTML content to print inside the cell.
$border (mixed): Border style. Use 0 for no border, 1 for a frame, or a combination of LRTB to define specific borders.
$ln (int): Indicates where the current position should go after the call. Possible values are:
0: to the right
1: to the beginning of the next line
2: below
$fill (int): Indicates if the cell background should be filled (1) or transparent (0).
$reseth (boolean): If true, reset the last cell height. Otherwise, the cell height is increased to accommodate the HTML content.
$align (string): Text alignment inside the cell. Possible values are:
'': Left (default)
C: Center
R: Right
J: Justified
$autopadding (boolean): If true, automatically adds padding based on the current padding settings.
-----------------------------------------------------------------------------------------------------------------------------------------
Variable                        Description
$db                            Database handler used for database interactions.
$name                        Name of the PDF model.
$description                Description of the PDF model.
$update_main_doc_field        Flag indicating if the generated file name should be saved as the main document.
$type                        Type of the document, usually set to 'pdf'.
$version                    Version of Dolibarr used.
$cols                        Array containing document table columns.
$page_largeur                Width of the PDF page in user units (usually millimeters).
$page_hauteur                Height of the PDF page in user units (usually millimeters).
$marge_gauche                Left margin of the PDF page in user units.
$marge_droite                Right margin of the PDF page in user units.
$marge_haute                Top margin of the PDF page in user units.
$marge_basse                Bottom margin of the PDF page in user units.
$emetteur                    Contains information about the sender (company or entity issuing the document).
$recipient                    Contains information about the recipient (customer or entity receiving the document).
$posxdesc                    X position for the description column.
$posxtva                    X position for the VAT column.
$posxup                        X position for the unit price column.
$posxqty                    X position for the quantity column.
$posxunit                    X position for the unit column.
$posxdiscount                X position for the discount column.
$posxprogress                X position for the progress column.
$postotalht                    X position for the total amount excluding tax.
$tabTitleHeight                Height of the table title row.
$tva                        Array containing VAT rates.
$tva_array                    Array containing detailed VAT information.
$localtax1                    Array containing local tax 1 information.
$localtax2                    Array containing local tax 2 information.
$atleastoneratenotnull        Indicates if there is at least one VAT rate that is not null.
$atleastonediscount            Indicates if there is at least one discount applied.
$option_logo                Flag to indicate whether to display the logo.
$option_tva                    Flag to indicate whether to manage the VAT option.
$option_modereg                Flag to indicate whether to display the payment mode.
$option_condreg                Flag to indicate whether to display the payment terms.
$option_multilang            Flag to indicate whether the document is available in multiple languages.
$option_escompte            Flag to indicate whether to display discounts.
$option_credit_note            Flag to indicate whether to support credit notes.
$option_freetext            Flag to indicate whether to support adding personalized text.
$option_draft_watermark        Flag to indicate whether to support adding a watermark on drafts.
$watermark                    Text of the watermark to be displayed on drafts.
$pdf                        PDF instance used to generate and manipulate the PDF document.
$nblines                    Number of lines in the proposal or document.
$realpatharray                Array holding real paths of images associated with products.
$tplidx                        Template index used for page template management.
$pagenb                        Current page number in the PDF document.
$heightforinfotot            Height reserved to output the info and total part of the document.
$heightforsignature            Height reserved to output the signature section.
$heightforfreetext            Height reserved to output the free text on the last page.
$heightforfooter            Height reserved to output the footer section.
$top_shift                    Top shift value used to adjust the position of elements on the page.
$tab_top                    Y position for the top of the table.
$tab_top_newpage            Y position for the top of the table on a new page.
$posy                        Current Y position for miscellaneous information sections.
$curY                        Current Y position used during the rendering process.
$nexY                        Next Y position after rendering a line or element.
$pageposbefore                Page number before rendering a certain section, used to detect page breaks.
$pageposafter                Page number after rendering a certain section, used to detect page breaks.
$posYAfterImage                Y position after rendering an image.
$posYAfterDescription        Y position after rendering a description.
$showpricebeforepagebreak    Flag indicating whether to show the price before a page break.
$item_number                Counter for the item numbers in the document.
$extranote                    Stores extra notes or information that may be displayed in the document.
$height_note                Height of a note section used to adjust the document layout.
$bottomlasttab                Y position for the bottom of the last table, used for positioning the next section.
$outputlangs                Language object used for managing translations and output language settings.
$hookmanager                Object used to manage hooks for extending functionality in the PDF generation process.
--------------
 */
/* Copyright (C) 2004-2014 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2008      Raphael Bertrand     <raphael.bertrand@resultic.fr>
 * Copyright (C) 2010-2015 Juanjo Menent        <jmenent@2byte.es>
 * Copyright (C) 2012      Christophe Battarel   <christophe.battarel@altairis.fr>
 * Copyright (C) 2012      Cedric Salvador      <csalvador@gpcsolutions.fr>
 * Copyright (C) 2015      Marcos García        <marcosgdf@gmail.com>
 * Copyright (C) 2017      Ferran Marcet        <fmarcet@2byte.es>
 * Copyright (C) 2018      Frédéric France      <frederic.france@netlogic.fr>
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
 *    \file       htdocs/core/modules/propale/doc/pdf_vaga.modules.php
 *    \ingroup    propale
 *    \brief      File of Class to generate PDF proposal with Cyan template
 */
require_once DOL_DOCUMENT_ROOT . '/core/modules/propale/modules_propale.php';
require_once DOL_DOCUMENT_ROOT . '/product/class/product.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/company.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/functions2.lib.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/pdf.lib.php';
// Include NUMBERWORDS module
require_once DOL_DOCUMENT_ROOT . '/custom/numberwords/core/modules/modNumberWords.class.php';
/**
 *    Class to generate PDF proposal Cyan
 */
class pdf_vaga extends ModelePDFPropales
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
     * @var int    Save the name of generated file as the main doc when generating a doc with this template
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
    /**
     * @var array of document table columns
     */
    public $cols;
    /**
     *    Constructor
     *
     *  @param        DoliDB        $db      Database handler
     */
    public function __construct($db)
    {
        global $langs, $mysoc;
        // Translations
        $langs->loadLangs(array("main", "bills"));
        $this->db = $db;
        $this->name = "vaga";
        $this->description = $langs->trans('DocModelCyanDescription');
        $this->update_main_doc_field = 1; // Save the name of generated file as the main doc when generating a doc with this template
        // Dimension page
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
        $this->watermark = '';
        // Get source company
        $this->emetteur = $mysoc;
        if (empty($this->emetteur->country_code)) {
            $this->emetteur->country_code = substr($langs->defaultlang, -2); // By default, if was not defined
        }
        // Define position of columns
        $this->posxdesc = $this->marge_gauche + 1; // used for notes ans other stuff
        $this->tabTitleHeight = 5; // default height
        //  Use new system for position of columns, view  $this->defineColumnField()
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
     *  @param        Propal        $object                Object to generate
     *  @param        Translate    $outputlangs        Lang output object
     *  @param        string        $srctemplatepath    Full path of source filename for generator using a template file
     *  @param        int            $hidedetails        Do not show line details
     *  @param        int            $hidedesc            Do not show desc
     *  @param        int            $hideref            Do not show ref
     *  @return     int                             1=OK, 0=KO
     */
    public function write_file($object, $outputlangs, $srctemplatepath = '', $hidedetails = 0, $hidedesc = 0, $hideref = 0)
    {
        // phpcs:enable
        global $user, $langs, $conf, $mysoc, $db, $hookmanager, $nblines;

        dol_syslog("write_file outputlangs->defaultlang=" . (is_object($outputlangs) ? $outputlangs->defaultlang : 'null'));
        if (!is_object($outputlangs)) {
            $outputlangs = $langs;
        }
        // For backward compatibility with FPDF, force output charset to ISO, because FPDF expect text to be encoded in ISO
        if (getDolGlobalString('MAIN_USE_FPDF')) {
            $outputlangs->charset_output = 'ISO-8859-1';
        }
        // Load translation files required by page
        $outputlangs->loadLangs(array("main", "dict", "companies", "bills", "products", "propal"));
        //  Show Draft Watermark
        if ($object->statut == $object::STATUS_DRAFT && getDolGlobalString('PROPALE_DRAFT_WATERMARK')) {
            $this->watermark = getDolGlobalString('PROPALE_DRAFT_WATERMARK');
        }
        global $outputlangsbis;
        $outputlangsbis = null;
        if (getDolGlobalString('PDF_USE_ALSO_LANGUAGE_CODE') && $outputlangs->defaultlang != $conf->global->PDF_USE_ALSO_LANGUAGE_CODE) {
            $outputlangsbis = new Translate('', $conf);
            $outputlangsbis->setDefaultLang($conf->global->PDF_USE_ALSO_LANGUAGE_CODE);
            $outputlangsbis->loadLangs(array("main", "dict", "companies", "bills", "products", "propal"));
        }
        $nblines = count($object->lines);
        $hidetop = 0;

        if (getDolGlobalString('MAIN_PDF_DISABLE_COL_HEAD_TITLE')) {
            $hidetop = $conf->global->MAIN_PDF_DISABLE_COL_HEAD_TITLE;
        }
        // Loop on each lines to detect if there is at least one image to show
        $realpatharray = array();
        $this->atleastonephoto = false;
        if (getDolGlobalString('MAIN_GENERATE_PROPOSALS_WITH_PICTURE')) {
            $objphoto = new Product($this->db);
            for ($i = 0; $i < $nblines; $i++) {
                if (empty($object->lines[$i]->fk_product)) {
                    continue;
                }

                $objphoto->fetch($object->lines[$i]->fk_product);
                //var_dump($objphoto->ref);exit;
                if (getDolGlobalInt('PRODUCT_USE_OLD_PATH_FOR_PHOTO')) {
                    $pdir[0] = get_exdir($objphoto->id, 2, 0, 0, $objphoto, 'product') . $objphoto->id . "/photos/";
                    $pdir[1] = get_exdir(0, 0, 0, 0, $objphoto, 'product') . dol_sanitizeFileName($objphoto->ref) . '/';
                } else {
                    $pdir[0] = get_exdir(0, 0, 0, 0, $objphoto, 'product'); // default
                    $pdir[1] = get_exdir($objphoto->id, 2, 0, 0, $objphoto, 'product') . $objphoto->id . "/photos/"; // alternative
                }
                $arephoto = false;
                foreach ($pdir as $midir) {
                    if (!$arephoto) {
                        if ($conf->entity != $objphoto->entity) {
                            $dir = $conf->product->multidir_output[$objphoto->entity] . '/' . $midir; //Check repertories of current entities
                        } else {
                            $dir = $conf->product->dir_output . '/' . $midir; //Check repertory of the current product
                        }
                        foreach ($objphoto->liste_photos($dir, 1) as $key => $obj) {
                            if (!getDolGlobalInt('CAT_HIGH_QUALITY_IMAGES')) { // If CAT_HIGH_QUALITY_IMAGES not defined, we use thumb if defined and then original photo
                                if ($obj['photo_vignette']) {
                                    $filename = $obj['photo_vignette'];
                                } else {
                                    $filename = $obj['photo'];
                                }
                            } else {
                                $filename = $obj['photo'];
                            }
                            $realpath = $dir . $filename;
                            $arephoto = true;
                            $this->atleastonephoto = true;
                        }
                    }
                }
                if ($realpath && $arephoto) {
                    $realpatharray[$i] = $realpath;
                }
            }
        } //MAIN_GENERATE_PROPOSALS_WITH_PICTURE
        if (count($realpatharray) == 0) {
            $this->posxpicture = $this->posxtva;
        }
		
		$proposal_revision = '';
        if (!empty($object->array_options['options_proposalrevision'])) {
            $proposal_revision = $object->array_options['options_proposalrevision'];
            //$pdf->MultiCell($w, 3, "Revision : " . $proposal_revision, '', 'R');
        }
		
        if ($conf->propal->multidir_output[$conf->entity]) {
            $object->fetch_thirdparty();
            $deja_regle = 0;
            // Definition of $dir and $file
            if ($object->specimen) {
                $dir = $conf->propal->multidir_output[$conf->entity];
                $file = $dir . "/SPECIMEN.pdf";
            } else {
                $objectref = dol_sanitizeFileName($object->ref);
                $dir = $conf->propal->multidir_output[$object->entity] . "/" . $objectref;
                // $file = $dir . "/" . $objectref . ".pdf";
                $file = $dir . "/" . $objectref ."-" .$proposal_revision . ".pdf";
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
                    include_once DOL_DOCUMENT_ROOT . '/core/class/hookmanager.class.php';
                    $hookmanager = new HookManager($this->db);
                }
                $hookmanager->initHooks(array('pdfgeneration'));
                $parameters = array('file' => $file, 'object' => $object, 'outputlangs' => $outputlangs);
                global $action;
                $reshook = $hookmanager->executeHooks('beforePDFCreation', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
                // Set nblines with the new content of lines after hook
                $nblines = count($object->lines);
                //$nbpayments = count($object->getListOfPayments());
                // Create pdf instance
                $pdf = pdf_getInstance($this->format);
                $default_font_size = pdf_getPDFFontSize($outputlangs); // Must be after pdf_getInstance
                //$pdf->SetAutoPageBreak(1, 0);
                $pdf->SetAutoPageBreak(1, 0);
                $heightforinfotot = 40; // Height reserved to output the info and total part
                $heightforfreetext = (isset($conf->global->MAIN_PDF_FREETEXT_HEIGHT) ? $conf->global->MAIN_PDF_FREETEXT_HEIGHT : 5); 
				// Height reserved to output the free text on last page
                $heightforfooter = $this->marge_basse + (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS') ? 12 : 22); 
				// Height reserved to output the footer (value include bottom margin) 12:22

                if (class_exists('TCPDF')) {
                    $pdf->setPrintHeader(false);
                    $pdf->setPrintFooter(false);
                }
                $pdf->SetFont(pdf_getPDFFont($outputlangs));
                // Set path to the background PDF File
                if (getDolGlobalString('MAIN_ADD_PDF_BACKGROUND')) {
                    $logodir = $conf->mycompany->dir_output;
                    if (!empty($conf->mycompany->multidir_output[$object->entity])) {
                        $logodir = $conf->mycompany->multidir_output[$object->entity];
                    }
                    $pagecount = $pdf->setSourceFile($logodir . '/' . getDolGlobalString('MAIN_ADD_PDF_BACKGROUND'));
                    $tplidx = $pdf->importPage(1);
                }
                $pdf->Open();
                $pagenb = 0;
                $pdf->SetDrawColor(128, 128, 128);
                $pdf->SetTitle($outputlangs->convToOutputCharset($object->ref));
                $pdf->SetSubject($outputlangs->transnoentities("PdfCommercialProposalTitle"));
                $pdf->SetCreator("VAGA " . DOL_VERSION);
                $pdf->SetAuthor($outputlangs->convToOutputCharset($user->getFullName($outputlangs)));
                $pdf->SetKeyWords($outputlangs->convToOutputCharset($object->ref) . " " . $outputlangs->transnoentities("PdfCommercialProposalTitle") . " " . $outputlangs->convToOutputCharset($object->thirdparty->name));
                if (getDolGlobalString('MAIN_DISABLE_PDF_COMPRESSION')) {
                    $pdf->SetCompression(false);
                }
                $pdf->SetMargins($this->marge_gauche, $this->marge_haute, $this->marge_droite); // Left, Top, Right
                // Set $this->atleastonediscount if you have at least one discount
                for ($i = 0; $i < $nblines; $i++) {
                    if ($object->lines[$i]->remise_percent) {
                        $this->atleastonediscount++;
                    }
                }
                // New page
                $pdf->AddPage();
                if (!empty($tplidx)) {
                    $pdf->useTemplate($tplidx);
                }
                $pagenb++;

                $heightforsignature = !getDolGlobalString('PROPAL_DISABLE_SIGNATURE') ? (pdfGetHeightForHtmlContent($pdf, $outputlangs->transnoentities("ProposalCustomerSignature")) + 10) : 0;

                $top_shift = $this->_pagehead($pdf, $object, 1, $outputlangs, $outputlangsbis);
                $pdf->SetFont('', '', $default_font_size - 1);
                $pdf->MultiCell(0, 3, ''); // Set interline to 3
                $pdf->SetTextColor(0, 0, 0);
                $tab_top = 86 + $top_shift;
                $tab_top_newpage = (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD') ? 43 + $top_shift : 10);
                $tab_height = $this->page_hauteur - $tab_top_newpage - $heightforinfotot - $heightforfreetext - $heightforsignature - $heightforfooter;
                
				//echo "\ntab_height: " .$tab_height;
				//echo "\ntab_top   : " .$tab_top;
				//echo "\ntop_shift : " .$top_shift;
				//tab_height: 103.708333 tab_top : 90 top_shift : 0
				//die();

                $nexY = $tab_top;       // 90 assigned to table top position         
				
				// // Incoterm  // WORKING CODE
                // $height_incoterms = 0;
                // if (isModEnabled('incoterm')) {
                //     $desc_incoterms = $object->getIncotermsForPDF();
                //     if ($desc_incoterms) {
                //         $tab_top -= 2;
                //
                //         $pdf->SetFont('', '', $default_font_size - 1);
                //         $pdf->writeHTMLCell(190, 3, $this->posxdesc - 1, $tab_top - 1, dol_htmlentitiesbr($desc_incoterms), 0, 1);
                //         $nexY = max($pdf->GetY(), $nexY);
                //         $height_incoterms = $nexY - $tab_top;
                //
                //         // Rect takes a length in 3rd parameter
                //         $pdf->SetDrawColor(192, 192, 192);
                //         $pdf->Rect($this->marge_gauche, $tab_top - 1, $this->page_largeur - $this->marge_gauche - $this->marge_droite, $height_incoterms + 1);
                //
                //         $tab_top = $nexY + 6;
                //         $height_incoterms += 4;
                //     }
                // }

                // Extrafields in note
                // $extranote = $this->getExtrafieldsInHtml($object, $outputlangs);
                // $notetoshow = dol_concatdesc($notetoshow, $extranote);
                // if (!empty($extranote)) {
                //       if($notetoshow="GeneralTermsAndConditions") {
                //           // do nothing
                //       } else {
                //
                //       }
                // }
                $extranote1 = '';
                if (!empty($object->array_options['options_scopeofwork'])) {
                    $extranote1 = $object->array_options['options_scopeofwork'];
                
                    // Set padding inside the cell
                    $pdf->setCellPadding(1);
                
                    // Move down before drawing content (top margin)
                    $pdf->SetY($nexY);
                
                    // Draw MultiCell
                    $pdf->MultiCell(0, 0, "Scope of Work: " . $extranote1, 1, 'L', 0, 1, '', '', true);
                
                    // Update nexY to new position after content + bottom margin
                    $nexY = $pdf->GetY();
                
                    // Reset padding
                    $pdf->setCellPadding(0);
                }
                
                // Table starts here, using updated nexY
                $tab_top = $nexY;
               
                $extranote2 = '';
                
                //comment purvesh
                // if (!empty($object->array_options['options_comments'])) {
                //     $extranote2 = $object->array_options['options_comments'];
                //     $pdf->MultiCell(0, 20, "Comments: " . $extranote2, 1, 'L', 0, 1, '', $tab_top, true);
                // }

                $tab_top = $nexY + 2;

                if (getDolGlobalString('MAIN_ADD_CREATOR_IN_NOTE') && $object->user_author_id > 0) {
                    $tmpuser = new User($this->db);
                    $tmpuser->fetch($object->user_author_id);
                    $creator_info = $langs->trans("CaseFollowedBy") . ' ' . $tmpuser->getFullName($langs);
                    if ($tmpuser->email) {
                        $creator_info .= ',  ' . $langs->trans("EMail") . ': ' . $tmpuser->email;
                    }
                    if ($tmpuser->office_phone) {
                        $creator_info .= ', ' . $langs->trans("Phone") . ': ' . $tmpuser->office_phone;
                    }
                    $notetoshow = dol_concatdesc($notetoshow, $creator_info);
                }

                $pagenb = $pdf->getPage(); //get current page number
				
                if ($notetoshow) {
                    $tab_top -= 2;
                    $tab_width = $this->page_largeur - $this->marge_gauche - $this->marge_droite;
                    $pageposbeforenote = $pagenb; 
                    $substitutionarray = pdf_getSubstitutionArray($outputlangs, null, $object);
                    complete_substitutions_array($substitutionarray, $outputlangs, $object);
                    $notetoshow = make_substitutions($notetoshow, $substitutionarray, $outputlangs);
                    $notetoshow = convertBackOfficeMediasLinksToPublicLinks($notetoshow);
                    $pdf->startTransaction();
                    $pdf->SetFont('', '', $default_font_size - 1);
                    $pdf->writeHTMLCell(190, 3, $this->posxdesc - 1, $tab_top, dol_htmlentitiesbr($notetoshow), 0, 1);

                    // Description
                    $pageposafternote = $pdf->getPage();
                    $posyafter = $pdf->GetY();
                    if ($pageposafternote > $pageposbeforenote) {
                        $pdf->rollbackTransaction(true);
                        // prepare pages to receive notes
                        while ($pagenb < $pageposafternote) {
                            $pdf->AddPage();
                            $pagenb++;
                            if (!empty($tplidx)) {
                                $pdf->useTemplate($tplidx);
                            }
                            if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                                $this->_pagehead($pdf, $object, 0, $outputlangs);
                            }
                            // $this->_pagefoot($pdf,$object,$outputlangs,1);
                            $pdf->setTopMargin($tab_top_newpage);
                            // The only function to edit the bottom margin of current page to set it.
                            $pdf->setPageOrientation('', 1, $heightforfooter + $heightforfreetext);
                        }
                        // back to start
                        $pdf->setPage($pageposbeforenote);
                        $pdf->setPageOrientation('', 1, $heightforfooter + $heightforfreetext);
                        $pdf->SetFont('', '', $default_font_size - 1);
                        $pdf->writeHTMLCell(190, 3, $this->posxdesc - 1, $tab_top, dol_htmlentitiesbr($notetoshow), 0, 1);
                        $pageposafternote = $pdf->getPage();
                        $posyafter = $pdf->GetY();
                        if ($posyafter > ($this->page_hauteur - ($heightforfooter + $heightforfreetext + 20))) { // There is no space left for total+free text
                            $pdf->AddPage('', '', true);
                            $pagenb++;
                            $pageposafternote++;
                            $pdf->setPage($pageposafternote);
                            $pdf->setTopMargin($tab_top_newpage);
                            // The only function to edit the bottom margin of current page to set it.
                            $pdf->setPageOrientation('', 1, $heightforfooter + $heightforfreetext);
                            //$posyafter = $tab_top_newpage;
                        }
                        // apply note frame to previous pages
                        $i = $pageposbeforenote;
                        while ($i < $pageposafternote) {
                            $pdf->setPage($i);
                            $pdf->SetDrawColor(128, 128, 128);
                            // Draw note frame
                            if ($i > $pageposbeforenote) {
                                $height_note = $this->page_hauteur - ($tab_top_newpage + $heightforfooter);
                                $pdf->Rect($this->marge_gauche, $tab_top_newpage - 1, $tab_width, $height_note + 1);
                            } else {
                                $height_note = $this->page_hauteur - ($tab_top + $heightforfooter);
                                $pdf->Rect($this->marge_gauche, $tab_top - 1, $tab_width, $height_note + 1);
                            }
                            // Add footer
                            $pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.
                            $this->_pagefoot($pdf, $object, $outputlangs, 1);
                            $i++;
                        }
                        // apply note frame to last page
                        $pdf->setPage($pageposafternote);
                        if (!empty($tplidx)) {
                            $pdf->useTemplate($tplidx);
                        }
                        if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                            $this->_pagehead($pdf, $object, 0, $outputlangs);
                        }
                        $height_note = $posyafter - $tab_top_newpage;
                        $pdf->Rect($this->marge_gauche, $tab_top_newpage - 1, $tab_width, $height_note + 1);
                    } else {
                        // No pagebreak
                        $pdf->commitTransaction();
                        $posyafter = $pdf->GetY();
                        $height_note = $posyafter - $tab_top;
                        $pdf->Rect($this->marge_gauche, $tab_top - 1, $tab_width, $height_note + 1);
                        if ($posyafter > ($this->page_hauteur - ($heightforfooter + $heightforfreetext + 20))) {

                            // not enough space, need to add page
                            $pdf->AddPage('', '', true);
                            $pagenb++;
                            $pageposafternote++;
                            $pdf->setPage($pageposafternote);
                            if (!empty($tplidx)) {
                                $pdf->useTemplate($tplidx);
                            }
                            if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                                $this->_pagehead($pdf, $object, 0, $outputlangs);
                            }
                            $posyafter = $tab_top_newpage;
                        }
                    }
                    $tab_height = $tab_height - $height_note;
                    $tab_top = $posyafter + 6;
                } else {
                    $height_note = 0;
                }
                
				// Use new auto column system
                $this->prepareArrayColumnField($object, $outputlangs, $hidedetails, $hidedesc, $hideref);
                
				// Table simulation to know the height of the title line
                $pdf->startTransaction();
                $this->pdfTabTitles($pdf, $tab_top, $tab_height, $outputlangs, $hidetop);
                $pdf->rollbackTransaction(true);
                $nexY = $tab_top + $this->tabTitleHeight;
                dol_syslog("********** nexy before table content " .$nexY);
				
				// Loop on each lines
                $pageposbeforeprintlines = $pdf->getPage();
                $pagenb = $pageposbeforeprintlines;
				dol_syslog("********** pagenb " .$pagenb);
				
				// ******************************************************
                // TABLE CONTENT STARTS HERE
                // ******************************************************
				
				for ($i = 0; $i < $nblines; $i++) {
				
                    // Pagination check and add new page if necessary
                    $curY = $nexY;
					dol_syslog("********** curY inside for loop " .$curY);
                    $pdf->SetFont('', '', $default_font_size - 1); // Into loop to work with multipage
                    $pdf->SetTextColor(0, 0, 0);
					
                    // Define size of image if we need it
                    $imglinesize = array();
                    if (!empty($realpatharray[$i])) {
                        $imglinesize = pdf_getSizeForImage($realpatharray[$i]);
                    }
                    $pdf->setTopMargin($tab_top_newpage);
					dol_syslog("********** tab_top_newpage inside for loop " .$tab_top_newpage);
                    $pdf->setPageOrientation('', 1, $heightforfooter + $heightforfreetext + $heightforsignature + $heightforinfotot);

                    // The only function to edit the bottom margin of current page to set it.

                    $pageposbefore = $pdf->getPage();
                    $showpricebeforepagebreak = 1;
                    $posYAfterImage = 0;
                    $posYAfterDescription = 0;

                    // photo not in use **************
                    if ($this->getColumnStatus('photo')) {
                        //        // We start with Photo of product line
                        //        if (isset($imglinesize['width']) && isset($imglinesize['height']) && ($curY + $imglinesize['height']) > ($this->page_hauteur - ($heightforfooter + $heightforfreetext + $heightforsignature + $heightforinfotot))) {    // If photo too high, we moved completely on new page
                        //            $pdf->AddPage('', '', true);
                        //            if (!empty($tplidx)) {
                        //                $pdf->useTemplate($tplidx);
                        //            }
                        //            $pdf->setPage($pageposbefore + 1);
                        //
                        //            $curY = $tab_top_newpage;
                        //
                        //            // Allows data in the first page if description is long enough to break in multiples pages
                        if (getDolGlobalString('MAIN_PDF_DATA_ON_FIRST_PAGE')) {
                            $showpricebeforepagebreak = 1;
                        } else {
                            $showpricebeforepagebreak = 0;
                        }
                        //}
                        //
                        //        if (!empty($this->cols['photo']) && isset($imglinesize['width']) && isset($imglinesize['height'])) {
                        //            $pdf->Image($realpatharray[$i], $this->getColumnContentXStart('photo'), $curY + 1, $imglinesize['width'], $imglinesize['height'], '', '', '', 2, 300); // Use 300 dpi
                        //            // $pdf->Image does not increase value return by getY, so we save it manually
                        //            $posYAfterImage = $curY + $imglinesize['height'];
                        //
                        //            //barcode test
                        //            //$pdf->Image(DOL_DOCUMENT_ROOT, 10, 10, 100, 100, '', '', '', true, 300, '', false, false, 1, false, false, false);
                        //            // Add the barcode below the photo
                        //            $barcodeStyle = array(
                        //                'border' => 0,
                        //                'vpadding' => 'auto',
                        //                'hpadding' => 'auto',
                        //                'fgcolor' => array(0, 0, 0),
                        //                'bgcolor' => false, // No background
                        //                'module_width' => 1, // Width of a single module in points
                        //                'module_height' => 1 // Height of a single module in points
                        //            );
                        //
                        //            // Adjust $x and $y to position the barcode correctly below the photo
                        //            // $pdf->write2DBarcode($product->barcode, 'QRCODE,H', 10, 20, 50, 50, $barcodeStyle, 'N');
                        //        }
                    } //photo
					
					//********************************************************
                    // Description of product line					
					//********************************************************
                    if ($this->getColumnStatus('desc')) {
                        $pdf->startTransaction();
						
                        // Start capturing the current position
                        //$startY = $curY;
						dol_syslog("********** desc curY slno " .$curY);
                        // Serial Number
                        if ($this->getColumnStatus('slno')) {
                            $this->printStdColumnContent($pdf, $curY, 'slno', $i + 1);
                        }
						
                        // Barcode Style
                        $barcodeStyle = array(
                            'position' => '',
                            'align' => 'R',
                            'stretch' => false,
                            'fitwidth' => true,
                            'cellfitalign' => '',
                            'border' => false,
                            'hpadding' => 'auto',
                            'vpadding' => 'auto',
                            'fgcolor' => array(0, 0, 0), // Black color for the barcode
                            'bgcolor' => false, // No background color
                            'text' => false, // Show the text below the barcode
                            'font' => 'helvetica', // Font for the text
                            'fontsize' => 8, // Font size for the text
                            'stretchtext' => 4,
                        );
                        
                        //var_dump($object);
                        // Write Barcode
                        $product_barcode = (!empty($object->lines[$i]->product_barcode) ? $object->lines[$i]->product_barcode : "123TEST");
                        
                        
                        $pdf->write1DBarcode($product_barcode, 'C128', 107, $curY, '', 7, 0.2, $barcodeStyle, 'N');
						
                        // Write Description
                        $this->printColDescContent($pdf, $curY , 'desc', $object, $i, $outputlangs, $hideref, $hidedesc);
                        $pageposafter = $pdf->getPage();
						
                        if ($pageposafter > $pageposbefore) { // There is a page break
                            // Rollback and start over, printing the whole group on the next page
                            $pdf->rollbackTransaction(true);
                            // Move to the next page and adjust the position

							$pdf->setPageOrientation('', 1, $heightforfooter); 
							// The only function to edit the bottom margin of current page to set it.

                           // $pdf->AddPage();
                           // $curY = $pdf->GetY();

                            // Serial Number
                            if ($this->getColumnStatus('slno')) {
                                $this->printStdColumnContent($pdf, $curY, 'slno', $i + 1);
                            }
							
                            // Barcode
							//93 x-axis   7 height  0.3 thickness of barcode
                            $pdf->write1DBarcode($product_barcode, 'C128', 107, $curY, '', 7, 0.2, $barcodeStyle, 'N');
							
                            // Description
                            $this->printColDescContent($pdf, $curY, 'desc', $object, $i, $outputlangs, $hideref, $hidedesc);
							
							$pageposafter = $pdf->getPage();
                            $posyafter = $pdf->GetY();
							
                            //var_dump($posyafter); var_dump(($this->page_hauteur - ($heightforfooter+$heightforfreetext+$heightforinfotot))); exit;
                            if ($posyafter > ($this->page_hauteur - ($heightforfooter + $heightforfreetext + $heightforsignature + $heightforinfotot))) { // There is no space left for total+free text
                                if ($i == ($nblines - 1)) { // No more lines, and no space left to show total, so we create a new page
                                    $pdf->AddPage('', '', true);
                                    if (!empty($tplidx)) {
                                        $pdf->useTemplate($tplidx);
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
																		   
                        $posYAfterDescription = $pdf->GetY();
						
	  
                    } // desc                    

					$nexY = $pdf->GetY();
                    $pageposafter = $pdf->getPage();

                    $pdf->setPage($pageposbefore);
                    $pdf->setTopMargin($this->marge_haute);
                    $pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.

                    // We suppose that a too long description or photo were moved completely on next page
                    if ($pageposafter > $pageposbefore && empty($showpricebeforepagebreak)) {
                        $pdf->setPage($pageposafter);
                        $curY = $tab_top_newpage;
						
                    }
                    $pdf->SetFont('', '', $default_font_size - 1); // We reposition the default font
					
					
                    // VAT Rate
                    // if ($this->getColumnStatus('vat')) {
                    //        $vat_rate = pdf_getlinevatrate($object, $i, $outputlangs, $hidedetails);
                    //    $this->printStdColumnContent($pdf, $curY, 'vat', $vat_rate);
                    //        $nexY = max($pdf->GetY(), $nexY);
                    //    }
                    // if ($pageposafter > $pageposbefore) {
					//         $pdf->setPage($pageposafter);
					//     }
					
                    // Unit price before discount
                //    if ($this->getColumnStatus('subprice')) {
             //           $up_excl_tax = pdf_getlineupexcltax($object, $i, $outputlangs, $hidedetails);
              //          $this->printStdColumnContent($pdf, $curY, 'subprice', $up_excl_tax);
                //        $nexY = max($pdf->GetY(), $nexY);
                  //  }
                    
                    // Unit price before discount
                    // if only greater than 0 subrprice than only print price in template purvesh
                    // Get subprice first to use as a condition
                    $up_excl_tax = pdf_getlineupexcltax($object, $i, $outputlangs, $hidedetails);

                    if ($this->getColumnStatus('subprice') && $up_excl_tax > 0) {
                        $formatted_subprice = number_format($up_excl_tax, 2);  // Format to 2 decimal places
                        $this->printStdColumnContent($pdf, $curY, 'subprice', $formatted_subprice);
                        $nexY = max($pdf->GetY(), $nexY);

                        // Qty
                        if ($this->getColumnStatus('qty')) {
                            $qty = pdf_getlineqty($object, $i, $outputlangs, $hidedetails);
                            $this->printStdColumnContent($pdf, $curY, 'qty', $qty);
                            $nexY = max($pdf->GetY(), $nexY);
                        }

                        // Unit
                        if ($this->getColumnStatus('unit')) {
                            $unit = pdf_getlineunit($object, $i, $outputlangs, $hidedetails, $hookmanager);
                            $this->printStdColumnContent($pdf, $curY, 'unit', $unit);
                            $nexY = max($pdf->GetY(), $nexY);
                        }

                        // Total Excl. Tax
                        if ($this->getColumnStatus('totalexcltax')) {
                            $total_excl_tax = pdf_getlinetotalexcltax($object, $i, $outputlangs, $hidedetails);
                            $formatted_total = number_format($total_excl_tax, 2);  // Format to 2 decimal places
                            $this->printStdColumnContent($pdf, $curY, 'totalexcltax', $formatted_total);
                            $nexY = max($pdf->GetY(), $nexY);
                        }
                    }

                   /* if ($this->getColumnStatus('subprice')) {
                        $up_excl_tax = pdf_getlineupexcltax($object, $i, $outputlangs, $hidedetails);
                        $up_excl_tax = number_format($up_excl_tax, 2);  // Format to 2 decimal places
                        $this->printStdColumnContent($pdf, $curY, 'subprice', $up_excl_tax);
                        $nexY = max($pdf->GetY(), $nexY);
                    }                    

                    // Quantity
                    // Enough for 6 chars
                    if ($this->getColumnStatus('qty')) {
                        $qty = pdf_getlineqty($object, $i, $outputlangs, $hidedetails);
                        $this->printStdColumnContent($pdf, $curY, 'qty', $qty);
                        $nexY = max($pdf->GetY(), $nexY);
                    }
					
                    // Unit
                    if ($this->getColumnStatus('unit')) {
                        $unit = pdf_getlineunit($object, $i, $outputlangs, $hidedetails, $hookmanager);
                        $this->printStdColumnContent($pdf, $curY, 'unit', $unit);
                        $nexY = max($pdf->GetY(), $nexY);
                    }*/
					
                    //    // Discount on line
                    //    if ($this->getColumnStatus('discount') && $object->lines[$i]->remise_percent) {
                    //        $remise_percent = pdf_getlineremisepercent($object, $i, $outputlangs, $hidedetails);
                    //        $this->printStdColumnContent($pdf, $curY, 'discount', $remise_percent);
                    //        $nexY = max($pdf->GetY(), $nexY);
                    //    }
					
					// ***************************************************
                    // Total excl tax line (HT) -  USED
					// ***************************************************
                    /*   if ($this->getColumnStatus('totalexcltax')) {
                           $total_excl_tax = pdf_getlinetotalexcltax($object, $i, $outputlangs, $hidedetails);
                           $total_excl_tax = number_format($total_excl_tax, 2);  // Format to 2 decimal places
                           $this->printStdColumnContent($pdf, $curY, 'totalexcltax', $total_excl_tax);
                           $nexY = max($pdf->GetY(), $nexY);
                       }
                    */
				  
                    //  // Total with tax line (TTC)  - NOT USED
                    //  if ($this->getColumnStatus('totalincltax')) {
                    //      $total_incl_tax = pdf_getlinetotalwithtax($object, $i, $outputlangs, $hidedetails);
                    //      $this->printStdColumnContent($pdf, $curY, 'totalincltax', $total_incl_tax);
                    //      $nexY = max($pdf->GetY(), $nexY);
                    //  }
                   
				   
				    // ***************************************************
                    // Total with tax line (TTC)   - NOT USED
					// ***************************************************
                    // if ($this->getColumnStatus('totalincltax')) {
                    //     $total_incl_tax = pdf_getlinetotalwithtax($object, $i, $outputlangs, $hidedetails);
                    //     $total_incl_tax = number_format($total_incl_tax, 2);  // Format to 2 decimal places
                    //     $this->printStdColumnContent($pdf, $curY, 'totalincltax', $total_incl_tax);
                    //     $nexY = max($pdf->GetY(), $nexY);
                    // }

               
               
                    // Extrafields
                    
                    // Assume the UOM position is defined as posxUOM
                    $this->posxUOM = $this->posxqty + $this->widthqty;  // Current position based on previous column
                    
                    // Reduce the width of the UOM column
                    $this->widthUOM = 10;  // Set the width to a smaller value   reduced from 15 to 10
                    
                    // Adjust the position of the next column to account for the reduced width
                    $this->posxnextcolumn = $this->posxUOM + $this->widthUOM;
                    
                    if (!empty($object->lines[$i]->array_options)) {
                        foreach ($object->lines[$i]->array_options as $extrafieldColKey => $extrafieldValue) {
                            
                            // var_dump($extrafieldColKey);                            
                            if ($this->getColumnStatus($extrafieldColKey)) {
                                $extrafieldValue = $this->getExtrafieldContent($object->lines[$i], $extrafieldColKey, $outputlangs);
                                $this->printStdColumnContent($pdf, $curY, $extrafieldColKey, $extrafieldValue);
                                // $this->printStdColumnContent($pdf, $curY, 'options_uom', $uom_value, $this->posxUOM, $this->widthUOM);
                                $this->printStdColumnContent($pdf, $curY, 'options_uom', $uom_value);
                                $nexY = max($pdf->GetY(), $nexY);
                            }
                        }
                    }
					
                    $parameters = array(
                        'object' => $object,
                        'i' => $i,
                        'pdf' => &$pdf,
                        'curY' => &$curY,
                        'nexY' => &$nexY,
                        'outputlangs' => $outputlangs,
                        'hidedetails' => $hidedetails,
                    );
                    $reshook = $hookmanager->executeHooks('printPDFline', $parameters, $this); 
					
					// Note that $object may have been modified by hook
                    // Collection of totals by value of vat in $this->tva["rate"] = total_tva
                    if (isModEnabled("multicurrency") && $object->multicurrency_tx != 1) {
                        $tvaligne = $object->lines[$i]->multicurrency_total_tva;
                    } else {
                        $tvaligne = $object->lines[$i]->total_tva;
                    }
                    $localtax1ligne = $object->lines[$i]->total_localtax1;
                    $localtax2ligne = $object->lines[$i]->total_localtax2;
                    $localtax1_rate = $object->lines[$i]->localtax1_tx;
                    $localtax2_rate = $object->lines[$i]->localtax2_tx;
                    $localtax1_type = $object->lines[$i]->localtax1_type;
                    $localtax2_type = $object->lines[$i]->localtax2_type;
					
                    // TODO remise_percent is an obsolete field for object parent
                    /*if ($object->remise_percent) {
                    $tvaligne -= ($tvaligne * $object->remise_percent) / 100;
                    }
                    if ($object->remise_percent) {
                    $localtax1ligne -= ($localtax1ligne * $object->remise_percent) / 100;
                    }
                    if ($object->remise_percent) {
                    $localtax2ligne -= ($localtax2ligne * $object->remise_percent) / 100;
                    }*/
					
                    $vatrate = (string) $object->lines[$i]->tva_tx;
                    // Retrieve type from database for backward compatibility with old records
					
					// if tax type not defined
                    if ((!isset($localtax1_type) || $localtax1_type == '' || !isset($localtax2_type) || $localtax2_type == '')			
                         && (!empty($localtax1_rate) || !empty($localtax2_rate))) { // and there is local tax
                        $localtaxtmp_array = getLocalTaxesFromRate($vatrate, 0, $object->thirdparty, $mysoc);
                        $localtax1_type = isset($localtaxtmp_array[0]) ? $localtaxtmp_array[0] : '';
                        $localtax2_type = isset($localtaxtmp_array[2]) ? $localtaxtmp_array[2] : '';
                    }
                    // retrieve global local tax
                    if ($localtax1_type && $localtax1ligne != 0) {
                        if (empty($this->localtax1[$localtax1_type][$localtax1_rate])) {
                            $this->localtax1[$localtax1_type][$localtax1_rate] = $localtax1ligne;
                        } else {
                            $this->localtax1[$localtax1_type][$localtax1_rate] += $localtax1ligne;
                        }
                    }
                    if ($localtax2_type && $localtax2ligne != 0) {
                        if (empty($this->localtax2[$localtax2_type][$localtax2_rate])) {
                            $this->localtax2[$localtax2_type][$localtax2_rate] = $localtax2ligne;

                        } else {
                            $this->localtax2[$localtax2_type][$localtax2_rate] += $localtax2ligne;
                        }
                    }
                    if (($object->lines[$i]->info_bits & 0x01) == 0x01) {
                        $vatrate .= '*';
                    }
                    // Fill $this->tva and $this->tva_array
                    if (!isset($this->tva[$vatrate])) {
                        $this->tva[$vatrate] = 0;
                    }
                    $this->tva[$vatrate] += $tvaligne;
                    $vatcode = $object->lines[$i]->vat_src_code;
                    if (empty($this->tva_array[$vatrate . ($vatcode ? ' (' . $vatcode . ')' : '')]['amount'])) {
                        $this->tva_array[$vatrate . ($vatcode ? ' (' . $vatcode . ')' : '')]['amount'] = 0;
                    }
                    $this->tva_array[$vatrate . ($vatcode ? ' (' . $vatcode . ')' : '')] = array('vatrate' => $vatrate, 'vatcode' => $vatcode, 'amount' => $this->tva_array[$vatrate . ($vatcode ? ' (' . $vatcode . ')' : '')]['amount'] + $tvaligne);
					
					if ($posYAfterImage > $posYAfterDescription) {
							$nexY = max($nexY, $posYAfterImage);
					}
					
                    // Add horizontal dashline
                    if (getDolGlobalString('MAIN_PDF_DASH_BETWEEN_LINES') && $i < ($nblines - 1)) {
                        $pdf->setPage($pageposafter);
                        $pdf->SetLineStyle(array('dash' => '1,1', 'color' => array(80, 80, 80)));
                        //$pdf->SetDrawColor(190,190,200);
                        $pdf->line($this->marge_gauche, $nexY + 1, $this->page_largeur - $this->marge_droite, $nexY + 1);
                        $pdf->SetLineStyle(array('dash' => 0));
                    }
                    $nexY += 2; // Add space between lines

                    // Detect if some page were added automatically and output _tableau for past pages

                    while ($pagenb < $pageposafter) {
                        $pdf->setPage($pagenb);

                        // following if condition is only for table header and lines
                        if ($pagenb == $pageposbeforeprintlines) {
                            $this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforfooter, 0, $outputlangs, $hidetop, 1, $object->multicurrency_code, $outputlangsbis);
                        } else {
                            $this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforfooter, 0, $outputlangs, 1, 1, $object->multicurrency_code, $outputlangsbis);
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
                    } //while ($pagenb < $pageposafter)

                    // if table rows are exceeding move to next page.
                    // following if condition not executed ?????????
                    if (isset($object->lines[$i + 1]->pagebreak) && $object->lines[$i + 1]->pagebreak) {
                        if ($pagenb == $pageposafter) {
                            $this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforfooter, 0, $outputlangs, $hidetop, 1, $object->multicurrency_code, $outputlangsbis);
                            
                        } else {
                            $this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforfooter, 0, $outputlangs, 1, 1, $object->multicurrency_code, $outputlangsbis);
                            
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
                            //dol_syslog(">>>>>>>>>>> here after page head");
                        }
                    }
                } // TABLE CONTENT ENDS HERE forloop end
				//--------------------------------------------------------------------------------------

                // Show square
                // 2nd page table structure - vertical lines and table only
                if ($pagenb == $pageposbeforeprintlines) {
                    $this->_tableau($pdf, $tab_top, $this->page_hauteur - $tab_top - $heightforinfotot - $heightforfreetext - $heightforsignature - $heightforfooter, 0, $outputlangs, $hidetop, 0, $object->multicurrency_code, $outputlangsbis);
                    $bottomlasttab = $this->page_hauteur - $heightforinfotot - $heightforfreetext - $heightforsignature - $heightforfooter + 1;
                } else {
                    $this->_tableau($pdf, $tab_top_newpage, $this->page_hauteur - $tab_top_newpage - $heightforinfotot - $heightforfreetext - $heightforsignature - $heightforfooter, 0, $outputlangs, 1, 0, $object->multicurrency_code, $outputlangsbis);
                    $bottomlasttab = $this->page_hauteur - $heightforinfotot - $heightforfreetext - $heightforsignature - $heightforfooter + 1;
                }

                // **********************************************************
                // Display infos area
                // **********************************************************
                //$posy = $this->drawInfoTable($pdf, $object, $bottomlasttab, $outputlangs);
				
                // **********************************************************
                // INFO AREA EXTRA
                // **********************************************************
                //WARRANTY
//               $warranty = '';
//               if (!empty($object->array_options['options_warranty'])) {
//                   $warranty = $object->array_options['options_warranty'];
//
//                   $pdf->SetFont('', 'B');
//                   $pdf->MultiCell(80, 4, "Warranty: ", 0, 'L', 0, 1, $this->marge_gauche, $posy, true);
//                   $pdf->SetFont('', '');
//                   $pdf->MultiCell(80, 4, $warranty, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
//               }
//               $posy = $posy + 10;
//
//               //SOW NOT INCLUDED
//               $scopesarenotincluded = '';
//               if (!empty($object->array_options['options_scopesarenotincluded'])) {
//                   $scopesarenotincluded = $object->array_options['options_scopesarenotincluded'];
//                   $pdf->SetFont('', 'B');
//                   $pdf->MultiCell(80, 4, "Scope of Work\nNot Included: ", 0, 'L', 0, 1, '', $posy, true);
//                   $pdf->SetFont('', '');
//                   $pdf->MultiCell(65, 15, $scopesarenotincluded, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
//               }
//               $posy = $posy + 15;
//
//               //LEAD TIME
//               $tentativeleadtime = '';
//               if (!empty($object->array_options['options_tentativeleadtime'])) {
//                   $tentativeleadtime = $object->array_options['options_tentativeleadtime'];
//                   $pdf->SetFont('', 'B');
//                   $pdf->MultiCell(75, 4, "Tentative Lead Time: ", 0, 'L', 0, 1, '', $posy, true);
//                   $pdf->SetFont('', '');
//                   $pdf->MultiCell(75, 4, $tentativeleadtime, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
//               }
//               $posy = $posy + 10;
//
//               //INCOTERMS BELOW INFO TABLE
//               if (isModEnabled('incoterm')) {
//                   $desc_incoterms = $object->getIncotermsForPDF();
//                   if ($desc_incoterms) {
//                       //$pdf->MultiCell(100, 10, "Inco Term: " .dol_htmlentitiesbr($desc_incoterms), 0, 'L', 0, 1, '', $posy, true);
//                       $pdf->SetFont('', 'B');
//                       $pdf->MultiCell(80, 4, "Incoterms: ", 0, 'L', 0, 1, '', $posy, true);
//                       $pdf->SetFont('', '');
//                       $pdf->MultiCell(80, 4, str_replace("Incoterm :", "", $desc_incoterms), 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
//                   }
//               }

                // **********************************************************
                // Display Total Zone
                // **********************************************************
                $posy = $this->drawTotalTable($pdf, $object, 0, $bottomlasttab, $outputlangs);
                // Assuming $langs is your Translate object and $object contains your invoice or proposal object
                
                
                // NUMBER TO WORDS SECTION
                $posy = $posy + 2;
                //$total_amount = $object->multicurrency_total_ttc;
                
                // Round the total amount to two decimal places to avoid excessive decimals
                //$total_amount = round($total_amount, 2);
                $total_amount = round($object->multicurrency_total_ttc, 2);
                
                // Optionally format for display (this will not change the rounded value but ensures proper formatting)
                $formatted_amount = number_format($total_amount, 2, '.', ''); // Formats as 95997.74
                
               
               // echo $formatted_amount;
                // Convert to float
                $numeric_amount = (float) $formatted_amount;
                //$total_amount = round($object->multicurrency_total_ttc, 2);
               // echo $formatted_amount;
                //echo $numeric_amount;
               // $amount_text = $langs->getLabelFromNumber('95997.15', 1); // Convert amount to words
               //word purvesh
                // $amount_text = $langs->getLabelFromNumber($numeric_amount, 1); // Convert amount to words
                // $pdf->MultiCell(87, 15, "Amount In Words: " . ucwords($amount_text) ." Only.", 1, 'L', 0, 1, '120', $posy, true);
                // $posy = $posy + 20;
                // echo $amount_text;
            // Assume $numeric_amount is a float like 104412.00
            $amount_text = $langs->getLabelFromNumber($numeric_amount, 1);

            // Optional cleanup — remove currency terms
            $cleaned_amount_text = str_ireplace(['CA$', 'CAD', 'Cents', 'Cent'], '', $amount_text);
            $cleaned_amount_text = preg_replace('/\s+/', ' ', trim($cleaned_amount_text));

            // Determine if cents are zero
            $dollars = floor($numeric_amount);
            $cents = round(($numeric_amount - $dollars) * 100);

            $final_text = ucwords($cleaned_amount_text);

            // Add "and Zero Cents Only." if no cents
            if ($cents == 0) {
                $final_text .= " and Zero Cents Only.";
            } else {
                $final_text .= " Only.";
            }

            // Print to PDF
            $pdf->MultiCell(87, 15, "Amount In Words: " . $final_text, 1, 'L', 0, 1, '120', $posy, true);
            $posy += 20;


                //echo $cleaned_amount_text;

                
                
                // Customer signature area
                //if (!getDolGlobalString('PROPAL_DISABLE_SIGNATURE')) {
                //    $posy = $this->drawSignatureArea($pdf, $object, $posy, $outputlangs);
                //}
                // Pagefoot
                $this->_pagefoot($pdf, $object, $outputlangs);
                if (method_exists($pdf, 'AliasNbPages')) {
                    $pdf->AliasNbPages();
                }
                //If propal merge product PDF is active
                if (getDolGlobalString('PRODUIT_PDF_MERGE_PROPAL')) {
                    require_once DOL_DOCUMENT_ROOT . '/product/class/propalmergepdfproduct.class.php';

                    $already_merged = array();
                    foreach ($object->lines as $line) {
                        if (!empty($line->fk_product) && !(in_array($line->fk_product, $already_merged))) {
                            // Find the desire PDF
                            $filetomerge = new Propalmergepdfproduct($this->db);
                            if (getDolGlobalInt('MAIN_MULTILANGS')) {
                                $filetomerge->fetch_by_product($line->fk_product, $outputlangs->defaultlang);
                            } else {
                                $filetomerge->fetch_by_product($line->fk_product);
                            }
                            $already_merged[] = $line->fk_product;
                            $product = new Product($this->db);
                            $product->fetch($line->fk_product);
                            if ($product->entity != $conf->entity) {
                                $entity_product_file = $product->entity;
                            } else {
                                $entity_product_file = $conf->entity;
                            }
                            // If PDF is selected and file is not empty
                            if (count($filetomerge->lines) > 0) {
                                foreach ($filetomerge->lines as $linefile) {
                                    if (!empty($linefile->id) && !empty($linefile->file_name)) {
                                        if (getDolGlobalInt('PRODUCT_USE_OLD_PATH_FOR_PHOTO')) {
                                            if (isModEnabled("product")) {
                                                $filetomerge_dir = $conf->product->multidir_output[$entity_product_file] . '/' . get_exdir($product->id, 2, 0, 0, $product, 'product') . $product->id . "/photos";
                                            } elseif (isModEnabled("service")) {
                                                $filetomerge_dir = $conf->service->multidir_output[$entity_product_file] . '/' . get_exdir($product->id, 2, 0, 0, $product, 'product') . $product->id . "/photos";
                                            }
                                        } else {

                                            if (isModEnabled("product")) {
                                                $filetomerge_dir = $conf->product->multidir_output[$entity_product_file] . '/' . get_exdir(0, 0, 0, 0, $product, 'product');
                                            } elseif (isModEnabled("service")) {
                                                $filetomerge_dir = $conf->service->multidir_output[$entity_product_file] . '/' . get_exdir(0, 0, 0, 0, $product, 'product');
                                            }
                                        }
                                        dol_syslog(get_class($this) . ':: upload_dir=' . $filetomerge_dir, LOG_DEBUG);
                                        $infile = $filetomerge_dir . '/' . $linefile->file_name;
                                        if (file_exists($infile) && is_readable($infile)) {
                                            $pagecount = $pdf->setSourceFile($infile);
                                            for ($i = 1; $i <= $pagecount; $i++) {
                                                $tplIdx = $pdf->importPage($i);
                                                if ($tplIdx !== false) {
                                                    $s = $pdf->getTemplatesize($tplIdx);
                                                    $pdf->AddPage($s['h'] > $s['w'] ? 'P' : 'L');
                                                    $pdf->useTemplate($tplIdx);
                                                } else {
                                                    setEventMessages(null, array($infile . ' cannot be added, probably protected PDF'), 'warnings');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
				
				//****************************************************************
                // TERMS AND CONDTIONS PAGE
                //****************************************************************
                // Add this at the appropriate place in your PDF generation script

				// Add a new page
                $pdf->AddPage();
                $pagenb++;
				// Set font for the terms and conditions
				$pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('helvetica', '', 14);
				// Add a title for the terms and conditions section
               
				$pdf->SetXY(0, 54);
				
                $pdf->Cell(0, 5, 'Terms and Conditions', 0, 1, 'C');
                $pdf->Ln(3);
                $pdf->SetFont('helvetica', '', 8);	
				$posy = 60;
          
				
				
				//if (!getDolGlobalString('PROPOSAL_PDF_HIDE_DELIVERYMODE') && $object->shipping_method_id > 0) {
				//	$outputlangs->load("sendings");
				//	$shipping_method_id = $object->shipping_method_id;
				//	if (getDolGlobalString('SOCIETE_ASK_FOR_SHIPPING_METHOD') && !empty($this->emetteur->shipping_method_id)) {
				//		$shipping_method_id = $this->emetteur->shipping_method_id;
				//	}
				//	$shipping_method_code = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'code');
				//	$shipping_method_label = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'libelle');
				//	$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
				//	$pdf->SetXY($this->marge_gauche, $posy);
				//	$titre = $outputlangs->transnoentities("SendingMethod") . ':';
				//	$pdf->MultiCell($this->page_largeur-25, 4, $titre, 0, 'L');
				//	$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
				//	$pdf->SetXY($posxval, $posy);
				//	$lib_condition_paiement = ($outputlangs->transnoentities("SendingMethod" . strtoupper($shipping_method_code)) != "SendingMethod" . strtoupper($shipping_method_code)) ? $outputlangs->trans("SendingMethod" . strtoupper($shipping_method_code)) : $shipping_method_label;
				//	$lib_condition_paiement = str_replace('\n', "\n", $lib_condition_paiement);
				//	$pdf->MultiCell($this->page_largeur-25, 4, $lib_condition_paiement, 0, 'L');
				//	$posy = $pdf->GetY() + 1;
				//}
				
				$posy = $posy + 10;	
				
			//	//1. WARRANTY
           //    $warranty = '';
           //    if (!empty($object->array_options['options_warranty'])) {
           //        $warranty = $object->array_options['options_warranty'];
		   //
           //        $pdf->SetFont('', 'B');
           //        $pdf->MultiCell($this->page_largeur-25, 4, "Warranty: ", 0, 'L', 0, 1, $this->marge_gauche, $posy, true);
           //        $pdf->SetFont('', '');
           //        $pdf->MultiCell($this->page_largeur-25, 4, $warranty, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
           //    }
           //    $posy = $posy + 10;
		   //
           //    //2. SOW NOT INCLUDED
           //    $scopesarenotincluded = '';
           //    if (!empty($object->array_options['options_scopesarenotincluded'])) {
           //        $scopesarenotincluded = $object->array_options['options_scopesarenotincluded'];
           //        $pdf->SetFont('', 'B');
           //        $pdf->MultiCell($this->page_largeur-25, 4, "Scope of Work\nNot Included: ", 0, 'L', 0, 1, '', $posy, true);
           //        $pdf->SetFont('', '');
           //        $pdf->MultiCell($this->page_largeur-75, 15, $scopesarenotincluded, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
           //    }
           //    $posy = $posy + 15;
		   //
           //    //3. LEAD TIME
           //    $tentativeleadtime = '';
           //    if (!empty($object->array_options['options_tentativeleadtime'])) {
           //        $tentativeleadtime = $object->array_options['options_tentativeleadtime'];
           //        $pdf->SetFont('', 'B');
           //        $pdf->MultiCell($this->page_largeur-25, 4, "Tentative Lead Time: ", 0, 'L', 0, 1, '', $posy, true);
           //        $pdf->SetFont('', '');
           //        $pdf->MultiCell($this->page_largeur-25, 4, $tentativeleadtime, 0, 'L', 0, 1, $this->marge_gauche + 42, $posy, true);
           //    }
           //    $posy = $posy + 10;

// Set initial position for Terms and Conditions
$posy = 60;

$infoRows = [];

// 1. Warranty
if (!empty($object->array_options['options_comments'])) {
    $infoRows[] = ['Comments', $object->array_options['options_comments']];
}

// 2. Scope of Work Not Included
if (!empty($object->array_options['options_scopesarenotincluded'])) {
    $infoRows[] = ['Scope of Work Not Included', $object->array_options['options_scopesarenotincluded']];
}

// 3. Tentative Lead Time
if (!empty($object->array_options['options_tentativeleadtime'])) {
    $infoRows[] = ['Tentative Lead Time', $object->array_options['options_tentativeleadtime']];
}

// 4. Incoterms
 if (isModEnabled('incoterm')) {
     $desc_incoterms = $object->getIncotermsForPDF();
     if ($desc_incoterms) {
         $infoRows[] = ['Incoterms', str_replace("Incoterm :", "", $desc_incoterms)];
     }
 }

// 5. Shipping Method

if (!getDolGlobalString('PROPOSAL_PDF_HIDE_DELIVERYMODE') && $object->shipping_method_id > 0) {
    $outputlangs->load("sendings");
$shipping_method_id = $object->shipping_method_id;
    if (getDolGlobalString('SOCIETE_ASK_FOR_SHIPPING_METHOD') && !empty($this->emetteur->shipping_method_id)) {
        $shipping_method_id = $this->emetteur->shipping_method_id;
    }
    $shipping_method_code = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'code');
    $shipping_method_label = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'libelle');
    $label = ($outputlangs->transnoentities("SendingMethod" . strtoupper($shipping_method_code)) != "SendingMethod" . strtoupper($shipping_method_code)) ? $outputlangs->trans("SendingMethod" . strtoupper($shipping_method_code)) : $shipping_method_label;
    $label = str_replace('\n', "\n", $label);

    $infoRows[] = ['Shipping Method', $label];
}

// 6. Payment Conditions
if (!getDolGlobalString('PROPOSAL_PDF_HIDE_PAYMENTTERM') && $object->cond_reglement_code) {
    $label = $outputlangs->transnoentities("PaymentTerms" . $object->cond_reglement_code) != 'PaymentTerms' . $object->cond_reglement_code
        ? $outputlangs->transnoentities("PaymentTerms" . $object->cond_reglement_code)
        : $outputlangs->convToOutputCharset($object->cond_reglement_doc ?: $object->cond_reglement_label);

    if ($object->deposit_percent > 0) {
        $label = str_replace('__DEPOSIT_PERCENT__', $object->deposit_percent, $label);
    }

    $infoRows[] = ['Payment Terms', str_replace('\n', "\n", $label)];
}

if (!empty($object->array_options['options_warranty'])) {
    $infoRows[] = ['Warranty', $object->array_options['options_warranty']];
}


    // Example: for row with HTML content
    if (!empty(getDolGlobalString('PROPOSAL_FREE_TEXT'))) {
        $html_notes = getDolGlobalString('PROPOSAL_FREE_TEXT'); // assume it's already HTML
        $infoRows[] = ['Additional Notes', $html_notes,'html'];
    }

    // Draw table with border
    if (!empty($infoRows)) {
        /*$pdf->SetFont('helvetica', '', 8);
        $wLabel = 50;
        $wValue = $this->page_largeur - $this->marge_gauche - $this->marge_droite - $wLabel;

        foreach ($infoRows as $row) {
            // Estimate height needed
            $hLabel = $pdf->getStringHeight($wLabel, $row[0]);
            $hValue = $pdf->getStringHeight($wValue, $row[1]);
            $rowHeight = max($hLabel, $hValue) + 2;

            // Page break check
            if ($posy + $rowHeight > ($pdf->getPageHeight() - $this->marge_basse)) {
                $pdf->AddPage();
                $posy = $this->marge_haute;
            }

            // Draw label cell (left column)
            $pdf->SetXY($this->marge_gauche, $posy);
            $pdf->MultiCell($wLabel, $rowHeight, $row[0], 1, 'L', 0, 0, '', '', true);

            // Draw value cell (right column)
            $pdf->SetXY($this->marge_gauche + $wLabel, $posy);
            $pdf->MultiCell($wValue, $rowHeight, $row[1], 1, 'L', 0, 1, '', '', true);

            // Move Y position for next row
            $posy += $rowHeight;
        }*/
        $pdf->SetFont('helvetica', '', 8);

        // Set padding for all cells (adjust as needed)
        $pdf->setCellPaddings(2, 2, 2, 2);
        
        $wLabel = 50;
        $wValue = $this->page_largeur - $this->marge_gauche - $this->marge_droite - $wLabel;
        $posy = $pdf->GetY();
        
        foreach ($infoRows as $row) {
            $label = $row[0];
            $value = $row[1];
            $isHtml = isset($row[2]) && $row[2] === 'html';
        
            $xLabel = $this->marge_gauche;
            $xValue = $this->marge_gauche + $wLabel;
        
            // -- Simulate LABEL height --
            $pdf->startTransaction();
            $pdf->MultiCell($wLabel, 0, $label, 0, 'L', 0, 1, '', '', true);
            $hLabel = $pdf->GetY() - $posy;
            $pdf->rollbackTransaction(true);
        
            // -- Simulate VALUE height --
            $pdf->startTransaction();
            if ($isHtml) {
                $pdf->writeHTMLCell($wValue, 0, $xValue, $posy, $value, 0, 1, false, true, 'L', true);
            } else {
                $pdf->MultiCell($wValue, 0, $value, 0, 'L', 0, 1, $xValue, $posy, true);
            }
            $hValue = $pdf->GetY() - $posy;
            $pdf->rollbackTransaction(true);
        
            // -- Final dynamic row height --
            $rowHeight = max($hLabel, $hValue);
        
            // -- Page break check --
            if ($posy + $rowHeight > ($pdf->getPageHeight() - $this->marge_basse)) {
                $pdf->AddPage();
                $posy = $this->marge_haute;
            }
        
            // -- Draw LABEL --
            $pdf->SetXY($xLabel, $posy);
            $pdf->MultiCell($wLabel, $rowHeight, $label, 1, 'L', 0, 0, '', '', true);
        
            // -- Draw VALUE --
            $pdf->SetXY($xValue, $posy);
            if ($isHtml) {
                $pdf->writeHTMLCell($wValue, $rowHeight, $xValue, $posy, $value, 1, 1, false, true, 'L', true);
            } else {
                $pdf->MultiCell($wValue, $rowHeight, $value, 1, 'L', 0, 1, '', '', true);
            }
        
            $posy += $rowHeight;
        }
 
    }

				//$posy = $this->drawInfoTable($pdf, $object, $posy, $outputlangs);
				
			
				$pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.
                $this->_pagefoot($pdf, $object, $outputlangs, 1);
                if (method_exists($pdf, 'AliasNbPages')) {
                    $pdf->AliasNbPages();
                }

				
                if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                    $this->_pagehead($pdf, $object, 0, $outputlangs);
                }
				
								
				//****************************************************************
                // COMMERCIAL TERMS PAGE
                //****************************************************************
                // Add this at the appropriate place in your PDF generation script

 				// Add a new page purvesh term left
                /* $pdf->AddPage();
                 $pagenb++;
				 
				 if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                     $this->_pagehead($pdf, $object, 0, $outputlangs);
                 } 
 
 				 // Set font for the terms and conditions
                 $pdf->SetFont('helvetica', '', 14);
 				 // Add a title for the terms and conditions section
                 $pdf->Ln(90);
				 $pdf->SetTextColor(0, 0, 0);
                 $pdf->SetXY(0, 54);
                 $pdf->Cell(0, 5, 'Commercial Terms', 0, 1, 'C');
                 $pdf->SetFont('helvetica', '', 9);				
				 $pdf->SetTextColor(0, 0, 0);
                 // Extract specific extrafield for General Terms and Conditions
                 $extranote = '';
                
                 if (!empty($object->array_options['options_proposal_general_terms_and_conditions'])) {
                    $extranote = $object->array_options['options_proposal_general_terms_and_conditions'];
                
                    // Replace common HTML tags with newlines and strip tags
                    $extranote = strip_tags(str_ireplace(['<br>', '<br/>', '<br />', '<p>', '</p>'], "\n", $extranote));
                
                    // Split into lines
                    $lines = explode("\n", $extranote);
                    $clean_lines = [];
                
                    foreach ($lines as $i => $line) {
                        $line = rtrim($line); // Trim trailing whitespace
                
                        // For last line only: remove extra spaces between words
                        if ($i === array_key_last($lines)) {
                            $line = preg_replace('/\s+/', ' ', $line); // collapse multiple spaces into one
                        }
                
                        $clean_lines[] = $line;
                    }
                
                    $cleaned_note = implode("\n", $clean_lines);
                
                    // Set font
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                
                    // Usable width
                    $usable_width = $this->page_largeur - $this->marge_gauche - $this->marge_droite;
                
                    // Print
                    $pdf->MultiCell($usable_width, 5, $cleaned_note, 0, 'L', 0, 1, $this->marge_gauche, '', true);
                }*/

                // Add a new page
                $pdf->AddPage();
                $pagenb++;

                if (!getDolGlobalInt('MAIN_PDF_DONOTREPEAT_HEAD')) {
                    $this->_pagehead($pdf, $object, 0, $outputlangs);
                }

                // Set font for the section title
                $pdf->SetFont('helvetica', '', 14);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(0, 54);
                $pdf->Cell(0, 5, 'Commercial Terms', 0, 1, 'C');

                $pdf->Ln(-2); // Space after the title

                // Extract specific extrafield for General Terms and Conditions
                $extranote = '';
                if (!empty($object->array_options['options_proposal_general_terms_and_conditions'])) {
                    $extranote = $object->array_options['options_proposal_general_terms_and_conditions'];

                    // Clean HTML and format as justified paragraph
                    $extranote = html_entity_decode($extranote, ENT_QUOTES | ENT_HTML5);
                    $extranote = preg_replace('/<\s*br\s*\/?>/i', "\n", $extranote);
                    $extranote = strip_tags($extranote);
                    $extranote = trim(preg_replace('/\s+/', ' ', $extranote)); // Collapse multiple whitespaces

                    // Set font for paragraph
                    $pdf->SetFont('helvetica', '', 9);
                    $pdf->SetTextColor(0, 0, 0);

                    // Print justified paragraph
                    $usable_width = $this->page_largeur - $this->marge_gauche - $this->marge_droite;
                    $html = '<div style="text-align:justify; text-align-last:left;">' . $extranote . '</div>';
                    $pdf->writeHTMLCell($usable_width, 5, $this->marge_gauche, '', $html, 0, 1, 0, true, '', true);
                    // $pdf->MultiCell($usable_width, 5, $extranote, 0, 'J', 0, 1, $this->marge_gauche, '', true);
                }

                
                            
			     
				 $posy = $posy +90;
                 // Customer signature area
                 if (!getDolGlobalString('PROPAL_DISABLE_SIGNATURE')) {
                    $posy = $pdf->GetY() + 2;
                     //$pdf->MultiCell(0, 10, "Proposal Accepted", 0, 'L', 0, 1, '', '', true);
                     $posy = $this->drawSignatureArea($pdf, $object, $posy, $outputlangs);
                 }
				 
 				 //$pdf->write2DBarcode("123456", 'QRCODE,H', 10, 20, 50, 50, $barcodeStyle, 'N');
                 //if (!empty($extralabels['proposal_general_terms_and_conditions'])) {
                 //    $extranote = $extralabels['proposal_general_terms_and_conditions'];
                 //    $pdf->writeHTMLCell($this->page_largeur-10, $this->page_hauteur, 10, 50, dol_htmlentitiesbr($extranote), 0, 1);
                 //}
                 //$extranote = $this->getExtrafieldsInHtml($object, $outputlangs);s
                 // if (!empty($extranote)) {
                 //     if($notetoshow="GeneralTermsAndConditions") {
                 //         //$pdf->MultiCell(0, 10, $extranote, 0, 'L', 0, 1, '', '', true);
                 //         $pdf->writeHTMLCell($this->page_largeur-10, $this->page_hauteur, 10, 50, dol_htmlentitiesbr($extranote), 0, 1);
                 //
                 //     } else {
                 //         //$notetoshow = dol_concatdesc($notetoshow, $extranote);
                 //     }
                 // }
                 
				 // Print text
                 $accepted_by = "\n\n\n\n
 ________________________         ____________________________       ______________________________
 ACCEPTED                                      DATE                                                     P.0#
 \n\n";
                 $pdf->setPageOrientation('', 1, 0); // The only function to edit the bottom margin of current page to set it.
                 $this->_pagefoot($pdf, $object, $outputlangs, 1);
                 if (method_exists($pdf, 'AliasNbPages')) {
                     $pdf->AliasNbPages();
                 }
                 $pdf->SetXY(5, 250);
                 $pdf->SetFont('', '', $default_font_size - 2); // We reposition the default font
                // $pdf->MultiCell(0, 10, "Form # 1012/001/Vaga/2024-07-11/R0", 0, 'L', 0, 1, '', '', true);
 				

				
				// Add footer
                $pdf->Close();
                $pdf->Output($file, 'F');
				
                //Add pdfgeneration hook
                $hookmanager->initHooks(array('pdfgeneration'));
                $parameters = array('file' => $file, 'object' => $object, 'outputlangs' => $outputlangs);
                global $action;
                $reshook = $hookmanager->executeHooks('afterPDFCreation', $parameters, $this, $action); 
				// Note that $action and $object may have been modified by some hooks
                if ($reshook < 0) {
                    $this->error = $hookmanager->error;
                    $this->errors = $hookmanager->errors;
                }
                dolChmod($file);
                $this->result = array('fullpath' => $file);
                return 1; // No error
            } else {
                $this->error = $langs->trans("ErrorCanNotCreateDir", $dir);
                return 0;
            }
        } else {
            $this->error = $langs->trans("ErrorConstantNotDefined", "PROP_OUTPUTDIR");
            return 0;
        }
    }
    /**
     *   Show miscellaneous information (payment mode, payment term, ...)
     *
     *   @param        TCPDF        $pdf             Object PDF
     *   @param        Propal        $object            Object to show
     *   @param        int            $posy            Y
     *   @param        Translate    $outputlangs    Langs object
     *   @return    int                            Pos y
     */
    public function drawInfoTable(&$pdf, $object, $posy, $outputlangs)
    {
        global $conf, $mysoc;
        $default_font_size = pdf_getPDFFontSize($outputlangs)+2;
        //$pdf->SetFont('', '', $default_font_size - 1);
        $pdf->SetFont('helvetica', '', 8);	
		$diffsizetitle = (!getDolGlobalString('PDF_DIFFSIZE_TITLE') ? 3 : $conf->global->PDF_DIFFSIZE_TITLE);
        // If France, show VAT mention if not applicable
        if ($this->emetteur->country_code == 'FR' && empty($mysoc->tva_assuj)) {
            //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
            $pdf->SetFont('helvetica', '', 8);	
			$pdf->SetXY($this->marge_gauche, $posy);
            $pdf->MultiCell(100, 3, $outputlangs->transnoentities("VATIsNotUsedForInvoice"), 0, 'L', 0);
            $posy = $pdf->GetY() + 4;
        }
        $posxval = 52;
        if (getDolGlobalString('MAIN_PDF_DATE_TEXT')) {
            $displaydate = "daytext";
        } else {
            $displaydate = "day";
        }
        // Show shipping date
        // if (!empty($object->delivery_date)) {
        //     $outputlangs->load("sendings");
        //     $pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
        //     $pdf->SetXY($this->marge_gauche, $posy);
        //     $titre = $outputlangs->transnoentities("DateDeliveryPlanned").':';
        //     $pdf->MultiCell(80, 4, $titre, 0, 'L');
        //     $pdf->SetFont('', '', $default_font_size - $diffsizetitle);
        //     $pdf->SetXY($posxval, $posy);
        //     $dlp = dol_print_date($object->delivery_date, $displaydate, false, $outputlangs, true);
        //     $pdf->MultiCell(80, 4, $dlp, 0, 'L');
        //
        //     $posy = $pdf->GetY() + 1;
        // } elseif ($object->availability_code || $object->availability) {    // Show availability conditions
        //     $pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
        //     $pdf->SetXY($this->marge_gauche, $posy);
        //     $titre = $outputlangs->transnoentities("AvailabilityPeriod").':';
        //     $pdf->MultiCell(80, 4, $titre, 0, 'L');
        //     $pdf->SetTextColor(0, 0, 0);
        //     $pdf->SetFont('', '', $default_font_size - $diffsizetitle);
        //     $pdf->SetXY($posxval, $posy);
        //     $lib_availability = ($outputlangs->transnoentities("AvailabilityType".$object->availability_code) != 'AvailabilityType'.$object->availability_code) ? $outputlangs->transnoentities("AvailabilityType".$object->availability_code) : $outputlangs->convToOutputCharset($object->availability);
        //     $lib_availability = str_replace('\n', "\n", $lib_availability);
        //     $pdf->MultiCell(80, 4, $lib_availability, 0, 'L');
        //
        //     $posy = $pdf->GetY() + 1;
        // }
        // Show delivery mode
        if (!getDolGlobalString('PROPOSAL_PDF_HIDE_DELIVERYMODE') && $object->shipping_method_id > 0) {
            $outputlangs->load("sendings");
            $shipping_method_id = $object->shipping_method_id;
            if (getDolGlobalString('SOCIETE_ASK_FOR_SHIPPING_METHOD') && !empty($this->emetteur->shipping_method_id)) {
                $shipping_method_id = $this->emetteur->shipping_method_id;
            }
            $shipping_method_code = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'code');
            $shipping_method_label = dol_getIdFromCode($this->db, $shipping_method_id, 'c_shipment_mode', 'rowid', 'libelle');
            //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
			$pdf->SetFont('helvetica', 'B', 8);	
            $pdf->SetXY($this->marge_gauche, $posy);
            $titre = $outputlangs->transnoentities("SendingMethod") . ':';
            $pdf->MultiCell(43, 4, $titre, 0, 'L');
            //$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
			$pdf->SetFont('helvetica', '', 8);	
            $pdf->SetXY($posxval, $posy);
            $lib_condition_paiement = ($outputlangs->transnoentities("SendingMethod" . strtoupper($shipping_method_code)) != "SendingMethod" . strtoupper($shipping_method_code)) ? $outputlangs->trans("SendingMethod" . strtoupper($shipping_method_code)) : $shipping_method_label;
            $lib_condition_paiement = str_replace('\n', "\n", $lib_condition_paiement);
            $pdf->MultiCell(67, 4, $lib_condition_paiement, 0, 'L');
            $posy = $pdf->GetY() + 1;
        }
        // Show payments conditions
        if (!getDolGlobalString('PROPOSAL_PDF_HIDE_PAYMENTTERM') && $object->cond_reglement_code) {
            //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
			$pdf->SetFont('helvetica', 'B', 8);	
            $pdf->SetXY($this->marge_gauche, $posy);
            $titre = $outputlangs->transnoentities("PaymentConditions") . ':';
            $pdf->MultiCell(43, 4, $titre, 0, 'L');
            //$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
			$pdf->SetFont('helvetica', '', 8);	
            $pdf->SetXY($posxval, $posy);
            $lib_condition_paiement = $outputlangs->transnoentities("PaymentCondition" . $object->cond_reglement_code) != 'PaymentCondition' . $object->cond_reglement_code ? $outputlangs->transnoentities("PaymentCondition" . $object->cond_reglement_code) : $outputlangs->convToOutputCharset($object->cond_reglement_doc ? $object->cond_reglement_doc : $object->cond_reglement_label);
            $lib_condition_paiement = str_replace('\n', "\n", $lib_condition_paiement);
            if ($object->deposit_percent > 0) {
                $lib_condition_paiement = str_replace('__DEPOSIT_PERCENT__', $object->deposit_percent, $lib_condition_paiement);
            }
            $pdf->MultiCell(67, 4, $lib_condition_paiement, 0, 'L');
            $posy = $pdf->GetY() + 3;
        }
        if (!getDolGlobalString('PROPOSAL_PDF_HIDE_PAYMENTMODE')) {
            // Show payment mode
            if ($object->mode_reglement_code
                && $object->mode_reglement_code != 'CHQ'
                && $object->mode_reglement_code != 'VIR') {
                //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
				$pdf->SetFont('helvetica', 'B', 8);	
                $pdf->SetXY($this->marge_gauche, $posy);
                $titre = $outputlangs->transnoentities("PaymentMode") . ':';
                $pdf->MultiCell(80, 5, $titre, 0, 'L');
                //$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
				$pdf->SetFont('helvetica', '', 8);	
                $pdf->SetXY($posxval, $posy);
                $lib_mode_reg = $outputlangs->transnoentities("PaymentType" . $object->mode_reglement_code) != 'PaymentType' . $object->mode_reglement_code ? $outputlangs->transnoentities("PaymentType" . $object->mode_reglement_code) : $outputlangs->convToOutputCharset($object->mode_reglement);
                $pdf->MultiCell(80, 5, $lib_mode_reg, 0, 'L');
                $posy = $pdf->GetY() + 2;
            }
            // Show payment mode CHQ
            if (empty($object->mode_reglement_code) || $object->mode_reglement_code == 'CHQ') {
                // Si mode reglement non force ou si force a CHQ
                if (getDolGlobalInt('FACTURE_CHQ_NUMBER')) {
                    if (getDolGlobalInt('FACTURE_CHQ_NUMBER') > 0) {
                        $account = new Account($this->db);
                        $account->fetch(getDolGlobalInt('FACTURE_CHQ_NUMBER'));
                        $pdf->SetXY($this->marge_gauche, $posy);
                        //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
						$pdf->SetFont('helvetica', 'B', 8);	
                        $pdf->MultiCell(100, 3, $outputlangs->transnoentities('PaymentByChequeOrderedTo', $account->proprio), 0, 'L', 0);
                        $posy = $pdf->GetY() + 1;
                        if (!getDolGlobalString('MAIN_PDF_HIDE_CHQ_ADDRESS')) {
                            $pdf->SetXY($this->marge_gauche, $posy);
                            //$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
							$pdf->SetFont('helvetica', '', 8);	
                            $pdf->MultiCell(100, 3, $outputlangs->convToOutputCharset($account->owner_address), 0, 'L', 0);
                            $posy = $pdf->GetY() + 2;
                        }
                    }
                    if (getDolGlobalInt('FACTURE_CHQ_NUMBER') == -1) {
                        $pdf->SetXY($this->marge_gauche, $posy);
                        //$pdf->SetFont('', 'B', $default_font_size - $diffsizetitle);
						$pdf->SetFont('helvetica', 'B', 8);	
                        $pdf->MultiCell(100, 3, $outputlangs->transnoentities('PaymentByChequeOrderedTo', $this->emetteur->name), 0, 'L', 0);
                        $posy = $pdf->GetY() + 1;
                        if (!getDolGlobalString('MAIN_PDF_HIDE_CHQ_ADDRESS')) {
                            $pdf->SetXY($this->marge_gauche, $posy);
                            //$pdf->SetFont('', '', $default_font_size - $diffsizetitle);
							$pdf->SetFont('helvetica', '', 8);	
                            $pdf->MultiCell(100, 3, $outputlangs->convToOutputCharset($this->emetteur->getFullAddress()), 0, 'L', 0);
                            $posy = $pdf->GetY() + 2;
                        }
                    }
                }
            }
            // If payment mode not forced or forced to VIR, show payment with BAN
            if (empty($object->mode_reglement_code) || $object->mode_reglement_code == 'VIR') {
                if ($object->fk_account > 0 || $object->fk_bank > 0 || getDolGlobalInt('FACTURE_RIB_NUMBER')) {
                    $bankid = ($object->fk_account <= 0 ? $conf->global->FACTURE_RIB_NUMBER : $object->fk_account);
                    if ($object->fk_bank > 0) {
                        $bankid = $object->fk_bank; // For backward compatibility when object->fk_account is forced with object->fk_bank
                    }
                    $account = new Account($this->db);
                    $account->fetch($bankid);
                    $curx = $this->marge_gauche;
                    $cury = $posy;
                    $posy = pdf_bank($pdf, $outputlangs, $curx, $cury, $account, 0, $default_font_size);
                    $posy += 2;
                }
            }
        }
        return $posy;
    }
	
    /**
     *    Show total to pay
     *
     *    @param    TCPDF        $pdf            Object PDF
     *    @param  Propal        $object         Object proposal
     *    @param  int            $deja_regle     Amount already paid (in the currency of invoice)
     *    @param    int            $posy            Position depart
     *    @param    Translate    $outputlangs    Objet langs
     *  @param  Translate    $outputlangsbis    Object lang for output bis
     *    @return int                            Position pour suite
     */
    protected function drawTotalTable(&$pdf, $object, $deja_regle, $posy, $outputlangs, $outputlangsbis = null)
    {
        global $conf, $mysoc, $hookmanager;
        $default_font_size = pdf_getPDFFontSize($outputlangs);
        if (getDolGlobalString('PDF_USE_ALSO_LANGUAGE_CODE') && $outputlangs->defaultlang != $conf->global->PDF_USE_ALSO_LANGUAGE_CODE) {
            $outputlangsbis = new Translate('', $conf);
            $outputlangsbis->setDefaultLang($conf->global->PDF_USE_ALSO_LANGUAGE_CODE);
            $outputlangsbis->loadLangs(array("main", "dict", "companies", "bills", "products", "propal"));
            $default_font_size--;
        }
        $tab2_top = $posy;
        $tab2_hl = 4;
        $pdf->SetFont('', '', $default_font_size - 1);
        // Total table
        $col1x = 120;
        $col2x = 170;
        if ($this->page_largeur < 210) { // To work with US executive format
            $col2x -= 20;
        }
        $largcol2 = ($this->page_largeur - $this->marge_droite - $col2x);
        $useborder = 0;
        $index = 0;
        
        // Total HT
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetXY($col1x, $tab2_top);
        $pdf->MultiCell($col2x - $col1x, $tab2_hl, $outputlangs->transnoentities("TotalHT") . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transnoentities("TotalHT") : ''), 0, 'L', 1);
        $total_ht = ((isModEnabled("multicurrency") && isset($object->multicurrency_tx) && $object->multicurrency_tx != 1) ? $object->multicurrency_total_ht : $object->total_ht);
        
        //added by vsn
        //$total_ht = number_format($total_ht, 2);  // Format to 2 decimal
        $pdf->SetXY($col2x, $tab2_top);
        $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($total_ht + (!empty($object->remise) ? number_format($object->remise,2) : 0), 0, $outputlangs),2), 0, 'R', 1);
        
        // Show VAT by rates and total
        $pdf->SetFillColor(248, 248, 248);
        $total_ttc = (isModEnabled("multicurrency") && $object->multicurrency_tx != 1) ? $object->multicurrency_total_ttc : $object->total_ttc;
        $this->atleastoneratenotnull = 0;
        if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT')) {
            $tvaisnull = ((!empty($this->tva) && count($this->tva) == 1 && isset($this->tva['0.000']) && is_float($this->tva['0.000'])) ? true : false);
            if (getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT_IFNULL') && $tvaisnull) {
                // Nothing to do
            } else {
                //Local tax 1 before VAT
                //if (!empty($conf->global->FACTURE_LOCAL_TAX1_OPTION) && $conf->global->FACTURE_LOCAL_TAX1_OPTION=='localtax1on')
                //{
                foreach ($this->localtax1 as $localtax_type => $localtax_rate) {
                    if (in_array((string) $localtax_type, array('1', '3', '5'))) {
                        continue;
                    }
                    foreach ($localtax_rate as $tvakey => $tvaval) {
                        if ($tvakey != 0) { // On affiche pas taux 0
                            //$this->atleastoneratenotnull++;
                            $index++;
                            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                            $tvacompl = '';
                            if (preg_match('/\*/', $tvakey)) {
                                $tvakey = str_replace('*', '', $tvakey);
                                $tvacompl = " (" . $outputlangs->transnoentities("NonPercuRecuperable") . ")";
                            }
                            $totalvat = $outputlangs->transcountrynoentities("TotalLT1", $mysoc->country_code) . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transcountrynoentities("TotalLT1", $mysoc->country_code) : '');
                            $totalvat .= ' ';
                            $totalvat .= vatrate(abs($tvakey), 1) . $tvacompl;
                            $pdf->MultiCell($col2x - $col1x, $tab2_hl, number_format($totalvat,2), 0, 'L', 1);
                            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                            $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($tvaval, 0, $outputlangs),2), 0, 'R', 1);
                        }
                    }
                }
                //}
                //Local tax 2 before VAT
                //if (!empty($conf->global->FACTURE_LOCAL_TAX2_OPTION) && $conf->global->FACTURE_LOCAL_TAX2_OPTION=='localtax2on')
                //{
                foreach ($this->localtax2 as $localtax_type => $localtax_rate) {
                    if (in_array((string) $localtax_type, array('1', '3', '5'))) {
                        continue;
                    }
                    foreach ($localtax_rate as $tvakey => $tvaval) {
                        if ($tvakey != 0) { // On affiche pas taux 0
                            //$this->atleastoneratenotnull++;
                            $index++;
                            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                            $tvacompl = '';
                            if (preg_match('/\*/', $tvakey)) {
                                $tvakey = str_replace('*', '', $tvakey);
                                $tvacompl = " (" . $outputlangs->transnoentities("NonPercuRecuperable") . ")";
                            }
                            $totalvat = $outputlangs->transcountrynoentities("TotalLT2", $mysoc->country_code) . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transcountrynoentities("TotalLT2", $mysoc->country_code) : '');
                            $totalvat .= ' ';
                            $totalvat .= vatrate(abs($tvakey), 1) . $tvacompl;
                            $pdf->MultiCell($col2x - $col1x, $tab2_hl, number_format($totalvat,2), 0, 'L', 1);
                            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                            $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($tvaval, 0, $outputlangs),2), 0, 'R', 1);
                        }
                    }
                }
                //}
                // VAT
                foreach ($this->tva as $tvakey => $tvaval) {
                    if ($tvakey != 0) { // On affiche pas taux 0
                        $this->atleastoneratenotnull++;
                        $index++;
                        $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                        $tvacompl = '';
                        if (preg_match('/\*/', $tvakey)) {
                            $tvakey = str_replace('*', '', $tvakey);
                            $tvacompl = " (" . $outputlangs->transnoentities("NonPercuRecuperable") . ")";
                        }
                        $totalvat = $outputlangs->transcountrynoentities("TotalVAT", $mysoc->country_code) . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transcountrynoentities("TotalVAT", $mysoc->country_code) : '');
                        $totalvat .= ' ';
                        $totalvat .= vatrate($tvakey, 1) . $tvacompl;
                        $pdf->MultiCell($col2x - $col1x, $tab2_hl, $totalvat, 0, 'L', 1);
                        $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                        $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($tvaval, 0, $outputlangs),2), 0, 'R', 1);
                    }
                }
                //Local tax 1 after VAT
                //if (!empty($conf->global->FACTURE_LOCAL_TAX1_OPTION) && $conf->global->FACTURE_LOCAL_TAX1_OPTION=='localtax1on')
                //{
                foreach ($this->localtax1 as $localtax_type => $localtax_rate) {
                    if (in_array((string) $localtax_type, array('2', '4', '6'))) {
                        continue;
                    }
                    foreach ($localtax_rate as $tvakey => $tvaval) {
                        if ($tvakey != 0) { // On affiche pas taux 0
                            //$this->atleastoneratenotnull++;
                            $index++;
                            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                            $tvacompl = '';
                            if (preg_match('/\*/', $tvakey)) {
                                $tvakey = str_replace('*', '', $tvakey);
                                $tvacompl = " (" . $outputlangs->transnoentities("NonPercuRecuperable") . ")";
                            }
                            $totalvat = $outputlangs->transcountrynoentities("TotalLT1", $mysoc->country_code) . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transcountrynoentities("TotalLT1", $mysoc->country_code) : '');
                            $totalvat .= ' ';
                            $totalvat .= vatrate(abs($tvakey), 1) . $tvacompl;
                            $pdf->MultiCell($col2x - $col1x, $tab2_hl, number_format($totalvat,2), 0, 'L', 1);
                            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                            $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($tvaval, 0, $outputlangs),2), 0, 'R', 1);
                        }
                    }
                }
                //}
                //Local tax 2 after VAT
                //if (!empty($conf->global->FACTURE_LOCAL_TAX2_OPTION) && $conf->global->FACTURE_LOCAL_TAX2_OPTION=='localtax2on')
                //{
                foreach ($this->localtax2 as $localtax_type => $localtax_rate) {
                    if (in_array((string) $localtax_type, array('2', '4', '6'))) {
                        continue;
                    }
                    foreach ($localtax_rate as $tvakey => $tvaval) {
                        // retrieve global local tax
                        if ($tvakey != 0) { // On affiche pas taux 0
                            //$this->atleastoneratenotnull++;
                            $index++;
                            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                            $tvacompl = '';
                            if (preg_match('/\*/', $tvakey)) {
                                $tvakey = str_replace('*', '', $tvakey);
                                $tvacompl = " (" . $outputlangs->transnoentities("NonPercuRecuperable") . ")";
                            }
                            $totalvat = $outputlangs->transcountrynoentities("TotalLT2", $mysoc->country_code) . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transcountrynoentities("TotalLT2", $mysoc->country_code) : '');
                            $totalvat .= ' ';
                            $totalvat .= vatrate(abs($tvakey), 1) . $tvacompl;
                            $pdf->MultiCell($col2x - $col1x, $tab2_hl, number_format($totalvat,2), 0, 'L', 1);
                            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                            //$pdf->MultiCell($largcol2, $tab2_hl, number_format(price($tvaval, 0, $outputlangs),2), 0, 'R', 1);
                            
                            $pdf->MultiCell($largcol2,$tab2_hl, number_format(price($total_ht + (!empty($object->remise) ? number_format($object->remise,2) : 0), 0, $outputlangs),2), 0, 'R', 1);
                        }
                    }
                }
                //}
                // Total TTC
                $index++;
                $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
                $pdf->SetTextColor(0, 0, 60);
                $pdf->SetFillColor(224, 224, 224);
                $pdf->MultiCell($col2x - $col1x, $tab2_hl, $outputlangs->transnoentities("TotalTTC") . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transnoentities("TotalTTC") : ''), $useborder, 'L', 1);
                $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
                $pdf->MultiCell($largcol2, $tab2_hl, number_format(price($total_ttc, 0, $outputlangs),2), $useborder, 'R', 1);
            }
        }
        $pdf->SetTextColor(0, 0, 0);
        $resteapayer = 0;
        /*
        $resteapayer = $object->total_ttc - $deja_regle;
        if (!empty($object->paye)) $resteapayer=0;
         */
        if ($deja_regle > 0) {
            // Already paid + Deposits
            $index++;
            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($col2x - $col1x, $tab2_hl, $outputlangs->transnoentities("AlreadyPaid") . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transnoentities("AlreadyPaid") : ''), 0, 'L', 0);
            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($largcol2, $tab2_hl, price($deja_regle, 0, $outputlangs), 0, 'R', 0);
            /*
            if ($object->close_code == 'discount_vat')
            {
            $index++;
            $pdf->SetFillColor(255,255,255);
            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($col2x - $col1x, $tab2_hl, $outputlangs->transnoentities("EscompteOfferedShort"), $useborder, 'L', 1);
            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($largcol2, $tab2_hl, price($object->total_ttc - $deja_regle, 0, $outputlangs), $useborder, 'R', 1);
            $resteapayer=0;
            }
             */
            $index++;
            $pdf->SetTextColor(0, 0, 60);
            $pdf->SetFillColor(224, 224, 224);
            $pdf->SetXY($col1x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($col2x - $col1x, $tab2_hl, $outputlangs->transnoentities("RemainderToPay") . (is_object($outputlangsbis) ? ' / ' . $outputlangsbis->transnoentities("RemainderToPay") : ''), $useborder, 'L', 1);
            $pdf->SetXY($col2x, $tab2_top + $tab2_hl * $index);
            $pdf->MultiCell($largcol2, $tab2_hl, price($resteapayer, 0, $outputlangs), $useborder, 'R', 1);
            $pdf->SetFont('', '', $default_font_size - 1);
            $pdf->SetTextColor(0, 0, 0);
        }
        $index++;
        return ($tab2_top + ($tab2_hl * $index));
    }
    
    
    
    // phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
    /**
     *   Show table for lines
     *
     *   @param        TCPDF        $pdf             Object PDF
     *   @param        string        $tab_top        Top position of table
     *   @param        string        $tab_height        Height of table (rectangle)
     *   @param        int            $nexY            Y (not used)
     *   @param        Translate    $outputlangs    Langs object
     *   @param        int            $hidetop        1=Hide top bar of array and title, 0=Hide nothing, -1=Hide only title
     *   @param        int            $hidebottom        Hide bottom bar of array
     *   @param        string        $currency        Currency code
     *   @param        Translate    $outputlangsbis    Langs object bis
     *   @return    void
     */
    protected function _tableau(&$pdf, $tab_top, $tab_height, $nexY, $outputlangs, $hidetop = 0, $hidebottom = 0, $currency = '', $outputlangsbis = null)
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
        $pdf->SetFont('', '', $default_font_size - 2);

        //NOT USED - STOPPED
        if (empty($hidetop)) {
            $titre = $outputlangs->transnoentities("AmountInCurrency", $outputlangs->transnoentitiesnoconv("Currency" . $currency));
            if (getDolGlobalString('PDF_USE_ALSO_LANGUAGE_CODE') && is_object($outputlangsbis)) {
                $titre .= ' - ' . $outputlangsbis->transnoentities("AmountInCurrency", $outputlangsbis->transnoentitiesnoconv("Currency" . $currency));
            }
            $pdf->SetXY($this->page_largeur - $this->marge_droite - ($pdf->GetStringWidth($titre) + 3), $tab_top - 4);

            //$pdf->MultiCell(($pdf->GetStringWidth($titre) + 3), 2, $titre);
            //$conf->global->MAIN_PDF_TITLE_BACKGROUND_COLOR='230,230,230';
            if (getDolGlobalString('MAIN_PDF_TITLE_BACKGROUND_COLOR')) {
                $pdf->Rect($this->marge_gauche, $tab_top, $this->page_largeur - $this->marge_droite - $this->marge_gauche, $this->tabTitleHeight, 'F', null, explode(',', getDolGlobalString('MAIN_PDF_TITLE_BACKGROUND_COLOR')));
            }
        }
        $pdf->SetDrawColor(128, 128, 128);
        //$pdf->SetDrawColor(255, 0, 0);
        $pdf->SetFont('', '', $default_font_size - 1);
        // Output Rect
        $this->printRect($pdf, $this->marge_gauche, $tab_top, $this->page_largeur - $this->marge_gauche - $this->marge_droite, $tab_height, $hidetop, $hidebottom); // Rect takes a length in 3rd parameter and 4th parameter
        if (getDolGlobalString('MAIN_PDF_TITLE_TEXT_COLOR')) {
            $arrayColorTextTitle = explode(',', getDolGlobalString('MAIN_PDF_TITLE_TEXT_COLOR'));
            $pdf->SetTextColor($arrayColorTextTitle[0], $arrayColorTextTitle[1], $arrayColorTextTitle[2]);
        }

        $this->pdfTabTitles($pdf, $tab_top, $tab_height, $outputlangs, $hidetop);
        if (getDolGlobalString('MAIN_PDF_TITLE_TEXT_COLOR')) {
            $pdf->SetTextColor(0, 0, 0);
        }

        if (empty($hidetop)) {
            $pdf->line($this->marge_gauche, $tab_top + $this->tabTitleHeight, $this->page_largeur - $this->marge_droite, $tab_top + $this->tabTitleHeight); // line takes a position y in 2nd parameter and 4th parameter
        }
    }
    // phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
    /**
     *  Show top header of page.
     *
     *  @param    TCPDF        $pdf             Object PDF
     *  @param  Propal        $object         Object to show
     *  @param  int            $showaddress    0=no, 1=yes
     *  @param  Translate    $outputlangs    Object lang for output
     *  @param  Translate    $outputlangsbis    Object lang for output bis
     *  @return    float|int
     */
    protected function _pagehead(&$pdf, $object, $showaddress, $outputlangs, $outputlangsbis = null)
    {
        global $conf, $langs;
        //-----------------------------------------------
        $ltrdirection = 'L';
        if ($outputlangs->trans("DIRECTION") == 'rtl') {
            $ltrdirection = 'R';
        }
        // Load traductions files required by page
        $outputlangs->loadLangs(array("main", "propal", "companies", "bills"));
        $default_font_size = pdf_getPDFFontSize($outputlangs);
        pdf_pagehead($pdf, $outputlangs, $this->page_hauteur);
        $pdf->SetTextColor(0, 0, 60);
        $pdf->SetFont('', 'B', $default_font_size + 3);
        $w = 200;
        $posy = $this->marge_haute;
        $posx = $this->page_largeur - $this->marge_droite - $w;
        $pdf->SetXY($this->marge_gauche, $posy);
        // LOGO
        if (!getDolGlobalInt('PDF_DISABLE_MYCOMPANY_LOGO')) {
            if ($this->emetteur->logo) {
                $logodir = $conf->mycompany->dir_output;
                if (!empty($conf->mycompany->multidir_output[$object->entity])) {
                    $logodir = $conf->mycompany->multidir_output[$object->entity];
                }
                if (!getDolGlobalInt('MAIN_PDF_USE_LARGE_LOGO')) {
                    $logo = $logodir . '/logos/thumbs/' . $this->emetteur->logo_small;
                } else {
                    $logo = $logodir . '/logos/' . $this->emetteur->logo;
                }
                if (is_readable($logo)) {
                    $height = pdf_getHeightForLogo($logo);
                    $pdf->Image($logo, $this->marge_gauche, $posy, 0, $height - 7); // width=0 (auto)   //vsn reduce logo height -10
                } else {
                    $pdf->SetTextColor(200, 0, 0);
                    $pdf->SetFont('', 'B', $default_font_size - 2);
                    $pdf->MultiCell($w, 3, $outputlangs->transnoentities("ErrorLogoFileNotFound", $logo), 0, 'L');
                    $pdf->MultiCell($w, 3, $outputlangs->transnoentities("ErrorGoToGlobalSetup"), 0, 'L');
                }
            } else {
                $text = $this->emetteur->name;
               // $pdf->MultiCell($w, 4, $outputlangs->convToOutputCharset($text), 0, $ltrdirection);
            }
        }

        //VSN
        $posx = $this->marge_gauche; // Left margin
        $posy = $this->marge_haute;
        
        // 1. Print company name
        $pdf->SetXY($posx, $posy + 12); // Slight top margin
        $pdf->SetFont('', 'B', $default_font_size);
        $pdf->MultiCell(0, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, $ltrdirection);
        
        // 2. Prepare contact/address block
        $carac_emetteur = '';
        
        $arrayidcontact = $object->getIdContact('internal', 'SALESREPFOLL');
        if (count($arrayidcontact) > 0) {
            $object->fetch_user($arrayidcontact[0]);
            $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') || getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ' (' : '';
            $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') && !empty($object->user->office_phone)) ? $object->user->office_phone : '';
            $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') && getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ', ' : '';
            $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT') && !empty($object->user->email)) ? $object->user->email : '';
            $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') || getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ')' : '';
            $carac_emetteur .= "\n";
        }
        
        $carac_emetteur .= "19 Frankford Crescent, Unit # 4\n";
        $carac_emetteur .= "Trenton, Ontario, K8V 6H8 Canada\n";
        $carac_emetteur .= "Phone: +1 613 955 VAGA [8242]\n";
        $carac_emetteur .= "Email: info@vagainc.ca Web: www.vagainc.ca\n";
        
        // 3. Print address block below company name
        $pdf->SetFont('', '', $default_font_size - 1);
        $y_after_company = $pdf->GetY()-4; // Get current Y after company name
        $pdf->SetXY($posx, $y_after_company); // Add small space
        $pdf->MultiCell(0, 4, $carac_emetteur, 0, $ltrdirection);
        
        // 4. Update $posy based on final Y to avoid overlap with next table
        $posy = $pdf->GetY(); // Position for next content (like the table)
        
        

        //------------------------------------------------------------
        //TITLE WITH DRAFT STATUS (NOT VALIDATED)
        //------------------------------------------------------------

        $posy = $this->marge_haute;

        $pdf->SetXY($posx, $posy);
        $pdf->SetFont('', 'B', $default_font_size + 3);
        $pdf->SetXY($posx, $posy);
        $pdf->SetTextColor(0, 0, 60);
        $title = $outputlangs->transnoentities("PdfCommercialProposalTitle");
        $title .= ' ' . $outputlangs->convToOutputCharset($object->ref);
        if ($object->statut == $object::STATUS_DRAFT) {
            $pdf->SetTextColor(128, 0, 0);
            $title .= ' - ' . $outputlangs->transnoentities("NotValidated");
        }
        $pdf->MultiCell($w, 4, $title, '', 'R');
        $pdf->SetFont('', 'B', $default_font_size);

        //------------------------------------------------------------
        //REVISION
        //------------------------------------------------------------

        $pdf->SetFont('', '', $default_font_size);
        $pdf->SetFont('', '', $default_font_size - 2);
        //$posy += 4;
        $posy = $pdf->getY();
        $pdf->SetXY($posx, $posy);
       // $proposal_revision = '';
        if (!empty($object->array_options['options_proposalrevision'])) {
            $proposal_revision = $object->array_options['options_proposalrevision'];
            $pdf->MultiCell($w, 3, "Revision : " . $proposal_revision, '', 'R');
        }
        //------------------------------------------------------------
        // PROPOSAL CURRENT DATE
        //------------------------------------------------------------
        $pdf->SetFont('', '', $default_font_size);
        $pdf->SetFont('', '', $default_font_size - 2);
        if (getDolGlobalString('MAIN_PDF_DATE_TEXT')) {
            $displaydate = "daytext";
        } else {
            $displaydate = "day";
        }
        $posy += 4;
        //$posy = $pdf->getY();
        $pdf->SetXY($posx, $posy);
        $pdf->SetTextColor(0, 0, 60);
        $pdf->MultiCell($w, 3, $outputlangs->transnoentities("Date") . " : " . dol_print_date($object->date, $displaydate, false, $outputlangs, true), '', 'R');

        //------------------------------------------------------------
        // PROJECT TITLE
        //------------------------------------------------------------

        if (getDolGlobalString('PDF_SHOW_PROJECT_TITLE')) {
            $object->fetch_projet();
            if (!empty($object->project->ref)) {
                $posy += 4;
                $pdf->SetXY($posx, $posy);
                $pdf->SetTextColor(0, 0, 60);
                $pdf->MultiCell($w, 3, $outputlangs->transnoentities("Project") . " : " . (empty($object->project->title) ? '' : $object->project->title), '', 'R');
                //echo $outputlangs->transnoentities("Project")." : ".(empty($object->project->title) ? '' : $object->project->title);
            }
        }
        //------------------------------------------------------------
        // PROJECT REFERENCE
        //------------------------------------------------------------
        
        $pdf->SetFont('', '', $default_font_size);
        $pdf->SetFont('', '', $default_font_size - 2);
        if (getDolGlobalString('PDF_SHOW_PROJECT')) {
            $object->fetch_projet();
            if (!empty($object->project->ref)) {
                $outputlangs->load("projects");
                $posy += 4;
                $pdf->SetXY($posx, $posy);
                $pdf->SetTextColor(0, 0, 60);
                $pdf->MultiCell($w, 3, $outputlangs->transnoentities("RefProject") . " : " . (empty($object->project->ref) ? '' : $object->project->ref), '', 'R');

                //echo  $outputlangs->transnoentities("RefProject")." : ".(empty($object->project->ref) ? '' : $object->project->ref);
            }
        }
        //------------------------------------------------------------
        // CUSTOMER REFERENCE NUMBER
        //------------------------------------------------------------
        //$posy += 3;
        
        if ($object->ref_client) {
            $posy += 4;
            $pdf->SetXY($posx, $posy);
            $pdf->SetTextColor(0, 0, 60);
            $pdf->MultiCell($w, 3, $outputlangs->transnoentities("RefCustomer") . " : " . dol_trunc($outputlangs->convToOutputCharset($object->ref_client), 100), '', 'R');
        }

        //------------------------------------------------------------
        //CUSTOMER CODE
        //------------------------------------------------------------
        //if (!getDolGlobalString('MAIN_PDF_HIDE_CUSTOMER_CODE') && $object->thirdparty->code_client) {
        //    $posy += 4;
        //    $pdf->SetXY($posx, $posy);
        //    $pdf->SetTextColor(0, 0, 60);
        //    $pdf->MultiCell($w, 3, $outputlangs->transnoentities("CustomerCode")." : ".$outputlangs->transnoentities($object->thirdparty->code_client), '', 'R');
        //}

        //------------------------------------------------------------
        //PROPOSAL END DATE
        //------------------------------------------------------------
        $posy += 4;
        $pdf->SetXY($posx, $posy);
        $pdf->SetTextColor(0, 0, 60);
        $title = $outputlangs->transnoentities("DateEndPropal");
        if (getDolGlobalString('PDF_USE_ALSO_LANGUAGE_CODE') && is_object($outputlangsbis)) {
            $title .= ' - ' . $outputlangsbis->transnoentities("DateEndPropal");
        }
        $pdf->MultiCell($w, 3, $title . " : " . dol_print_date($object->fin_validite, $displaydate, false, $outputlangs, true), '', 'R');

        //// Get contact
        //if (getDolGlobalString('DOC_SHOW_FIRST_SALES_REP')) {
        //    $arrayidcontact = $object->getIdContact('internal', 'SALESREPFOLL');
        //    if (count($arrayidcontact) > 0) {
        //        $usertmp = new User($this->db);
        //        $usertmp->fetch($arrayidcontact[0]);
        //        $posy += 4;
        //        $pdf->SetXY($posx, $posy);
        //        $pdf->SetTextColor(0, 0, 60);
        //        //$pdf->MultiCell($w, 3, $langs->transnoentities("SalesRepresentative")." : ".$usertmp->getFullName($langs), '', 'R');
        //    }
        //}
        $posy += 5;
        $top_shift = 0;
        // Show list of linked objects
        $current_y = $pdf->getY();
        $posy = pdf_writeLinkedObjects($pdf, $object, $outputlangs, $posx, $posy, $w, 3, 'R', $default_font_size);
        if ($current_y < $pdf->getY()) {
            $top_shift = $pdf->getY() - $current_y;
        }

        //------------------------------------------------------------
        //CURRENCY
        //------------------------------------------------------------
        $pdf->SetXY($posx, $posy);
        $pdf->SetTextColor(0, 0, 60);
        $currency = !empty($currency) ? $currency : $conf->currency;
        $pdf->MultiCell($w, 3, "Currency: " . $outputlangs->transnoentitiesnoconv("Currency" . $currency), '', 'R');
        
        
        //-------------------------------------------------------
        // THIS SECTION IS FOR CUSTOMER CONTACT (LEFT SIDE FRAME)
        //-------------------------------------------------------
        if ($showaddress) {

            //If CUSTOMER contact defined, we use it
            $usecontact = false;
            $arrayidcontact = $object->getIdContact('external', 'CUSTOMER');
            if (count($arrayidcontact) > 0) {
                $usecontact = true;
                $result = $object->fetch_contact($arrayidcontact[0]);
            }

            // Recipient name
            if ($usecontact && ($object->contact->socid != $object->thirdparty->id && (!isset($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT) || getDolGlobalString('MAIN_USE_COMPANY_NAME_OF_CONTACT')))) {
                $thirdparty = $object->contact;
            } else {
                $thirdparty = $object->thirdparty;
            }

            $carac_client_name = pdfBuildThirdpartyName($thirdparty, $outputlangs);

            $mode = 'target'; //pdf.lib.php
            $carac_client = pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, ($usecontact ? $object->contact : ''), $usecontact, $mode, $object);

            // Show recipient
            $widthrecbox = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 82 : 90;
            if ($this->page_largeur < 210) {
                $widthrecbox = 84; // To work with US executive format
            }
            $posy = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 40 : 42;
            $posy += $top_shift + 16;
            //$posx = $this->page_largeur - $this->marge_droite - $widthrecbox;
            $posx = $this->marge_gauche;
            if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
                $posx = $this->marge_gauche;
            }
			
			// --------------------------------------
            // Show Customer frame
			// --------------------------------------
            if (!getDolGlobalString('MAIN_PDF_NO_RECIPENT_FRAME')) {
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('', 'B', $default_font_size - 1);
                $pdf->SetXY($posx + 0, $posy - 15);
                $pdf->SetFillColor(220, 220, 220); // RGB color
                $pdf->MultiCell($widthrecbox, 6, $outputlangs->transnoentities("CustomerInformation"), 1, $ltrdirection, '', 1);
                //$pdf->Rect($posx, $posy, $widthrecbox, $hautcadre);
                $posy = $posy - 10;
                $pdf->SetXY($posx, $posy);
                $hautcadre = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 34 : 36;
                $pdf->MultiCell($widthrecbox, $hautcadre, "", 0, 'R', 1);

                $widthrecbox = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 82 : 90;
                if ($this->page_largeur < 210) {
                    $widthrecbox = 80; // To work with US executive format
                }
                $pdf->Rect($posx, $posy, $widthrecbox, $hautcadre);
            }

            // Show customer name
            $pdf->SetXY($posx + 2, $posy + 3);
            $pdf->SetFont('', 'B', $default_font_size);
            $pdf->MultiCell($widthrecbox, 2, $carac_client_name, 0, $ltrdirection);

            $posy = $pdf->getY();

            // Show customer information
            $pdf->SetFont('', '', $default_font_size - 1);
            $pdf->SetXY($posx + 2, $posy);
            $pdf->MultiCell($widthrecbox, 4, $carac_client, 0, $ltrdirection);


			//var_dump($object);
			
            //------------------------------------------------------------
            //CUSTOMER CODE
            //------------------------------------------------------------
            if (!getDolGlobalString('MAIN_PDF_HIDE_CUSTOMER_CODE') && $object->thirdparty->code_client) {

                $pdf->SetXY($posx - 2, $posy + 24);
                //$pdf->SetTextColor(0, 0, 60);
                //$pdf->MultiCell($w, 3, $outputlangs->transnoentities("CustomerCode")." : ".$outputlangs->transnoentities($object->thirdparty->code_client), '', 'R');
               // $pdf->MultiCell($w, 4, $outputlangs->transnoentities("CustomerCode") . " : " . $outputlangs->transnoentities($object->thirdparty->code_client), '', 'R');
                $pdf->MultiCell($widthrecbox, 4, $outputlangs->transnoentities("CustomerCode") . ": " . $outputlangs->transnoentities($object->thirdparty->code_client), '', 'R');
            }

            //----------------------------
            // THIS SECTION IS FOR SALES CONTACT (RIGHT SIDE FRAME)
            //----------------------------
            
            // Sales contact
            if ($usecontact && ($object->contact->socid != $object->thirdparty->id && (!isset($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT) || getDolGlobalString('MAIN_USE_COMPANY_NAME_OF_CONTACT')))) {
                $thirdparty = $object->contact;
            } else {
                $thirdparty = $object->thirdparty;
            }

            $carac_client_name = pdfBuildThirdpartyName($thirdparty, $outputlangs);
            $mode = 'target';
            $carac_client = pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, ($usecontact ? $object->contact : ''), $usecontact, $mode, $object);
			
            // Show recipient
            $widthrecbox = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 92 : 100;
            if ($this->page_largeur < 210) {
                $widthrecbox = 80; // To work with US executive format
            }
            $posy = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 40 : 42;
            $posy += $top_shift + 5;
            $posx = $this->page_largeur - $this->marge_droite - $widthrecbox;
            if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
                $posx = $this->marge_gauche;
            }
			
            // Show recipient frame
            if (!getDolGlobalString('MAIN_PDF_NO_RECIPENT_FRAME')) {
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('', 'B', $default_font_size - 1);
                $pdf->SetXY($posx + 0, $posy - 4);
                $pdf->SetFillColor(230, 230, 230);
                $pdf->MultiCell($widthrecbox, 5, $outputlangs->transnoentities("SalesContact"), 1, $ltrdirection);
                $pdf->SetFont('', '', $default_font_size - 2);
                $pdf->Rect($posx, $posy + 1, $widthrecbox, $hautcadre);
            }

            // Show recipient name
            //$pdf->SetXY($posx + 2, $posy + 3);
            //$pdf->SetFont('', 'B', $default_font_size);
            //$pdf->MultiCell($widthrecbox, 2, $carac_client_name, 0, $ltrdirection);
            //
            //$posy = $pdf->getY();
            //
            //// Show recipient information
            //$pdf->SetFont('', '', $default_font_size - 1);
            //$pdf->SetXY($posx + 2, $posy);
            //$pdf->MultiCell($widthrecbox, 4, $carac_client, 0, $ltrdirection);
            
            //-------------------------------------------------------------------
            // Fetch the vaga sales representative name
            //-------------------------------------------------------------------
            
            $salesRepresentative = '';
            if (!empty($object->user)) {
                $salesRepresentative = $object->user->getFullName($outputlangs);
            }
            // Show sales representative information
            if (!empty($salesRepresentative)) {
                $pdf->SetXY($posx + 2, $pdf->getY() + 2);
                $pdf->SetFont('', 'B', $default_font_size);
                $pdf->MultiCell($widthrecbox, 4, "Name: " . $salesRepresentative, 0, $ltrdirection);

                $pdf->SetXY($posx + 2, $pdf->getY() + 4);
                $pdf->SetFont('', '', $default_font_size);
                $salesRepresentativeDesignation = $object->user->job;
                $salesRepresentativePhone = $object->user->office_phone;
                $salesRepresentativeMobile = $object->user->user_mobile;

                $pdf->MultiCell($widthrecbox, 4, "Designation: " . $salesRepresentativeDesignation, 0, $ltrdirection);
                $pdf->SetXY($posx + 2, $pdf->getY() + 4);
                $pdf->MultiCell($widthrecbox, 4, "Phone: " . $salesRepresentativePhone . "  Mobile:  " . $salesRepresentativeMobile, 0, $ltrdirection);

                $pdf->SetXY($posx + 2, $pdf->getY() + 4);
                $pdf->SetFont('', '', $default_font_size);
                $salesRepresentativeEmail = $object->user->email;
                $pdf->MultiCell($widthrecbox, 4, "Email: " . $salesRepresentativeEmail, 0, $ltrdirection);
                // $line_number=1;
                // $hhh1 = '<table border="1">
                //             <tr>
                //                 <th>Sl.#</th>
                //                 <th>Description</th>
                //                 <th>Qty.</th>
                //                 <th>UOM</th>
                //                 <th>Price</th>
                //                 <th>Total</th>
                //             </tr>';
                //
                // foreach ($object->lines as $line) {
                //     $hhh2 = $hhh2 .'<tr>
                //                 <td>' . $line_number++ . '</td>
                //                 <td>' . htmlentities($line->desc) . '<br><img src="' . $product_image . '" width="50" height="50"></td>
                //                 <td>' . htmlentities($this->printColDescContent($pdf, $curY, 'desc', $object, $i, $outputlangs, $hideref, $hidedesc)) . '<br><img src="' . $product_image . '" width="50" height="50"></td>
                //                 <td>' . $line->qty . '</td>
                //                 <td>PCS</td>
                //                 <td>' . $line->subprice . '</td>
                //                 <td>' . $line->total_ht . '</td>
                //             </tr>';
                // }
                //
                // $hhh3 = '</table>';
                // $pdf->writeHTMLCell(0, 0, '', '', $hhh1 .$hhh2 .$hhh3, 1, 1, 0, true, '', true);
            }

            // Representative following-up proposal information
            //$representative = $object->user->getFullName($outputlangs);
            //$pdf->SetXY($posx + 2, $posy + 4);
            //$pdf->SetFont('', 'B', $default_font_size);
            //$pdf->MultiCell($widthrecbox, 2, $representative, 0, $ltrdirection);
            //    // Sender properties
            //    $carac_emetteur = '';
            //    // Add internal contact of object if defined
            //    $arrayidcontact = $object->getIdContact('internal', 'SALESREPFOLL');
            //    if (count($arrayidcontact) > 0) {
            //        $object->fetch_user($arrayidcontact[0]);
            //        $labelbeforecontactname = ($outputlangs->transnoentities("FromContactName") != 'FromContactName' ? $outputlangs->transnoentities("FromContactName") : $outputlangs->transnoentities("Name"));
            //        $carac_emetteur .= ($carac_emetteur ? "\n" : '').$labelbeforecontactname." ".$outputlangs->convToOutputCharset($object->user->getFullName($outputlangs));
            //        $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') || getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ' (' : '';
            //        $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') && !empty($object->user->office_phone)) ? $object->user->office_phone : '';
            //        $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') && getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ', ' : '';
            //        $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT') && !empty($object->user->email)) ? $object->user->email : '';
            //        $carac_emetteur .= (getDolGlobalInt('PDF_SHOW_PHONE_AFTER_USER_CONTACT') || getDolGlobalInt('PDF_SHOW_EMAIL_AFTER_USER_CONTACT')) ? ')' : '';
            //        $carac_emetteur .= "\n";
            //    }
            //
            //    $carac_emetteur .= pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, '', 0, 'source', $object);
            //
            //    // Show sender
            //    $posy = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 40 : 42;
            //    $posy += $top_shift+15;
            //    $posx = $this->marge_gauche;
            //    if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
            //        $posx = $this->page_largeur - $this->marge_droite - 80;
            //    }
            //
            //    $hautcadre = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 38 : 40;
            //    $widthrecbox = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 92 : 82;
            //
            //    // Show sender frame
            //    if (!getDolGlobalString('MAIN_PDF_NO_SENDER_FRAME')) {
            //        $pdf->SetTextColor(0, 0, 0);
            //        $pdf->SetFont('', '', $default_font_size - 2);
            //        $pdf->SetXY($posx, $posy - 5);
            //        $pdf->MultiCell($widthrecbox, 5, $outputlangs->transnoentities("BillFrom"), 0, $ltrdirection);
            //        $pdf->SetXY($posx, $posy);
            //        $pdf->SetFillColor(230, 230, 230);
            //        $pdf->MultiCell($widthrecbox, $hautcadre, "", 0, 'R', 1);
            //
            //        /*vsn
            //        if ($usecontact && ($object->contact->socid != $object->thirdparty->id && (!isset($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT) || getDolGlobalString('MAIN_USE_COMPANY_NAME_OF_CONTACT')))) {
            //            $thirdparty = $object->contact;
            //        } else {
            //            $thirdparty = $object->thirdparty;
            //        }
            //        $carac_client_name = pdfBuildThirdpartyName($thirdparty, $outputlangs);
            //        $pdf->MultiCell($widthrecbox, $carac_client_name, "", 0, 'R', 1);
            //        */
            //
            //        $pdf->SetTextColor(0, 0, 60);
            //    }
            //
            //    // Show sender name
            //    if (!getDolGlobalString('MAIN_PDF_HIDE_SENDER_NAME')) {
            //        $pdf->SetXY($posx + 2, $posy + 3);
            //        $pdf->SetFont('', 'B', $default_font_size);
            //        $pdf->MultiCell($widthrecbox - 2, 4, $outputlangs->convToOutputCharset($this->emetteur->name), 0, $ltrdirection);
            //        $posy = $pdf->getY();
            //    }
            //
            //    // Show sender information
            //    $pdf->SetXY($posx + 2, $posy);
            //    $pdf->SetFont('', '', $default_font_size - 1);
            //    $pdf->MultiCell($widthrecbox - 2, 4, $carac_emetteur, 0, $ltrdirection);
            //    // If CUSTOMER contact defined, we use it
            //    $usecontact = false;
            //    $arrayidcontact = $object->getIdContact('external', 'CUSTOMER');
            //    if (count($arrayidcontact) > 0) {
            //        $usecontact = true;
            //        $result = $object->fetch_contact($arrayidcontact[0]);
            //    }
            //    // Recipient name
            //    if ($usecontact && ($object->contact->socid != $object->thirdparty->id && (!isset($conf->global->MAIN_USE_COMPANY_NAME_OF_CONTACT) || getDolGlobalString('MAIN_USE_COMPANY_NAME_OF_CONTACT')))) {
            //        $thirdparty = $object->contact;
            //    } else {
            //        $thirdparty = $object->thirdparty;
            //    }
            //
            //    $carac_client_name = pdfBuildThirdpartyName($thirdparty, $outputlangs);
            //
            //    $mode = 'target';
            //    $carac_client = pdf_build_address($outputlangs, $this->emetteur, $object->thirdparty, ($usecontact ? $object->contact : ''), $usecontact, $mode, $object);
            //
            //    // Show recipient
            //    $widthrecbox = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 92 : 100;
            //    if ($this->page_largeur < 210) {
            //        $widthrecbox = 84; // To work with US executive format
            //    }
            //    $posy = getDolGlobalString('MAIN_PDF_USE_ISO_LOCATION') ? 40 : 42;
            //    $posy += $top_shift+15;
            //    $posx = $this->page_largeur - $this->marge_droite - $widthrecbox;
            //    if (getDolGlobalString('MAIN_INVERT_SENDER_RECIPIENT')) {
            //        $posx = $this->marge_gauche;
            //    }
            //
            //    // Show recipient frame
            //    if (!getDolGlobalString('MAIN_PDF_NO_RECIPENT_FRAME')) {
            //        $pdf->SetTextColor(0, 0, 0);
            //        $pdf->SetFont('', '', $default_font_size - 2);
            //        $pdf->SetXY($posx + 2, $posy - 5);
            //        $pdf->MultiCell($widthrecbox, 5, $outputlangs->transnoentities("BillTo"), 0, $ltrdirection);
            //        $pdf->Rect($posx, $posy, $widthrecbox, $hautcadre);
            //    }
            //
            //    // Show recipient name
            //    $pdf->SetXY($posx + 2, $posy + 3);
            //    $pdf->SetFont('', 'B', $default_font_size);
            //    $pdf->MultiCell($widthrecbox, 2, $carac_client_name, 0, $ltrdirection);
            //
            //    $posy = $pdf->getY();
            //
            //    // Show recipient information
            //    $pdf->SetFont('', '', $default_font_size - 1);
            //    $pdf->SetXY($posx + 2, $posy);
            //    $pdf->MultiCell($widthrecbox, 4, $carac_client, 0, $ltrdirection);

        }

        $pdf->SetTextColor(255, 255, 255);
        return $top_shift;
    }
	
    // phpcs:disable PEAR.NamingConventions.ValidFunctionName.PublicUnderscore
    /**
     *      Show footer of page. Need this->emetteur object
     *
     *      @param    TCPDF        $pdf                 PDF
     *      @param    Propal        $object                Object to show
     *      @param    Translate    $outputlangs        Object lang for output
     *      @param    int            $hidefreetext        1=Hide free text
     *      @return    int                                Return height of bottom margin including footer text
     */
    protected function _pagefoot(&$pdf, $object, $outputlangs, $hidefreetext = 0)
    {
        $showdetails = getDolGlobalInt('MAIN_GENERATE_DOCUMENTS_SHOW_FOOT_DETAILS', 0);
        //remoove condtion after words purvesh
       // return pdf_pagefoot($pdf, $outputlangs, 'PROPOSAL_FREE_TEXT', $this->emetteur, $this->marge_basse, $this->marge_gauche, $this->page_hauteur, $object, $showdetails, $hidefreetext, $this->page_largeur, $this->watermark);
      global $conf;

    $pdf->SetY(-20); // Position from bottom
    $pdf->SetFont('helvetica', '', 7);
    $marge_gauche = $this->marge_gauche;
    $pageWidth = $pdf->getPageWidth();
    $marge_droite = $this->marge_droite;

    // Define your footer text (you can adjust line breaks and styling)
    $leftText = "Form # 1012/001/Vaga/2024-07-11/R0\n"
              . "Registered Office: VAGA Refrigeration Inc. | 19 Frankford Crescent, Unit # 4 K8V 6H8 Trenton ON Canada\n"
              . "Phone: +1 613 955 VAGA [8242] | www.vagainc.ca | info@vagainc.ca\n"
              . "Import / Export ID: 76378 1101 RM0001 | GST 76378 1101 RT0001";

    $rightText = "Page " . $pdf->getAliasNumPage() . "/" . $pdf->getAliasNbPages();

    // Left block (company footer)
    $pdf->SetXY($marge_gauche, -20);
    $pdf->MultiCell($pageWidth - $marge_gauche - $marge_droite - 30, 5, $leftText, 0, 'L');

    // Right corner (page number)
    $pdf->SetXY($pageWidth - $marge_droite - 30, -20);
    $pdf->MultiCell(30, 5, $rightText, 0, 'R');
    
    }
    /**
     *    Show area for the customer to sign
     *
     *    @param    TCPDF        $pdf            Object PDF
     *    @param  Propal        $object         Object proposal
     *    @param    int            $posy            Position depart
     *    @param    Translate    $outputlangs    Objet langs
     *    @return int                            Position pour suite
     */
    protected function drawSignatureArea(&$pdf, $object, $posy, $outputlangs)
    {
        $default_font_size = pdf_getPDFFontSize($outputlangs);
        $tab_top = $posy + 4;
        $tab_hl = 4;
        $posx = 120;
        $largcol = ($this->page_largeur - $this->marge_droite - $posx);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetXY($posx, $tab_top);
        $pdf->SetFont('', '', $default_font_size);
        $pdf->MultiCell($largcol, $tab_hl, "Proposal Accepted", 0, 'L', 1);
        $pdf->SetXY($posx, $tab_top + 4);
        $pdf->SetFont('', '', $default_font_size - 3);
        $pdf->MultiCell($largcol, $tab_hl, $outputlangs->transnoentities("ProposalCustomerSignature"), 0, 'L', 1);
        $pdf->SetXY($posx, $tab_top + $tab_hl + 6);
        $pdf->MultiCell($largcol, $tab_hl * 3, '', 1, 'R');
        if (getDolGlobalString('MAIN_PDF_PROPAL_USE_ELECTRONIC_SIGNING')) {
            $pdf->addEmptySignatureAppearance($posx, $tab_top + $tab_hl, $largcol, $tab_hl * 3);
        }
        return ($tab_hl * 8);
    }
	
     /*
     *  Define Array Column Field
     *  
     *  @param    Propal           $object         object proposal
     *  @param    Translate        $outputlangs    langs
     *  @param    int              $hidedetails    Do not show line details
     *  @param    int              $hidedesc       Do not show desc
     *  @param    int              $hideref        Do not show ref
     *  @return   void
     */
	 
    public function defineColumnField($object, $outputlangs, $hidedetails = 0, $hidedesc = 0, $hideref = 0)
    {
        global $conf, $hookmanager;
        // Default field style for content
        $this->defaultContentsFieldsStyle = array(
            'align' => 'R', // R,C,L
            'padding' => array(1, 0.5, 1, 0.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
        );
        // Default field style for content
        $this->defaultTitlesFieldsStyle = array(
            'align' => 'C', // R,C,L
            'padding' => array(0.5, 0, 0.5, 0), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
        );
        /*
         * For exemple
        $this->cols['theColKey'] = array(
        'rank' => $rank, // int : use for ordering columns
        'width' => 20, // the column width in mm
        'title' => array(
        'textkey' => 'yourLangKey', // if there is no label, yourLangKey will be translated to replace label
        'label' => ' ', // the final label : used fore final generated text
        'align' => 'L', // text alignement :  R,C,L
        'padding' => array(0.5,0.5,0.5,0.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
        ),
        'content' => array(
        'align' => 'L', // text alignement :  R,C,L
        'padding' => array(0.5,0.5,0.5,0.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
        ),
        );
         */
        $rank = 0; // do not use negative rank

        $this->cols['slno'] = array(
            'rank' => $rank,
            'width' => 10, // only for desc
            'status' => true,
            'title' => array(
                'textkey' => 'Sl #', // use lang key is usefull in somme case with module
                'align' => 'C',
                // 'textkey' => 'yourLangKey', // if there is no label, yourLangKey will be translated to replace label
                // 'label' => ' ', // the final label

                'padding' => array(0.5, 0.5, 0.5, 0.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
            ),
            'content' => array(
                'align' => 'L',
                'padding' => array(1, 0.5, 1, 1.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
            ),
        );

        $this->cols['desc'] = array(
            'rank' => $rank + 1,
            'width' => false, // only for desc
            'status' => true,
            'title' => array(
                'textkey' => 'Description', // use lang key is usefull in somme case with module
                'align' => 'C',
                // 'textkey' => 'yourLangKey', // if there is no label, yourLangKey will be translated to replace label
                // 'label' => ' ', // the final label

                'padding' => array(0.5, 0.5, 0.5, 0.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
            ),
            'content' => array(
                'align' => 'L',
                'padding' => array(1, 0.5, 1, 1.5), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
            ),
            'border-left' => true, // add left line separator
        );
        // Image of product
        $rank = $rank + 10;
        $this->cols['photo'] = array(
            'rank' => $rank,
            'width' => (!getDolGlobalString('MAIN_DOCUMENTS_WITH_PICTURE_WIDTH') ? 20 : $conf->global->MAIN_DOCUMENTS_WITH_PICTURE_WIDTH), // in mm
            'status' => false,
            'title' => array(
                'textkey' => 'Photo',
                'label' => 'Photo',
            ),
            'content' => array(
                'padding' => array(0, 0, 0, 0), // Like css 0 => top , 1 => right, 2 => bottom, 3 => left
            ),
            'border-left' => false, // remove left line separator
        );
        if (getDolGlobalString('MAIN_GENERATE_PROPOSALS_WITH_PICTURE') && !empty($this->atleastonephoto)) {
            $this->cols['photo']['status'] = true;
            $this->cols['photo']['border-left'] = true;
        }
        // $rank = $rank + 10;
        // $this->cols['vat'] = array(
        //     'rank' => $rank,
        //     'status' => false,
        //     'width' => 16, // in mm
        //     'title' => array(
        //         'textkey' => 'VAT'
        //     ),
        //     'border-left' => true, // add left line separator
        // );
        //
        // if (!getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT') && !getDolGlobalString('MAIN_GENERATE_DOCUMENTS_WITHOUT_VAT_COLUMN')) {
        //     $this->cols['vat']['status'] = true;
        // }
		
		
        $rank = $rank + 10;
        $this->cols['subprice'] = array(
            'rank' => $rank,
            'width' => 19, // in mm
            'status' => true,
            'title' => array(
                'textkey' => 'PriceUHT',
            ),
            'border-left' => true, // add left line separator
        );
		
		
        // Adapt dynamically the width of subprice, if text is too long.
        $tmpwidth = 0;
        $nblines = count($object->lines);
        for ($i = 0; $i < $nblines; $i++) {
            $tmpwidth2 = dol_strlen(dol_string_nohtmltag(pdf_getlineupexcltax($object, $i, $outputlangs, $hidedetails)));
            $tmpwidth = max($tmpwidth, $tmpwidth2);
        }
        if ($tmpwidth > 10) {
            $this->cols['subprice']['width'] += (2 * ($tmpwidth - 10));
        }
		
		// 	UNIT PRICE
        $rank = $rank + 9;
        $this->cols['unit'] = array(
            'rank' => $rank,
            'width' => 11, // in mm
            'status' => false,
            'title' => array(
                'textkey' => 'Unit',
            ),
            'border-left' => true, // add left line separator
        );
		
		// 	QTY
        $rank = $rank + 10;
        $this->cols['qty'] = array(
            'rank' => $rank,
            'width' => 16, // in mm
            'status' => true,
            'title' => array(
                'textkey' => 'Qty',
            ),
            'border-left' => true, // add left line separator
        );
		
		
		
        if (getDolGlobalInt('PRODUCT_USE_UNITS')) {
            $this->cols['unit']['status'] = true;
        }
        // $rank = $rank + 10;
        // $this->cols['discount'] = array(
        //     'rank' => $rank,
        //     'width' => 13, // in mm
        //     'status' => false,
        //     'title' => array(
        //         'textkey' => 'ReductionShort'
        //     ),
        //     'border-left' => true, // add left line separator
        // );
        // if ($this->atleastonediscount) {
        //     $this->cols['discount']['status'] = true;
        // }
		
		// TOTAL CAD COLUMN - USED ******************************
        $rank = $rank + 1000; // add a big offset to be sure is the last col because default extrafield rank is 100
        $this->cols['totalexcltax'] = array(
            'rank'    => $rank,
            'width'   => 18, // in mm   changed from 16 to 19 on 8th dec 2024 - VSN
            'status'  => !getDolGlobalString('PDF_PROPAL_HIDE_PRICE_EXCL_TAX') ? true : false,
            'title'   => array(
			'textkey' => 'TotalHTShort',
            ),
            'border-left' => true, // add left line separator
        );
		
        $rank = $rank + 1010; // add a big offset to be sure is the last col because default extrafield rank is 100
        $this->cols['totalincltax'] = array(
            'rank' => $rank,
            'width' => 20, // in mm
            'status' => !getDolGlobalString('PDF_PROPAL_SHOW_PRICE_INCL_TAX') ? false : true,
            'title' => array(
                'textkey' => 'TotalTTCShort',
            ),
            'border-left' => true, // add left line separator
        );
		
		
        // Add extrafields cols
        if (!empty($object->lines)) {
            $line = reset($object->lines);
            $this->defineColumnExtrafield($line, $outputlangs, $hidedetails);
        }
        $parameters = array(
            'object' => $object,
            'outputlangs' => $outputlangs,
            'hidedetails' => $hidedetails,
            'hidedesc' => $hidedesc,
            'hideref' => $hideref,
        );
		
        $reshook = $hookmanager->executeHooks('defineColumnField', $parameters, $this); // Note that $object may have been modified by hook
        if ($reshook < 0) {
            setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
        } elseif (empty($reshook)) {
            $this->cols = array_replace($this->cols, $hookmanager->resArray); // array_replace is used to preserve keys
        } else {
            $this->cols = $hookmanager->resArray;
        }
		
    }
}
