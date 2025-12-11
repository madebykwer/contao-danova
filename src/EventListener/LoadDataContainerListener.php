<?php

namespace Madebykwer\ContaoDanova\EventListener;

class LoadDataContainerListener
{
    public function __invoke(string $table): void
    {
        if ($table !== 'tl_settings') {
            return;
        }

        $GLOBALS['TL_DCA']['tl_settings']['fields']['danova_enable'] = [
            'label' => ['Danova aktivieren', 'Aktiviert das Barrierefreiheitstool von danova.'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr'],
        ];

        $GLOBALS['TL_DCA']['tl_settings']['fields']['danova_id'] = [
            'label' => ['Danova ID', 'Wenn leer, wird die Standard-ID 98F8B3FD verwendet.'],
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50'],
        ];

        $GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{danova_legend},danova_enable,danova_id';
    }
}
