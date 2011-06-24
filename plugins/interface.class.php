<?php

interface PluginInterface
{
	public function info();
	public function hooks();
	public function activate();
	public function deactivate();
	public function uninstall();
}

?>
