<?php
namespace TYPO3\CMS\Lang\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Sebastian Fischer <typo3@evoweb.de>
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
 * Model to contain all information from the form changing the selection of available languages
 *
 * @author Sebastian Fischer <typo3@evoweb.de>
 * @package TYPO3
 * @subpackage lang
 */
class LanguageSelectionForm extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * @var array
	 */
	protected $locale = array();

	/**
	 * Setter for the choosen locale
	 *
	 * @param array $locale all locale that were selected in the form
	 * @return void
	 */
	public function setLocale(array $locale) {
		$this->locale = $locale;
	}

	/**
	 * Getter for the choosen locale
	 *
	 * @return array
	 */
	public function getLocale() {
		return $this->locale;
	}
}

?>