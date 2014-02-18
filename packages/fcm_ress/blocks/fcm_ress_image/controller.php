<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	class FcmRessImageBlockController extends BlockController {

		protected $btInterfaceWidth = 400;
		protected $btInterfaceHeight = 550;
		protected $btTable = 'btFcmRessImage';
		protected $btCacheBlockRecord = false;
		protected $btCacheBlockOutput = false;
		protected $btCacheBlockOutputOnPost = false;
		protected $btCacheBlockOutputForRegisteredUsers = false;
		protected $btWrapperClass = 'ccm-ui';
		protected $btExportFileColumns = array('fID','fOnstateID','fIDTablet','fOnstateIDTablet','fIDMobile','fOnstateIDMobile');

		/**
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("Adds RESS images to pages based on whether the user is using Mobile, Tablet or Desktop.");
		}

		public function getBlockTypeName() {
			return t("RESS Image");
		}

		public function getJavaScriptStrings() {
			return array(
				'image-required' => t('You must select an image.'),
				'tablet-image-required' => t('You must select a Tablet image.'),
				'mobile-image-required' => t('You must select a Mobile image.')
			);
		}


		function getFileID() {return $this->fID;}
		function getTabletFileID() {return $this->fIDTablet;}
		function getMobileFileID() {return $this->fIDMobile;}

		function getFileOnstateID() {return $this->fOnstateID;}

		function getFileOnstateObject() {
			if ($this->fOnstateID > 0) {
				return File::getByID($this->fOnstateID);
			}
		}

		function getFileObject() {
			return File::getByID($this->fID);
		}
		function getTabletFileObject() {
			return File::getByID($this->fIDTablet);
		}
		function getMobileFileObject() {
			return File::getByID($this->fIDMobile);
		}

		function getAltText() {return $this->altText;}
		function getExternalLink() {return $this->externalLink;}
		function getInternalLinkCID() {return $this->internalLinkCID;}
		function getLinkURL() {
			if (!empty($this->externalLink)) {
				return $this->externalLink;
			} else if (!empty($this->internalLinkCID)) {
				$linkToC = Page::getByID($this->internalLinkCID);
				return (empty($linkToC) || $linkToC->error) ? '' : Loader::helper('navigation')->getLinkToCollection($linkToC);
			} else {
				return '';
			}
		}

		function save($args) {
			$args['fOnstateID'] = ($args['fOnstateID'] != '') ? $args['fOnstateID'] : 0;

			$args['fID'] = ($args['fID'] != '') ? $args['fID'] : 0;
			$args['fIDTablet'] = ($args['fIDTablet'] != '') ? $args['fIDTablet'] : 0;
			$args['fIDMobile'] = ($args['fIDMobile'] != '') ? $args['fIDMobile'] : 0;

			switch (intval($args['linkType'])) {
				case 1:
					$args['externalLink'] = '';
					break;
				case 2:
					$args['internalLinkCID'] = 0;
					break;
				default:
					$args['externalLink'] = '';
					$args['internalLinkCID'] = 0;
					break;
			}
			unset($args['linkType']); //this doesn't get saved to the database (it's only for UI usage)
			parent::save($args);
		}

		function getContentAndGenerate($align = false, $style = false, $id = null) {
			$c = Page::getCurrentPage();
			$bID = $this->bID;

			$f = null;
			$onstate = null;
			$fos = null;
			if(defined('IS_TABLET') && IS_TABLET){
				$f = $this->getTabletFileObject();
			}else if(defined('IS_MOBILE') && IS_MOBILE){
				$f = $this->getMobileFileObject();
			}else{
				$f = $this->getFileObject();
				$onstate = $this->fOnstateID;
				$fos = $this->getFileOnstateObject();
			}
			$fullPath = $f->getPath();
			$relPath = $f->getRelativePath();
			$size = @getimagesize($fullPath);
			if (empty($size)) {
				echo t( 'Image Not Found. ');
			    return '';
			}

			$img = "<img border=\"0\" class=\"ccm-image-block\" alt=\"{$this->altText}\" src=\"{$relPath}\" {$sizeStr} ";
			$img .= ($align) ? "align=\"{$align}\" " : '';

			$img .= ($style) ? "style=\"{$style}\" " : '';

			if($onstate != 0) {
				$fullPathOnstate = $f->getPath();
				$sizehover = @getimagesize($fullPathOnstate);

				if(IS_DESKTOP && is_object($fos)){
					$relPathHover = $fos->getRelativePath();
					$img .= " onmouseover=\"this.src = '{$relPathHover}'\" ";
					$img .= " onmouseout=\"this.src = '{$relPath}'\" ";
				}
			}

			$img .= ($id) ? "id=\"{$id}\" " : "";
			$img .= "/>";

			$linkURL = $this->getLinkURL();
			if (!empty($linkURL)) {
				$img = "<a href=\"{$linkURL}\">" . $img ."</a>";
			}
			return $img;
		}

	}
