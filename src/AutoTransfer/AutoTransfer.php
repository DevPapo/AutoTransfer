<?php

namespace AutoTransfer;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;

class AutoTransfer extends PluginBase implements Listener {

    private string $targetServer;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $config = $this->getConfig();
        $this->targetServer = $config->get("target-server", "play.example.com:19132");
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $config = $this->getConfig();
        $message = $config->get("transfer-message", "");
        
        if ($message !== "") {
            $player->sendMessage($message);
        }
        
        $this->getScheduler()->scheduleDelayedTask(new TransferTask($this, $player, $this->targetServer), 20);
    }
}
