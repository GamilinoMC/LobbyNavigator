<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin\forms\subforms;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\player\Player;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\region\RegionType;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\Server;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\ServerManager;

class RegionServersForm extends MenuForm
{
    public function __construct(RegionType $region)
    {
        $servers = ServerManager::getServersByRegion($region);
        $options = [];
        $serverList = array_values($servers);

        foreach ($serverList as $server) {
            $serverLabel = $server->isOnline()
                ? "§6" . $server->getDisplayName() . "\n§ePlayers: " . $server->getPlayerCount()
                : "§6" . $server->getDisplayName() . "\n§cOffline";

            $options[] = new MenuOption($serverLabel);
        }

        $regionName = ServerManager::getRegionName($region) ?? "Unknown Region";

        parent::__construct(
            $regionName . "Servers",
            "§7Choose a server to play on!",
            $options,
            function (Player $player, int $data) use ($serverList): void {
                $selServer = $serverList[$data] ?? null;

                if ($selServer instanceof Server && $selServer->isOnline()) {
                    $player->transfer($selServer->getIp(), $selServer->getPort());
                } else {
                    $player->sendMessage("§cThe selected server is currently offline.");
                }
            }
        );
    }
}