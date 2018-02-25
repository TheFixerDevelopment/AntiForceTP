<?php
namespace Angel\AntiTP;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
class Main extends PluginBase implements Listener{
  
  public $tper = [];
  
  public function onEnable(){
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
  public function antiTP(PlayerCommandPreprocessEvent $ev){
    $p = $ev->getPlayer();
    $command = strtolower(explode(" ", $ev->getMessage())[0]);
    if($p->isOp() or $p->hasPermission("pocketmine.command.teleport")){
      if($command == "./tp" || $command == "/tp"){
        $p->setGamemode(0);
        $p->sendMessage("§aYou have teleported to a player! \n§aYou best not abuse your tp. Only use it to catch hackers.");
        $this->tper[strtolower($p->getName())] = strtolower($p->getName());
      }
      // cancels event if force tped and run blocked force tp command
      if(isset($this->tper[strtolower($p->getName())])){
        if($command == "/sethome" || $command == "./sethome" || $command == "/god" || $command == "./god" || $command == "/gamemode" || $command == "./gamemode" || $command == "/gma" || $command == "./gma" || $command == "/creative" || $command == "./creative" || $command == "/survival" || $command == "./survival" || $command == "/adventure" || $command == "./adventure" || $command == "./gmc" || $command == "/gmc" || $command == "./gms" || $command == "/gms" || $command == "./createhome" || $command == "/createhome"){
          $ev->setCancelled(true);
          $p->sendMessage("§cThis command is blocked by the server because you force tped. We do not want abusers. To fix this, use /spawn. Please do not use this command again.\n§cYou could potentially get demoted. Who knows!\n§cIt's called tp raiding / tp abuse.");
        }
      }
      
      if($command == "/spawn" || $command == "./spawn" || $command == "/hub" || $command == "./hub"){
        unset($this->tper[strtolower($p->getName())]);
        $p->setGamemode(0);
      }
    }
  }
 }
