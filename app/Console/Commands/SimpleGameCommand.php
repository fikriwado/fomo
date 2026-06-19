<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimpleGameCommand extends Command
{
    protected $signature = 'game:start';

    protected $description = 'Task 2 | Simple Game';

    public function handle()
    {
        $upSteps = 1;
        $rightSteps = 2;
        $downSteps = 1;

        $grid = [
            ['.', '.', '.', '.', '.'],
            ['.', '.', '.', '.', '.'],
            ['.', '.', 'X', '.', '.'],
            ['.', '.', '.', '.', '.'],
            ['.', '.', '.', '.', '.'],
        ];

        $this->info('Initial Grid:');

        foreach ($grid as $row) {
            $this->line(implode(' ', $row));
        }

        $this->line("");
        $this->info('Steps:');
        $this->line("Up: {$upSteps}");
        $this->line("Right: {$rightSteps}");
        $this->line("Down: {$downSteps}");

        [$playerRow, $playerCol] = $this->findPlayer($grid);

        $this->line("");
        $this->info('Player Position:');
        $this->line("Row: {$playerRow}, Column: {$playerCol}");
    }

    private function findPlayer(array $grid): array
    {
        foreach ($grid as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                if ($cell === 'X') {
                    return [$rowIndex, $colIndex];
                }
            }
        }

        return [];
    }
}
