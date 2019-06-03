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

class GadgetsCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct('gadgets', "§aThe Code gadgets command", "/gadgets", ["gd", "gad", "gadgets"]);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {

        } else {
            $sender->sendMessage(CoreUtils::USE_IN_GAME);
        }
    }
}