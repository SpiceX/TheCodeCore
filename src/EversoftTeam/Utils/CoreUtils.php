<?php


namespace EversoftTeam\Utils;

use pocketmine\utils\TextFormat as TE;

class CoreUtils
{
    const PREFIX = "§f§l{TheCod§4ê§f}§r ";
    const AUTHENTICATE_MESSAGE = self::PREFIX . ": " . TE::GRAY . "Bienvenido a §fTheCod§4ê§f§r§7 un servidor code-featured donde podrás explorar multiples modalidades y divertirte en los minijuegos, por favor §6registrate para jugar!§7, tu contraseña debe tener mas de §c6 caracteres.";
    const REGISTER_MESSAGE = self::PREFIX . ": " . TE::GRAY . "Ingresa tu contraseña en el chat! <ej: pass123 pass123>";
    const SUBTITLE = "§7Minecraft §4Bedrock §7Edition §4Server";
    const AUTH_SUCESS = self::PREFIX . "§7Te has registrado correctamente!";
    const SOON = self::PREFIX . "§7Proximamente";
    const GOING_LOBBY = self::PREFIX . "§aDirigiendote al lobby!";
    const USE_IN_GAME = self::PREFIX . "§c Use el comando en juego";
    const RANK_HELP = self::PREFIX . "§7Ayuda del comando rank" .
                                     "\n§a- /rank help §7 [Ayuda del comando]" .
                                     "\n§a- /rank set <jugador> <rank> §7 [Configurar un rango]" .
                                     "\n§a- /rank list §7 [Listar los rangos]";
    const RANK_LIST = self::PREFIX . "§7 RANGOS DISPONIBLES" .
    "\n§a- Youtuber" .
    "\n§a- Diamond" .
    "\n§a- Gold" .
    "\n§a- Emerald" .
    "\n§a- Bedrock" .
    "\n§a- VIP" .
    "\n§a- VIP+";
    const OFFLINE = self::PREFIX . "§7El jugador no esta en linea!";
}