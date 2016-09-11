<?php
namespace EssentialsPE\Events;


use EssentialsPE\BaseFiles\BaseAPI;
use EssentialsPE\BaseFiles\BaseCustomEvent;
use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerNickChangeEvent extends BaseCustomEvent implements Cancellable{
    public static $handlerList = null;

    /** @var Player  */
    protected $player;
    /** @var  null|string */
    protected   $new_nick;
    /** @var  string */
    protected   $old_nick;
    /** @var bool|mixed  */
    protected $nametag;

    /**
     * @param BaseAPI $api
     * @param Player $player
     * @param string $new_nick
     * @param mixed $nametag
     */
    public function __construct(BaseAPI $api, Player $player, string $new_nick, $nametag = false){
        parent::__construct($api);
        $this->player = $player;
        $this->new_nick = $new_nick;
        $this->old_nick = $player->getDisplayName();
        $this->nametag = ($nametag ?? $new_nick);
    }

    /**
     * Return the player to be used
     *
     * @return Player
     */
    public function getPlayer(): Player{
        return $this->player;
    }

    /**
     * Return the new nick to be set
     *
     * @return string
     */
    public function getNewNick(): string{
        return $this->new_nick;
    }

    /**
     * Tell the actual nick of the player
     *
     * @return string
     */
    public function getOldNick(): string{
        return $this->old_nick;
    }

    /**
     * Change the nick to be set
     *
     * @param string $nick
     */
    public function setNick(string $nick){
        $this->new_nick = $nick;
    }

    /**
     * Return the NameTag to be set
     * Usually it's the same has the new nick, but plugins can use it to modify the NameTag too
     *
     * @return bool|string
     */
    public function getNameTag(){
        return $this->nametag;
    }

    /**
     * Change the NameTag to be set
     *
     * @param null|string $nametag
     */
    public function setNameTag($nametag){
        $this->nametag = $nametag;
    }
}
