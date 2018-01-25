<?php

namespace PluginCore\Commands;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat as C;
use PluginCore\Loader;
class Hub extends Loader {
    public function __construct($name, Loader $plugin){
        parent::__construct($name, $plugin);
    	$this->setDescription("Teleport to Hub.");
    	$this->setAliases(["lobby"]);
    }
     
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if ($sender instanceof Player) {
            $level = $sender->getLevel();
            $x = $sender->getX();
            $y = $sender->getY();
            $z = $sender->getZ();
            $spawn = new Vector3($x, $y, $z);
            $sender->sendMessage(C::GREEN . "Teleporting to Hub.");
            $sender->teleport($this->getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
            $level->addSound(new EndermanTeleportSound($spawn));
        } else {
            $sender->sendMessage(C::RED . "You are not in-Game.");
        }
        return true;
    }
}
