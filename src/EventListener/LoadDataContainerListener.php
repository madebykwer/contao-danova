<?php

namespace Madebykwer\ContaoDanova\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\DataContainer;
use Contao\Input;

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
            'save_callback' => [[self::class, 'validateDanovaId']],
        ];

        // Palette erweitern
        $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
            .= ';{danova_legend},danova_enable,danova_id';
    }

    public function validateDanovaId(string $value, DataContainer $dc): string
    {
        if (!Input::post('danova_enable')) {
            return $value;
        }

        if ($value !== '') {
            return $value;
        }

        $fieldLabel = $GLOBALS['TL_LANG']['tl_settings']['danova_id'][0] ?? 'Danova ID';
        $messageTemplate = $GLOBALS['TL_LANG']['ERR']['mandatory'] ?? 'Field "%s" must not be empty.';

        throw new \RuntimeException(sprintf($messageTemplate, $fieldLabel));
    }
}
