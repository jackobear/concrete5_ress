<?php
defined('C5_EXECUTE') or die(_("Access Denied."));

class FcmRessPackage extends Package {

	protected $pkgHandle = 'fcm_ress';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '0.9.1';

	public function getPackageName() {
		return t("Improved Mobile Optimization with RESS");
	}

	public function getPackageDescription() {
		return t("Improved Mobile Optimization using both server and client side detection (RESS).  See INSTALL.txt for installation instructions.");
	}

	public function install() {
    $pkg = parent::install();
    BlockType::installBlockTypeFromPackage('fcm_ress_image', $pkg);
	}

}