# PRODUCT CUSTOM REFERENCE NUMBER FOR [DOLIBARR ERP CRM](https://www.dolibarr.org)

## Features

Introducing the Product Custom Reference Number feature for Dolibarr ERP CRM, designed to enhance your product management capabilities. This innovative tool allows you to assign unique reference numbers to new products, empowering you to streamline inventory tracking and management.

When creating a new product in Dolibarr ERP CRM, users can select from various product types. Upon selection, the Product Custom Reference Number feature dynamically displays a customizable reference number field. This field enables users to input or generate unique identifiers tailored to their organizational needs. Whether utilizing alphanumeric codes, barcode integration, or specific product identifiers, this feature ensures precise identification and efficient tracking of products throughout their lifecycle.

<!--
![Screenshot productcustomreferencenumber](img/screenshot_productcustomreferencenumber.png?raw=true "ProductCustomReferenceNumber"){imgmd}
-->

Other external modules are available on [Dolistore.com](https://www.dolistore.com).

## Translations

Translations can be completed manually by editing files into directories *langs*.

<!--
This module contains also a sample configuration for Transifex, under the hidden directory [.tx](.tx), so it is possible to manage translation using this service.

For more information, see the [translator's documentation](https://wiki.dolibarr.org/index.php/Translator_documentation).

There is a [Transifex project](https://transifex.com/projects/p/dolibarr-module-template) for this module.
-->


## Installation

Prerequisites: You must have the Dolibarr ERP CRM software installed. You can down it from [Dolistore.org](https://www.dolibarr.org).
You can also get a ready to use instance in the cloud from htts://saas.dolibarr.org


### From the ZIP file and GUI interface

If the module is a ready to deploy zip file, so with a name module_xxx-version.zip (like when downloading it from a market place like [Dolistore](https://www.dolistore.com)),
go into menu ```Home - Setup - Modules - Deploy external module``` and upload the zip file.

Note: If this screen tell you that there is no "custom" directory, check that your setup is correct:

<!--

- In your Dolibarr installation directory, edit the ```htdocs/conf/conf.php``` file and check that following lines are not commented:

    ```php
    //$dolibarr_main_url_root_alt ...
    //$dolibarr_main_document_root_alt ...
    ```

- Uncomment them if necessary (delete the leading ```//```) and assign a sensible value according to your Dolibarr installation

    For example :

    - UNIX:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = '/var/www/Dolibarr/htdocs/custom';
        ```

    - Windows:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = 'C:/My Web Sites/Dolibarr/htdocs/custom';
        ```
-->

<!--

### From a GIT repository

Clone the repository in ```$dolibarr_main_document_root_alt/productcustomreferencenumber```

```sh
cd ....../custom
git clone git@github.com:gitlogin/productcustomreferencenumber.git productcustomreferencenumber
```

-->

### Final steps

From your browser:

  - Log into Dolibarr as a super-administrator
  - Go to "Setup" -> "Modules"
  - You should now be able to find and enable the module



## Licenses

### Main code

GPLv3 or (at your option) any later version. See file COPYING for more information.

### Documentation

All texts and readmes are licensed under GFDL.
