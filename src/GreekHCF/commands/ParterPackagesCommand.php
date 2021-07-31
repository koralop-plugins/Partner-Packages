<?php

namespace GreekHCF\commands;

use GreekHCF\backup\ItemsBackup;
use GreekHCF\Greek;
use GreekHCF\GreekUtils;

use GreekHCF\modules\InvMenu\Inventory;
use GreekHCF\modules\PartnerPackage;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat as TE;
use pocketmine\Player;

class ParterPackagesCommand extends PluginCommand
{

    /**
     * ParterPackagesCommand constructor.
     */
    public function __construct()
    {
        parent::__construct("pp", Greek::getInstance());

        $this->setAliases(["partnerpackage"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $label
     * @param array $args
     */
    public function execute(CommandSender $sender, string $label, array $args): void
    {
        if (count($args) === 0) {
            $sender->sendMessage(TE::RED . "Usage: " . TE::GRAY . "/{$label} <help> ");
            return;
        }
        switch ($args[0]) {
            case "edit":
                if (!$sender->isOp()) {
                    $sender->sendMessage(TE::RED . "You don't have permissions");
                    return;
                }
                if (!$sender instanceof Player) {
                    $sender->sendMessage(TE::RED . "This message can only be executed in game!");
                    return;
                }
                $player = Greek::getInstance()->getServer()->getPlayer($sender->getName());
                Greek::$items = new PartnerPackage($player->getInventory()->getContents());
                $sender->sendMessage(TE::GREEN . "The content has been edited correctly");
                break;
            case "give":
                if (!$sender->isOp()) {
                    $sender->sendMessage(TE::RED . "You don't have permissions");
                    return;
                }
                if (empty($args[1])) {
                    $sender->sendMessage(TE::RED . "Usage: /{$label} give <player|all> <amount>");
                    return;
                }
                if (empty($args[2])) {
                    $sender->sendMessage(TE::RED . "Usage: /{$label} give <player|all> <amount>");
                    return;
                }
                $player = Greek::getInstance()->getServer()->getPlayer($args[1]);
                if ($player !== null) {
                    GreekUtils::addPartner($player, $args[2]);
                    return;
                }
                foreach (Greek::getInstance()->getServer()->getOnlinePlayers() as $player) {
                    GreekUtils::addPartner($player, $args[2]);
                }
                break;
            case "items":
            case "conent":
                if (!$sender instanceof Player) {
                    $sender->sendMessage(TE::RED . "This message can only be executed in game!");
                    return;
                }
                $inv = new Inventory();
                foreach (PartnerPackage::getItems() as $item) {
                    $inv->addItem($item);
                }
                $inv->setName(TE::BOLD.TE::LIGHT_PURPLE."Partner Package");
                $inv->openInventory($sender);
                break;
        }
    }
}