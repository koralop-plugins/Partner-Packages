<?php

namespace GreekHCF;

use GreekHCF\backup\ItemsBackup;
use GreekHCF\modules\InvMenu\Inventory;
use GreekHCF\modules\PartnerPackage;

use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\utils\TextFormat as TE;

/**
 * Class GreekListener
 * @package GreekHCF
 */
class GreekListener implements Listener
{

    /**
     * @param PlayerInteractEvent $event
     */
    public function PlayerInteractEvent(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item->getId() === 130) {
            if ($item->getCustomName() === TE::BOLD . TE::LIGHT_PURPLE . "Partner Packages") {
                $event->setCancelled(true);
                if (count(PartnerPackage::getItems()) == 0)
                    return;

                if (!$player->getInventory()->canAddItem(PartnerPackage::getRandomItem())) {
                    $player->sendMessage(TE::RED . "Your inventory is full!");
                    return;
                }

                $item = PartnerPackage::getRandomItem();
                $player->sendMessage(TE::GOLD . "You recived an item" . TE::GRAY . ": " . $item->getCustomName());
                $player->getLevel()->addSound(new BlazeShootSound($event->getPlayer()->asVector3()), [$event->getPlayer()]);
                $player->getInventory()->addItem($item);
                $player->getInventory()->setItemInHand($player->getInventory()->getItemInHand()->setCount($player->getInventory()->getItemInHand()->getCount() - 1));
            }
        }
    }

    /**
     * @param InventoryTransactionEvent $event
     */
    public function InventoryTransactionEvent(InventoryTransactionEvent $event): void
    {
        $transaction = $event->getTransaction();
        foreach ($transaction->getActions() as $action) {
            if ($action instanceof SlotChangeAction) {
                $inventory = $action->getInventory();
                if ($inventory instanceof Inventory) {
                    $event->setCancelled(true);
                }
            }
        }
    }
}