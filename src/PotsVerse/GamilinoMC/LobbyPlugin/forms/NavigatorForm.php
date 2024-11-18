<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin\forms;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use dktapps\pmforms\FormIcon;
use pocketmine\player\Player;
use PotsVerse\GamilinoMC\LobbyPlugin\forms\subforms\RegionServersForm;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\ServerManager;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\region\RegionType;

class NavigatorForm extends MenuForm
{
    public function __construct()
    {
        $options = [];

        foreach (RegionType::cases() as $region) {
            $servers = ServerManager::getServersByRegion($region);
            $totalPlayers = 0;
            $anyOnline = false;

            foreach ($servers as $server) {
                if ($server->isOnline()) {
                    $totalPlayers += $server->getPlayerCount();
                    $anyOnline = true;
                }
            }

            $regionLabel = $anyOnline
                ? "§6" . ServerManager::getRegionName($region) . "\n§ePlayers: " . $totalPlayers
                : "§6" . ServerManager::getRegionName($region) . "\n§cOffline";

            $options[] = new MenuOption($regionLabel, new FormIcon("textures/ui/world_glyph_color_2x", FormIcon::IMAGE_TYPE_PATH));
        }

        parent::__construct(
            "§6PotsVerse§7 | §rNavigator",
            "§7Choose a region to play on!",
            $options,
            function (Player $player, int $data): void {
                $region = RegionType::cases()[$data];
								
                $player->sendForm(new RegionServersForm($region));
            }
        );
    }
}
