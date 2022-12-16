<?php
/**
 * [View] SubsiteMenu
 * [element] ツールバー用 テンプレート
 */
$this->BcBaser->css('SubsiteMenu.admin/subsite_menu', ['inline' => true]);
?>
<?php if (count($sites) >= 2): ?>
	<?php
	 // 現在のサイトIDがデータに含まれていない場合、セッションから取得する
	if (!isset($siteId) || !$siteId) {
		$siteId = $this->Session->read('Baser.viewConditions.ContentsAdminIndex.named.site_id');
	}
	// サブサイトリストのオプションにメインサイトを追加
	array_unshift($sites, $this->BcBaser->siteConfig['main_site_display_name']);
	?>
	<div class="bca-panel-box__inline-fields-item">
		<label class="bca-toolbar__logo-text bca-panel-box__inline-fields-title"><?php echo $siteId ? __d('baser', 'サブサイト') : __d('baser', 'メインサイト') ?></label>
		<?php
		$options = [
			'type' => 'select',
			'options' => $sites,
			'onChange' => 'location.href="/cmsadmin/contents/index/site_id:" + value;', // 選択時にそのサイトに移動する
		];
		if ($siteId !== false) {
			$options['selected'] = $siteId === null ? 0 : $siteId;
		}
		echo $this->BcForm->input('site_id', $options);
		?>
	</div>
	<div class="bca-panel-box__inline-fields-separator"></div>
<?php else : ?>
<?php endif;?>
