-- SQL script to create sync logging table
-- Place this file in: htdocs/custom/proposalsync/sql/llx_proposal_sync_log.sql

ALTER TABLE vg_commande ADD COLUMN fk_propal_origin INT(11) NULL DEFAULT NULL;
CREATE INDEX idx_commande_fk_fk_propal_origin ON vg_commande (fk_propal_origin);


CREATE TABLE vg_proposal_sync_log (
    rowid int(11) NOT NULL AUTO_INCREMENT,
    sales_order_id int(11) NOT NULL,
    proposal_id int(11) NOT NULL,
    sync_date datetime NOT NULL,
    sync_status varchar(255) NOT NULL,
    user_id int(11) NOT NULL,
    PRIMARY KEY (rowid),
    KEY idx_proposal_sync_log_so (sales_order_id),
    KEY idx_proposal_sync_log_prop (proposal_id),
    KEY idx_proposal_sync_log_date (sync_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;