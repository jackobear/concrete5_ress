<?php

defined('C5_EXECUTE') or die("Access Denied.");

abstract class PageCache extends Concrete5_Library_PageCache {

	public function shouldAddToCache(View $v) {

		if(IS_MOBILE){
			// Since mobile view looks different, don't cache here
			return false;
		}

		$c = $v->getCollectionObject();
		if (!is_object($c)) {
			return false;
		}

		$cp = new Permissions($c);
		if (!$cp->canViewPage()) {
			return false;
		}

		$u = new User();

		$allowedControllerActions = array('view');
		if (is_object($v->controller)) {
			if (!in_array($v->controller->getTask(), $allowedControllerActions)) {
				return false;
			}
		}

		if (!$c->getCollectionFullPageCaching()) {
			return false;
		}

		if ($u->isRegistered() || $_SERVER['REQUEST_METHOD'] == 'POST') {
			return false;
		}

		if ($c->isGeneratedCollection()) {
			if ((is_object($v->controller) && (!$v->controller->supportsPageCache())) || (!is_object($v->controller))) {
				return false;
			}
		}

		if ($c->getCollectionFullPageCaching() == 1 || FULL_PAGE_CACHE_GLOBAL === 'all') {
			// this cache page at the page level
			// this overrides any global settings
			return true;
		}

		if (FULL_PAGE_CACHE_GLOBAL !== 'blocks') {
			// we are NOT specifically caching this page, and we don't
			return false;
		}

		$blocks = $c->getBlocks();
		array_merge($c->getGlobalBlocks(), $blocks);

		foreach($blocks as $b) {
			$controller = $b->getInstance();
			if (!$controller->cacheBlockOutput()) {
				return false;
			}
		}
		return true;
	}


}