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
        $conn = new DataExtractor($this->main);
        $player = $deathEvent->getPlayer();
        $name = $player->getName();
        $crescent = $conn->getPlayerDeaths($player);
        $total = $crescent + 1;
        $query = "UPDATE ServerAccounts SET DEATHS = '".$total."' WHERE ServerAccounts.NAME = '".$name."'";
        $db = new DatabaseConnection($this->main);
        mysqli_query($db->connection, $query);
        mysqli_close($db->connection);
    }

    public function addKill(EntityDeathEvent $deathEvent) {
        $conn = new DataExtractor($this->main);
        $entity = $deathEvent->getEntity();
        $cause = $entity->getLastDamageCause();
        if ($cause instanceof EntityDamageByEntityEvent) {
            $killer = $cause->getDamager();
            if ($killer instanceof Player) {
                $name = $killer->getName();
                $crescent = $conn->getPlayerKills($killer);
                $total = $crescent + 1;
                $money = $conn->getPlayerMoney($killer);
                $total_money = $conn->getPlayerKDR($killer) + 1 + $money;
                $query = "UPDATE ServerAccounts SET KILLS = '".$total."' WHERE ServerAccounts.NAME = '".$name."'";
                $query2 = "UPDATE ServerAccounts SET MONEY = '".$total_money."' WHERE ServerAccounts.NAME = '".$name."'";
                $db = new DatabaseConnection($this->main);
                mysqli_query($db->connection, $query);
                mysqli_query($db->connection, $query2);
                mysqli_close($db->connection);
            }
        }
    }
}