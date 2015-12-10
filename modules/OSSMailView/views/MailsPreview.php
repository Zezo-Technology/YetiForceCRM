<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

Class OSSMailView_MailsPreview_View extends Vtiger_IndexAjax_View
{

	public function checkPermission(Vtiger_Request $request)
	{
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());
		if (!$permission) {
			throw new NoPermittedException('LBL_PERMISSION_DENIED');
		}

		$srecord = $request->get('srecord');
		$smodule = $request->get('smodule');

		$recordPermission = Users_Privileges_Model::isPermitted($smodule, 'DetailView', $srecord);
		if (!$recordPermission) {
			throw new NoPermittedToRecordException('LBL_NO_PERMISSIONS_FOR_THE_RECORD');
		}
	}

	public function process(Vtiger_Request $request)
	{
		$moduleName = $request->getModule();
		$srecord = $request->get('srecord');
		$smodule = $request->get('smodule');
		$type = $request->get('type');
		$mode = $request->get('mode');
		$record = $request->get('record');
		$mailFilter = $request->get('mailFilter');
		$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
		$recordModel_OSSMailScanner = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
		$config = $recordModel_OSSMailScanner->getConfig('email_list');
		$config['widget_limit'] = '';

		$viewer = $this->getViewer($request);
		$viewer->assign('RECOLDLIST', $recordModel->$mode($srecord, $smodule, $config, $type, $mailFilter));
		$viewer->assign('SENDURLDDATA', $urldata);
		$viewer->assign('MODULENAME', $moduleName);
		$viewer->assign('SMODULENAME', $smodule);
		$viewer->assign('RECORD', $record);
		$viewer->assign('SRECORD', $srecord);
		$viewer->assign('TYPE', $type);
		$viewer->assign('POPUP', $config['popup']);
		$viewer->view('MailsPreview.tpl', 'OSSMailView');
	}
}
