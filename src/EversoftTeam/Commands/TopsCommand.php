<?php
declare(strict_types=1);
namespace EversoftTeam\Commands;

use EversoftTeam\Main;
use EversoftTeam\SQLConnection\DataExtractor;
use EversoftTeam\Utils\CoreUtils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class TopsCommand extends Command implements PluginIdentifiableCommand
{

    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct("topkills", "§aStatistics kills top command", "/topkills", ['tk', 'topk', 'topkills']);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $sender->sendMessage('§4××××××§cTop Kills§4××××××');
            DataExtractor::getTopKills($sender->getPlayer());
        } else {
            $sender->sendMessage(CoreUtils::USE_IN_GAME);
        }
    }
}