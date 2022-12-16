<?php
/*
 * [Event] SubsiteMenu
 * ViewEventListener
 */
class SubsiteMenuViewEventListener extends BcViewEventListener
{
	public $events = [
		'leftOfToolbar',
	];

	public function leftOfToolbar(CakeEvent $event)
	{
		// 管理画面以外対象外
		if (!BcUtil::isAdminSystem()) {
			return;
		}
		$View = $event->subject();
		// ログイン画面も対象外
		if ($View->request->action == 'admin_login') {
			return;
		}
		// 設定の読み込み
		$settings = Configure::read('SubsiteMenu');
		// ログインユーザーとユーザーグループを取得
		$loginUserId = BcUtil::loginUser()['id'];
		$userGroupId = BcUtil::loginUserGroup()['id'];
		// 設定されているユーザーかユーザーグループならエレメントを呼び出す
		if (in_array($loginUserId, $settings['loginUser']) || in_array($userGroupId, $settings['loginUserGroup'])) {
			// 現在のサイトIDの取得
			$requestData = $View->request->data;
			$params = $View->request->params;
			if (!empty($requestData['Content']['site_id'])) {
				$siteId = $requestData['Content']['site_id'];
			} elseif (isset($params['named']) && isset($params['named']['site_id'])) {
				$siteId = $params['named']['site_id'];
			} elseif (isset($params['Site'])) {
				$siteId = $params['Site']['id'];
			} else {
				$siteId = isset($View->passedArgs['site_id']) ? strval($View->passedArgs['site_id']) : false;
			}
			// サブサイトリストの取得
			$Site = ClassRegistry::init('Site');
			$sites = $Site->find('list', ['fields' => ['Site.id','Site.title'], 'recursive' => -1]);

			echo $View->element('SubsiteMenu.toolbar_subsite', ['siteId' => $siteId, 'sites' => $sites]);
		}
		return true;

	}
}
