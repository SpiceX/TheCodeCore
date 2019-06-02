<?php
namespace EversoftTeam\Pet;

use EversoftTeam\Main;
use pocketmine\scheduler\Task;

use pocketmine\item\Item;

class Stand extends Task {

public $plugin;
public function __construct(Main $eid){

		$this->plugin = $eid;

	}
public function onRun(int $currentTick){
	foreach($this->plugin->getServer()->getLevels() as $level) {
            foreach($level->getEntities() as $entity) {
                if($entity instanceof Armor) {

$entity->setNametagVisible(true);
$entity->setNameTagAlwaysVisible(true);
 $entity->getArmorInventory()->setHelmet(Item::get(397,4,1));
 $c = Item::get(298,0,1);
            $entity->getArmorInventory()->setChestplate($c);
            $b = Item::get(301,0,1);
            $entity->getArmorInventory()->setBoots($b);



                }
            }
        }

	}





}