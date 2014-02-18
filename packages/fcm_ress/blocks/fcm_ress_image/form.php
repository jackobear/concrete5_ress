<?php
defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$bf = null;
$bfo = null;
$bft = null;
$bfm = null;

if ($controller->getFileID() > 0) {
	$bf = $controller->getFileObject();
}
if ($controller->getFileOnstateID() > 0) {
	$bfo = $controller->getFileOnstateObject();
}

if ($controller->getTabletFileID() > 0) {
	$bft = $controller->getTabletFileObject();
}

if ($controller->getMobileFileID() > 0) {
	$bfm = $controller->getMobileFileObject();
}
?>
<div class="ccm-block-field-group">
<h4><?php echo t('Desktop Image')?></h4><br/>

<div class="clearfix">
	<label><?php echo t('Image')?></label>
	<div class="input">
		<?php echo $al->image('ccm-b-image', 'fID', t('Choose Image'), $bf, $args);?>
	</div>
</div>
<div class="clearfix">
	<label><?php echo t('Image On-State')?></label>
	<div class="input">
		<?php echo $al->image('ccm-b-image-onstate', 'fOnstateID', t('Choose Image On-State'), $bfo, $args);?>
	</div>
</div>

</div>


<div class="ccm-block-field-group">
<h4><?php echo t('Tablet Image')?></h4><br/>

<div class="clearfix">
	<label><?php echo t('Image')?></label>
	<div class="input">
		<?php echo $al->image('ccm-b-image-tablet', 'fIDTablet', t('Choose Image'), $bft, $args);?>
	</div>
</div>

</div>



<div class="ccm-block-field-group">
<h4><?php echo t('Mobile Image')?></h4><br/>

<div class="clearfix">
	<label><?php echo t('Image')?></label>
	<div class="input">
		<?php echo $al->image('ccm-b-image-mobile', 'fIDMobile', t('Choose Image'), $bfm, $args);?>
	</div>
</div>

</div>




<div class="ccm-block-field-group">
<h4><?php echo t('Link and Caption')?></h4><br/>

<div class="clearfix">
	<?php echo $form->label('linkType', t('Image Links to:'))?>
	<div class="input">
		<select name="linkType" id="linkType">
			<option value="0" <?php echo (empty($externalLink) && empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('Nothing')?></option>
			<option value="1" <?php echo (empty($externalLink) && !empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('Another Page')?></option>
			<option value="2" <?php echo (!empty($externalLink) ? 'selected="selected"' : '')?>><?php echo t('External URL')?></option>
		</select>
	</div>
</div>

<div id="linkTypePage" style="display: none;" class="clearfix">
	<?php echo $form->label('internalLinkCID', t('Choose Page:'))?>
	<div class="input">
		<?php echo  Loader::helper('form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
	</div>
</div>
<div id="linkTypeExternal" style="display: none;" class="clearfix">
	<?php echo $form->label('externalLink', t('URL:'))?>
	<div class="input">
	<?php echo  $form->text('externalLink', $externalLink, array('style' => 'width: 250px')); ?>
	</div>
</div>


<div class="clearfix">
	<?php echo $form->label('altText', t('Alt Text/Caption'))?>
	<div class="input">
		<?php echo  $form->text('altText', $altText, array('style' => 'width: 250px')); ?>
	</div>
</div>

</div>

