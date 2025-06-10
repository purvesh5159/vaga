<?php
/**
 * Setup page for ProposalSync module
 */
require '../../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';

// Load translation files
$langs->loadLangs(array("admin", "other"));

// Access control
if (!$user->admin) accessforbidden();

$action = GETPOST('action', 'aZ09');

// Actions
if ($action == 'set') {
    $auto_sync = GETPOST('auto_sync', 'int');
    $res = dolibarr_set_const($db, "PROPOSALSYNC_AUTO_SYNC", $auto_sync, 'int', 0, '', $conf->entity);
    
    if ($res > 0) {
        setEventMessages($langs->trans("SetupSaved"), null, 'mesgs');
    } else {
        setEventMessages($langs->trans("Error"), null, 'errors');
    }
}

// Page header
llxHeader('', 'ProposalSync Setup');

$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php?restore_lastsearch_values=1">' . $langs->trans("BackToModuleList") . '</a>';
print load_fiche_titre('ProposalSync Setup', $linkback, 'title_setup');

print '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">';
print '<input type="hidden" name="token" value="' . newToken() . '">';
print '<input type="hidden" name="action" value="set">';

print '<table class="noborder centpercent">';
print '<tr class="liste_titre">';
print '<td>' . $langs->trans("Parameter") . '</td>';
print '<td>' . $langs->trans("Value") . '</td>';
print '</tr>';

// Auto sync option
print '<tr class="oddeven">';
print '<td>Enable automatic synchronization</td>';
print '<td>';
print '<input type="checkbox" name="auto_sync" value="1"';
if (!empty($conf->global->PROPOSALSYNC_AUTO_SYNC)) print ' checked';
print '> Automatically update sales orders when proposals are modified';
print '</td>';
print '</tr>';

print '</table>';

print '<div class="tabsAction">';
print '<input type="submit" class="button" value="' . $langs->trans("Save") . '">';
print '</div>';

print '</form>';

llxFooter();
$db->close();
?>