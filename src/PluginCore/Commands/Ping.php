<?php
namespace PluginCore\Commands;
use PluginCore\Loader;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\TextFormat;
class Ping extends PluginCommand {
    private $prefix =  TextFormat::BOLD . TextFormat::GREEN . "Ping" . TextFormat::RESET;
    public function __construct($name, Loader $main){
        $this->main = $main;
        $this->setDescription("/ping to view the latency from the server to your home");
        parent::__construct($name, $main);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
        if (!$sender instanceof Player) {
            $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must be in-game to run this command.");
        }
        if ($sender instanceof Player) {
            $ping = $sender->getPing();
            $color = TextFormat::GREEN;
            if($ping >= 150 and $ping <= 250){
                $color = TextFormat::GOLD;
            }elseif($ping >= 250 and $ping <= 350){
                $color = TextFormat::RED;
            }elseif($ping > 350){
                $color = TextFormat::DARK_RED;   
            }
            $sender->sendMessage($this->prefix . TF::GRAY . " Your ping is " . $color . $ping . "ms");
            return true;
        }
        return true;
    }
}