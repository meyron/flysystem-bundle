<?php

/*
 * This file is part of the flysystem-bundle project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\FlysystemBundle\Adapter\Builder;

use Lustmored\Flysystem\Cache\CacheAdapter;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @internal
 */
class CacheAdapterDefinitionBuilder extends AbstractAdapterDefinitionBuilder
{
    public function getName(): string
    {
        return 'cache';
    }

    protected function getRequiredPackages(): array
    {
        return [
            CacheAdapter::class => 'lustmored/flysystem-v2-simple-cache-adapter',
        ];
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('store');
        $resolver->setAllowedTypes('store', 'string');

        $resolver->setRequired('source');
        $resolver->setAllowedTypes('source', 'string');
    }

    protected function configureDefinition(Definition $definition, array $options)
    {
        $definition->setClass(CacheAdapter::class);
        $definition->setArgument(0, new Reference('flysystem.adapter.'.$options['source']));
        $definition->setArgument(1, new Reference($options['store']));
    }
}
