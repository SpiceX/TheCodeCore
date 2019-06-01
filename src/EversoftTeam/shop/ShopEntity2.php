<?php
namespace EversoftTeam\shop;

use pocketmine\entity\Animal;

class ShopEntity2 extends Animal{
    const NETWORK_ID = self::SNOW_GOLEM;

    public $width = 0.9;
    public $height = 1.4;

    public function getName(): string{
    	return "Loading";
    }


}
