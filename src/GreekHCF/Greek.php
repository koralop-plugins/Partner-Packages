<?php

namespace GreekHCF;

use GreekHCF\backup\ItemsBackup;
use GreekHCF\commands\ParterPackagesCommand;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TE;

class Greek extends PluginBase {

    public static $instance;
    
    public static $items;

    public function onLoad(){
        self::$instance = $this;
    }

    public function onEnable(){
        $this->getLogger()->info(TE::LIGHT_PURPLE."Partner Packages ".TE::GRAY."by ".TE::GOLD."Koralop");
        $this->getServer()->getCommandMap()->register("/pp", new ParterPackagesCommand());
        $this->getServer()->getPluginManager()->registerEvents(new GreekListener($this), $this);
        if(!is_dir($this->getDataFolder()."backup")){
        	@mkdir($this->getDataFolder()."backup");
        }
        ItemsBackup::init();
    }
    
    public function onDisable(): void{
        ItemsBackup::save();
    }

    public static function getInstance():Greek{
        return self::$instance;
    }


}

