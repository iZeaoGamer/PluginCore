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
use PluginCore\Commands\GBuy;
use PluginCore\Commands\Friends;
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
        $this->getServer()->getCommandMap()->register("gbuy", new GBuy("gbuy", $this));
        $this->getServer()->getCommandMap()->register("ban", new Ban("ban", $this));
        $this->getServer()->getCommandMap()->register("banip", new BanIP("banip", $this));
        $this->getServer()->getCommandMap()->register("tban", new TBan("tban", $this));
        $this->getServer()->getCommandMap()->register("tbanip", new TBanIP("tbanip", $this));
        $this->getServer()->getCommandMap()->register("kick", new Kick("kick", $this));
        $this->getServer()->getCommandMap()->register("tblock", new TBlock("tblock", $this));
        $this->getServer()->getCommandMap()->register("tblockip", new TBlockIP("tblockip", $this));
        $this->getServer()->getCommandMap()->register("block", new Block("block", $this));
        $this->getServer()->getCommandMap()->register("blockip", new BlockIP("blockip", $this));
        $this->getServer()->getCommandMap()->register("tmute", new TMute("tmute", $this));
        $this->getServer()->getCommandMap()->register("tmuteip", new TMuteIP("tmuteip", $this));
        $this->getServer()->getCommandMap()->register("blocklist", new BlockList("blocklist", $this));
        $this->getServer()->getCommandMap()->register("banlist", new BanList("banlist", $this));
        $this->getServer()->getCommandMap()->register("mute", new Mute("mute", $this));
        $this->getServer()->getCommandMap()->register("muteip", new MuteIP("muteip", $this));
        $this->getServer()->getCommandMap()->register("unban", new Unban("unban", $this));
        $this->getServer()->getCommandMap()->register("unbanip", new UnbanIP("unbanip", $this));
        $this->getServer()->getCommandMap()->register("pardon", new Pardon("pardon", $this));
        $this->getServer()->getCommandMap()->register("pardonip", new PardonIP("pardonip", $this));
    }
}
