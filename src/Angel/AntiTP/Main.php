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
    if($p->isOp() or $p->hasPermission("simplewarp.warp.pvp")){
      if($command == "./arena" || $command == "/arena"){
        $p->setGamemode(0);
        $this->tper[strtolower($p->getName())] = strtolower($p->getName());
      }
      // cancels event if force tped and run blocked force tp command
      if(isset($this->tper[strtolower($p->getName())])){
        if($command == "/fly" || $command == "./fly"){
          $ev->setCancelled(true);
          $p->sendMessage("§cYou are not allowed to use this command because you're in the arena. To fix this, use /spawn.");
        }
      }
      
      if($command == "/spawn" || $command == "./spawn"){
        unset($this->tper[strtolower($p->getName())]);
        $p->sendMessage("§aFixed! Now try /fly.");
        $p->setGamemode(0);
      }
    }
  }
}
