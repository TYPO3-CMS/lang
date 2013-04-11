<?php
namespace TYPO3\CMS\Lang\ViewHelpers\Be;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2013 Kai Vogel <kai.vogel@speedprogs.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * View helper which allows you to create extbase based modules in the style of TYPO3 default modules.
 * Note: This feature is experimental!
 *
 * = Examples =
 *
 * <code title="Simple">
 * <f:be.container>your module content</f:be.container>
 * </code>
 * <output>
 * "your module content" wrapped with propper head & body tags.
 * Default backend CSS styles and JavaScript will be included
 * </output>
 *
 * <code title="All options">
 * <f:be.container pageTitle="foo" enableJumpToUrl="false" enableClickMenu="false" loadPrototype="false" loadScriptaculous="false" loadJQuery="false" scriptaculousModule="someModule,someOtherModule" loadExtJs="true" loadExtJsTheme="false" extJsAdapter="jQuery" enableExtJsDebug="true" addCssFile="{f:uri.resource(path:'styles/backend.css')}" addJsFile="{f:uri.resource(path:'scripts/main.js')}">your module content</f:be.container>
 * </code>
 * <output>
 * "your module content" wrapped with propper head & body tags.
 * Custom CSS file EXT:your_extension/Resources/Public/styles/backend.css and JavaScript file EXT:your_extension/Resources/Public/scripts/main.js will be loaded
 * </output>
 */
class ContainerViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper {

	/**
	 * Render start page with template.php and pageTitle
	 *
	 * @param string  $pageTitle title tag of the module. Not required by default, as BE modules are shown in a frame
	 * @param boolean $enableJumpToUrl If TRUE, includes "jumpTpUrl" javascript function required by ActionMenu. Defaults to TRUE
	 * @param boolean $enableClickMenu If TRUE, loads clickmenu.js required by BE context menus. Defaults to TRUE
	 * @param boolean $loadPrototype specifies whether to load prototype library. Defaults to TRUE
	 * @param boolean $loadScriptaculous specifies whether to load scriptaculous libraries. Defaults to FALSE
	 * @param string  $scriptaculousModule additionales modules for scriptaculous
	 * @param boolean $loadExtJs specifies whether to load ExtJS library. Defaults to FALSE
	 * @param boolean $loadExtJsTheme whether to load ExtJS "grey" theme. Defaults to FALSE
	 * @param string  $extJsAdapter load alternative adapter (ext-base is default adapter)
	 * @param boolean $enableExtJsDebug if TRUE, debug version of ExtJS is loaded. Use this for development only
	 * @param boolean $loadJQuery whether to load jQuery library. Defaults to FALSE
	 * @param array $addCssFiles Custom CSS files to be loaded
	 * @param array $addJsFiles Custom JavaScript files to be loaded
	 * @param array $addJsInlineLabels Custom labels to add to JavaScript inline labels
	 * @return string
	 * @see template
	 * @see \TYPO3\CMS\Core\Page\PageRenderer
	 */
	public function render($pageTitle = '', $enableJumpToUrl = TRUE, $enableClickMenu = TRUE, $loadPrototype = TRUE, $loadScriptaculous = FALSE, $scriptaculousModule = '', $loadExtJs = FALSE, $loadExtJsTheme = TRUE, $extJsAdapter = '', $enableExtJsDebug = FALSE, $loadJQuery = FALSE, $addCssFiles = NULL, $addJsFiles = NULL, $addJsInlineLabels = NULL) {
		$doc = $this->getDocInstance();
		$pageRenderer = $doc->getPageRenderer();
		if ($enableJumpToUrl) {
			$doc->JScode .= '
				<script language="javascript" type="text/javascript">
					script_ended = 0;
					function jumpToUrl(URL)	{
						document.location = URL;
					}
					' . $doc->redirectUrls() . '
				</script>
			';
		}
		if ($enableClickMenu) {
			$doc->loadJavascriptLib('js/clickmenu.js');
		}
		if ($loadPrototype) {
			$pageRenderer->loadPrototype();
		}
		if ($loadScriptaculous) {
			$pageRenderer->loadScriptaculous($scriptaculousModule);
		}
		if ($loadExtJs) {
			$pageRenderer->loadExtJS(TRUE, $loadExtJsTheme, $extJsAdapter);
			if ($enableExtJsDebug) {
				$pageRenderer->enableExtJsDebug();
			}
		}
		if ($loadJQuery) {
			$pageRenderer->loadJquery(NULL, NULL, $pageRenderer::JQUERY_NAMESPACE_DEFAULT_NOCONFLICT);
		}
		if (is_array($addCssFiles)) {
			foreach ($addCssFiles as $addCssFile) {
				$pageRenderer->addCssFile($addCssFile);
			}
		}
		if (is_array($addJsFiles)) {
			foreach ($addJsFiles as $addJsFile) {
				$pageRenderer->addJsFile($addJsFile);
			}
		}
		if (is_array($addJsInlineLabels)) {
			$extensionKey = $this->controllerContext->getRequest()->getControllerExtensionKey();
			foreach ($addJsInlineLabels as $key) {
				$label = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, $extensionKey);
				$pageRenderer->addInlineLanguageLabel($key, $label);
			}
		}
		$output = $this->renderChildren();
		$output = $doc->startPage($pageTitle) . $output;
		$output .= $doc->endPage();
		return $output;
	}

}
?>