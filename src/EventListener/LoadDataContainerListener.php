<?php

namespace Madebykwer\ContaoDanova\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;

#[Hook('loadDataContainer')]
class LoadDataContainerListener
{
    public function __invoke(string $table): void
    {
        if ($table !== 'tl_settings') {
            return;
        }

        // Felder
        $GLOBALS['TL_DCA']['tl_settings']['fields']['danova_enable'] = [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['danova_enable'],
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr'],
        ];

        $GLOBALS['TL_DCA']['tl_settings']['fields']['danova_id'] = [
            'label' => &$GLOBALS['TL_LANG']['tl_settings']['danova_id'],
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50'],
        ];

        // Palette erweitern
        $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
            .= ';{danova_legend},danova_enable,danova_id';
    }
}
