<?php
/* Copyright (C) 2024 Your Company
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

/**
 * Custom module to sync proposal changes to sales orders
 * Place this file in: htdocs/custom/proposalsync/class/actions_proposalsync.class.php
 */

class ActionsProposalSync
{
    public $db;
    public $conf;
    public $langs;
    public $user;

    public function __construct($db)
    {
        $this->db = $db;
        global $conf, $langs, $user;
        $this->conf = $conf;
        $this->langs = $langs;
        $this->user = $user;
    }

    /**
     * Hook executed after proposal update
     */
    public function doActions($parameters, &$object, &$action, $hookmanager)
    {
        global $conf, $user, $langs;

        $error = 0;
        $errors = array();

        $contexts = explode(':', $parameters['context']);

    //   print_r($_GET);
    //   exit();

        if (in_array('commandecard', $contexts) && 
        $action == 'add' && 
        !empty($_POST['origin']) && $_POST['origin'] == 'propal' && 
        !empty($_POST['originid'])) {
            echo "DASdasasd";
            exit();
        
        error_log("Calling establishProposalOrderRelationship on Create Draft");
        $this->establishProposalOrderRelationship($object, $_POST['originid']);
    }

        if (in_array('propalcard', $contexts) && !empty($_GET['origin']) && $_GET['origin'] == 'propal' && !empty($_GET['originid'])) {
            echo "DASdadasd";
            exit();
            $this->establishProposalOrderRelationship($object, $_GET['originid']);
        }


        if (in_array('propalcard', $contexts)) {
           
            $this->establishProposalOrderRelationship($object, $_GET['originid']);
          
            if ($action == 'validate' && get_class($object) == 'Propal') {
                $this->syncProposalToSalesOrder($object);
            }
        }

        if (!$error) {
            return 0;
        } else {
            $this->errors = $errors;
            return -1;
        }
    }

    /**
     * Establish relationship between proposal and newly created sales order
     */
    private function establishProposalOrderRelationship($salesorder, $proposal_id)
    {
        // Update the sales order to track which proposal it came from
        $sql = "UPDATE " . MAIN_DB_PREFIX . "commande";
        $sql .= " SET fk_propal_origin = " . intval($proposal_id);
        $sql .= " WHERE rowid = " . $salesorder->id;
        
        $this->db->query($sql);

    }


    /**
     * Sync proposal changes to related sales orders
     */
    private function syncProposalToSalesOrder($proposal)
    {
        dol_syslog("ActionsProposalSync::syncProposalToSalesOrder Starting sync for proposal ID: " . $proposal->id);

        // Find related sales orders
        $sql = "SELECT rowid FROM " . MAIN_DB_PREFIX . "commande";
        $sql .= " WHERE fk_propal_origin = " . ((int) $proposal->id);
        $sql .= " AND entity IN (" . getEntity('commande') . ")";
        $resql = $this->db->query($sql);
        if ($resql) {
            while ($obj = $this->db->fetch_object($resql)) {
                $this->updateSalesOrder($obj->rowid, $proposal);
            }
            $this->db->free($resql);
        } else {
            dol_print_error($this->db);
        }
    }

    /**
     * Update sales order with proposal data
     */

    private function updateSalesOrder($sales_order_id, $proposal)
    {
        require_once DOL_DOCUMENT_ROOT . '/commande/class/commande.class.php';

        $salesorder = new Commande($this->db);
        $result = $salesorder->fetch($sales_order_id);

        if ($result > 0) {
            dol_syslog("ActionsProposalSync::updateSalesOrder Updating sales order ID: " . $sales_order_id);

            // Store original status
            $original_status = $salesorder->statut;
        
            $status_changed = false;

            // Check if order needs to be set to draft for line modifications
        

            if ($original_status != Commande::STATUS_DRAFT) {
                dol_syslog("ActionsProposalSync::updateSalesOrder Order status is " . $original_status . ", setting to draft for line modifications");
            
                // Set to draft to allow line modifications
            //  $result_status = $salesorder->set_draft($this->user);
                $result_status = $salesorder->setStatut(Commande::STATUS_DRAFT);
                if ($result_status < 0) {
                    setEventMessages('Error setting sales order to draft: ' . implode(', ', $salesorder->errors), null, 'errors');
                    dol_syslog("ActionsProposalSync::updateSalesOrder Error setting to draft: " . implode(', ', $salesorder->errors), LOG_ERR);
                    return;
                }
                $status_changed = true;
                dol_syslog("ActionsProposalSync::updateSalesOrder Successfully set order to draft status");
            }

            // Update basic fields
            $salesorder->cond_reglement_id = $proposal->cond_reglement_id;
            $salesorder->selectmode_reglement_id = $proposal->selectmode_reglement_id;
            $salesorder->availability_id = $proposal->availability_id;
            $salesorder->shipping_method_id = $proposal->shipping_method_id;
            $salesorder->demand_reason_id = $proposal->demand_reason_id;
            $salesorder->incoterm_id = $proposal->incoterm_id;
            $salesorder->location_incoterms = $proposal->location_incoterms;
            $salesorder->array_options = $proposal->array_options;

            // Handle line items synchronization
            if (count($proposal->lines) > 0) {
                // First, delete all existing lines in reverse order
                if (!empty($salesorder->lines)) {
                    // Sort lines by rang in descending order to delete from bottom to top
                    $lines_to_delete = $salesorder->lines;
                    usort($lines_to_delete, function($a, $b) {
                        return $b->rang - $a->rang;
                    });
                    
                    foreach ($lines_to_delete as $line) {
                        $delete_result = $salesorder->deleteline($this->user, $line->id);
                        if ($delete_result < 0) {
                            dol_syslog("Error deleting line ID " . $line->id . ": " . implode(', ', $salesorder->errors), LOG_ERR);
                        } else {
                            dol_syslog("Successfully deleted line ID: " . $line->id, LOG_INFO);
                        }
                    }
                }

                // Refresh the sales order to get updated line structure
                $salesorder->fetch_lines();

                // Add new lines from proposal
                foreach ($proposal->lines as $line) {
                    $result_line = $salesorder->addline(
                        $line->desc,                   // Description
                        $line->subprice,               // Unit price
                        $line->qty,                    // Quantity
                        $line->tva_tx,                 // VAT rate
                        $line->localtax1_tx,           // Local tax 1
                        $line->localtax2_tx,           // Local tax 2
                        $line->fk_product,             // Product ID
                        $line->remise_percent,         // Discount percent
                        $line->info_bits,              // Info bits
                        $line->fk_remise_except,       // Discount exception
                        'HT',                          // Price base
                        0,                             // TMP - deprecated parameter
                        $line->date_start,             // Start date
                        $line->date_end,               // End date
                        $line->product_type,           // Product type
                        $line->rang,                   // Position/rank
                        $line->special_code,           // Special code
                        $line->fk_parent_line,         // Parent line
                        $line->fk_fournprice,          // Supplier price
                        $line->pa_ht,                  // Purchase price
                        $line->label,                  // Label
                        $line->array_options,          // Extra fields
                        '',                            // Supplier ref
                        $line->fk_unit,                // Unit
                        $line->multicurrency_subprice, // Multicurrency unit price
                        0,                             // Origin
                        1,                             // Origin ID
                        $line->multicurrency_total_ht, // Multicurrency total HT
                        $line->multicurrency_total_tva // Multicurrency total VAT
                    );
                    
                    if ($result_line < 0) {
                        dol_syslog("Error adding line: " . implode(', ', $salesorder->errors), LOG_ERR);
                        setEventMessages('Error adding line: ' . implode(', ', $salesorder->errors), null, 'errors');
                    } else {
                        dol_syslog("Successfully added line with ID: " . $result_line, LOG_INFO);
                    }
                }
            }

            // Update totals after line modifications
            $salesorder->update_price(1);

            // Save the sales order
            $result = $salesorder->update($this->user, 1);

            if ($result > 0) {
                // Restore original status if it was changed
                if ($status_changed && $original_status != Commande::STATUS_DRAFT) {
                    switch ($original_status) {
                        case Commande::STATUS_VALIDATED:
                            $restore_result = $salesorder->valid($this->user);
                            if ($restore_result < 0) {
                                dol_syslog("Warning: Could not restore order to validated status: " . implode(', ', $salesorder->errors), LOG_WARNING);
                            } else {
                                dol_syslog("Successfully restored order to validated status", LOG_INFO);
                            }
                            break;
                        case Commande::STATUS_SHIPMENTONPROCESS:
                            // For shipment in process, we may need special handling
                            dol_syslog("Order was in shipment process status - leaving in current state", LOG_INFO);
                            break;
                        default:
                            dol_syslog("Order had status " . $original_status . " - leaving in current state", LOG_INFO);
                            break;
                    }
                }

                // Add success message
                setEventMessages('Sales Order ' . $salesorder->ref . ' has been automatically updated from Proposal ' . $proposal->ref, null, 'mesgs');
                
                // Log the sync action
                $this->logSyncAction($sales_order_id, $proposal->id, 'SUCCESS - Fields and line items synced');
                dol_syslog("ActionsProposalSync::updateSalesOrder Successfully synced proposal to sales order", LOG_INFO);
            } else {
                // Add error message
                setEventMessages('Error syncing to Sales Order: ' . implode(', ', $salesorder->errors), null, 'errors');
                
                $this->logSyncAction($sales_order_id, $proposal->id, 'ERROR: ' . implode(', ', $salesorder->errors));
                dol_syslog("ActionsProposalSync::updateSalesOrder Error syncing: " . implode(', ', $salesorder->errors), LOG_ERR);
            }
        } else {
            dol_syslog("ActionsProposalSync::updateSalesOrder Could not fetch sales order ID: " . $sales_order_id, LOG_ERR);
        }
    }

    /**
     * Log sync actions for audit trail
     */
    private function logSyncAction($sales_order_id, $proposal_id, $status)
    {
        $sql = "INSERT INTO " . MAIN_DB_PREFIX . "proposal_sync_log";
        $sql .= " (sales_order_id, proposal_id, sync_date, sync_status, user_id)";
        $sql .= " VALUES (" . ((int) $sales_order_id) . ", " . ((int) $proposal_id) . ", '" . $this->db->idate(dol_now()) . "', '" . $this->db->escape($status) . "', " . ((int) $this->user->id) . ")";

        $this->db->query($sql);
    }

}


?>