<?php


namespace EversoftTeam\Utils;

use pocketmine\utils\TextFormat as TE;
use EversoftTeam\Main;

class CoreUtils
{
    private $main;
    const PREFIX = "§f§l{TheCod§4ê§f}§r ";
    const AUTHENTICATE_MESSAGE = self::PREFIX . ": " . TE::GRAY . "Bienvenido a §fTheCod§4ê§f§r§7 un servidor code-featured donde podrás explorar multiples modalidades y divertirte en los minijuegos, por favor §6registrate para jugar!§7, tu contraseña debe tener mas de §c6 caracteres.";
    const REGISTER_MESSAGE = self::PREFIX . ": " . TE::GRAY . "Ingresa tu contraseña en el chat! <ej: pass123 pass123>";
    const SUBTITLE = "§7Minecraft §4Bedrock §7Edition §4Server";
    const AUTH_SUCESS = self::PREFIX . "§7Te has registrado correctamente!";
    const SOON = self::PREFIX . "§7Proximamente";
    const GOING_LOBBY = self::PREFIX . "§aDirigiendote al lobby!";

    public function __construct(Main $main)
    {
        $this->main = $main;
    }
}