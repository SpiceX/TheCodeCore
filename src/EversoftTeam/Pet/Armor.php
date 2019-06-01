<?php

namespace EversoftTeam\Pet;

use pocketmine\entity\Animal;

class Armor extends Animal{
    const NETWORK_ID = self::ARMOR_STAND;

    public $width = 0.9;
    public $height = 1.4;

    public function getName(): string{
    	return "Loading";
    }
 public function entityBaseTick(int $tickDiff = 1): bool{

        $this->ticksLived++;

        if ($this->getTargetEntity() !== null) {

            $entidad = $this->getTargetEntity();

            $ticks = 1 / 20;

            $this->x = $entidad->x+2;
            $this->y = $entidad->y+mt_rand(1,2);
            $this->z = $entidad->z+1;
            $this->yaw =$entidad->yaw;

            $this->updateMovement();
        }

        return true;
    }
   
}