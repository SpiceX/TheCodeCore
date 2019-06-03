<?php
declare(strict_types=1);
namespace EversoftTeam\Commands;

use EversoftTeam\Main;
use EversoftTeam\Utils\CoreUtils;
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
        parent::__construct("hub", "§aIr al spawn", "/hub", ["spawn", "lobby", "h", "hub"]);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("code.cmd.hub")) {
            if ($sender instanceof Player) {
                $lobby = Server::getInstance()->getDefaultLevel()->getSafeSpawn();
                $sender->sendMessage(CoreUtils::GOING_LOBBY);
                $sender->teleport($lobby);
            } else {
                $sender->sendMessage(CoreUtils::USE_IN_GAME);
            }
        }
    }
}