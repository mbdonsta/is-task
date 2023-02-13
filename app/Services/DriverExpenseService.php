<?php
 
namespace App\Services;
  
class DriverExpenseService
{
    public function calculateDriverExpenses(array $drivers, array $expenses): array
    {
        $resultTitles = $this->getResultTitles($drivers);
        $expensesRows = $this->getExpensesRows($drivers, $expenses);
        $totals = $this->getTotals($expensesRows, $drivers);

        return array_merge([$resultTitles], $expensesRows, [$totals]);
    }

    private function getResultTitles(array $drivers): array
    {
        return array_merge(['Expenses', 'Amount'], $drivers);
    }

    private function getExpensesRows(array $drivers, array $expenses): array
    {
        $rows = [];
        $nextIndex = 0;

        foreach ($expenses as $expenseTitle => $expense) {
            // Check if expense can be divided evenly
            $canBeDevidedEvenly = round(100 * $expense) % count($drivers) === 0;

            // Calculate equal expense division for a driver
            $expensesPerDriver = round($expense / count($drivers), 3);
            $row = [
                $expenseTitle,
                $expense
            ];
            $centAdded = false;

            foreach ($drivers as $index => $driver) {
                // Check if expense's one cent must be added to one of the drivers
                if (!$centAdded && $nextIndex === $index && !$canBeDevidedEvenly) {
                    $driverExpense = round($expensesPerDriver, 2);
                    $nextIndex = $index === 1 ? 0 : 1;
                    $centAdded = true;
                } else {
                    $driverExpense = round($expensesPerDriver, 2, PHP_ROUND_HALF_DOWN);
                }

                $row[$driver] = $driverExpense;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function getTotals(array $expensesRows, array $drivers): array
    {
        $totals = ['Total', 'amount' => 0];

        foreach ($drivers as $driver) {
            $totals[$driver] = array_reduce($expensesRows, function($carry, $item) use ($driver) {
                return $carry += $item[$driver];
            });
            $totals['amount'] += $totals[$driver];
        }  

        return $totals;
    }
}