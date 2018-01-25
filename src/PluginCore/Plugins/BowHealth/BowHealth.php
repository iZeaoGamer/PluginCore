<?php
namespace PluginCore\Plugins\BowHealth;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
class BowHealth extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder()."config.yml",Config::YAML,array(
				"Msg" => "Player {PLAYER} has {HEALTH}/{MAXHEALTH}",
				"Message" => "true",
				"Popup" => "false"
		));
		$this->config->save();
	}
	
	public function onHit(EntityDamageEvent $ev){
		$entity = $ev->getEntity();
			if ($ev->getCause() === EntityDamageByEntityEvent::CAUSE_PROJECTILE){
				if ($entity instanceof Player){
					$shooter = $ev->getDamager();
						if ($shooter instanceof Player){
							$msg = $this->config->get("Msg");
							$msg = str_replace("{PLAYER}", $entity->getName(), $msg);
							$msg = str_replace("{HEALTH}", $entity->getHealth(), $msg);
							$msg = str_replace("{MAXHEALTH}", $entity->getMaxHealth(), $msg);
							if ($this->config->get("Message") === "true"){
								$shooter->sendMessage($msg);
							} 
							if ($this->config->get("Popup") === "true"){
								$shooter->sendPopup($msg);
							}
						}
					
				}
			}
		
	}
	
	
}
