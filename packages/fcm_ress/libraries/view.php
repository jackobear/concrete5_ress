<?php

defined('C5_EXECUTE') or die("Access Denied.");
class View extends Concrete5_Library_View {

		public function checkMobileView() {

			// Add RESS functionality using as described here: http://www.netmagazine.com/tutorials/getting-started-ress
			// We're using mobile-detect rather than WURFL: http://code.google.com/p/php-mobile-detect/wiki/Mobile_Detect

			// Load the ress js

			$html = Loader::helper('html');
			$this->addHeaderItem('<script type="text/javascript" src="' . DIR_REL . '/packages/fcm_ress/js/ress.js"></script>');

			// If the ress js detected the viewport width and saved it to a cookie, we should use that rather than the server side detection

			$RESSCookie = $_COOKIE['RESS'];
			if ($RESSCookie) {
			    $RESSValues = explode('|', $RESSCookie);
			    $featureCapabilities;
			    foreach ($RESSValues as $RESSValue) {
			        $capability = explode('.', $RESSValue);
			        $featureCapabilities[$capability[0]] = $capability[1];
			    }
			}
			if($featureCapabilities["width"]){
				if($featureCapabilities["width"] <= 600 && $featureCapabilities["width"] > 0){
					define('IS_MOBILE',true);
					define('IS_TABLET',false);
					define('IS_DESKTOP',false);
				}else if($featureCapabilities["width"] < 960){
					define('IS_MOBILE',false);
					define('IS_TABLET',true);
					define('IS_DESKTOP',false);
				}else{
					define('IS_MOBILE',false);
					define('IS_TABLET',false);
					define('IS_DESKTOP',true);
				}
			}else{

				// Now check mobile-detect for device category (phone/tablet/desktop) as a fallback...this is needed on the first page load
				// or if js or cookies are disabled...the cookie should have precedence

				Loader::library('3rdparty/mobile_detect');
				$md = new Mobile_Detect();
				if($md->isTablet()){
					define('IS_MOBILE',false);
					define('IS_TABLET',true);
					define('IS_DESKTOP',false);
				}else if($md->isMobile()){
					define('IS_MOBILE',true);
					define('IS_TABLET',false);
					define('IS_DESKTOP',false);
				}else{
					define('IS_MOBILE',false);
					define('IS_TABLET',false);
					define('IS_DESKTOP',true);
				}
			}

			// Continue with the legacy version of this function

			if(isset($_COOKIE['ccmDisableMobileView']) && $_COOKIE['ccmDisableMobileView'] == true) {
				define('MOBILE_THEME_IS_ACTIVE', false);
				return false; // break out if we've said we don't want the mobile theme
			}

			$page = Page::getCurrentPage();
			if($page instanceof Page && $page->isAdminArea()) {
				define('MOBILE_THEME_IS_ACTIVE', false);
				return false; // no mobile theme for the dashboard
			}

			if (IS_MOBILE) {
				$themeId = Config::get('MOBILE_THEME_ID');
				if ($themeId > 0) {
					$mobileTheme = PageTheme::getByID($themeId);
					if($mobileTheme instanceof PageTheme) {
						define('MOBILE_THEME_IS_ACTIVE',true);
						// we have to grab the instance of the view
						// since on_page_view doesn't give it to us
						$this->setTheme($mobileTheme);
					}
				}
			}

			if (!defined('MOBILE_THEME_IS_ACTIVE')) {
				define('MOBILE_THEME_IS_ACTIVE', false);
			}

		}
}