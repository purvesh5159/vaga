<?php
/* Copyright (C) 2024 Your Company
 *
 * Module descriptor for Proposal-Sales Order Sync
 * Place this file in: htdocs/custom/proposalsync/core/modules/modProposalSync.class.php
 */

include_once DOL_DOCUMENT_ROOT . '/core/modules/DolibarrModules.class.php';

class modProposalSync extends DolibarrModules
{
    public function __construct($db)
    {
        global $langs, $conf;

        $this->db = $db;

        $this->numero = 500001; // Unique module number
        $this->rights_class = 'proposalsync';
        $this->family = "other";
        $this->module_position = '90';
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Module to synchronize proposal changes to sales orders";
        $this->descriptionlong = "Automatically updates sales orders when their related proposals are modified";
        
        $this->editor_name = 'Your Company';
        $this->editor_url = 'https://yourcompany.com';
        
        $this->version = '1.0.0';
        $this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
        $this->picto = 'propal';

        // Module parts
        $this->module_parts = array(
            'hooks' => array('propalcard')
        );

        // Dependencies
        $this->depends = array('modPropale', 'modCommande');
        $this->requiredby = array();
        $this->conflictwith = array();

        // Constants
        $this->const = array();

        // Boxes
        $this->boxes = array();

        // Cronjobs
        $this->cronjobs = array();

        // Permissions
        $this->rights = array();

        // Menu entries
        $this->menu = array();
    }

    /**
     * Function called when module is enabled.
     */
    public function init($options = '')
    {
        global $conf, $langs, $user;

        $result = $this->_load_tables('/custom/proposalsync/sql/');
        if ($result < 0) {
            return -1;
        }

        return $this->_init($this->db, $options);
    }

    /**
     * Function called when module is disabled.
     */
    public function remove($options = '')
    {
        return $this->_remove($options);
    }
}
?>