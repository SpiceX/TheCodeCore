<?php
namespace EversoftTeam\shop;

use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use EversoftTeam\Main;
class ShopUpdate extends Task {
public $plugin;

public function __construct(Main $eid){

		$this->plugin = $eid;

	}
public function onRun(int $currentTick){
	 $shop = new Config($this->plugin->getDataFolder() . "/shop.yml", Config::YAML);
foreach($this->plugin->getServer()->getLevels() as $level) {
			foreach($level->getEntities() as $entity) {
	if($entity instanceof \EversoftTeam\shop\ShopEntity){
$coins = "20000";

	$lock = "§l§a✔§2ULTRA COSMETICO§r\n§7KIT FFA FULL§r\n §6Costo §b: §e".$coins."§6 coins".$br = "\n\n\n\n\n";
$entity->setNameTag($lock);
$entity->setNameTagAlwaysVisible(true);
$entity->setScale(1.5);
}
}
}

foreach($this->plugin->getServer()->getLevels() as $level) {

			foreach($level->getEntities() as $entity) {
	if($entity instanceof \EversoftTeam\shop\ShopEntity1){
foreach($this->plugin->getServer()->getLevelByName($shop->get('level'))->getPlayers() as $pl){
$lock = null;
$coins = "80000";

	$lock = "§l§a✔§2ULTRA COSMETICO§r\n§7PACK PET BASIC§r\n §6Costo §b: §e".$coins."§6 coins".$br = "\n\n\n\n\n";
$entity->setNameTagAlwaysVisible(true);
$entity->setNameTag($lock);
$entity->setScale(1.5);
}
}
}
}
foreach($this->plugin->getServer()->getLevels() as $level) {
			foreach($level->getEntities() as $entity) {
	if($entity instanceof \EversoftTeam\shop\ShopEntity2){



$lock = null;
$coins = "100000";

		$lock = "§l§a✔§2ULTRA COSMETICO§r\n§7PACK GADGETS BASIC§r\n §6Costo §b: §e".$coins."§6 coins".$br = "\n\n\n\n\n";

$entity->setNameTagAlwaysVisible(true);
$entity->setNameTag($lock);
$entity->setScale(1.5);

}
}
}

foreach($this->plugin->getServer()->getLevels() as $level) {
			foreach($level->getEntities() as $entity) {
	if($entity instanceof \EversoftTeam\shop\ShopEntity3){


$lock = null;
$coins = "50000";

		$lock = "§l§a✔§2ULTRA COSMETICO§r\n§7RANGO ENGINNER§r\n §6Costo §b: §e".$coins."§6 coins".$br = "\n\n\n\n\n";
$entity->setNameTagAlwaysVisible(true);
$entity->setNameTag($lock);
$entity->setScale(1.5);
}
}
}
}


	}
