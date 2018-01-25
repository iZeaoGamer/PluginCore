<?php

namespace PluginCore;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\Textformat as C;
use PluginCore\Plugins\ActionSystem;
use PluginCore\Plugins\FriendsPE;
use PluginCore\Plugins\BowHealth;
use PluginCore\Commands\{BanCommand, BanIPCommand};
use PluginCore\Commands\{TBanCommand, TBanIPCommand};
use PluginCore\Commands\KickCommand;
use PluginCore\Commands\{TBlockCommand, TBlockIPCommand};
use PluginCore\Commands\{BlockCommand, BlockIPCommand};
use PluginCore\Commands\{TMuteCommand, TMuteIPCommand};
use PluginCore\Commands\{BlockListCommand, BanListCommand};
use PluginCore\Commands\{MuteIPCommand, MuteCommand};
use PluginCore\Commands\{UnbanCommand, UnbanIPcommand, PardonCommand, PardonIPCommand};
/*use PluginCore\Commands\GBuy; TODO*/
use PluginCore\Commands\Fly;
class Loader extends PluginBase{
    public $cfg;
    
    public function onEnable(){
            $this->RegConfig();
	    $this->RegCommands();
            $this->getLogger()->info(C::GREEN."PluginCore Enabled.");
    }
    
    public function onDisable(){
        $this->getLogger()->info(C::RED."Disabled.");
    }
    public function RegConfig(){
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveResource("title.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }
    private function RegCommands(){
        $this->getServer()->getCommandMap()->register("fly", new Fly("fly", $this));
        /*$this->getServer()->getCommandMap()->register("gbuy", new GBuy("gbuy", $this)); TODO*/
        $this->getServer()->getCommandMap()->register("ban", new BanCommand("ban", $this));
        $this->getServer()->getCommandMap()->register("banip", new BanIPCommand("banip", $this));
        $this->getServer()->getCommandMap()->register("tban", new TBanCommand("tban", $this));
        $this->getServer()->getCommandMap()->register("tbanip", new TBanIPCommand("tbanip", $this));
        $this->getServer()->getCommandMap()->register("kick", new KickCommand("kick", $this));
        $this->getServer()->getCommandMap()->register("tblock", new TBlockCommand("tblock", $this));
        $this->getServer()->getCommandMap()->register("tblockip", new TBlockIPCommand("tblockip", $this));
        $this->getServer()->getCommandMap()->register("block", new BlockCommand("block", $this));
        $this->getServer()->getCommandMap()->register("blockip", new BlockIPCommand("blockip", $this));
        $this->getServer()->getCommandMap()->register("tmute", new TMuteCommand("tmute", $this));
        $this->getServer()->getCommandMap()->register("tmuteip", new TMuteIPCommand("tmuteip", $this));
        $this->getServer()->getCommandMap()->register("blocklist", new BlockListCommand("blocklist", $this));
        $this->getServer()->getCommandMap()->register("banlist", new BanListCommand("banlist", $this));
        $this->getServer()->getCommandMap()->register("mute", new MuteCommand("mute", $this));
        $this->getServer()->getCommandMap()->register("muteip", new MuteIPCommand("muteip", $this));
        $this->getServer()->getCommandMap()->register("unban", new UnbanCommand("unban", $this));
        $this->getServer()->getCommandMap()->register("unbanip", new UnbanIPCommand("unbanip", $this));
        $this->getServer()->getCommandMap()->register("pardon", new PardonCommand("pardon", $this));
        $this->getServer()->getCommandMap()->register("pardonip", new PardonIPCommand("pardonip", $this));
    }
}
