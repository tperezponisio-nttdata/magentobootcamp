<?php

namespace NTTData\Pokemon\Model;

use NTTData\Pokemon\Model\ResourceModel\Pokemons as PokemonsResourceModel;
use Magento\Framework\Model\AbstractModel;

class Pokemons extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(PokemonsResourceModel::class);
    }
}
