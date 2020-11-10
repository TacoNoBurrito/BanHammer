<?php
namespace Taco\BanHammer;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat as TF;
class Main extends PluginBase implements Listener {
    public function onEnable() : void {
        $this->getLogger()->info("BanHammer By Taco Enabled!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onDamage(EntityDamageByEntityEvent $event) : void {
        if ($event->getDamager() instanceof Player) {
            $player = $event->getEntity();
            $damager = $event->getDamager();
            $item = $damager->getInventory()->getItemInHand();
            if (!$damager->isOp()) return;
            if (!$item->getCustomName() == TF::RESET . TF::BOLD . TF::RED . "BanHammer") return;
            if ($player->isOp()) return;
            $damager->sendMessage("§cBanHammer >> Succesfully Banned " . $player->getName());
            $player->kick("You Were Banned By The Ban Hammer!", false);
            $player->setBanned(true);
        }
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
        if ($command->getName() == "bh") {
            if (!$sender->isOp() or !$sender instanceof Player) {
                return true;
            }
            $item = Item::get(279, 0, 1);
            $item->setCustomName(TF::RESET . TF::BOLD . TF::RED . "BanHammer");
            $sender->getInventory()->addItem($item);
            $sender->sendMessage("§cBanHammer >> Succesfully Claimed BanHammer");
            return true;
        }
    }
}