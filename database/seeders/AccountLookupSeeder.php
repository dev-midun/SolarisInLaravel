<?php

namespace Database\Seeders;

use App\Const\AccountTypeConst;
use App\Const\AnnualRevenueConst;
use App\Const\BusinessEntityConst;
use App\Const\BusinessSizeConst;
use App\Const\CurrencyConst;
use App\Const\CustomerJourneyConst;
use App\Const\FrequencyConst;
use App\Const\IndustryConst;
use App\Const\NumberOfEmployeeConst;
use App\Const\OwnershipTypeConst;
use App\Const\SegmentationConst;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountLookupSeeder extends Seeder
{
    public function run(): void
    {
        $this->account_type();
        $this->customer_journey();
        $this->segmentation();
        $this->frequency_type();
        $this->business_size();
        $this->ownership_type();
        $this->number_of_employee();
        $this->annual_revenue();
        $this->business_entity();
        $this->industry();
    }

    protected function account_type(): void
    {
        $data = [
            [
                'id' => AccountTypeConst::Customer,
                'name' => 'Customer',
                'position' => 1
            ],
            [
                'id' => AccountTypeConst::Partner,
                'name' => 'Partner',
                'position' => 2
            ],
            [
                'id' => AccountTypeConst::Competitor,
                'name' => 'Competitor',
                'position' => 3
            ]
        ];
        DB::table('account_type')->insert($data);
    }

    protected function customer_journey(): void
    {
        $data = [
            [
                'id' => CustomerJourneyConst::NewCustomer,
                'name' => 'New Customer',
                'position' => 1
            ],
            [
                'id' => CustomerJourneyConst::Customer,
                'name' => 'Customer',
                'position' => 2
            ],
            [
                'id' => CustomerJourneyConst::ValuesAndBeliefs,
                'name' => 'Values & Beliefs',
                'position' => 3
            ],
            [
                'id' => CustomerJourneyConst::Loyalty,
                'name' => 'Loyalty',
                'position' => 4
            ],
            [
                'id' => CustomerJourneyConst::Advocate,
                'name' => 'Advocate',
                'position' => 5
            ],
        ];
        DB::table('customer_journey')->insert($data);
    }

    protected function segmentation(): void
    {
        $data = [
            [
                'id' => SegmentationConst::VIP,
                'name' => 'VIP',
                'position' => 1
            ],
            [
                'id' => SegmentationConst::Gold,
                'name' => 'Gold',
                'position' => 2
            ],
            [
                'id' => SegmentationConst::Bronze,
                'name' => 'Bronze',
                'position' => 3
            ],
            [
                'id' => SegmentationConst::Silver,
                'name' => 'Silver',
                'position' => 4
            ]
        ];
        DB::table('segmentation')->insert($data);
    }

    protected function frequency_type(): void
    {
        $data = [
            [
                'id' => FrequencyConst::Days,
                'name' => 'Days',
                'position' => 1
            ],
            [
                'id' => FrequencyConst::Weeks,
                'name' => 'Weeks',
                'position' => 2
            ],
            [
                'id' => FrequencyConst::Months,
                'name' => 'Months',
                'position' => 3
            ],
            [
                'id' => FrequencyConst::Years,
                'name' => 'Years',
                'position' => 4
            ]
        ];
        DB::table('frequency_type')->insert($data);
    }

    protected function business_size(): void
    {
        $data = [
            [
                'id' => BusinessSizeConst::SMB,
                'name' => 'SMB',
                'position' => 1
            ],
            [
                'id' => BusinessSizeConst::LargeEnterprise,
                'name' => 'Large Enterprise',
                'position' => 2
            ]
        ];
        DB::table('business_size')->insert($data);
    }

    protected function ownership_type(): void
    {
        $data = [
            [
                'id' => OwnershipTypeConst::PrivateCompany,
                'name' => 'Private Company',
                'position' => 1
            ],
            [
                'id' => OwnershipTypeConst::PublicCompany,
                'name' => 'Public Company',
                'position' => 2
            ],
            [
                'id' => OwnershipTypeConst::MNC,
                'name' => 'MNC',
                'position' => 3
            ],
            [
                'id' => OwnershipTypeConst::BUMN,
                'name' => 'BUMN',
                'position' => 4
            ],
            [
                'id' => OwnershipTypeConst::Government,
                'name' => 'Government',
                'position' => 5
            ],
            [
                'id' => OwnershipTypeConst::Others,
                'name' => 'Others',
                'position' => 6
            ],
        ];
        DB::table('ownership_type')->insert($data);
    }

    protected function number_of_employee(): void
    {
        $data = [
            [
                'id' => NumberOfEmployeeConst::OneTo100,
                'name' => "1-100",
                'position' => 1
            ],
            [
                'id' => NumberOfEmployeeConst::HundredOneTo500,
                'name' => "101-500",
                'position' => 2
            ],
            [
                'id' => NumberOfEmployeeConst::FiveHundredOneTo1000,
                'name' => "501-1.000",
                'position' => 3
            ],
            [
                'id' => NumberOfEmployeeConst::ThousandOneTo5000,
                'name' => "1.001-5.000",
                'position' => 4
            ],
            [
                'id' => NumberOfEmployeeConst::FiveThousandOneTo10000,
                'name' => "5.001-10.000",
                'position' => 5
            ],
            [
                'id' => NumberOfEmployeeConst::MoreThan10000,
                'name' => "> 10.000",
                'position' => 6
            ],
        ];
        DB::table('number_of_employee')->insert($data);
    }

    protected function annual_revenue(): void
    {
        $data = [
            [
                'id' => AnnualRevenueConst::ZeroToFiveBillion,
                'name' => "0 - 5 Billion",
                'position' => 1,
            ],
            [
                'id' => AnnualRevenueConst::FiveToTenBillion,
                'name' => "5 - 10 Billion",
                'position' => 2,
            ],
            [
                'id' => AnnualRevenueConst::TenToOneHundredBillion,
                'name' => "10 - 100 Billion",
                'position' => 3,
            ],
            [
                'id' => AnnualRevenueConst::OneHundredToFiveHundredBillion,
                'name' => "100 - 500 Billion",
                'position' => 4,
            ],
            [
                'id' => AnnualRevenueConst::FiveHundredBillionToOneTrillion,
                'name' => "500 - 1 Trillion",
                'position' => 5,
            ],
            [
                'id' => AnnualRevenueConst::MoreThanOneTrillion,
                'name' => "> 1 Trillion",
                'position' => 6,
            ],
        ];
        DB::table('annual_revenue')->insert($data);
    }

    protected function business_entity(): void
    {
        $data = [
            [
                'id' => BusinessEntityConst::PT,
                'name' => "PT",
                'position' => 1,
            ],
            [
                'id' => BusinessEntityConst::CV,
                'name' => "CV",
                'position' => 2,
            ],
            [
                'id' => BusinessEntityConst::UD,
                'name' => "UD",
                'position' => 3,
            ],
            [
                'id' => BusinessEntityConst::Others,
                'name' => "Others",
                'position' => 4,
            ]
        ];
        DB::table('business_entity')->insert($data);
    }

    protected function industry(): void
    {
        $data = [
            [
                'id' => IndustryConst::Pharma,
                'name' => "Pharma",
                'position' => 1
            ],
            [
                'id' => IndustryConst::Telco,
                'name' => "Telco",
                'position' => 2
            ],
            [
                'id' => IndustryConst::Leasing,
                'name' => "Leasing",
                'position' => 3
            ],
            [
                'id' => IndustryConst::Bank,
                'name' => "Bank",
                'position' => 4
            ],
            [
                'id' => IndustryConst::ITTechnology,
                'name' => "IT / Technology",
                'position' => 5
            ],
            [
                'id' => IndustryConst::Construction,
                'name' => "Construction",
                'position' => 6
            ],
            [
                'id' => IndustryConst::Consulting,
                'name' => "Consulting",
                'position' => 7
            ],
            [
                'id' => IndustryConst::Insurance,
                'name' => "Insurance",
                'position' => 8
            ],
            [
                'id' => IndustryConst::FMCG,
                'name' => "FMCG",
                'position' => 9
            ],
            [
                'id' => IndustryConst::Airlane,
                'name' => "Airlane",
                'position' => 10
            ],
            [
                'id' => IndustryConst::FoodBeverages,
                'name' => "Food & Beverages",
                'position' => 11
            ],
            [
                'id' => IndustryConst::Transportation,
                'name' => "Transportation",
                'position' => 12
            ],
            [
                'id' => IndustryConst::Trading,
                'name' => "Trading",
                'position' => 13
            ],
            [
                'id' => IndustryConst::FInancialServices,
                'name' => "FInancial Services",
                'position' => 14
            ],
            [
                'id' => IndustryConst::Retail,
                'name' => "Retail",
                'position' => 15
            ],
            [
                'id' => IndustryConst::FacilityBuilbindManagementServices,
                'name' => "Facility & Builbind Management Services",
                'position' => 16
            ],
            [
                'id' => IndustryConst::PropertyConsultant,
                'name' => "Property Consultant",
                'position' => 17
            ],
            [
                'id' => IndustryConst::Government,
                'name' => "Government",
                'position' => 18
            ],
            [
                'id' => IndustryConst::MediaInformation,
                'name' => "Media & Information",
                'position' => 19
            ],
            [
                'id' => IndustryConst::OilEnergy,
                'name' => "Oil & Energy",
                'position' => 20
            ],
            [
                'id' => IndustryConst::Distribution,
                'name' => "Distribution",
                'position' => 21
            ],
            [
                'id' => IndustryConst::Startup,
                'name' => "Startup",
                'position' => 22
            ],
            [
                'id' => IndustryConst::Aviation,
                'name' => "Aviation",
                'position' => 23
            ],
            [
                'id' => IndustryConst::Logistic,
                'name' => "Logistic",
                'position' => 24
            ],
            [
                'id' => IndustryConst::CommunicationProvider,
                'name' => "Communication Provider",
                'position' => 25
            ],
            [
                'id' => IndustryConst::MechanicalIndustrialEngineering,
                'name' => "Mechanical / Industrial Engineering",
                'position' => 26
            ],
            [
                'id' => IndustryConst::Others,
                'name' => "Others",
                'position' => 27
            ]
        ];
        DB::table('industry')->insert($data);
    }
}