<?php

namespace App\Services;

use App\Repositories\Interfaces\CashFlowRepositoryInterface;
use App\Repositories\Interfaces\LogRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Services\Interfaces\PaymentServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentService
 * @package App\Services
 */
class PaymentService implements PaymentServiceInterface
{
    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var CashFlowRepositoryInterface
     */
    protected $cashFlowRepository;

    /**
     * @var LogRepositoryInterface
     */
    protected $logRepository;

    /**
     * PaymentService constructor.
     * @param PaymentRepositoryInterface $paymentRepository
     * @param CashFlowRepositoryInterface $cashFlowRepository
     * @param LogRepositoryInterface $logRepository
     */
    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        CashFlowRepositoryInterface $cashFlowRepository,
        LogRepositoryInterface $logRepository
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->cashFlowRepository = $cashFlowRepository;
        $this->logRepository = $logRepository;
    }

    /**
     * Add payment, validate back money
     *
     * @param array $data
     * @return array
     */
    public function createPayment(array $data): array
    {
        try {
            DB::beginTransaction();
            $totalBackMoney = $data['total_customer'] - $data['total_purchase'];
            $backMoneyList = $this->getBackMoney($totalBackMoney);

            if (empty($backMoneyList)) {
                return ['status' => false, 'message' => __('cash_flow.no_back_money')];
            }

            $payment = $this->paymentRepository->createPayment($data);

            $dataLogEntry = ['type' => 'entry', 'value' => $payment->total_customer];
            $logEntry = $this->logRepository->createLog($dataLogEntry);

            $cashFlow = $this->cashFlowRepository->getCashFlowByValue($data['total_customer']);
            $cashFlow->logs()->attach($logEntry, ['cash_flow_count' => 1]);
            $add = $this->cashFlowRepository->cashFlowAddCount($cashFlow->id, 1);

            if (!$add) {
                DB::rollBack();
                return ['status' => false, 'message' => __('cash_flow.system_error')];
            }

            $dataLogEgress = ['type' => 'egress', 'value' => $totalBackMoney];
            $logEgress = $this->logRepository->createLog($dataLogEgress);

            foreach ($backMoneyList as $backMoney) {
                $cashFlow = $this->cashFlowRepository->getCashFlowByValue($backMoney['value']);
                $cashFlow->logs()->attach($logEgress, ['cash_flow_count' => $backMoney['count']]);
                $subtract = $this->cashFlowRepository->cashFlowSubtractCount($cashFlow->id, $backMoney['count']);
                if (!$subtract) {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('cash_flow.system_error')];
                }
            }
            DB::commit();
            return ['status' => true, 'message' => __('cash_flow.payment_success'), 'backMoney' => $backMoneyList];
        } catch (\Exception $e) {
            DB::rollBack();

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get back money paid
     *
     * @param int $totalBackMoney
     * @return array
     */
    private function getBackMoney(int $totalBackMoney): array
    {
        $cashFlowList = $this->cashFlowRepository->listCashFlows();
        $backMoneyTmp = $totalBackMoney;
        $response = [];
        $limit = 200;

        while ($backMoneyTmp > 0 && $limit > 0) {
            $cont = 0;
            $limit--;
            foreach ($cashFlowList as $key => $cashFlow) {
                if ($cashFlow['count'] > 0 && $backMoneyTmp >= $cashFlow['value']) {
                    $cont++;
                    $backMoneyTmp -= $cashFlow['value'];

                    if (isset($response[$cashFlow['value']]) && $response[$cashFlow['value']]['value'] == $cashFlow['value']) {
                        $cont = $response[$cashFlow['value']]['count'] + 1;
                    }

                    $response[$cashFlow['value']] = ['value' => $cashFlow['value'], 'count' => $cont];
                    $cashFlowList[$key]['count'] -= 1;
                    break;
                }
            }
        }

        if ($backMoneyTmp > 0) {
            return [];
        }

        return $response;
    }
}
