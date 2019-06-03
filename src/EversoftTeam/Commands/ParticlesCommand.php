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

class ParticlesCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct('particles', '§cThe Code particles command', "/particles", ['particles', 'part', 'pt']);
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission("code.cmd.particles")) {
            if ($sender instanceof Player) {
                $this->main->ParticlesForm($sender->getPlayer());
            } else {
                $sender->sendMessage(CoreUtils::USE_IN_GAME);
            }
        }
    }
}