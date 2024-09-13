<?php

/**
 * Record Actions test class.
 *
 * @package   Tests
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 6.5 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace Tests\Base;

class C_RecordActions extends \Tests\Base
{
	/**
	 * Temporary record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordAccounts;
	/**
	 * Temporary record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordCampaigns;
	/**
	 * Temporary Contacts record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordContacts;
	/**
	 * Temporary Products record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordProducts;

	/** @var \Vtiger_Record_Model Temporary Documents record object. */
	protected static $recordDocuments;
	/**
	 * Temporary SQuotes record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordSQuotes;
	/**
	 * Temporary Leads record object.
	 *
	 * @var \Vtiger_Record_Model
	 */
	protected static $recordLeads;
	/**
	 * Temporary loremIpsum text.
	 *
	 * @var string
	 */
	protected static $loremIpsumText;
	/**
	 * Temporary loremIpsum html.
	 *
	 * @var string
	 */
	protected static $loremIpsumHtml;

	/**
	 * Load lorem ipsum clear text for tests.
	 *
	 * @return string
	 */
	public static function createLoremIpsumText()
	{
		if (self::$loremIpsumText) {
			return self::$loremIpsumText;
		}
		return self::$loremIpsumText = \file_get_contents('./tests/data/stringText.txt');
	}

	/**
	 * Load lorem ipsum html text for tests.
	 *
	 * @return string
	 */
	public static function createLoremIpsumHtml()
	{
		if (self::$loremIpsumHtml) {
			return self::$loremIpsumHtml;
		}
		return self::$loremIpsumHtml = \file_get_contents('./tests/data/stringHtml.txt');
	}

	/**
	 * Creating leads module record for tests.
	 *
	 * @var bool
	 *
	 * @param mixed $cache
	 *
	 * @return \Vtiger_Record_Model
	 */
	public static function createLeadRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordLeads && $cache) {
			return self::$recordLeads;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Leads');
		$recordModel->set('company', 'TestLead sp. z o.o.');
		$recordModel->set('description', 'autogenerated test lead for \App\TextParser tests');
		$recordModel->set('assigned_user_id', \App\User::getCurrentUserId());
		$recordModel->save();
		if ($cache) {
			self::$recordLeads = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Creating contacts module record for tests.
	 *
	 * @param mixed $cache
	 *
	 * @return \Vtiger_Record_Model
	 */
	public static function createContactRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordContacts && $cache) {
			return self::$recordContacts;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Contacts');
		$recordModel->set('salutationtype', 'Mr.');
		$recordModel->set('firstname', 'Test');
		$recordModel->set('lastname', 'Testowy');
		$recordModel->set('contactstatus', 'Active');
		$recordModel->set('verification', 'Address details');
		$recordModel->set('parent_id', self::createAccountRecord()->getId());
		$recordModel->set('assigned_user_id', \App\User::getCurrentUserId());
		$recordModel->save();
		if ($cache) {
			self::$recordContacts = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Creating account module record for tests.
	 *
	 * @var bool
	 *
	 * @param mixed $cache
	 */
	public static function createAccountRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordAccounts && $cache) {
			return self::$recordAccounts;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Accounts');
		$recordModel->set('accountname', 'YetiForce S.A.');
		$recordModel->set('legal_form', 'PLL_COMPANY');
		$recordModel->save();
		if ($cache) {
			self::$recordAccounts = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Creating SQuotes module record for tests.
	 *
	 * @var bool
	 *
	 * @param mixed $cache
	 */
	public static function createSQuotesRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordSQuotes && $cache) {
			return self::$recordSQuotes;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('SQuotes');
		$recordModel->set('subject', 'System CRM YetiForce');
		$recordModel->setInventoryItemPart(1, 'name', self::createProductRecord()->getId());
		$recordModel->setInventoryItemPart(1, 'discountmode', 1);
		$recordModel->setInventoryItemPart(1, 'taxmode', 1);
		$recordModel->setInventoryItemPart(1, 'currency', 1);
		$recordModel->setInventoryItemPart(1, 'qty', 2);
		$recordModel->setInventoryItemPart(1, 'price', 5);
		$recordModel->setInventoryItemPart(1, 'total', 10);
		$recordModel->setInventoryItemPart(1, 'discount', 0);
		$recordModel->setInventoryItemPart(1, 'net', 10);
		$recordModel->setInventoryItemPart(1, 'purchase', 0);
		$recordModel->setInventoryItemPart(1, 'marginp', 0);
		$recordModel->setInventoryItemPart(1, 'margin', 0);
		$recordModel->setInventoryItemPart(1, 'tax', 0);
		$recordModel->setInventoryItemPart(1, 'gross', 10);
		$recordModel->setInventoryItemPart(1, 'comment1', '');
		$recordModel->save();
		if ($cache) {
			self::$recordSQuotes = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Creating Product module record for tests.
	 *
	 * @var bool
	 *
	 * @param mixed $cache
	 */
	public static function createProductRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordProducts && $cache) {
			return self::$recordProducts;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Products');
		$recordModel->set('productname', 'System CRM YetiForce');
		$recordModel->set('discontinued', 1);
		$recordModel->set('unit_price', '{"currencies":{"1":{"price":"2222"}},"currencyId":1}');
		$recordModel->set('pscategory', 'T3');
		$recordModel->set('imagename', '[]');
		$recordModel->save();
		if ($cache) {
			self::$recordProducts = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Creating Documents module record for tests.
	 *
	 * @var bool
	 *
	 * @param mixed $cache
	 */
	public static function createDocumentsRecord($cache = true): \Vtiger_Record_Model
	{
		if (self::$recordDocuments && $cache) {
			return self::$recordDocuments;
		}
		$recordModel = \Vtiger_Record_Model::getCleanInstance('Documents');
		$path = \App\Fields\File::getTmpPath() . 'phpunit.xml';
		copy(ROOT_DIRECTORY . '/tests/phpunit.xml', $path);
		$file = \App\Fields\File::loadFromPath($path);
		$fileName = $file->getName();
		$recordModel->set('notes_title', $fileName);
		$recordModel->set('filename', $fileName);
		$recordModel->set('filestatus', 1);
		$recordModel->set('filelocationtype', 'I');
		$recordModel->file = [
			'name' => $fileName,
			'size' => $file->getSize(),
			'type' => $file->getMimeType(),
			'tmp_name' => $file->getPath(),
			'error' => 0,
		];
		$recordModel->save();
		if ($cache) {
			self::$recordDocuments = $recordModel;
		}
		return $recordModel;
	}

	/**
	 * Testing the record creation.
	 */
	public function testCreateRecord()
	{
		$record = self::createAccountRecord();
		self::assertIsInt($record->getId());
		self::assertSame('Accounts', $record->getModuleName());
		self::createSQuotesRecord();
		$record = self::createSQuotesRecord();
		self::assertIsInt($record->getId());
		self::assertSame('SQuotes', $record->getModuleName());
		self::assertNotEmpty($record->getInventoryData());
		self::createDocumentsRecord();
		self::createDocumentsRecord();
	}

	/**
	 * Testing editing permissions.
	 */
	public function testPermission()
	{
		$this->assertTrue(self::$recordAccounts->isEditable());
		$this->assertTrue(self::$recordAccounts->isCreateable());
		$this->assertTrue(self::$recordAccounts->isViewable());
		$this->assertFalse(self::$recordAccounts->privilegeToActivate());
		$this->assertTrue(self::$recordAccounts->privilegeToArchive());
		$this->assertTrue(self::$recordAccounts->privilegeToMoveToTrash());
		$this->assertTrue(self::$recordAccounts->privilegeToDelete());
	}

	/**
	 * Testing the edit block feature.
	 */
	public function testCheckLockFields()
	{
		$this->assertFalse(self::$recordAccounts->isLockByFields());
	}

	/**
	 * Testing record editing.
	 */
	public function testEditRecord()
	{
		self::$recordAccounts->set('accounttype', 'Customer');
		self::$recordAccounts->save();
		$this->assertTrue((new \App\Db\Query())->from('vtiger_account')->where(['account_type' => 'Customer'])->exists());
	}

	/**
	 * Testing the record label.
	 */
	public function testGetDisplayName()
	{
		$this->assertTrue('YetiForce S.A.' === self::$recordAccounts->getDisplayName());
	}

	/**
	 * Testing the change record state.
	 */
	public function testStateRecord()
	{
		self::$recordAccounts->changeState('Trash');
		$this->assertSame(1, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => self::$recordAccounts->getId()])->scalar());
		self::$recordAccounts->changeState('Archived');
		$this->assertSame(2, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => self::$recordAccounts->getId()])->scalar());
		self::$recordAccounts->changeState('Active');
		$this->assertSame(0, (new \App\Db\Query())->select(['deleted'])->from('vtiger_crmentity')->where(['crmid' => self::$recordAccounts->getId()])->scalar());
	}
}
