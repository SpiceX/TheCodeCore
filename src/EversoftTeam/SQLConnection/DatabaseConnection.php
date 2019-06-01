<?php


namespace EversoftTeam\SQLConnection;


use EversoftTeam\Main;
use mysqli;

class DatabaseConnection
{
    private $main;
    public static $connection;

    public function __construct(Main $main)
    {
        $this->main = $main;
        self::$connection = @new mysqli("198.245.51.96", "db_57361", "4b083c986b", "db_57361");
        if (mysqli_connect_errno()) {
            printf("Error de conexión: %s\n", mysqli_connect_error());
            exit();
        } else {
            $main->getLogger()->info("Database conectada con exito");
        }
    }
}