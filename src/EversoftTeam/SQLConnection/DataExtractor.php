<?php


namespace EversoftTeam\SQLConnection;


use EversoftTeam\Main;
use pocketmine\Player;

class DataExtractor
{
    private $main;
    private $init;

    public function __construct(Main $main)
    {
        $this->main = $main;
        $this->init = new DatabaseConnection($main);
    }


    public function getPlayerKills(Player $player) {
        $conn =  new DatabaseConnection($this->main);
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            mysqli_close($conn->connection);
            return false;
        } else {
            $KILLS = $conn->connection->query("SELECT KILLS FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->KILLS;
            mysqli_close($conn->connection);
            return $KILLS;
        }

    }

    public function getPlayerDeaths(Player $player)
    {
        $conn = new DatabaseConnection($this->main);
        $name = $player->getName();
        if ($this->verifyUserInDB($name) == 0) {
            mysqli_close($conn->connection);
            return false;
        } else {
            $DEATHS = $conn->connection->query("SELECT DEATHS FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->DEATHS;
            mysqli_close($conn->connection);
            return $DEATHS;
        }
    }

    public function getPlayerKDR(Player $player) {
        $kills = $this->getPlayerKills($player);
        $deaths = $this->getPlayerDeaths($player);
        $result = $kills / $deaths;
        $kdr = round($result, 2, PHP_ROUND_HALF_DOWN);
        return $kdr;
    }

    public function getPlayerMoney(Player $player)
    {
        $conn = new DatabaseConnection($this->main);
        $name = $player->getName();
        if (self::verifyUserInDB($name) == 0) {
            mysqli_close($conn->connection);
            return false;
        } else {
            $MONEY = $conn->connection->query("SELECT MONEY FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->MONEY;
            mysqli_close($conn->connection);
            return $MONEY;
        }
    }

    public function getPlayerRank(Player $player)
    {
        $conn = new DatabaseConnection($this->main);
        $name = $player->getName();
        if ($this->verifyUserInDB($name) == 0) {
            mysqli_close($conn->connection);
            return false;
        } else {
            $RANK = $conn->connection->query("SELECT RANK FROM ServerAccounts WHERE NAME = '" . $name . "'")->fetch_object()->RANK;
            mysqli_close($conn->connection);
            return $RANK;
        }
    }

    public function setPlayerRank(string $player, string $rank): bool
    {
        $conn = new DatabaseConnection($this->main);
        if (self::verifyUserInDB($player) == 0) {
            mysqli_close($conn->connection);
            return false;
        } else {
            $query = "UPDATE ServerAccounts SET RANK = '".$rank."' WHERE ServerAccounts.NAME = '".$player."'";
            mysqli_query($conn->connection, $query);
            mysqli_close($conn->connection);
        }
        return true;
    }

    public function getTopKills(Player $player) {
        $conn = new DatabaseConnection($this->main);
        $query = mysqli_query($conn->connection, "SELECT NAME, KILLS FROM ServerAccounts ORDER BY KILLS DESC");
        while ($fila = mysqli_fetch_array($query, MYSQLI_BOTH)) {
            $player->sendMessage("§2Jugador: §6" . $fila['NAME'] . '   ' . "§2Kills: §6" . $fila['KILLS']);
        }
        mysqli_close($conn->connection);
    }

    private function verifyUserInDB(string $name)
    {
        $conn = new DatabaseConnection($this->main);
        $query = mysqli_query($conn->connection, "SELECT * FROM ServerAccounts WHERE NAME='" . $name . "'");
        if (!$query) {
            mysqli_close($conn->connection);
            die('Error: ' . mysqli_error($conn->connection));
        }
        if (mysqli_num_rows($query) > 0) {
            mysqli_close($conn->connection);
            return 1;
        } else {
            mysqli_close($conn->connection);
            return 0;
        }
    }

}