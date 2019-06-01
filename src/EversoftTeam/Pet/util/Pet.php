<?php
namespace EversoftTeam\Pet\util;
use pocketmine\math\Vector3;
use pocketmine\entity\{Entity};
use EversoftTeam\Pet\MePet;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\utils\Color;
class Pet{
	private $player;

public function __construct(Player $player,$type){
$this->player = $player;
switch ($type) {
	case "creeper":
	$this->createDragon($this->player);
	break;
	case "me":
	$this->createMiniMe($this->player);
	break;
}

}

private function createDragon(Player $player){
		$compoundtag = Entity::createBaseNBT(new Vector3((float) $player->getX(), (float) $player->getY(), (float) $player->getZ()));
		$npcgame = Entity::createEntity("Armor", $player->getLevel(), $compoundtag);
		$npcgame->setTargetEntity($player);
		$npcgame->setScale(0.7);
$npcgame->setNameTag("§r§b".$player->getName()."§r§d PET");
$npcgame->setNametagVisible(true);
$npcgame->setNameTagAlwaysVisible(true);
 $npcgame->getArmorInventory()->setHelmet(Item::get(397,4,1));
 $c = Item::get(298,0,1);
            $npcgame->getArmorInventory()->setChestplate($c);
            $b = Item::get(301,0,1);
            $npcgame->getArmorInventory()->setBoots($b);
		$npcgame->spawnToAll();
		

	}
private function createMiniMe(Player $player){
		$nbt = Entity::createBaseNBT(new Vector3((float) $player->getX(), (float) $player->getY(), (float) $player->getZ()));
$nbt->setTag(clone $player->namedtag->getCompoundTag("Skin"));

$humano = new MePet($player->getLevel(), $nbt);
$humano->setTargetEntity($player);
$humano->setScale(0.7);
$humano->setNameTag("§r§b".$player->getName()."§r§d PET");
$humano->setNametagVisible(true);
$humano->setNameTagAlwaysVisible(true);
$humano->spawnToAll();

	}

}