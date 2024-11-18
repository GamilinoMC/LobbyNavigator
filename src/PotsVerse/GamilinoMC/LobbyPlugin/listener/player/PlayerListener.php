<?php

namespace PotsVerse\GamilinoMC\LobbyPlugin\listener\player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\VanillaItems;
use PotsVerse\GamilinoMC\LobbyPlugin\forms\NavigatorForm;

class PlayerListener implements Listener
{
    public function onItemUse(PlayerItemUseEvent $event): void
    {
        if ($event->getItem()->getTypeId() === VanillaItems::COMPASS()->getTypeId()) $event->getPlayer()->sendForm(new NavigatorForm());
    }
}