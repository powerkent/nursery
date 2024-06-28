<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'file_name_pattern' => '*.twig',
    ]);
    if ('test' === $containerConfigurator->env()) {
        $containerConfigurator->extension('twig', [
            'strict_variables' => true,
        ]);
    }
};
