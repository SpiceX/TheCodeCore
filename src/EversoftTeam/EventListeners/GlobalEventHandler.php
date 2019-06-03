<?php
declare(strict_types=1);
namespace EversoftTeam\EventListeners;

use EversoftTeam\Main;
use EversoftTeam\Morphs\SpiderM;
use EversoftTeam\Morphs\WitchM;
use EversoftTeam\Pet\Armor;
use EversoftTeam\Pet\MePet;
use EversoftTeam\shop\ShopEntity;
use EversoftTeam\shop\ShopEntity1;
use EversoftTeam\shop\ShopEntity2;
use EversoftTeam\shop\ShopEntity3;
use EversoftTeam\SQLConnection\DatabaseConnection;
use EversoftTeam\SQLConnection\DataExtractor;
use EversoftTeam\Utils\CoreUtils;
use EversoftTeam\Utils\PlayerFaceAPI;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class GlobalEventHandler implements Listener
{
    private $main;

    /**
     * GlobalEventHandler constructor.
     * @param $main
     */
    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function onPlace(BlockPlaceEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $event->setCancelled(true);
        }
    }

    public function onPvP(EntityDamageEvent $eventPvP)
    {
        $lobby = $eventPvP->getEntity()->getLevel()->getName();
        if ($lobby == Server::getInstance()->getDefaultLevel()->getName()) {
            if ($eventPvP instanceof EntityDamageByEntityEvent) {
                if ($eventPvP->getEntity() instanceof Player && $eventPvP->getDamager() instanceof Player) {
                    $eventPvP->setCancelled();
                }
            }
        }
    }

    public function onPlayerInteractEvent(PlayerInteractEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $i = $event->getItem();
            if ($i->getId() == Item::COMPASS) {
                $event->getPlayer()->sendMessage("Teleports");
            } elseif ($i->getId() == Item::SKULL) {
                $event->getPlayer()->sendMessage("Pets");
            } elseif ($i->getId() == Item::CHEST) {
                $event->getPlayer()->sendMessage("Games");
            } elseif ($i->getId() == Item::DYE) {
                $event->getPlayer()->sendMessage("Particulas");
            } elseif ($i->getId() == Item::NETHER_STAR) {
                $event->getPlayer()->sendMessage("Cosmeticos");
            }
        }
    }

    public function onBreak(BlockBreakEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $event->setCancelled(true);
        }
    }

    public function enDrop(PlayerDropItemEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $event->setCancelled(true);
        }
    }


    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $rank = DataExtractor::getPlayerRank($player);
        $event->setFormat("§8> §7" . $player->getName() . " §8>> §7" . $message);
        if ($rank != "User") {
            if ($rank == "diamond") {
                $event->setFormat("§7[§l§bDiamond§r§7]§r §b" . $player->getName() . " §8> §7" . $message);
            } elseif ($rank == "bedrock") {
                $event->setFormat("§7[§r§5§lBedrock§r§7]§r §d" . $player->getName() . " §8> §7" . $message);
            } elseif ($rank == "emerald") {
                $event->setFormat("§7[§r§2§lEmerald§r§7]§r §b" . $player->getName() . " §6>>§a " . $message);
            } elseif ($rank == "gold") {
                $event->setFormat("§7[§r§e§lGold§r§7]§r §b" . " §b" . $player->getName() . " §8> §7" . $message);
            } elseif ($rank == "vip") {
                $event->setFormat("§7§kii§r§bVIP§7§kii§r §c" . $player->getName() . "§r §l§7»§r §f" . $message);
            } elseif ($rank == "vip+") {
                $event->setFormat("§7§kii§r§bVIP§6+§7§kii§r §c" . $player->getName() . "§r §l§7»§r §f" . $message);
            } elseif ($rank == "youtuber") {
                $event->setFormat("§7§kii§r§fYou§4Tuber§7§kii§r §c" . $player->getName() . "§r §l§7»§r §f" . $message);
            } elseif ($rank == "helper") {
                $event->setFormat("§7[§c§lHelper§7]§r §c" . $player->getName() . " §8> §7" . $message);
            }
        }
    }

    public function danoArmor(EntityDamageEvent $evento)
    {
        if ($evento->getEntity() instanceof Armor) {
            $evento->setCancelled(true);
        }
        if ($evento->getEntity() instanceof MePet) {
            $evento->setCancelled(true);
        }
        if ($evento->getEntity() instanceof SpiderM) {
            $evento->setCancelled(true);
        }
        if ($evento->getEntity() instanceof WitchM) {
            $evento->setCancelled(true);
        }
        if ($evento->getEntity() instanceof ShopEntity) {
            $evento->setCancelled(true);
            $shop = new Config($this->main->getDataFolder() . "shop.yml", Config::YAML);
            if ($evento instanceof EntityDamageByEntityEvent) {
                $pl = $evento->getDamager();
                if ($pl instanceof Player) {
                    $pla = $shop->get($pl->getName());
                    if ($pla['cosmetic1'] == "unlocket") {
                        $pl->sendMessage("§7[§6SHOP§7] §aYa tienes comprado esto!");
                    }
                }
            }

        }
        if ($evento->getEntity() instanceof ShopEntity1) {
            $evento->setCancelled(true);
            $shop = new Config($this->main->getDataFolder() . "shop.yml", Config::YAML);

            $pl = $evento->getDamager();
            if ($pl instanceof Player) {
                $pla = $shop->get($pl->getName());
                if ($pla['cosmetic2'] == "unlocket") {
                    $pl->sendMessage("§7[§6SHOP§7] §aYa tienes comprado esto!");
                }
            }


        }
        if ($evento->getEntity() instanceof ShopEntity2) {
            $evento->setCancelled(true);
            $shop = new Config($this->main->getDataFolder() . "shop.yml", Config::YAML);

            $pl = $evento->getDamager();
            if ($pl instanceof Player) {
                $pla = $shop->get($pl->getName());
                if ($pla['cosmetic3'] == "unlocket") {
                    $pl->sendMessage("§7[§6SHOP§7] §aYa tienes comprado esto!");
                }
            }


        }
        if ($evento->getEntity() instanceof ShopEntity3) {
            $evento->setCancelled(true);
            $shop = new Config($this->main->getDataFolder() . "shop.yml", Config::YAML);
            $pl = $evento->getDamager();
            if ($pl instanceof Player) {
                $pla = $shop->get($pl->getName());
                if ($pla['cosmetic4'] == "unlocket") {
                    $pl->sendMessage("§7[§6SHOP§7] §aYa tienes comprado esto!");
                }
            }
        }
    }

    public function levelChangeArmor(EntityLevelChangeEvent $e)
    {
        $pet = new Config($this->main->getDataFolder() . "/pet.yml", Config::YAML);
        $p = new Config($this->main->getDataFolder() . "/particle.yml", Config::YAML);
        $m = new Config($this->main->getDataFolder() . "/mor.yml", Config::YAML);
        $player = $e->getEntity();
        if ($player instanceof Player) {
            $level = $e->getTarget()->getName();
            if ($level == $this->main->getServer()->getDefaultLevel()->getFolderName()) {

            } else {
                foreach ($this->main->getServer()->getLevels() as $lvls) {
                    foreach ($lvls->getEntities() as $e) {
                        if ($e->getTargetEntity() == $player) {
                            $e->close();
                            $player->removeAllEffects();
                        }
                    }
                }
                if ($this->checkPermission($player) == "owner") {
                    $pet->set($player->getName(), "ds");
                    $pet->save();
                    $p->set($player->getName(), "ds");
                    $p->save();
                    $m->set($player->getName(), "ds");
                    $m->save();
                }
                if ($this->checkPermission($player) == "vip") {
                    $pet->set($player->getName(), "ds");
                    $pet->save();
                    $p->set($player->getName(), "ds");
                    $p->save();
                    $m->set($player->getName(), "ds");
                    $m->save();
                }
                if ($this->checkPermission($player) == "part") {
                    $p->set($player->getName(), "ds");
                    $p->save();
                }
            }
        }
    }

    public function onQuitArmor(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $event->setQuitMessage("");
        foreach ($this->main->getServer()->getLevels() as $lvls) {
            foreach ($lvls->getEntities() as $e) {
                if ($e->getTargetEntity() == $player) {
                    $e->close();
                }
            }
        }
    }

    public function onDamageEvents(EntityDamageEvent $event)
    {
        if ($event->getCause() === EntityDamageEvent::CAUSE_FALL) {
            $event->setCancelled(true);
        }
        if ($event->getCause() === EntityDamageEvent::CAUSE_BLOCK_EXPLOSION) {
            $event->setCancelled(true);
        }
        if ($event->getCause() === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION) {
            $event->setCancelled(true);
        }
    }

    public function checkPermission(Player $player)
    {
        $rank = DataExtractor::getPlayerRank($player);
        $p = '';

        if ($rank == "User") {
            $p = "User";
        }
        if ($rank == "vip" or $rank == "vip+") {
            $p = "vip_user";
        }
        if ($rank == "bedrock") {
            $p = "bedrock";
        }
        if ($rank == "diamond" or $rank == "gold" or $rank == "emerald") {
            $p = "ore_user";
        }
        if ($rank == "youtuber") {
            $p = "youtuber";
        }
        return $p;
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $pet = new Config($this->main->getDataFolder() . "/pet.yml", Config::YAML);
        $p = new Config($this->main->getDataFolder() . "/particle.yml", Config::YAML);
        $m = new Config($this->main->getDataFolder() . "/mor.yml", Config::YAML);
        $player = $event->getPlayer();
        if ($this->main->verifyUserInDB($player->getName()) == 0) {
            $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
            $player->setImmobile(true);
            $player->setInvisible(true);
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 999999, 1));
            $player->getInventory()->clearAll(true);
        } else {
            $player->setNametag("§r§c" . $player->getName());
            $this->main->addBoss($player);
            $this->main->lobby($player);
            if ($this->checkPermission($player) == "owner") {
                $pet->set($player->getName(), "ds");
                $pet->save();
                $p->set($player->getName(), "ds");
                $p->save();
                $m->set($player->getName(), "ds");
                $m->save();
            }
            if ($this->checkPermission($player) == "vip") {
                $pet->set($player->getName(), "ds");
                $pet->save();
                $p->set($player->getName(), "ds");
                $p->save();
                $m->set($player->getName(), "ds");
                $m->save();
            }
            if ($this->checkPermission($player) == "part") {
                $p->set($player->getName(), "ds");
                $p->save();
            }
            $this->main->setDefaultShop($player);
            $player->removeAllEffects();
            $event->setJoinMessage("");
            $player->sendMessage(CoreUtils::AUTHENTICATE_MESSAGE);
            $rank = DataExtractor::getPlayerRank($player);
            if ($rank == "vip") {
                $player->setNameTag("§7§kii§r§bVIP§6+§7§kii§r §c" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "diamond") {
                $player->setNameTag("§l§bDiamond§r§7" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "gold") {
                $player->setNameTag("§r§e§lGold§r§7" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "bedrock") {
                $player->setNameTag("§r§5§lBedrock§r§7" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "vip+") {
                $player->setNameTag("§7§kii§r§bVIP§6+§7§kii§r §c" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "youtuber") {
                $player->setNameTag("§7§kii§r§fYou§4Tuber§7§kii§r §c" . $player->getName());
                $player->setAllowFlight(false);
            } elseif ($rank == "emerald") {
                $player->setNameTag("§r§2§lEmerald§r§7" . $player->getName());
                $player->setAllowFlight(false);
            }
            $this->main->menu($player);
        }
    }
    public function processAuth(PlayerChatEvent $chatEvent)
    {
        $name = $chatEvent->getPlayer()->getName();
        $player = $chatEvent->getPlayer();
        $args = explode(" ", $chatEvent->getMessage());
        $password = $args[0];
        $rank = "User";
        $money = 0;
        $kills = 0;
        $deaths = 1;
        $idn = 0;
        $uuid = $player->getUniqueId()->toString();
        if ($this->main->verifyUserInDB($name) == 0) {
            $this->main->autenticando[] = $name;
            $chatEvent->setCancelled(true);
            if (!isset($args[0]) || !isset($args[1])) {
                $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
            } elseif ($args[0] == $args[1]) {
                if (strlen($args[0]) > 6 and strlen($args[1]) > 6) {
                    $player->setImmobile(false);
                    $player->setInvisible(false);
                    $this->main->Menu($player);
                    $player->sendMessage(CoreUtils::AUTH_SUCESS);
                    $player->removeAllEffects();
                    $player->sendMessage(CoreUtils::PREFIX . "§aObteniendo datos del jugador...");
                    $player->sendMessage(CoreUtils::PREFIX . "§cPor favor espere...");
                    $player->sendMessage(CoreUtils::PREFIX . "§aDatos obtenidos con exito!");
                    $getFace = new PlayerFaceAPI($this->main);
                    $getFace->sendHead($name, $player->getSkin()->getSkinData());
                    $sqli = DatabaseConnection::$connection;
                    $query = "INSERT INTO ServerAccounts (ID,NAME,PASSWORD,RANK,MONEY,KILLS,DEATHS,UUID) VALUES (?,?,?,?,?,?,?,?)";
                    if ($stmt = $sqli->prepare($query)) {
                        $stmt->bind_param("isssiiis", $idn, $name, $password, $rank, $money, $kills, $deaths, $uuid);
                        $stmt->execute();
                    }
                } else {
                    $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
                }
            } else {
                $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
            }
        }
    }


    public function addTitleOnJoin(PlayerJoinEvent $joinEvent)
    {
        $player = $joinEvent->getPlayer();
        $player->addTitle(CoreUtils::PREFIX, CoreUtils::SUBTITLE, 20, 20, 20);
        $this->main->sendJoinSound($player, "mob.endermen.death", 1, 1);
        $this->main->addBoss($player);
    }
}