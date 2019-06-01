<?php
namespace EversoftTeam;

use pocketmine\scheduler\Task;
use pocketmine\utils\Config;

class NameTagUpdate extends Task {

private $plugin;
public function __construct(Main $eid){

		$this->plugin = $eid;

	}
public function onRun(int $currentTick){
	$world = $this->plugin->getServer()->getDefaultLevel();
	foreach($world->getPlayers() as $player){

 $rank = new Config($this->plugin->getDataFolder() . "/rank.yml", Config::YAML);
 $r = $rank->get($player->getName());

if($r == $this->plugin->titan)
        {
          
            $player->setNameTag($this->plugin->titan.$player->getName());
            
            
           
            
        }
        elseif($r == $this->plugin->dragon)
        {
           
            $player->setNameTag($this->plugin->dragon.$player->getName());
           
              
        }
        elseif($r == $this->plugin->master)
        {
             
            $player->setNameTag($this->plugin->master.$player->getName());
            
             
        }
        elseif($r == $this->plugin->king)
        {
             
            $player->setNameTag($this->plugin->king.$player->getName());
            
              
        }
        elseif($r == $this->plugin->miniyt)
        {
            
            $player->setNameTag($this->plugin->miniyt.$player->getName());
           
             
        }
        elseif($r == $this->plugin->yt)
        {
            
            $player->setNameTag($this->plugin->yt.$player->getName());
            
             
        }
        elseif($r == $this->plugin->ytmas)
        {
            
            $player->setNameTag($this->plugin->ytmas.$player->getName());
            
             
        }
        elseif($r == $this->plugin->fbi)
        {
             
            $player->setNameTag($this->plugin->fbi.$player->getName());
          
          
        }
        elseif($r == $this->plugin->cr)
        {
          
            
            $player->setNameTag($this->plugin->cr.$player->getName());
        }
        elseif($r == $this->plugin->admin)
        {
            
            $player->setNameTag($this->plugin->admin.$player->getName());
            ;
        }



	}

	}





}