<?php

$properties = array();

$tmp = array(
  'tplCreate' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.create',
  ),
  'tplUpdate' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.update',
  ),
  'tplSectionRow' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.section.row',
  ),
  'tplTagRow' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.tag.row',
  ),
  'allowFiles' => array(
    'type' => 'combo-boolean',
    'value' => true,
  ),
  'tplFiles' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.files',
  ),
  'tplFile' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.file',
  ),
  'tplImage' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.image',
  ),
  'tplEmailBcc' => array(
    'type' => 'textfield',
    'value' => 'tpl.ms2guploader.email.bcc',
  ),
  'allowedFields' => array(
    'type' => 'textfield',
    'value' => 'parent,pagetitle,content,published,template,hidemenu,tags',
  ),
  'requiredFields' => array(
    'type' => 'textfield',
    'value' => 'parent,pagetitle,content',
  ),
  'redirectPublished' => array(
    'type' => 'textfield',
    'value' => 'new',
    'desc' => 'ms2guploader_prop_redirectPublished'
  ),
  'redirectScheme' => array(
    'type' => 'textfield',
    'value' => '-1',
    'desc' => 'ms2guploader_prop_redirectScheme'
  ),
  'parent' => array(
    'type' => 'numberfield',
    'value' => '',
    'desc' => 'ms2guploader_prop_parent'
  ),
  'parents' => array(
    'type' => 'textfield',
    'value' => '',
    'desc' => 'ms2guploader_prop_parents'
  ),
  'parentMse2form' => array(
    'type' => 'textfield',
    'value' => '',
    'desc' => 'ms2guploader_prop_parentMse2form'
  ),
  'parentsIncludeTVs' => array(
    'type' => 'textfield',
    'value' => '',
  ),
  'parentsSortby' => array(
    'type' => 'textfield',
    'value' => 'pagetitle',
  ),
  'parentsSortdir' => array(
    'type' => 'list',
    'options' => array(
      array('text' => 'ASC', 'value' => 'ASC'),
      array('text' => 'DESC', 'value' => 'DESC'),
    ),
    'value' => 'ASC',
  ),
  'resources' => array(
    'type' => 'textfield',
    'value' => '',
    'desc' => 'ms2guploader_prop_resources'
  ),
  'template' => array(
    'type' => 'numberfield',
    'value' => '',
    'desc' => 'ms2guploader_prop_template'
  ),
  'templates' => array(
    'type' => 'textfield',
    'value' => '1',
    'desc' => 'ms2guploader_prop_templates'
  ),
  'permissions' => array(
    'type' => 'textfield',
    'value' => 'section_add_children',
    'desc' => 'ms2guploader_prop_sections_permissions'
  ),
  'source' => array(
    'type' => 'numberfield',
    'value' => '',
  ),
  'tags' => array(
    'type' => 'combo-boolean',
    'value' => true,
    'desc' => 'ms2guploader_prop_tags'
  ),
  'tagsNew' => array(
    'type' => 'combo-boolean',
    'value' => true,
    'desc' => 'ms2guploader_prop_tagsNew'
  ),
  'editor' => array(
    'type' => 'list',
    'options' => array(
      array('text' => '0', 'value' => '0'),
      array('text' => 'bootstrapMarkdown', 'value' => 'bootstrapMarkdown'),
      array('text' => 'quill', 'value' => 'quill'),
    ),
    'value' => 'quill',
    'desc' => 'ms2guploader_prop_editor'
  ),
);

foreach ($tmp as $k => $v) {
  $properties[] = array_merge(
    array(
      'name' => $k,
      'desc' => PKG_NAME_LOWER . '_prop_' . $k,
      'lexicon' => PKG_NAME_LOWER . ':properties',
    ), $v
  );
}

return $properties;