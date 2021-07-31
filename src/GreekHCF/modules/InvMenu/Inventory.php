<?php

namespace GreekHCF\modules\InvMenu;

use pocketmine\block\{Block, BlockIds};
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\tile\Tile;

class Inventory extends InvHandler {

    public function __construct(){
        parent::__construct();
    }

    public function getDefaultSize() : int{
        return 27;
    }

    public function getNetworkType() : int{
        return self::CONTAINER;
    }

    public function getBlockId() : int{
        return BlockIds::CHEST;
    }
}

?>