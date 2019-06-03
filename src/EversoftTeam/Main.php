<?php

namespace EversoftTeam;

use EversoftTeam\Commands\GadgetsCommand;
use EversoftTeam\Commands\HubCommand;
use EversoftTeam\Commands\ParticlesCommand;
use EversoftTeam\Commands\RanksCommand;
use EversoftTeam\Commands\StatsCommand;
use EversoftTeam\Commands\TopsCommand;
use EversoftTeam\Form\MenuForm;
use EversoftTeam\Morphs\SpiderM;
use EversoftTeam\Morphs\util\Morph;
use EversoftTeam\Morphs\WitchM;
use EversoftTeam\Particula\Helix;
use EversoftTeam\Pet\Armor;
use EversoftTeam\Pet\MePet;
use EversoftTeam\Pet\Stand;
use EversoftTeam\Pet\util\Pet;
use EversoftTeam\shop\{ShopEntity, ShopEntity1, ShopEntity2, ShopEntity3, ShopUpdate};
use EversoftTeam\SQLConnection\DatabaseConnection;
use EversoftTeam\SQLConnection\DatabaseEventHandler;
use EversoftTeam\SQLConnection\DataExtractor;
use EversoftTeam\Utils\API;
use EversoftTeam\Utils\CoreUtils;
use EversoftTeam\Utils\PlayerFaceAPI;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
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
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{

    public $prefix = "§4§k||§r§f§l{TheCod§4ê§f}§r§4§k||§r";
    public $error = "§7[§cERROR§7]§4 ";
    public $titan = "§7[§l§9HELPER§r§7]§r§7";
    public $dragon = "§7[§r§d§lObsidiana§r§7]§r§7";
    public $master = "§7[§r§b§lDiamond§r§7]§r§7";
    public $king = "§f[§7§lHierro§r§f]§r§7";
    public $miniyt = " §f» §7[§fMini§4YT§7]§r§7";
    public $yt = "§f» §7[§fYou§4Tuber§7]§r§7";
    public $ytmas = "§f» §7[§fYou§4Tuber§b+§7]§r§7";
    public $cr = "§7[§l§4OWNER§r§7]§r§7";
    public $admin = "§7[§c§lADMIN§r§7]§r§7";
    public $fbi = "§7[§l§2MOD§r§7]§r§7";
    public $potal1 = ["x" => 49, "y" => 93, "z" => -23];
    public $potal2 = ["x" => 47, "y" => 101, "z" => -16];
    public $games = ["x" => 41, "y" => 20, "z" => 155];
    public $id = 44444;
    public $edit = "off";
    public $autenticando = [];

    public function addBoss(Player $player)
    {
        API::sendBossBarToPlayer($player, $this->id, "§4§k||§r§f§l{TheCod§4ê§f}§r§4§k||§r");
    }

    public function sendBossBar()
    {
        foreach ($this->getServer()->getOnlinePlayers() as $player) {
            API::setPercentage(100, $this->id);
            API::setTitle($this->Text(), $this->id, [$player]);
        }
    }

    public function Text()
    {
        $c = array("§a", "§d", "§0", "§9", "§5", "§4", "§3");
        $tx = $c[array_rand($c)] . "        §f§l{TheCod§4ê§f}§r" . " §1| " . $c[array_rand($c)] . " BETA";
        $st = count($this->getServer()->getOnlinePlayers()) . " §9| §7Coins §b: §a";
        return $tx . "\n\n" . "§7Players Online §b: §a" . $st;
    }

    public function removeBossToPlayer(Player $player)
    {
        API::removeBossBar([$player], $this->id);
    }

    public function addMorphs(Player $player, $type)
    {
        $par = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $p = $par->get($player->getName());
        if ($p == null) {
            $par->set($player->getName(), "ac");
            $par->save();
            foreach ($this->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity instanceof Player) {
                        if ($entity->getTargetEntity() == $player) {
                            $entity->close();
                        }
                    }
                }
            }
            $pet->set($player->getName(), "ds");
            $pet->save();
            $player->removeAllEffects();
            new Morph($player, $type);
        }
        if ($p == "ac") {
            $par->set($player->getName(), "ds");
            $par->save();
            foreach ($this->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity->getTargetEntity() == $player) {
                        $entity->close();

                    }
                }
            }
            $player->removeAllEffects();
        }
        if ($p == "ds") {
            $par->set($player->getName(), "ac");
            $par->save();
            foreach ($this->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity->getTargetEntity() == $player) {
                        $entity->close();

                    }
                }
            }
            $pet->set($player->getName(), "ds");
            $pet->save();
            $player->removeAllEffects();
            new Morph($player, $type);
        }


    }


    public function addPArticle(Player $player)
    {
        $par = new Config($this->getDataFolder() . "/particle.yml", Config::YAML);
        $p = $par->get($player->getName());
        if ($p == null) {
            $par->set($player->getName(), "ac");
            $par->save();

        }
        if ($p == "ac") {

            $par->set($player->getName(), "ds");
            $par->save();
        }
        if ($p == "ds") {

            $par->set($player->getName(), "ac");
            $par->save();
        }

    }

    public function createPet(Player $player, $type)
    {
        $par = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $p = $pet->get($player->getName());
        if ($p == null) {
            $pet->set($player->getName(), "ac");
            $pet->save();
            $par->set($player->getName(), "ds");
            $par->save();

            new Pet($player, $type);
            $player->removeAllEffects();
            $player->sendMessage("§7[§aPet§7]§e Me extrañaste?");
        }
        if ($p == "ds") {
            foreach ($this->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity->getTargetEntity() == $player) {
                        $entity->close();

                    }
                }
            }
            new Pet($player, $type);
            $par->set($player->getName(), "ds");
            $par->save();

            $player->removeAllEffects();
            $player->sendMessage("§7[§aPet§7]§e Me extrañaste?");
            $pet->set($player->getName(), "ac");
            $pet->save();
        }
        if ($p == "ac") {
            foreach ($this->getServer()->getLevels() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity->getTargetEntity() == $player) {
                        $entity->close();

                    }
                }
            }
            $par->set($player->getName(), "ds");
            $par->save();
            $player->removeAllEffects();
            $player->sendMessage("§7[§aPet§7]§e Adios!");
            $pet->set($player->getName(), "ds");
            $pet->save();
        }


    }


    public function checkPermission(Player $player)
    {
        $cfg = new Config($this->getDataFolder() . "rank.yml", Config::YAML);
        $p = '';
        $r = $cfg->get($player->getName());

        if ($r == null) {
            $p = "no";
        }

        if ($r == $this->cr or $r == $this->admin or $r == $this->fbi or $r == $this->titan) {
            $p = "owner";
        }

        if ($r == $this->king or $r == $this->king) {
            $p = "part";
        }

        if ($r == $this->dragon or $r == $this->master or $r == $this->miniyt or $r == $this->yt or $r == $this->ytmas) {
            $p = "vip";

        }
        return $p;
    }


    public function removePets()
    {
        foreach ($this->getServer()->getLevels() as $level) {
            foreach ($level->getEntities() as $entity) {
                if ($entity instanceof Armor) {
                    $entity->close();
                }
                if ($entity instanceof MePet) {
                    $entity->close();
                }
                if ($entity instanceof SpiderM) {
                    $entity->close();
                }
                if ($entity instanceof WitchM) {
                    $entity->close();
                }
                if ($entity instanceof ShopEntity) {
                    $entity->close();
                }
                if ($entity instanceof ShopEntity1) {
                    $entity->close();
                }
                if ($entity instanceof ShopEntity2) {
                    $entity->close();
                }
                if ($entity instanceof ShopEntity3) {
                    $entity->close();
                }

            }
        }
    }

//ACCIONES COINS


    public function onDisable()
    {
        $this->removePets();
    }

    public function onEnable()
    {
        new SQLConnection\DatabaseConnection($this);
        $world = $this->getServer()->getDefaultLevel();
        $world->setTime(0);
        $world->stopTime();
        $this->getServer()->getCommandMap()->register('gadgets', new GadgetsCommand($this), "Gadgets");
        $this->getServer()->getCommandMap()->register('lobby', new HubCommand($this), "Lobby");
        $this->getServer()->getCommandMap()->register('gadgets', new ParticlesCommand($this), "Particles");
        $this->getServer()->getCommandMap()->register('stats', new StatsCommand($this), "Statistics");
        $this->getServer()->getCommandMap()->register("topkills", new TopsCommand($this), "Top Kills");
        $this->getServer()->getCommandMap()->register("rank", new RanksCommand($this), "Ranks");
        $this->getLogger()->info("TheCodeCore enabled");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new DatabaseEventHandler($this), $this);
        Entity::registerEntity(Armor::class, true);
        Entity::registerEntity(SpiderM::class, true);
        Entity::registerEntity(MePet::class, true);
        Entity::registerEntity(WitchM::class, true);
        Entity::registerEntity(ShopEntity::class, true);
        Entity::registerEntity(ShopEntity1::class, true);
        Entity::registerEntity(ShopEntity2::class, true);
        Entity::registerEntity(ShopEntity3::class, true);
        @mkdir($this->getDataFolder());
        $config = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
        $config->save();
        $configa = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $configa->save();
        $configs = new Config($this->getDataFolder() . "/particle.yml", Config::YAML);
        $configs->save();
        $configsa = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $configsa->save();
        $configsaa = new Config($this->getDataFolder() . "/shop.yml", Config::YAML, [
            'shop1' => 0,
            'shop2' => 0,
            'shop3' => 0,
            'shop4' => 0,
            'level' => $this->getServer()->getDefaultLevel()->getName(),

        ]);
        $configsaa->save();
        $this->getScheduler()->scheduleRepeatingTask(new Boss($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new Taska($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new Helix($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new NameTagUpdate($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new Stand($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new ShopUpdate($this), 20);
        $this->spawnShop();
    }

    public function createShop1(Level $level, Vector3 $pos)
    {
        $compoundtag = Entity::createBaseNBT($pos);
        $npcgame = Entity::createEntity("ShopEntity", $level, $compoundtag);
        $npcgame->setScale(1.5);
        $npcgame->setNametagVisible(true);
        $npcgame->setNameTagAlwaysVisible(true);
        $npcgame->spawnToAll();


    }

    public function createShop2(Level $level, Vector3 $pos)
    {
        $compoundtag = Entity::createBaseNBT($pos);
        $npcgame = Entity::createEntity("ShopEntity1", $level, $compoundtag);
        $npcgame->setScale(1.5);
        $npcgame->setNametagVisible(true);
        $npcgame->setNameTagAlwaysVisible(true);
        $npcgame->spawnToAll();


    }

    public function createShop3(Level $level, Vector3 $pos)
    {
        $compoundtag = Entity::createBaseNBT($pos);
        $npcgame = Entity::createEntity("ShopEntity2", $level, $compoundtag);
        $npcgame->setScale(1.5);
        $npcgame->setNametagVisible(true);
        $npcgame->setNameTagAlwaysVisible(true);
        $npcgame->spawnToAll();


    }

    public function createShop4(Level $level, Vector3 $pos)
    {
        $compoundtag = Entity::createBaseNBT($pos);
        $npcgame = Entity::createEntity("ShopEntity3", $level, $compoundtag);
        $npcgame->setScale(1.5);
        $npcgame->setNametagVisible(true);
        $npcgame->setNameTagAlwaysVisible(true);
        $npcgame->spawnToAll();
    }

    public function spawnShop()
    {
        $shop = new Config($this->getDataFolder() . "/shop.yml", Config::YAML);
        $r = $shop->get("shop1");
        $s = $shop->get("shop2");
        $a = $shop->get("shop3");
        $b = $shop->get("shop4");

        if (!$r == 0 or !$s == 0 or !$a == 0 or !$b == 0) {

            $this->createShop1($this->getServer()->getLevelByName($shop->get('level')), new Vector3($r[0], $r[1], $r[2]));
            $this->createShop2($this->getServer()->getLevelByName($shop->get('level')), new Vector3($s[0], $s[1], $s[2]));
            $this->createShop3($this->getServer()->getLevelByName($shop->get('level')), new Vector3($a[0], $a[1], $a[2]));
            $this->createShop4($this->getServer()->getLevelByName($shop->get('level')), new Vector3($b[0], $b[1], $b[2]));
            $this->getServer()->getLogger()->info($this->prefix . " SHops Creadas");
        }

    }


    public function MovePortal(PlayerMoveEvent $event)
    {
        $par = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $pos = $event->getPlayer();
        $x = $pos->getX();
        $y = $pos->getY();
        $z = $pos->getZ();
        $x2 = 159;
        $y2 = 29;
        $z2 = 473;
        $x1 = 152;
        $y1 = 19;
        $z1 = 458;
        if ($event->getPlayer()->getLevel()->getFolderName() == "lob") {
            if ($pos->getY() <= 5) {
                $pos->teleport(new Vector3(105, 22, 129));
            }

        }
        if (($x <= max($x1, $x2)) and ($x >= min($x1, $x2)) and ($y <= max($y1, $y2)) and ($y >= min($y1, $y2)) and ($z <= max($z1, $z2)) and ($z >= min($z1, $z2))) {
            if ($event->getPlayer()->getLevel()->getFolderName() == "lob") {
                $pos->teleport(new Vector3(105, 22, 129));
                foreach ($this->getServer()->getLevels() as $level) {
                    foreach ($level->getEntities() as $entity) {
                        if ($entity->getTargetEntity() == $pos) {
                            $entity->close();
                            $pos->removeAllEffects();
                            if (!$par->get($pos->getName()) == null) {
                                if (!$pet->get($pos->getName()) == null) {
                                    $par->set($pos->getName(), "ds");
                                    $pet->set($pos->getName(), "ds");
                                    $par->save();
                                    $pet->save();


                                }


                            }


                        }
                    }
                }
            }
        }
    }

    public function enDrop(PlayerDropItemEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $event->setCancelled(true);
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
            $shop = new Config($this->getDataFolder() . "shop.yml", Config::YAML);
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
            $shop = new Config($this->getDataFolder() . "shop.yml", Config::YAML);

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
            $shop = new Config($this->getDataFolder() . "shop.yml", Config::YAML);

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
            $shop = new Config($this->getDataFolder() . "shop.yml", Config::YAML);
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
        $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $p = new Config($this->getDataFolder() . "/particle.yml", Config::YAML);
        $m = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $player = $e->getEntity();
        if ($player instanceof Player) {
            $level = $e->getTarget()->getName();
            if ($level == $this->getServer()->getDefaultLevel()->getFolderName()) {

            } else {
                foreach ($this->getServer()->getLevels() as $lvls) {
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
        foreach ($this->getServer()->getLevels() as $lvls) {
            foreach ($lvls->getEntities() as $e) {
                if ($e->getTargetEntity() == $player) {
                    $e->close();
                }
            }
        }
    }

    public function setDefaultShop(Player $player)
    {
        $shop = new Config($this->getDataFolder() . "/shop.yml", Config::YAML);
        if ($shop->get($player->getName()) == null) {

            $shop->set($player->getName(), [
                'cosmetic1' => "locket",
                'cosmetic2' => "locket",
                'cosmetic3' => "locket",
                'cosmetic4' => "locket",
            ]);
            $shop->save();


        }


    }

    public function caida(EntityDamageEvent $event)
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

    private function sendJoinSound(Player $player, string $soundName, float $volume = 0, float $pitch = 0)
    {
        $pk = new PlaySoundPacket();
        $pk->soundName = $soundName;
        $pk->x = (int)$player->x;
        $pk->y = (int)$player->y;
        $pk->z = (int)$player->z;
        $pk->volume = $volume;
        $pk->pitch = $pitch;
        $player->dataPacket($pk);
    }

    public function onJoin(PlayerJoinEvent $event)
    {
        $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
        $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
        $p = new Config($this->getDataFolder() . "/particle.yml", Config::YAML);
        $m = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
        $player = $event->getPlayer();
        if ($this->verifyUserInDB($player->getName()) == 0) {
            $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
            $player->setImmobile(true);
            $player->setInvisible(true);
            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::BLINDNESS), 999999, 1));
            $player->getInventory()->clearAll(true);
        } else {
            $player->setNametag("§r§c" . $player->getName());
            $this->addBoss($player);
            $this->lobby($player);
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
            $this->setDefaultShop($player);
            $player->removeAllEffects();
            $event->setJoinMessage("");
            $player->sendMessage(CoreUtils::AUTHENTICATE_MESSAGE);

            $r = $rank->get($player->getName());

            if ($r == $this->titan) {

                $player->setNameTag($this->titan . $player->getName());
                $player->setAllowFlight(false);


            } elseif ($r == $this->dragon) {

                $player->setNameTag($this->dragon . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->master) {

                $player->setNameTag($this->master . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->king) {

                $player->setNameTag($this->king . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->miniyt) {

                $player->setNameTag($this->miniyt . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->yt) {

                $player->setNameTag($this->yt . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->ytmas) {

                $player->setNameTag($this->ytmas . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->fbi) {

                $player->setNameTag($this->fbi . $player->getName());
                $player->setAllowFlight(false);

            } elseif ($r == $this->cr) {


                $player->setAllowFlight(false);
            } elseif ($r == $this->admin) {

                $player->setNameTag($this->admin . $player->getName());
                $player->setAllowFlight(false);
            }

            $this->menu($player);

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
        if ($this->verifyUserInDB($name) == 0) {
            $this->autenticando[] = $name;
            $chatEvent->setCancelled(true);
            if (!isset($args[0]) || !isset($args[1])) {
                $player->sendMessage(CoreUtils::REGISTER_MESSAGE);
            } elseif ($args[0] == $args[1]) {
                if (strlen($args[0]) > 6 and strlen($args[1]) > 6) {
                    $player->setImmobile(false);
                    $player->setInvisible(false);
                    $this->Menu($player);
                    $player->sendMessage(CoreUtils::AUTH_SUCESS);
                    $player->removeAllEffects();
                    $player->sendMessage($this->prefix . "§aObteniendo datos del jugador...");
                    $player->sendMessage($this->prefix . "§cPor favor espere...");
                    $player->sendMessage($this->prefix . "§aDatos obtenidos con exito!");
                    $getFace = new PlayerFaceAPI($this);
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
        $this->sendJoinSound($player, "mob.endermen.death", 1, 1);
        $this->addBoss($player);
    }


    /**
     * @param string $name
     * @return int
     */
    public function verifyUserInDB(string $name)
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


    /*Seccion de players function*/


    /**
     * @param Player $player
     * @return bool
     */
    public function lobby(Player $player): bool
    {
        if ($player->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $this->getServer()->loadLevel(Server::getInstance()->getDefaultLevel()->getName());
            $player->setGamemode(0);
            $this->Menu($player);
            return true;
        }
        return true;
    }


    public function onBreak(BlockBreakEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {

            $event->setCancelled();
        }
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {

            if ($this->edit == "on") {
                if ($event->getPlayer()->isOp()) {
                    $event->setCancelled(false);
                }
            }
            if ($this->edit == "off") {
                if ($event->getPlayer()->isOp()) {
                    $event->setCancelled(true);
                }
            }
        }

    }


    public function onPlace(BlockPlaceEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {

            $event->setCancelled();
        }
        if ($event->getPlayer()->getLevel()->getFolderName() == Server::getInstance()->getDefaultLevel()->getName()) {

            if ($this->edit == "on") {
                if ($event->getPlayer()->isOp()) {
                    $event->setCancelled(false);
                }
            }
            if ($this->edit == "off") {
                if ($event->getPlayer()->isOp()) {
                    $event->setCancelled(true);
                }
            }
        }

    }

    public function onPvP(EntityDamageEvent $eventPvP)
    {
        $map = $eventPvP->getEntity()->getLevel()->getName();
        if ($map == Server::getInstance()->getDefaultLevel()->getName()) {
            if ($eventPvP instanceof EntityDamageByEntityEvent) {
                if ($eventPvP->getEntity() instanceof Player && $eventPvP->getDamager() instanceof Player) {
                    $eventPvP->setCancelled();
                }
            }
        }
        if ($map == Server::getInstance()->getDefaultLevel()->getName()) {
            if ($eventPvP instanceof EntityDamageByEntityEvent) {
                if ($eventPvP->getEntity() instanceof Player && $eventPvP->getDamager() instanceof Player) {
                    $eventPvP->setCancelled();
                }
            }
        }
    }

    public function Menu(Player $player)
    {
        $player->getInventory()->clearAll();
        $player->setGamemode(2);
        $player->getInventory()->setItem(0, Item::get(Item::COMPASS, 0, 1)->setCustomName("§b§k||§r§6Teleports§b§k||"));
        $player->getInventory()->setItem(1, Item::get(Item::SKULL, 0, 1)->setCustomName("§b§k||§r§9Pets§b§k||"));
        $player->getInventory()->setItem(4, Item::get(Item::CHEST, 0, 1)->setCustomName("§b§k||§r§4Games§b§k||"));
        $player->getInventory()->setItem(7, Item::get(Item::DYE, 10, 1)->setCustomName("§b§k||§r§aParticulas§b§k||"));
        $player->getInventory()->setItem(8, Item::get(Item::NETHER_STAR, 0, 1)->setCustomName("§b§k||§r§2Miscelaneo§b§k||"));
        return true;
    }

    public function onPlayerInteractEvent(PlayerInteractEvent $event)
    {
        if ($event->getPlayer()->getLevel()->getName() == Server::getInstance()->getDefaultLevel()->getName()) {
            $i = $event->getItem();
            $player = $event->getPlayer();
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


    public function infoadmin(Player $player)
    {
        $this->sendPlayerForm($player);
    }

    public function dataPet(Player $player)
    {
        $datos = array(

            "type" => "form",
            "title" => "§l§6Cosmetics",
            "content" => "",
            "buttons" => array()

        );

        if ($this->checkPermission($player) == "no") {
            $datos["buttons"][] = array("text" => "§cNo tienes cosmeticos Disponibles\n§eCompra Rank para liberar");
        }

        if ($this->checkPermission($player) == "owner") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[0]);
            $datos["buttons"][] = array("text" => $name[1]);
            $datos["buttons"][] = array("text" => $name[2]);
            $datos["buttons"][] = array("text" => $name[3]);
            $datos["buttons"][] = array("text" => $name[4]);
        }
        if ($this->checkPermission($player) == "vip") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[0]);
            $datos["buttons"][] = array("text" => $name[1]);
            $datos["buttons"][] = array("text" => $name[2]);
            $datos["buttons"][] = array("text" => $name[3]);
            $datos["buttons"][] = array("text" => $name[4]);
        }
        if ($this->checkPermission($player) == "part") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[1]);

        }
        return $datos;
    }


    public function sendFormMB(): array
    {

        $datos = array(

            "type" => "form",
            "title" => "§l§7Servers Aliados",
            "content" => "",
            "buttons" => array()

        );
        for ($i = 0; $i < 1; $i++) {
            $name = array("§l§cMine§aCreepe§ePE");
            $datos["buttons"][] = array("text" => $name[0]);
        }


        return $datos;
    }

    public function sendPlayerForm(Player $pl)
    {
        $accion = function ($pl, $data) {
        };
        $pl->sendForm(new MenuForm($this->sendFormMB(), $accion));
    }

    public function sendFormGames()
    {
        $datos = array(

            "type" => "form",
            "title" => "§k§6iii§r§9§lGames§r§k§6iii§r",
            "content" => "",
            "buttons" => array()

        );
        for ($i = 0; $i < 5; $i++) {
            $name = array("§k§aiii§r§l§6SkyWars§r§k§aiii§r\n§eCombate en islas flotantes!", "§k§aiii§r§l§6FFA§r§k§aiii§r\n§eTodos vs Todos!", "§k§aiii§r§l§6TheBridge§r§k§aiii§r\n§eCuantos puntos lograras hacer?", "§k§aiii§r§l§61vs1§r§k§aiii§r\n§eResuelve disputas!", "§k§aiii§r§l§6EggWars§r§k§aiii§r\n§eMuy pronto");
            $datos["buttons"][] = array("text" => $name[$i]);
        }
        return $datos;
    }


    public function GamesTP(Player $player)
    {
        if ($player instanceof Player) {
            $accion = function ($pl, $data) {
                if ($data !== null) {
                    $par = new Config($this->getDataFolder() . "/mor.yml", Config::YAML);
                    $pet = new Config($this->getDataFolder() . "/pet.yml", Config::YAML);
                    $name = array("§k§aiii§r§l§6SkyWars§r§k§aiii§r\n§eCombate en islas flotantes!", "§k§aiii§r§l§6FFA§r§k§aiii§r\n§eTodos vs Todos!", "§k§aiii§r§l§6TheBridge§r§k§aiii§r\n§eCuantos puntos lograras hacer?", "§k§aiii§r§l§61vs1§r§k§aiii§r\n§eResuelve disputas!", "§k§aiii§r§l§6EggWars§r§k§aiii§r\n§eMuy pronto");
                    if ($pl instanceof Player) {
                        switch ($name[$data]) {
                            case $name[0]:
                                $pl->teleport(new Vector3(140, 19, 116));
                                foreach ($this->getServer()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if ($entity->getTargetEntity() == $pl) {
                                            $entity->close();
                                            $pl->removeAllEffects();
                                            if (!$par->get($pl->getName()) == null) {
                                                if (!$pet->get($pl->getName()) == null) {
                                                    $par->set($pl->getName(), "ds");
                                                    $pet->set($pl->getName(), "ds");
                                                    $par->save();
                                                    $pet->save();


                                                }


                                            }

                                        }
                                    }
                                }
                                break;
                            case $name[1]:
                                $pl->teleport(new Vector3(142, 19, 122));
                                foreach ($this->getServer()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if ($entity->getTargetEntity() == $pl) {
                                            $entity->close();
                                            $pl->removeAllEffects();
                                            if (!$par->get($pl->getName()) == null) {
                                                if (!$pet->get($pl->getName()) == null) {
                                                    $par->set($pl->getName(), "ds");
                                                    $pet->set($pl->getName(), "ds");
                                                    $par->save();
                                                    $pet->save();
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                            case $name[2]:
                                $pl->teleport(new Vector3(140, 19, 135));
                                foreach ($this->getServer()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if ($entity->getTargetEntity() == $pl) {
                                            $entity->close();
                                            $pl->removeAllEffects();

                                        }
                                    }
                                }
                                break;
                            case $name[3]:
                                $pl->teleport(new Vector3(138, 19, 140));
                                foreach ($this->getServer()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if ($entity->getTargetEntity() == $pl) {
                                            $entity->close();
                                            $pl->removeAllEffects();
                                            if (!$par->get($pl->getName()) == null) {
                                                if (!$pet->get($pl->getName()) == null) {
                                                    $par->set($pl->getName(), "ds");
                                                    $pet->set($pl->getName(), "ds");
                                                    $par->save();
                                                    $pet->save();


                                                }


                                            }
                                        }
                                    }
                                }
                                break;
                            case $name[4]:
                                $pl->teleport(new Vector3(124, 19, 129));
                                foreach ($this->getServer()->getLevels() as $level) {
                                    foreach ($level->getEntities() as $entity) {
                                        if ($entity->getTargetEntity() == $pl) {
                                            $entity->close();
                                            $pl->removeAllEffects();
                                            if (!$par->get($pl->getName()) == null) {
                                                if (!$pet->get($pl->getName()) == null) {
                                                    $par->set($pl->getName(), "ds");
                                                    $pet->set($pl->getName(), "ds");
                                                    $par->save();
                                                    $pet->save();


                                                }


                                            }
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            };
            $player->sendForm(new MenuForm($this->sendFormGames(), $accion));
        }
    }


    public function onChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $rank = DataExtractor::getPlayerRank($player);
        $event->setFormat("§8> §7" . $player->getName() . " §8>> §7" . $message);
        if ($rank != null) {
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
}

class Taska extends Task
{

    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;

    }

    public function onRun(int $tick)
    {
        $lobby = $this->plugin->getServer()->getLevelByName(Server::getInstance()->getDefaultLevel()->getName());
        if ($lobby instanceof Level) {
            $players = $lobby->getPlayers();
            foreach ($players as $pl) {
                $pl->setFood(20);
                $pl->setHealth(20);
                $deaths = DataExtractor::getPlayerDeaths($pl);
                $kills = DataExtractor::getPlayerKills($pl);
                $money = DataExtractor::getPlayerMoney($pl);
                $pl->sendTip("§f{TheCod§4ê§f}§7 Beta Edition | " . "§cPlayers online:§6 " . count(Server::getInstance()->getOnlinePlayers()) . "\n            §2Kills: §e" . $kills . " §2Deaths: §e" . $deaths . " §2Money: §e" . $money);
            }
        }
    }
}


class Boss extends Task
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;

    }

    public function onRun(int $tick)
    {
        $this->plugin->sendBossBar();
    }
}
