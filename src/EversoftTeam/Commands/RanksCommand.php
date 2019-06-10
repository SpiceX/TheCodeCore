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

class RanksCommand extends Command implements PluginIdentifiableCommand
{
    private $main;

    /**
     * RanksCommand constructor.
     * @param Main $main
     */
    public function __construct(Main $main)
    {
        $this->main = $main;
        parent::__construct("rank", "§aRank command for The Code server", "/rank help", ["rank", "rk"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $conn = new DataExtractor($this->main);
        if ($sender instanceof Player) {
            if ($sender->isOp()) {
                if (!empty($args[0])) {
                    switch ($args[0]) {
                        case "help":
                            $sender->sendMessage(CoreUtils::RANK_HELP);
                            break;
                        case "list":
                            $sender->sendMessage(CoreUtils::RANK_LIST);
                            break;
                        case "set":
                            if (!empty($args[1])) {
                                if (!empty($args[2])) {
                                    if ($args[2] == "emerald") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "diamond") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "gold") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "youtuber") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "bedrock") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "vip") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "vip+") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "user") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } elseif ($args[2] == "helper") {
                                        $conn->setPlayerRank($args[1], $args[2]);
                                        $sender->sendMessage(CoreUtils::PREFIX . "§7Has dado el rango " . $args[2] . " a el jugador " . $args[1]);
                                    } else {
                                        $sender->sendMessage(CoreUtils::RANK_HELP);
                                    }
                                }

                            } else {
                                $sender->sendMessage(CoreUtils::RANK_HELP);
                            }
                    }
                } else {
                    $sender->sendMessage(CoreUtils::RANK_HELP);
                }
            }
        } else {
            $sender->sendMessage(CoreUtils::USE_IN_GAME);
        }
    }

    public function getPlugin(): Plugin
    {
        return $this->main;
    }


}