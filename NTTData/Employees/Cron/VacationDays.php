<?php

namespace NTTData\Employees\Cron;

use Psr\Log\LoggerInterface;
use NTTData\Employees\Model\EmployeesFactory;
use NTTData\Employees\Model\ResourceModel\Employees\Collection as EmployeesCollection;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class VacationDays
{
    protected $logger;
    protected EmployeesCollection $employeesCollection;
    protected $timezone;

    public function __construct(
        LoggerInterface $logger,
        EmployeesCollection $employeesCollection,
        TimezoneInterface $timezone
    ) {
        $this->logger = $logger;
        $this->employeesCollection = $employeesCollection;
        $this->timezone = $timezone;
    }

    public function execute()
    {
        $this->logger->info(__('Updating vacation days for employees'));

        $employees = $this->employeesCollection->getItems();
        foreach ($employees as $employee) {
            $startDate = $employee->getStartDate();
            $now = $this->timezone->scopeDate()->format('Y-m-d');
            $yearsWorked = $this->getYearsWorked($startDate, $now);
            $weeksWorked = $this->getWeeksWorked($startDate, $now);

            $vacationDays = $this->calculateVacationDays($weeksWorked, $yearsWorked);

            // Update the vacation days for the employee
            $employee->setVacationDays($vacationDays);
            $employee->save();
        }

        $this->logger->info(__('Vacation days updated'));
    }

    protected function getYearsWorked($startDate, $endDate)
    {
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);

        $interval = $endDateTime->diff($startDateTime);
        $years = $interval->format('%y');

        return $years;
    }

    protected function getWeeksWorked($startDate, $endDate)
    {
        $startDateTime = new \DateTime($startDate);
        $endDateTime = new \DateTime($endDate);

        $interval = $endDateTime->diff($startDateTime);
        $weeks = floor($interval->days / 7);

        return $weeks;
    }

    /**
     * ¿Cuántos días de vacaciones me corresponden?
     * Depende de la antigüedad que tengas en tu empleo:
     *   Menor a 6 meses:
     *      Entre 4 y 7 semanas de trabajo: 1 día
     *      Entre 8 y 11 semanas de trabajo: 2 días corridos
     *      Entre 12 y 15 semanas de trabajo: 3 días corridos
     *      Entre 16 y 19 semanas de trabajo: 4 días corridos
     *      Más de 20 semanas de trabajo: 5 días corridos
     *   Más de 6 meses hasta 5 años: 14 días corridos.
     *   Más de 5 años hasta 10 años: 21 días corridos.
     *   Más de 10 años hasta 20 años: 28 días corridos.
     *   Más de 20 años: 35 días corridos.
     */
    protected function calculateVacationDays($weeksWorked, $yearsWorked)
    {
        if ($yearsWorked <= 5) {
            if ($weeksWorked <= 4) {
                return 0;
            } elseif ($weeksWorked <= 7) {
                return 1;
            } elseif ($weeksWorked <= 11) {
                return 2;
            } elseif ($weeksWorked <= 15) {
                return 3;
            } elseif ($weeksWorked <= 19) {
                return 4;
            } elseif ($weeksWorked <= 24) {
                return 5;
            } else { 
                return 14;
            }
        } elseif ($yearsWorked <= 10) {
            return 21;
        } elseif ($yearsWorked <= 20) {
            return 28;
        } else {
            return 35;
        }
    }
}
