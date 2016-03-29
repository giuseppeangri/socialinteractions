<?php
	
	$plugin = OW::getPluginManager()->getPlugin('socialinteractions');

  BOL_LanguageService::getInstance()->importPrefixFromZip($plugin->getRootDir() . 'langs.zip', 'socialinteraction');
  
  OW::getPluginManager()->addPluginSettingsRouteName('socialinteractions', 'socialinteractions.main');

?>
