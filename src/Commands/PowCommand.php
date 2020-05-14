<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;


class PowCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    protected $history;

    public function __construct(CommandHistoryManagerInterface $history)
    {
        $this->history = $history;
        $commandVerb = $this->getCommandVerb();
        
        $this->signature = $this->getSignature();
        $this->description = "Exponent the given number";
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'pow';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'powed';
    }

    protected function getSignature(): string 
    {
        $signature = $this->getCommandVerb();
        $arguments = $this->getArguments();
        $arguments = collect($arguments);
        $arguments->each(function ($value, $key) use (&$signature) {
            $signature .= sprintf(' {%s : %s}', $key, $value);
        });
        return $signature;
    }

    protected function getArguments() : array 
    {
        $arguments = [
            'base' => 'The base number',
            'exp' => 'The exponent number'
        ];
        return $arguments;
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculate($numbers['base'], $numbers['exp']);

        $dataToSave = $this->getDataToSave($description, $result);
        $this->history->log($dataToSave);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        $arguments = $this->getArguments();
        $arguments = collect($arguments);
        $arguments = $arguments->map(function($value, $key) {
            $value = $this->argument($key);
            return $value;
        });
        $arguments = $arguments->all();
        return $arguments;
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '^';
    }


    /**
     * @param int|float $base
     * @param int|float $exp
     *
     * @return int|float
     */
    protected function calculate($base, $exp)
    {

        return pow($base, $exp);
    }

    protected function getDataToSave($description, $result): array 
    {
        $output = sprintf('%s = %s', $description, $result);
        $data = [
            "command" => $this->getCommandVerb(),
            "description" => $description,
            "result" => $result,
            "output" => $output,
        ];
        return $data;
    }
}
