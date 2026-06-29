<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonService
{
    public function execute(array $data): array
    {
        $process = new Process([
            'python3',
            base_path('app/scripts/match.py')
        ]);

        $process->setInput(json_encode($data, JSON_THROW_ON_ERROR));
        $process->setTimeout(30);

        $process->run();


        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();
        $error = $process->getErrorOutput();

        if (!empty($error)) {
            logger()->error('Python error: ' . $error);
        }

        return json_decode(
            $output,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
