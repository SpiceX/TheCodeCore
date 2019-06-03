<?php

namespace EversoftTeam;

use EversoftTeam\EventListeners\GlobalEventHandler;
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
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
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

    public $id = 44444;
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
        $this->getServer()->getPluginManager()->registerEvents(new GlobalEventHandler($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new DatabaseEventHandler($this), $this);
        Entity::registerEntity(Armor::class, true);
        Entity::registerEntity(SpiderM::class, true);
        Entity::registerEntity(MePet::class, true);
        Entity::registerEntity(WitchM::class, true);
        Entity::registerEntity(ShopEntity::class, true);
        Entity::registerEntity(ShopEntity1::class, true);
        Entity::registerEntity(ShopEntity2::class, true);
        Entity::registerEntity(ShopEntity3::class, true);
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
            $this->getServer()->getLogger()->info(CoreUtils::PREFIX . " SHops Creadas");
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


    public function sendJoinSound(Player $player, string $soundName, float $volume = 0, float $pitch = 0)
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


    public function dataPet(Player $player)
    {
        $datos = array(

            "type" => "form",
            "title" => "§l§6Cosmetics",
            "content" => "",
            "buttons" => array()

        );

        if ($this->checkPermission($player) == "User") {
            $datos["buttons"][] = array("text" => "§cNo tienes cosmeticos Disponibles\n§eCompra Rank para liberar");
        }

        if ($this->checkPermission($player) == "vip_user") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[0]);
            $datos["buttons"][] = array("text" => $name[1]);
            $datos["buttons"][] = array("text" => $name[2]);
            $datos["buttons"][] = array("text" => $name[3]);
            $datos["buttons"][] = array("text" => $name[4]);
        }
        if ($this->checkPermission($player) == "bedrock") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[0]);
            $datos["buttons"][] = array("text" => $name[1]);
            $datos["buttons"][] = array("text" => $name[2]);
            $datos["buttons"][] = array("text" => $name[3]);
            $datos["buttons"][] = array("text" => $name[4]);
        }
        if ($this->checkPermission($player) == "ore_user") {
            $name = array("§l§eStand Creeper\n§r§5Type§7: §aPet", "§l§eHelix\n§r§5Type§7: §aParticle", "§l§eMini Me\n§r§5Type§7: §aPet", "§l§eSpider\n§r§5Type§7: §aMorph", "§l§eWitch\n§r§5Type§7: §aMorph");
            $datos["buttons"][] = array("text" => $name[1]);
        }
        return $datos;
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



    public function onDisable()
    {
        $this->removePets();
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
