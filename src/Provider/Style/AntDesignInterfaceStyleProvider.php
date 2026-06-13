<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Style;

use App\Interfacing\ProviderInterface\Style\InterfaceStyleProviderInterface;

final readonly class AntDesignInterfaceStyleProvider implements InterfaceStyleProviderInterface
{
    public function key(): string
    {
        return 'ant_design';
    }

    public function label(): string
    {
        return 'Ant Design native';
    }

    public function bodyClass(): string
    {
        return 'interfacing-ui-provider interfacing-ui-provider--ant-design';
    }

    public function locationClass(): string
    {
        return 'interfacing-location-provider interfacing-location-provider--ant-design';
    }

    public function stylesheet(): string
    {
        return 'bundles/interfacing/provider/themes/ant-design.interface-location.css';
    }

    /**
     * @return array<string, mixed>
     */
    public function manifest(): array
    {
        return [
            'key' => $this->key(),
            'label' => $this->label(),
            'body_class' => $this->bodyClass(),
            'location_class' => $this->locationClass(),
            'stylesheet' => $this->stylesheet(),
            'owner' => 'Interfacing',
            'runtime' => 'native-css',
            'inline_styles' => false,
        ];
    }
}
