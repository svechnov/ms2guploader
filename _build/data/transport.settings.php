<?php

$settings = array();

$tmp = array(
  'core_path' => array(
    'xtype' => 'textfield',
    'value' => PKG_CORE_PATH,
    'area' => 'ms2guploader.main',
  ),
  'assets_url' => array(
    'xtype' => 'textfield',
    'value' => PKG_ASSETS_URL,
    'area' => 'ms2guploader.main',
  ),
  'frontend_css' => array(
    'xtype' => 'textfield',
    'value' => PKG_ASSETS_URL . 'css/web/ms2guploader.css',
    'area' => 'ms2guploader.main',
  ),
  'frontend_js' => array(
    'xtype' => 'textfield',
    'value' => PKG_ASSETS_URL . 'js/web/ms2guploader.js',
    'area' => 'ms2guploader.main',
  ),
  'disable_htmlpurifier' => array(
    'xtype' => 'combo-boolean',
    'value' =>  true,
    'area' => 'ms2guploader.main',
  ),
  'mail_bcc' => array(
    'xtype' => 'textfield',
    'value' => '0',
    'area' => 'ms2guploader.mail',
  ),
  'mail_from' => array(
    'xtype' => 'textfield',
    'value' => '',
    'area' => 'ms2guploader.mail',
  ),
  'mail_from_name' => array(
    'xtype' => 'textfield',
    'value' => '',
    'area' => 'ms2guploader.mail',
  ),
  'mail_createdby' => array(
    'xtype' => 'combo-boolean',
    'value' => true,
    'area' => 'ms2guploader.mail',
  ),
);


foreach ($tmp as $k => $v) {
  /* @var modSystemSetting $setting */
  $setting = $modx->newObject('modSystemSetting');
  $setting->fromArray(array_merge(
    array(
      'key' => 'ms2guploader_' . $k,
      'namespace' => PKG_NAME_LOWER,
    ), $v
  ), '', true, true);

  $settings[] = $setting;
}

unset($tmp);
return $settings;
