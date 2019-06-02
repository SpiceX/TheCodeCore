<?php
declare(strict_types=1);
namespace EversoftTeam\SQLConnection;

use EversoftTeam\Main;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;

class DatabaseEventHandler implements Listener
{
    private $main;

    /**
     * DatabaseEventHandler constructor.
     * @param Main $main
     */
    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function addDeath(PlayerDeathEvent $deathEvent) {
        $player = $deathEvent->getPlayer();
        $name = $player->getName();
        $crescent = DataExtractor::getPlayerDeaths($player);
        $total = $crescent + 1;
        $query = "UPDATE ServerAccounts SET DEATHS = '".$total."' WHERE ServerAccounts.NAME = '".$name."'";
        mysqli_query(DatabaseConnection::$connection, $query);
    }

    public function addKill(EntityDeathEvent $deathEvent) {
        $entity = $deathEvent->getEntity();
        $cause = $entity->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();
            if ($killer instanceof Player) {
                $name = $killer->getName();
                $crescent = DataExtractor::getPlayerKills($killer);
                $total = $crescent + 1;
                $money = DataExtractor::getPlayerMoney($killer);
                $total_money = DataExtractor::getPlayerKDR($killer) + 1 + $money;
                $query = "UPDATE ServerAccounts SET KILLS = '".$total."' WHERE ServerAccounts.NAME = '".$name."'";
                $query2 = "UPDATE ServerAccounts SET MONEY = '".$total_money."' WHERE ServerAccounts.NAME = '".$name."'";
                mysqli_query(DatabaseConnection::$connection, $query);
                mysqli_query(DatabaseConnection::$connection, $query2);
            }
        }
    }
}