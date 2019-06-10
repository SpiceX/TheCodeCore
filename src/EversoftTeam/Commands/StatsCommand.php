<?php

namespace EversoftTeam\Commands;


use EversoftTeam\Main;
use EversoftTeam\SQLConnection\DataExtractor;
use EversoftTeam\Utils\CoreUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class StatsCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct("sts", "§aStatistics command", "/sts", ['sta', 'sts']);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $conn = new DataExtractor($this->main);
        if ($sender instanceof Player){
            $sender->sendMessage('§b××××§aYour Stats§b××××' . "\n" .
                                 '§2Jugador: ' . '§c' . $sender->getName() . "\n" .
                                 '§9Rango: ' . '§6' . $conn->getPlayerRank($sender->getPlayer()) . "\n" .
                                 '§9Kills: ' . '§6' . $conn->getPlayerKills($sender->getPlayer()) . "\n" .
                                 '§9Deaths: ' . '§6' . $conn->getPlayerDeaths($sender->getPlayer()) . "\n" .
                                 '§9Money: ' . '§6' . $conn->getPlayerMoney($sender->getPlayer()) . "\n" .
                                 '§9KDR: ' . '§6' . $conn->getPlayerKDR($sender->getPlayer()) . "\n" .
                                 '§b××××××××××××××××');
        } else {
            $sender->sendMessage(CoreUtils::USE_IN_GAME);
        }
    }

}