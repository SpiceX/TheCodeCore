<?php

namespace EversoftTeam\Morphs\util;

use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\entity\{

    Effect, EffectInstance

};

class Morph
{
    private $player;

    public function __construct(Player $player, $type)
    {
        $this->player = $player;
        switch ($type) {
            case "spider":
                $this->createSpidern($this->player);
                $this->player->addEffect((new EffectInstance(Effect::getEffect(14)))->setDuration(99999)->setAmplifier(2));
                break;
            case "witch":
                $this->player->addEffect((new EffectInstance(Effect::getEffect(14)))->setDuration(99999)->setAmplifier(2));
                $this->createWitch($this->player);
                break;

        }

    }

    private function createSpidern(Player $player)
    {
        $compoundtag = Entity::createBaseNBT(new Vector3((float)$player->getX(), (float)$player->getY(), (float)$player->getZ()));
        $npcgame = Entity::createEntity("SpiderM", $player->getLevel(), $compoundtag);
        $npcgame->setTargetEntity($player);
        $npcgame->setNameTag("§r§b\n\n\n\n\n\n§b" . $player->getName());
        $npcgame->setNametagVisible(true);
        $npcgame->setNameTagAlwaysVisible(true);
        $npcgame->spawnToAll();


    }

    private function createWitch(Player $player)
    {
        $compoundtag = Entity::createBaseNBT(new Vector3((float)$player->getX(), (float)$player->getY(), (float)$player->getZ()));
        $npcgame = Entity::createEntity("WitchM", $player->getLevel(), $compoundtag);
        $npcgame->setTargetEntity($player);
        $npcgame->setScale(0.6);
        $npcgame->spawnToAll();


    }

}