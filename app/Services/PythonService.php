<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonService
{
    public function execute(array $data): array
    {
        /*
        CAMINHO WINDOWS

        $process = new Process(
            [
                'C:\Program Files\Python39\python.exe',
                base_path('app/scripts/match.py')
            ],
            base_path(),
            [
                'SYSTEMROOT' => getenv('SYSTEMROOT'),
                'WINDIR' => getenv('WINDIR'),
                'PATH' => getenv('PATH'),
                'TEMP' => getenv('TEMP'),
                'TMP' => getenv('TMP'),
            ]
        ); */

        # caminho universal
        $process = new Process(['python3', base_path('app/scripts/match.py')]);

        $process->setInput(
            json_encode($data, JSON_THROW_ON_ERROR)
        );

        $process->setTimeout(30);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        return json_decode(
            $process->getOutput(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
