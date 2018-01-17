<?php
namespace PluginCore\Commands;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityDamageEvent;
class friend extends Loader {
	
	//commands
	public function onCommand(CommandSender $sender,Command $command, string $label,array $args): bool{
		switch($command->getName()){
			case "friend":
			if ($sender instanceof Player){
			if (isset($args[0])){
				switch ($args[0]){
					case "add":
						if ($sender->hasPermission("friend.add")){
						if (isset($args[1])){
							$player = $this->getServer()->getPlayer($args[1]);
							if(!$player == null){
								$this->addRequest($player, $sender);
							}	else {
								$sender->sendMessage(TextFormat::RED."Player not found");
							}
						}
						return true;
						}else{
							$sender->sendMessage(TextFormat::RED."You do not have permission for that command :(");
						}
					break;
					case "remove":
						if ($sender->hasPermission("friend.remove")){
						if (isset($args[1])){
							if ($this->removeFriend($sender, $args[1])){
								$sender->sendMessage("Friend removed");
							}else{
								$sender->sendMessage("Friend not found do /friend list \n to list your friends");
							}
						}else{
							$sender->sendMessage("Usage: /friend remove [name]");
						}
						return true;
						}else{
							$sender->sendMessage(TextFormat::RED."You do not have permission for that command :(");
						}
					break;
					case "list":
						if ($sender->hasPermission("friend.list")){
						$config = new Config($this->getDataFolder()."players/". strtolower($sender->getName()).".yml", Config::YAML);
						$array = $config->get("friends", []);
						$sender->sendMessage(TextFormat::GOLD.TextFormat::BOLD."Friends:");
						foreach ($array as $friendname){
							$sender->sendMessage(TextFormat::GREEN."* ".$friendname);
						}
						return true;
						}else {
							$sender->sendMessage(TextFormat::RED."You do not have permission for that command :(");
						}
					break;
					
				}
			}}else{
		$sender->sendMessage("Must use command in-game");
	}
			break;
			case "accept":
				if ($sender->hasPermission("friend.accept")){
				$plugin->getLogger()->info("var_dump($this->request");
				if (in_array($sender->getName(), $this->request)){
					$plugin->getLogger()->info("added");
					foreach ($this->request as $target => $requestp){
						$target = $this->getServer()->getPlayer($target);
						$requestp = $this->getServer()->getPlayer($requestp);
						$plugin->getLogger()->info("$target->getName().$requestp->getName()");
						if ($requestp->getName() === $sender->getName()){
							$plugin->getLogger()->info("yes");
							$this->addFriend($target, $requestp);
							$this->addFriend($requestp, $target);
						}
						
					}
					return true;
				}else{
					$sender->sendMessage("No pending friend requests :(");
				}
				return true;
				}else{
					$sender->sendMessage(TextFormat::RED."You do not have permission for that command :(");
				}
			break;
		}
	}
	
	//api
	public function addRequest(Player $target,Player $requestp){
		if (!$this->isFriend($requestp, $target->getName())){
		$requestp->sendMessage("Sent request to ".$target->getName());
		$this->request[$requestp->getName()] = $target->getName();
		$target->sendMessage(TextFormat::GREEN.$requestp->getName()." has requested you as a friend do /accept to accept or ignore to ignore");
		echo var_dump($this->request);
 		$task = new cancelrequest($this, $target, $requestp);
 		$this->getServer()->getScheduler()->scheduleDelayedTask($task, 20*10);
 		return ;
		}else{
			$requestp->sendMessage("That player is already your friend :)");
		}
	}
	
	public function removeRequest(Player $target,Player $requestp, $reason){
		if (in_array($target->getName(), $this->request)){
			if ($reason == 0){
				$requestp->sendMessage(TextFormat::RED."Player ".$target->getName()." did not accept your friend request... :(");
			}
			unset($this->request[$requestp->getName()]);
		}
	}
	
	public function addFriend(Player $player,Player $friend){
		$player->sendMessage("added friend".$friend->getName());
		$friend->sendMessage("added friend ".$player->getName());
		$config = new Config($this->getDataFolder()."players/". strtolower($player->getName()).".yml", Config::YAML);
		$array = $config->get("friends", []);
		$array[] = $friend->getName();
		$config->set("friends", $array);
		$config->save();
		$this->removeRequest($friend, $player, 1);
	}
	
	public function removeFriend(Player $player, $friendname){
		if ($this->isFriend($player, $friendname)){
			$config = new Config($this->getDataFolder()."players/". strtolower($player->getName()).".yml", Config::YAML);
			$array = $config->get("friends", []);
			$id = array_search($friendname, $array);
			unset($array[$id]);
			$config->set("friends", $array);
			$config->save();
			return true;
		}
		return false;
	}
	
	public function isFriend(Player $player, $isfriendname){
		$config = new Config($this->getDataFolder()."players/". strtolower($player->getName()).".yml", Config::YAML);
		$array = $config->get("friends", []);
		if (in_array($isfriendname, $array)){
			return true;
		}
		return false;
	}
	
}
