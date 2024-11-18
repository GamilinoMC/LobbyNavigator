<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin\manager;

use PotsVerse\GamilinoMC\LobbyPlugin\manager\region\RegionType;

class ServerManager
{
    public static array $servers;

    public static function addServer(string $displayName, RegionType $region, bool $maintenance, ?string $ip, ?int $port): void
    {
        if ($ip === null && $port === null) {
            self::$servers[$displayName] = new Server($displayName, $region, $maintenance);
        } elseif ($port === null) {
            self::$servers[$displayName] = new Server($displayName, $region, $maintenance, $ip);
        } else {
            self::$servers[$displayName] = new Server($displayName, $region, $maintenance, $ip, $port);
        }
    }

    /**
     * @return array
     */
    public static function getServers(): array
    {
        return self::$servers;
    }

    public static function getServersByRegion(RegionType $region): array
    {
        return array_filter(self::$servers, fn(Server $server) => $server->getRegion() === $region);
    }

    public static function getRegionName(RegionType $region): string
    {
        if ($region == RegionType::REGION_ASIA) return "Asia";
        if ($region == RegionType::REGION_EUROPE) return "Europe";
        if ($region == RegionType::REGION_NORTH_AMERICA) return "North America";
        if ($region == RegionType::REGION_OCEANIA) return "Oceania";
        return "";
    }
}