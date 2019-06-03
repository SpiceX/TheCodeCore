<?php
declare(strict_types=1);
namespace EversoftTeam;

use EversoftTeam\SQLConnection\DataExtractor;
use pocketmine\scheduler\Task;

class NameTagUpdate extends Task
{

    private $main;

    public function __construct(Main $main)
    {

        $this->main = $main;

    }

    public function onRun(int $currentTick)
    {
        $world = $this->main->getServer()->getDefaultLevel();
        foreach ($world->getPlayers() as $player) {
            $r = DataExtractor::getPlayerRank($player);
            if ($r == "diamond") {
                $player->setNameTag("§l§bDiamond§r§7" . $player->getName());
            } elseif ($r == "vip") {
                $player->setNameTag("§7§kii§r§bVIP§6+§7§kii§r §c" . $player->getName());
            } elseif ($r == "vip+") {
                $player->setNameTag("§7§kii§r§bVIP§6+§7§kii§r §c" . $player->getName());
            } elseif ($r == "emerald") {
                $player->setNameTag("§r§2§lEmerald§r§7" . $player->getName());
            } elseif ($r == "bedrock") {
                $player->setNameTag("§r§5§lBedrock§r§7" . $player->getName());
            } elseif ($r == "gold") {
                $player->setNameTag("§r§e§lGold§r§7" . $player->getName());
            } elseif ($r == "youtuber") {
                $player->setNameTag("§7§kii§r§fYou§4Tuber§7§kii§r §c" . $player->getName());
            }
        }

    }


}