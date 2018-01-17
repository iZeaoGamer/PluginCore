<?php

namespace PluginsCore\Listeners;

use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerJoinEvent;

class FriendsEvent extends Listener

public $request = array();

	public function onEnable(){
		$this->getLogger()->info("Loaded!");
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		@mkdir($this->getDataFolder());
		@mkdir($this->getDataFolder()."players/");
	}
	//events
	public function onDamageByPlayer(EntityDamageEvent $ev){
		$cause = $ev->getCause();
		switch ($cause){
		case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
		$atkr = $ev->getDamager();
		$player = $ev->getEntity();
		if ($atkr instanceof Player and $player instanceof Player){
			if($this->isFriend($player, $atkr->getName())){
				$ev->setCancelled();
				$atkr->sendMessage("Cannot attack friend :(");
			}
		}
		break;
		}
	}
	
	public function onJoin(PlayerJoinEvent $ev){
		if (!file_exists($this->getDataFolder()."players/".$ev->getPlayer()->getName().".yml")){
			$config = new Config($this->getDataFolder()."players/".strtolower($ev->getPlayer()->getName()).".yml", Config::YAML);
			$config->set("friends", array());
			$config->save();
			$plugin->getLogger()->info("Made config for ".$ev->getPlayer()->getName()");
		}
	}
