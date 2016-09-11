<?php
namespace EssentialsPE\Commands\Economy;

use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class Eco extends BaseCommand{
    /**
     * @param BaseAPI $api
     */
    public function __construct(BaseAPI $api){
        parent::__construct($api, "eco", "Sets the balance of a player", "<give|take|set|reset> <player> [amount]", true, ["economy"]);
        $this->setPermission("essentials.eco.use");
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
        switch(count($args)){
            case 2:
            case 3:
                if(!($player = $this->getAPI()->getPlayer($args[1]))){
                    $sender->sendMessage(TextFormat::RED . "[Error] Player not found");
                    return false;
                }
                if((!isset($args[2]) && strtolower($args[0]) !== "reset") || (isset($args[2]) && !is_numeric($args[2]))){
                    $sender->sendMessage(TextFormat::RED . "[Error] Please specify a" . (isset($args[2]) ? " valid" : "n") . " amount");
                    return false;
                }
                $balance = (int) $args[2];
                switch(strtolower($args[0])){
                    case "give":
                        $sender->sendMessage(TextFormat::YELLOW . "Adding the balance...");
                        $this->getAPI()->addToPlayerBalance($player, $balance);
                        break;
                    case "take":
                        $sender->sendMessage(TextFormat::YELLOW . "Taking the balance...");
                        $this->getAPI()->addToPlayerBalance($player, -$balance);
                        break;
                    case "set":
                        $sender->sendMessage(TextFormat::YELLOW . "Setting the balance...");
                        $this->getAPI()->setPlayerBalance($player, $balance);
                        break;
                    case "reset":
                        $sender->sendMessage(TextFormat::YELLOW . "Resetting balance...");
                        $this->getAPI()->setPlayerBalance($player, $this->getAPI()->getDefaultBalance());
                        break;
                }
                break;
            default:
                $this->sendUsage($sender, $alias);
                break;
        }
        return true;
    }
}