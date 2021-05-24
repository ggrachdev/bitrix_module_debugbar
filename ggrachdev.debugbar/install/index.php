<?php

global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang) - strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang . "/lang/", "/install/index.php"));

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

class ggrachdev_debugbar extends CModule {

    public $MODULE_ID = "ggrachdev.debugbar";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS = "Y";

    function __construct() {

        $arModuleVersion = [];

        if (file_exists(__DIR__ . "/version.php")) {
            require(__DIR__ . "/version.php");
        }

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("GGRACHDEV_DEBUGBAR_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("GGRACHDEV_DEBUGBAR_DESCRIPTION");
        $this->MODULE_GROUP_RIGHTS = "N";
        $this->PARTNER_NAME = Loc::getMessage("GGRACHDEV_DEBUGBAR_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("GGRACHDEV_DEBUGBAR_PARTNER_URI");
    }

    public function DoInstall() {

        if (PHP_VERSION_ID >= 70200) {

            if (CheckVersion(ModuleManager::getVersion("main"), "17.00.00")) {
                global $DB, $APPLICATION, $step;

                $step = IntVal($step);

                $this->installAssets();

                ModuleManager::registerModule($this->MODULE_ID);
            } else {
                throw new SystemException(Loc::getMessage("GGRACHDEV_ERROR_BITRIX_VERSION"));
            }
        } else {
            throw new SystemException(Loc::getMessage("GGRACHDEV_ERROR_PHP_VERSION"));
        }

//        $APPLICATION->IncludeAdminFile(Loc::getMessage("FORM_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/ggrach.debugpanel/install/step1.php");
    }

    public function DoUninstall() {
        global $DB, $APPLICATION, $step;

        $this->reinstallAssets();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        $step = IntVal($step);
//        $APPLICATION->IncludeAdminFile(Loc::getMessage("FORM_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/ggrach.debugpanel/install/unstep1.php");
    }

    public function installAssets() {

        // copy js
        $dirJsFrom = null;
        
        if(\is_file($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/{$this->MODULE_ID}/install/version.php"))
        {
            $dirJsFrom = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/js";
        }
        else if(\is_file($_SERVER["DOCUMENT_ROOT"] . "/local/modules/{$this->MODULE_ID}/install/version.php"))
        {
            $dirJsFrom = $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/js";
        }

        if ($dirJsFrom && !\is_dir($dirJsTo)) {
            \mkdir($dirJsTo);
        }

        \CopyDirFiles($dirJsFrom, $dirJsTo, true, true);

        // copy css
        $dirCssTo = null;
        
        if(\is_file($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/{$this->MODULE_ID}/install/version.php"))
        {
            $dirCssFrom = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/css";
        }
        else if(\is_file($_SERVER["DOCUMENT_ROOT"] . "/local/modules/{$this->MODULE_ID}/install/version.php"))
        {
            $dirCssFrom = $_SERVER["DOCUMENT_ROOT"] . "/local/modules/" . $this->MODULE_ID . "/install/css";
        }
        
        if ($dirCssTo && !\is_dir($dirCssTo)) {
            \mkdir($dirCssTo);
        }

        \CopyDirFiles($dirCssFrom, $dirCssTo, true, true);
    }

    public function reinstallAssets() {

        // delete js
        $dirJs = "/bitrix/js/" . $this->MODULE_ID;
        if (!\is_dir($dirJs)) {
            \DeleteDirFilesEx($dirJs);
        }

        // delete css
        $dirCss = "/bitrix/css/" . $this->MODULE_ID;
        if (!\is_dir($dirCss)) {
            \DeleteDirFilesEx($dirCss);
        }
    }

}

?>