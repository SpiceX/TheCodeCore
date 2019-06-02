<?php
declare(strict_types=1);
namespace EversoftTeam\Commands;

use EversoftTeam\TheCodeCore\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

class ParticlesCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function getPlugin(): Plugin
    {
        // TODO: Implement getPlugin() method.
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        // TODO: Implement execute() method.
    }
}