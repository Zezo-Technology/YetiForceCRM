<?php
/**
 * Dav public file.
 *
 * @license YetiForce Public License 6.5 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce S.A.
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
chdir(__DIR__ . '/../');
if (!\defined('IS_PUBLIC_DIR')) {
	\define('IS_PUBLIC_DIR', true);
}
require 'dav.php';
