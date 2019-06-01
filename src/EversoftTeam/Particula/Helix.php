<?php
namespace EversoftTeam\Particula;
use pocketmine\scheduler\Task;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\level\particle\FlameParticle;
class Helix extends Task {

    public $plugin;

public function __construct(\EversoftTeam\Main $eid){

		$this->plugin = $eid;

	}
public function onRun(int $currentTick){

$world = $this->plugin->getServer()->getDefaultLevel();
foreach($world->getPlayers() as $pl){
$par = new Config($this->plugin->getDataFolder()."particle.yml",Config::YAML);

$p = $par->get($pl->getName());

if(!$p == null){
if($p == "ac"){
$level = $this->plugin->getServer()->getDefaultLevel();
$location = new Vector3($pl->getX(),$pl->getY(),$pl->getZ());
$radio = 5;

	for($i = 5; $i > 0; $i-=0.1){

	$radio = $i/3;

	$x = $radio*cos(3*$i);

	$y = 5-$i;

	$z = $radio*sin(3*$i);

	$level->addParticle(new FlameParticle($location->add($x, $y, $z)));

	}

	for($i = 5; $i > 0; $i-=0.1){

	$radio = $i/3;

	$x = -$radio*cos(3*$i);

	$y = 5-$i;

	$z = -$radio*sin(3*$i);

	$level->addParticle(new FlameParticle($location->add($x, $y, $z)));

	}


}

}



}		

	}





}