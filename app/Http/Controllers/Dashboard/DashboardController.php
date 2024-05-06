<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Agent\Agent;
use App\Models\Agent\AgentPaymentInformation;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerLandPriceInfo;
use App\Models\Customer\CustomerLandRelation;
use App\Models\LandBroker\LandBroker;
use App\Models\LandBroker\LandBrokerPaymentInformation;
use App\Models\LandSeller\LandSellerAgreement;
use App\Models\LandSeller\LandSellerAgreementBSRelation;
use App\Models\LandSeller\LandSellerAgreementPriceInformation;
use App\Models\LandSeller\LandSellerAgreementRelation;
use App\Models\LandSeller\LandSellerList;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = CustomerInfo::count();

        $paybleAmount = CustomerLandPriceInfo::sum('total_amount');

        $paidAmount = CustomerLandPriceInfo::sum('booking_money_paid') + CustomerLandPriceInfo::sum('downpayment_paid') + CustomerLandPriceInfo::sum('total_installment_amount_paid');

        $dueAmount =  CustomerLandPriceInfo::sum('total_amount') - (CustomerLandPriceInfo::sum('booking_money_paid') + CustomerLandPriceInfo::sum('downpayment_paid') + CustomerLandPriceInfo::sum('total_installment_amount_paid'));

        $paymentCompleteCustomer =  CustomerLandPriceInfo::whereColumn('total_booking_money', '=', 'booking_money_paid')
        ->whereColumn('total_downpayment_amount', '=', 'downpayment_paid')
        ->whereColumn('total_installment_amount', '=', 'total_installment_amount_paid')
        ->count();

        $regCompleteCustomer =  CustomerLandRelation::distinct()->count('customerID');

        $bookingCancelCustomer = 0;

        $bookingCancelPaymentReturn = 0;

        $totalAgent =  Agent::count();

        $paybleAmountAgent =  AgentPaymentInformation::sum('agent_money');

        $paidAmountAgent =  AgentPaymentInformation::sum('agent_money_paid');

        $dueAmountAgent =  AgentPaymentInformation::sum('agent_money') - AgentPaymentInformation::sum('agent_money_paid');

        $totalLandSeller = LandSellerAgreementPriceInformation::count();

        $paybleAmountLandSeller = LandSellerAgreementPriceInformation::sum('total_price');

        $paidAmountLandSeller = LandSellerAgreementPriceInformation::sum('paid_amount');

        $dueAmountLandSeller = LandSellerAgreementPriceInformation::sum('total_price') - LandSellerAgreementPriceInformation::sum('paid_amount');

        $totalLandSize = 1000;

        $landPurchaseCompleteTotalSeller = LandSellerAgreementRelation::distinct()->count('land_seller_id');

        $landPurchaseCompleteTotalLandSize = LandSellerAgreement::sum('land_size_katha');

        $landDispute  =0;

        $totalLandBroker = LandBroker::count();

        $paybleAmountLandBroker = LandBrokerPaymentInformation::sum('broker_money');

        $paidAmountLandBroker = LandBrokerPaymentInformation::sum('broker_money_paid');

        $dueAmountLandBroker = LandBrokerPaymentInformation::sum('broker_money') - LandBrokerPaymentInformation::sum('broker_money_paid');


        return response()->json([
            'totalCustomers' => $totalCustomers,
            'paybleAmount' => $paybleAmount,
            'paidAmount' => $paidAmount,
            'dueAmount' => $dueAmount,
            'paymentCompleteCustomer' => $paymentCompleteCustomer,
            'regCompleteCustomer' => $regCompleteCustomer,
            'bookingCancelCustomer' => $bookingCancelCustomer,
            'bookingCancelPaymentReturn' => $bookingCancelPaymentReturn,
            'totalAgent' => $totalAgent,
            'paybleAmountAgent' => $paybleAmountAgent,
            'paidAmountAgent' => $paidAmountAgent,
            'dueAmountAgent' => $dueAmountAgent,
            'totalLandSeller' => $totalLandSeller,
            'paybleAmountLandSeller' => $paybleAmountLandSeller,
            'paidAmountLandSeller' => $paidAmountLandSeller,
            'dueAmountLandSeller' => $dueAmountLandSeller,
            'totalLandSize'  => $totalLandSize,
            'landPurchaseCompleteTotalSeller' => $landPurchaseCompleteTotalSeller,
            'landPurchaseCompleteTotalLandSize' => $landPurchaseCompleteTotalLandSize,
            'landDispute' => $landDispute,
            'totalLandBroker' => $totalLandBroker,
            'paybleAmountLandBroker' => $paybleAmountLandBroker,
            'paidAmountLandBroker' => $paidAmountLandBroker,
            'dueAmountLandBroker' => $dueAmountLandBroker,
        ], 200);
    }

}
