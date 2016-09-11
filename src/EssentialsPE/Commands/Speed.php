<?php
namespace EssentialsPE\Commands;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Speed extends BaseCommand{
    public function __construct(BaseAPI $api){
        parent::__construct($api, "speed", "Change your speed limits", "<speed> [player]");
        $this->setPermission("essentials.speed");
    }

    public function execute(CommandSender $sender, $alias, array $args): bool{
        if($this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player || count($args) < 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        if(!is_numeric($args[0])){
            $sender->sendMessage(TextFormat::RED . "[Error] Please provide a valid value");
            return false;
        }
        $player = $sender;
        if(isset($args[1]) && !($player = $this->getAPI()->getPlayer($args[1]))){
            $sender->sendMessage(TextFormat::RED . "[Error] Player not found");
            return false;
        }
        if((int) $args[0] === 0){
            $player->removeEffect(Effect::SPEED);
        }else{
            $effect = Effect::getEffect(Effect::SPEED);
            $effect->setAmplifier($args[0]);
            $effect->setDuration(PHP_INT_MAX);
            $player->addEffect($effect);
        }
        $sender->sendMessage(TextFormat::YELLOW . "Speed amplified by " . TextFormat::WHITE . $args[0]);
        return true;
    }
}