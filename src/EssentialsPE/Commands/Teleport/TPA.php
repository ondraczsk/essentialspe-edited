<?php
namespace EssentialsPE\Commands\Teleport;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class TPA extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "tpa", "Asks the player if you can telepor to them", "<player>", false, ["call", "tpask"]);
        $this->setPermission("essentials.tpa");
    }

    /**
     * @param CommandSender $sender
     * @param string $alias
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, $alias, array $args): bool{
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player || count($args) !== 1){
            $this->sendUsage($sender, $alias);
            return false;
        }
        if(!($player = $this->getAPI()->getPlayer($args[0]))){
            $sender->sendMessage(TextFormat::RED . "[Error] Hrac nebyl nalezen");
            return false;
        }
        if($player->getName() === $sender->getName()){
            $sender->sendMessage(TextFormat::RED . "[Error] Please provide another player name");
            return false;
        }
        $this->getAPI()->requestTPTo($sender, $player);
        $player->sendMessage(TextFormat::AQUA . $sender->getName() . TextFormat::GREEN . " se chce k tobe portnout, pouzij:\n/tpyes pro prijmuti\n/tpno pro odmitnuti");
        $sender->sendMessage(TextFormat::GREEN . "Zadost o teleport byla poslana hraci " . $player->getDisplayName() . "!");
        return true;
    }
} 
