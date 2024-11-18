<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin;

use jasonw4331\libpmquery\PMQuery;
use jasonw4331\libpmquery\PmQueryException;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\region\RegionType;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\ServerManager;
use PotsVerse\GamilinoMC\LobbyPlugin\listener\player\PlayerListener;

class LobbyPlugin extends PluginBase
{
    use SingletonTrait;

    protected function onEnable(): void
    {
        self::setInstance($this);

        $this->registerServers();
        $this->registerListeners();
    }

    protected function registerListeners(): void
    {
        $pm = Server::getInstance()->getPluginManager();

        $pm->registerEvents(new PlayerListener(), $this);
    }

    protected function registerServers(): void
    {
        /**
         * Just add the servers here that you want to be shown!
        */

        ServerManager::addServer("EU-1", RegionType::REGION_EUROPE, false, "lydoxmc.net", 19132);
    }
}