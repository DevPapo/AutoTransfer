<?php

namespace AutoTransfer;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class TransferTask extends Task {

    private AutoTransfer $plugin;
    private Player $player;
    private string $targetServer;

    public function __construct(AutoTransfer $plugin, Player $player, string $targetServer) {
        $this->plugin = $plugin;
        $this->player = $player;
        $this->targetServer = $targetServer;
    }

    public function onRun(): void {
        if ($this->player->isOnline()) {
            [$ip, $port] = explode(":", $this->targetServer);
            $this->player->transfer($ip, (int)$port);
        }
    }
}
