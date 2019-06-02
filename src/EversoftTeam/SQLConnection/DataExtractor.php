<?php


namespace EversoftTeam\SQLConnection;


use EversoftTeam\Main;
use pocketmine\Player;

class DataExtractor
{
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }


    public static function getPlayerKills(Player $player) {
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            return false;
        } else {
            $KILLS = DatabaseConnection::$connection->query("SELECT KILLS FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->KILLS;
            return $KILLS;
        }
    }

    public static function getPlayerDeaths(Player $player)
    {
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            return false;
        } else {
            $DEATHS = DatabaseConnection::$connection->query("SELECT DEATHS FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->DEATHS;
            return $DEATHS;
        }
    }

    public static function getPlayerKDR(Player $player) {
        $kills = self::getPlayerKills($player);
        $deaths = self::getPlayerDeaths($player);
        $result = $kills / $deaths;
        $kdr = round($result, 2, PHP_ROUND_HALF_DOWN);
        return $kdr;
    }

    public static function getPlayerMoney(Player $player)
    {
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            return false;
        } else {
            $MONEY = DatabaseConnection::$connection->query("SELECT MONEY FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->MONEY;
            return $MONEY;
        }
    }

    public static function getPlayerRank(Player $player)
    {
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            return false;
        } else {
            $RANK = DatabaseConnection::$connection->query("SELECT RANK FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->RANK;
            return $RANK;
        }
    }

    public static function setPlayerRank(string $player, string $rank)
    {
        if (self::verifyUserInDB($player) == 0) {
            return false;
        } else {
            $query = "UPDATE ServerAccounts SET RANK = '".$rank."' WHERE ServerAccounts.NAME = '".$player."'";
            mysqli_query(DatabaseConnection::$connection, $query);
        }
    }

    public static function getTopKills(Player $player) {
        $query = mysqli_query(DatabaseConnection::$connection, "SELECT NAME, KILLS FROM ServerAccounts ORDER BY KILLS DESC");
        while ($fila = mysqli_fetch_array($query, MYSQLI_BOTH)) {
            $player->sendMessage("§2Jugador: §6" . $fila['NAME'] . '   ' . "§2Kills: §6" . $fila['KILLS']);
        }
    }

    private static function verifyUserInDB(string $name)
    {
        $conn = DatabaseConnection::$connection;
        $query = mysqli_query($conn, "SELECT * FROM ServerAccounts WHERE NAME='" . $name . "'");
        if (!$query) {
            die('Error: ' . mysqli_error($conn));
        }
        if (mysqli_num_rows($query) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

}