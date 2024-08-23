<?php

namespace Core\Commands\Helpers;

class ConsoleTable
{
    protected $headers = [];
    protected $rows = [];

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }

    public function addRow(array $row)
    {
        if (count($row) !== count($this->headers)) {
            throw new \Exception('Row contents count is not equal to header count');
        }
        $this->rows[] = $row;
    }


    public function display()
    {
        $this->normalizeHeaders();
        $this->displayHeaders();
        $this->displayRows();
    }

    protected function normalizeHeaders()
    {
        foreach ($this->headers as $index => $header) {
            $maxLength = strlen($header);
            foreach ($this->rows as $row) {
                $maxLength = max($maxLength, strlen($row[$index]));
            }
            $this->headers[$index] = str_pad($header, $maxLength);
        }
    }

    protected function displayHeaders()
    {
        echo implode(' | ', $this->headers) . PHP_EOL;
        echo str_repeat('-', array_sum(array_map('strlen', $this->headers)) + 3 * (count($this->headers) - 1)) . PHP_EOL;
    }

    protected function displayRows()
    {
        foreach ($this->rows as $row) {
            foreach ($row as $index => $cell) {
                $row[$index] = str_pad($cell, strlen($this->headers[$index]));
            }
            echo implode(' | ', $row) . PHP_EOL;
        }
    }
}
