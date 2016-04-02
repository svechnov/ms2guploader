<?php
$ms2Gallery = $modx->getService('ms2gallery', 'ms2Gallery', MODX_CORE_PATH . 'components/ms2gallery/model/ms2gallery/');
$ms2guploader = $modx->getService('ms2guploader', 'ms2guploader', $modx->getOption('ms2guploader_core_path', null, $modx->getOption('core_path') . 'components/ms2guploader/') . 'model/ms2guploader/', $scriptProperties);
$config = $ms2guploader->initialize($modx->context->key);
$data = $config;
if (empty($source)) {
  $source = $modx->getOption('ms2_product_source_default');
}
$ms2_product_thumbnail_size = $modx->getOption('ms2_product_thumbnail_size', $scriptProperties, $modx->getOption('ms2_product_thumbnail_size'));
$pid = !empty($_REQUEST['id']) ? (integer)$_REQUEST['id'] : 0;
if($pid != 0) $resource = $modx->getObject('Ticket', $pid);
if ($source = $modx->getObject('sources.modMediaSource', $source)) {
    $sourceProperties = $source->getPropertyList();
}
$q = $modx->newQuery('msResourceFile');
if($resource && !$resource->deleted){
    $q->where(array(
      'resource_id' => $pid
    , 'parent' => 0
    //, 'createdby' => $modx->user->id
    ));
}else{
    $q->where(array(
      'resource_id' => 0
      ,'parent' => 0
      ,'createdby' => $modx->user->id
    ));
}
$q->sortby('rank', 'ASC');
$collection = $modx->getIterator('msResourceFile', $q);
$files = '';
foreach ($collection as $item) {
    $item = $item->toArray();
    $thumb = $modx->getObject('msResourceFile', array('name' => $item['name'],'path' => $pid.'/'.$ms2_product_thumbnail_size.'/'));
    $item['thumb'] = $thumb->url;
    $tpl = $tplImage;
    $files .= $ms2guploader->getChunk($tpl, $item);
}
$data['files'] = $ms2guploader->getChunk($tplFiles, array('files' => $files));

//output
$output = $ms2guploader->getChunk('tpl.ms2guploader.uploader', $data);

return $output;