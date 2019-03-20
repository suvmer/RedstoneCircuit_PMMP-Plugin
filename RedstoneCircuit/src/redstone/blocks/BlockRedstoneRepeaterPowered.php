<?php

namespace redstone\blocks;

use pocketmine\Player;

use pocketmine\block\Block;

use pocketmine\item\Item;

use pocketmine\math\Vector3;


use redstone\utils\Facing;

class BlockRedstoneRepeaterPowered extends BlockRedstoneRepeaterUnpowered {

    protected $id = self::POWERED_REPEATER;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function getName() : string {
        return "Powered Repeater";
    }

    public function onScheduledUpdate() : void {
        $this->getLevel()->setBlock($this, new BlockRedstoneRepeaterUnpowered($this->getDamage()));
        $this->updateAroundDiodeRedstone($this);
    }

    public function getStrongPower(int $face) : int {
        return $this->getWeakPower($face);
    }

    public function getWeakPower(int $face) : int {
        if ($face == $this->getInputFace()) {
            return 15;
        }
        return 0;
    }

    public function isPowerSource() : bool {
        return true;
    }

    public function onRedstoneUpdate() : void {
        if ($this->isLocked()) {
            return;
        }
        if (!$this->isSidePowered($this->asVector3(), $this->getInputFace())) {
            $this->level->scheduleDelayedBlockUpdate($this, $this->getDelayTime());
        }
    }
}