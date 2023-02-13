<?php
 
namespace App\Http\Controllers;

use App\Services\DriverExpenseService;
  
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(DriverExpenseService $driverExpenseService)
    {
        // Data is hardcoded for test purposes.
        $drivers = ['John Sigono', 'Tom Davidson'];

        $expenses = $this->generateTestExpenses();
        // $expenses = [
        //     'Fuel (EFS)' => '100',
        //     'Fuel (Comdata)' => '50',
        //     // 'Insurance (Truck)' => '150.67',
        //     // 'Insurance (Trailer)' => '283.86',
        //     // 'Engine oil' => '122.15',
        //     // 'Tires' => '491.9',
        //     // 'Truck wash' => '319.82',
        //     // 'Trailer wash' => '8.98',
        //     // 'Flight tickets' => '473.2'
        // ];

        return view('home', [
            'data' => $driverExpenseService->calculateDriverExpenses($drivers, $expenses),
        ]);
    }

    private function generateTestExpenses()
    {
        $result = [];

        $expenseTypes = [
            'Fuel (EFS)', 
            'Fuel (Comdata)', 
            'Insurance (Truck)', 
            'Insurance (Trailer)', 
            'Engine oil', 
            'Tires', 
            'Truck wash', 
            'Trailer wash', 
            'Flight tickets',
        ];

        $iterations = rand(1, 9);

        for ($i = 0; $i < $iterations; $i++) 
        {
            $expense = $expenseTypes[$i];
            
            $result[$expense] = number_format($this->randomDecimal(1, 5000), 2, '.', '');
        }

        return $result;
    }

    private function randomDecimal(float $min, float $max, int $digit = 2)
    {
        return mt_rand($min * 10, $max * 10) / pow(10, $digit);
    }
}