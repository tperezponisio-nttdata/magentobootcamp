<?php

namespace NTTData\Pokemon\Model\ResourceModel\Pokemons;

use NTTData\Pokemon\Model\Pokemons as PokemonsModel;
use NTTData\Pokemon\Model\ResourceModel\Pokemons as PokemonsResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            PokemonsModel::class,
            PokemonsResourceModel::class
        );
    } 
}