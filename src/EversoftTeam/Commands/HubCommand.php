<?php
declare(strict_types=1);
namespace EversoftTeam\Commands;

use EversoftTeam\TheCodeCore\Main;
use EversoftTeam\TheCodeCore\Utils\CoreUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class HubCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct("hub", "§aIr al spawn", "/hub", ["spawn", "lobby", "h"]);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $lobby = Server::getInstance()->getDefaultLevel()->getSafeSpawn();
            $sender->sendMessage(CoreUtils::GOING_LOBBY);
            $sender->teleport($lobby);
        }
    }
}