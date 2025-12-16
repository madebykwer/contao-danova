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

        if (preg_match('/<header\\b[^>]*>/i', $buffer, $matches, PREG_OFFSET_CAPTURE)) {
            $match = $matches[0];
            $insertPosition = $match[1] + strlen($match[0]);

            return substr($buffer, 0, $insertPosition)
                . $script . "\n"
                . substr($buffer, $insertPosition);
        }

        return str_replace('</head>', $script . "\n</head>", $buffer);
    }
}
