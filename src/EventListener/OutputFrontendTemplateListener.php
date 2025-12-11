<?php

namespace Madebykwer\ContaoDanova\EventListener;

use Contao\Config;

class OutputFrontendTemplateListener
{
    public function __invoke(string $buffer, string $template): string
    {
        if ($template !== 'fe_page') {
            return $buffer;
        }

        if (!Config::get('danova_enable')) {
            return $buffer;
        }

        $id = Config::get('danova_id') ?: '98F8B3FD';

        $script = sprintf(
            '<script src="https://api.danova.de/embed.js" id="da-script_id" da-data_id="%s" defer></script>',
            $id
        );

        return str_replace('</head>', $script . "\n</head>", $buffer);
    }
}
