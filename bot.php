<?php
require "vendor/autoload.php";

use Mpociot\BotMan\BotManFactory;
use React\EventLoop\Factory;

$loop = Factory::create();
$botman = BotManFactory::createForRTM([
   "slack_token" => getenv("SLACK_TOKEN")
], $loop);

// Search for addresses
$botman->hears("([\s\S]*)", function ($bot, $addressFull) {
   $m = preg_match("((0x)?[0-9a-fA-F]{40})", $addressFull, $matches);
   if (!$m) return;

   $addr = $matches[0];
   $addrs = array("0x960b236a07cf122663c4303350609a66a7b288c0", "0x960b236A07cf122663c4303350609A66A7B288C0", "0x0cEB0D54A7e87Dfa16dDF7656858cF7e29851fD7", "0x0ceb0d54a7e87dfa16ddf7656858cf7e29851fd7");
   if (in_array($addr, $addrs, true)) {
     $bot->reply(":white_check_mark: The above address (*".$addr."*) is a valid address for the Aragon Token sale. Nevertheless, double check the address in <https://aragonone.slack.com/archives/announcements|#announcements> or https://aragon.network");
   } else {
     $bot->reply(":warning::interrobang::rage: The above address (*".$addr."*) is *NOT A VALID ADDRESS FOR THE ARAGON TOKEN SALE*. Sending funds to that address wont give you ANT tokens:warning::interrobang::rage:. Check the official address in <https://aragonone.slack.com/archives/announcements|#announcements> or https://aragon.network");
   }
});

echo "Bot is running";
$loop->run();
