<?php

namespace GGrach\BitrixDebugger\Debugger;

use GGrach\BitrixDebugger\Configurator\DebuggerConfigurator;
use GGrach\BitrixDebugger\Configurator\DebugBarConfigurator;
use GGrach\BitrixDebugger\Contract\ShowModableContract;
use GGrach\BitrixDebugger\Validator\ShowModeDebuggerValidator;

/**
 * Description of Debugger
 *
 * @author ggrachdev
 * @version 0.01
 */
class DebuggerShowModable implements ShowModableContract {

    /**
     * Где показывать
     * 
     * code - в коде
     * debug_bar - в дебаг-баре
     * 
     * @var array
     */
    protected $showModes = ['code', 'debug_bar'];

    public function getShowModes(): array {
        return $this->showModes;
    }

    public function getShowModesEnum(): array {
        return ['code', 'debug_bar'];
    }

    public function setShowModes(array $showModes): bool {
        $result = true;

        if (!empty($showModes)) {

            $avaliableModes = $this->getShowModesEnum();

            // @todo array_udiff
            foreach ($showModes as $mode) {
                if (!\in_array($mode, $avaliableModes)) {
                    $result = false;
                    break;
                }
            }

            if ($result) {
                $this->showModes = $showModes;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    public function setShowMode(string $showMode): bool {
        return $this->setShowModes([$showMode]);
    }

}
