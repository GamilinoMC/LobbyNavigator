<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin\manager;

use jasonw4331\libpmquery\PMQuery;
use jasonw4331\libpmquery\PmQueryException;
use pocketmine\scheduler\ClosureTask;
use PotsVerse\GamilinoMC\LobbyPlugin\LobbyPlugin;
use PotsVerse\GamilinoMC\LobbyPlugin\manager\region\RegionType;

class Server
{
    protected bool $serverOnline;
    protected array $serverQuery;

    public function __construct(
        protected string     $displayName,
        protected RegionType $region,
        protected bool       $maintenance,
        protected string     $ip = "potsverse.net",
        protected int        $port = 19132
    )
    {
        LobbyPlugin::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask(function (): void {
            try {
                $query = PMQuery::query($this->getIp(), $this->getPort());
                $this->serverOnline = isset($query["Players"]);
                $this->serverQuery = $query;
            } catch (PmQueryException $e) {
                $this->serverOnline = false;
            }
        }), 20 * 5);

    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return RegionType
     */
    public function getRegion(): RegionType
    {
        return $this->region;
    }

    /**
     * @return bool
     */
    public function isMaintenance(): bool
    {
        return $this->maintenance;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     */
    public function isOnline(): bool
    {
        return $this->serverOnline;

    }

    public function getPlayerCount(): ?int
    {
        if (!$this->isOnline()) return null;
        return $this->serverQuery["Players"];
    }
}