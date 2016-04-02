<?php
if (empty($_REQUEST['action'])) {
  die('Access denied');
}
else {
  $action = $_REQUEST['action'];
}

define('MODX_API_MODE', true);

$productionIndex = dirname(dirname(dirname(dirname(__FILE__)))). '/index.php';
$developmentIndex = dirname(dirname(dirname(dirname(dirname(__FILE__))))). '/index.php';
if (file_exists($productionIndex)){
  require_once $productionIndex;
}else{
  require_once $developmentIndex;
}

$modx->getService('error', 'error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

$ctx = !empty($_REQUEST['ctx']) ? $_REQUEST['ctx'] : 'web';
if ($ctx != 'web') {
  $modx->switchContext($ctx);
}

$properties = array();
if (!empty($_REQUEST['form_key']) && isset($_SESSION['ms2guploader'][$_REQUEST['form_key']])) {
  $properties = $_SESSION['ms2guploader'][$_REQUEST['form_key']];
} else{
  $message = 'Error missing $_REQUEST[form_key] or not find this in session data';
  $modx->log(modX::LOG_LEVEL_ERROR, $message);
  die($message);
}

/* @var ms2guploader $ms2guploader */
$ms2guploader = $modx->getService('ms2guploader', 'ms2guploader', $modx->getOption('ms2guploader_core_path', null, $modx->getOption('core_path') . 'components/ms2guploader/') . 'model/ms2guploader/', $properties);

if ($modx->error->hasError() || !($ms2guploader instanceof ms2guploader)) {
  die('Error');
}
switch ($action) {
  case 'config/get': $response = $_SESSION['ms2guploader'][$_REQUEST['form_key']]; break;
  case 'gallery/upload': $response = $ms2guploader->fileUpload($_POST);break;
  case 'gallery/delete': $response = $ms2guploader->fileDelete($_POST['id']); break;
  case 'gallery/sort': $response = $ms2guploader->fileSort($_POST['rank']);break;

 /* case 'product/getlist_tag': $response = $ms2guploader->getListTag($_POST); break;
  case 'product/getlist_category': $response = $ms2guploader->getListCategory($_POST); break;
  case 'product/update':
  case 'product/save': $response = $ms2guploader->productSave($_POST); break;
  case 'category/create': $response = $ms2guploader->categoryCreate($_POST); break; */
  default:
    $message = $_REQUEST['action'] != $action ? 'tickets_err_register_globals' : 'tickets_err_unknown';
    $response = $modx->toJSON(array('success' => false, 'message' => $modx->lexicon($message)));
}

if (is_array($response)) {
  $response = $modx->toJSON($response);
}

@session_write_close();
exit($response);
