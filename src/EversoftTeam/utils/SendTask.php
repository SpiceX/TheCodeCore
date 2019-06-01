<?php

namespace EversoftTeam\utils;

use pocketmine\plugin\Plugin;
use pocketmine\scheduler\Task;

class SendTask extends Task{

	public function __construct(Plugin $owner){
		parent::__construct($owner);
	}

	public function onRun(int $currentTick){
		$this->getOwner()->sendBossBar();
	}

	public function cancel(){
		$this->getHandler()->cancel();
	}
}