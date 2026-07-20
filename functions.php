<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once(__DIR__ . "/vendor/autoload.php");

//Contexis\KidsTeam\Check::init();
Contexis\KidsTeam\Assets::init();
Contexis\KidsTeam\Color::init();
Contexis\KidsTeam\Menu::init();
Contexis\KidsTeam\Theme::init();
Contexis\KidsTeam\Icons::init();

?>