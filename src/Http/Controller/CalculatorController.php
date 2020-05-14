<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
class CalculatorController
{
	protected $action;
	protected $operator;

	public function __construct(CommandHistoryManagerInterface $history) {
	   $this->history = $history;
	}

    public function calculate(Request $request,$action)
    {
    	$this->setAction($action);
    	$this->setOperator();
    	$numbers = $request->request->get('input');
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);
        
        $dataToSave = $this->getDataToSave($description, $result);
        $this->history->log($dataToSave);
        $data = [
        	"command" => $dataToSave['command'],
        	"operation" => $dataToSave['description'],
        	"result" => $dataToSave['result']
        ];
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function setAction($action): void {
    	$this->action = $action;
    }

    protected function getAction(): string {
    	$action = $this->action;
    	return $action;

    }

    protected function getOperator(): string
    {
    	$operator = $this->operator;
        return $operator;
    }

    protected function setOperator(): void
    {
    	$operator = [
    		"add" => "+",
    		"subtract" => "-",
    		"multiply" => "*",
    		"divide" => "/",
    		"pow" => "^"
    	];
        $this->operator = $operator[$this->action];
    }

    

    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->count($this->calculateAll($numbers), $number);
    }

    protected function count($number1, $number2)
    {
    	$operator = $this->getOperator();
    	switch ($operator) {
    		case '+':
        		return $number1 + $number2;
    			break;
    		case '-':
        		return $number1 - $number2;
    			break;
    		case '/':
        		return $number1 / $number2;
    			break;
    		case '*':
        		return $number1 * $number2;
    			break;
    		case '^':
        		return pow($number1, $number2);
    			break;
    		
    		default:
    			break;
    	}
    }

    protected function getDataToSave($description, $result): array 
    {
        $output = sprintf('%s = %s', $description, $result);
        $data = [
            "command" => $this->getAction(),
            "description" => $description,
            "result" => $result,
            "output" => $output,
        ];
        return $data;
    }
}
