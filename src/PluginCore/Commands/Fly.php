<?php

namespace PluginCore\Commands;

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
use pocketmine\command\{PluginCommand, CommandSender};
use pocketmine\command\CommandExecutor;
class Fly extends PluginCommand {
    public $players = array();
     public function onEntityDamage(EntityDamageEvent $event) {
        if($event instanceof EntityDamageByEntityEvent) {
        $damager = $event->getDamager();
           if($damager instanceof Player && $this->isPlayer($damager)) {
              $damager->sendTip(TextFormat::RED . "You cannot damage players while in fly mode!");
              $event->setCancelled(true);
           }
        }
     }
   public function onJoin(PlayerJoinEvent $event){
        $sender = $event->getPlayer();
        if ($sender->hasPermission("plugincore.fly.off")) {
            /**
             * onJoin if in survival mode = setAllowFlight false
             */
                 if($this->isPlayer($sender)) {
                    $this->removePlayer($sender);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage(TextFormat::GREEN . "§dYou have disabled fly mode since you joined!");
                    return true;
            }
        }
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if(strtolower($command->getName()) == "fly") {
            if($sender instanceof Player) {
                if($this->isPlayer($sender)) {
                    $this->removePlayer($sender);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage(TextFormat::RED . "You have disabled fly mode!");
                    return true;
                }
                else{
                    $this->addPlayer($sender);
                    $sender->setAllowFlight(true);
                    $sender->sendMessage(TextFormat::GREEN . "You have enabled fly mode!");
                    return true;
                }
            }
            else{
                $sender->sendMessage(TextFormat::RED . "Please use this command in-game.");
                return true;
            }
        }
    }
    public function addPlayer(Player $player) {
        $this->players[$player->getName()] = $player->getName();
    }
    public function isPlayer(Player $player) {
        return in_array($player->getName(), $this->players);
    }
    public function removePlayer(Player $player) {
        unset($this->players[$player->getName()]);
    }
}
