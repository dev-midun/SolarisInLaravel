<?php

namespace Database\Seeders;

use App\Const\CurrencyConst;
use App\Const\GenderConst;
use App\Const\ReligionConst;
use App\Const\SalutationConst;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Province;
use App\Models\Religion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        $this->salutation();
        $this->gender();
        $this->religion();
        $this->currency();
        // $this->addressLookup();
    }

    protected function salutation(): void
    {
        $data = [
            [
                'id' => SalutationConst::Mr,
                'name' => 'Mr',
                'position' => 1
            ],
            [
                'id' => SalutationConst::Ms,
                'name' => 'Ms',
                'position' => 2
            ],
            [
                'id' => SalutationConst::Dr,
                'name' => 'Dr',
                'position' => 3
            ],
            [
                'id' => SalutationConst::Mrs,
                'name' => 'Mrs',
                'position' => 4
            ]
        ];
        DB::table('salutation')->insert($data);
    }

    protected function gender(): void
    {
        $data = [
            [
                'id' => GenderConst::Male,
                'name' => 'Male',
                'position' => 1
            ],
            [
                'id' => GenderConst::Female,
                'name' => 'Female',
                'position' => 2
            ]
        ];
        DB::table('gender')->insert($data);
    }

    protected function religion(): void
    {
        $data = [
            [
                'id' => ReligionConst::Islam,
                'name' => 'Islam',
                'position' => 1
            ],
            [
                'id' => ReligionConst::Protestan,
                'name' => 'Protestan',
                'position' => 2
            ],
            [
                'id' => ReligionConst::Katolik,
                'name' => 'Katolik',
                'position' => 3
            ],
            [
                'id' => ReligionConst::Hindu,
                'name' => 'Hindu',
                'position' => 4
            ],
            [
                'id' => ReligionConst::Buddha,
                'name' => 'Buddha',
                'position' => 5
            ],
            [
                'id' => ReligionConst::Khonghucu,
                'name' => 'Khonghucu',
                'position' => 6
            ],
        ];
        DB::table('religion')->insert($data);
    }

    protected function currency(): void
    {
        $data = [
            [
                'id' => CurrencyConst::Rupiah,
                'name' => 'Rupiah',
                'code' => 'IDR',
                'symbol' => 'Rp',
                'position' => 1
            ],
            [
                'id' => CurrencyConst::SingaporeDollar,
                'name' => 'Singapore Dollar',
                'code' => 'SGD',
                'symbol' => 'S$',
                'position' => 8
            ],
            [
                'id' => CurrencyConst::MalaysianRinggit,
                'name' => 'Malaysian Ringgit',
                'code' => 'MYR',
                'symbol' => 'RM',
                'position' => 9
            ],
            [
                'id' => CurrencyConst::Baht,
                'name' => 'Baht',
                'code' => 'THB',
                'symbol' => '฿',
                'position' => 10
            ],
            [
                'id' => CurrencyConst::Dong,
                'name' => 'Dong',
                'code' => 'VND',
                'symbol' => '₫',
                'position' => 11
            ],
            [
                'id' => CurrencyConst::PhilippinePeso,
                'name' => 'Philippine Peso',
                'code' => 'PHP',
                'symbol' => '₱',
                'position' => 12
            ],
            [
                'id' => CurrencyConst::Kyat,
                'name' => 'Kyat',
                'code' => 'MMK',
                'symbol' => 'K',
                'position' => 13
            ],
            [
                'id' => CurrencyConst::Riel,
                'name' => 'Riel',
                'code' => 'KHR',
                'symbol' => '៛',
                'position' => 14
            ],
            [
                'id' => CurrencyConst::Kip,
                'name' => 'Kip',
                'code' => 'LAK',
                'symbol' => '₭',
                'position' => 15
            ],
            [
                'id' => CurrencyConst::USDollar,
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'position' => 2
            ],
            [
                'id' => CurrencyConst::Euro,
                'name' => 'EURO',
                'code' => 'EUR',
                'symbol' => '€',
                'position' => 3
            ],
            [
                'id' => CurrencyConst::PoundSterling,
                'name' => 'Pound Sterling',
                'code' => 'GBP',
                'symbol' => '£',
                'position' => 4
            ],
            [
                'id' => CurrencyConst::YuanRenminbi,
                'name' => 'Yuan Renminbi',
                'code' => 'CNY',
                'symbol' => 'CN¥',
                'position' => 5
            ],
            [
                'id' => CurrencyConst::Yen,
                'name' => 'Yen',
                'code' => 'JPY',
                'symbol' => '¥',
                'position' => 4
            ],
            [
                'id' => CurrencyConst::Won,
                'name' => 'Won',
                'code' => 'KRW',
                'symbol' => '₩',
                'position' => 7
            ],
            [
                'id' => CurrencyConst::IndianRupee,
                'name' => 'Indian Rupee',
                'code' => 'INR',
                'symbol' => '₹',
                'position' => 16
            ],
        ];
        DB::table('currency')->insert($data);
    }

    protected function addressLookup(): void
    {
        $country = Country::create([
            'name' => "Indonesia",
            'position' => 1,
        ]);

        $countryId = $country->id;

        $this->province($countryId);
        $provincies = Province::select('id', 'code')->where('country_id', $countryId)->get();

        $this->postal_code($countryId, $provincies);
    }

    private function province(string $countryId): void
    {
        $url = 'https://raw.githubusercontent.com/pentagonal/Indonesia-Postal-Code/master/Json/provinces_id_as_key_indonesia.json';
        $req = Http::get($url);
        $res = $req->json();

        $i = 1;
        $data = [];
        foreach($res as $key => $value) {
            $data[] = [
                'id' => (string) Str::orderedUuid(),
                'name' => Str::title($value),
                'country_id' => $countryId,
                'code' => (String)$key,
                'position' => $i++
            ];

            if(count($data) == 10) {
                DB::table('province')->insert($data);
                $data = [];
            }
        }

        if(count($data) > 0) {
            DB::table('province')->insert($data);
        }
    }

    private function postal_code($countryId, $provincies): void
    {
        $url = 'https://raw.githubusercontent.com/pentagonal/Indonesia-Postal-Code/master/Json/postal_province_code_as_key.json';
        $req = Http::get($url);
        $res = $req->json();

        foreach($res as $provCode => $value) {
            $provId = $provincies->first(fn($item) => $item->code == (string)$provCode)->id;

            $cities = array_unique(array_column($value, 'city'));
            $this->city($countryId, $provId, $cities);

            $cityIds = City::select('id', 'name')->where('province_id', $provId)->get();
            foreach ($cities as $city) {
                $cityId = $cityIds->where('name', Str::title($city))->first()->id;

                $districts = Arr::where($value, fn($item) => $item['city'] == $city);
                $this->district($countryId, $provId, $cityId, $districts);

                $districtIds = District::select('id', 'name')
                    ->where('province_id', $provId)
                    ->where('city_id', $cityId)
                    ->get();
                foreach ($districts as $district) {
                    $districtId = $districtIds->where('name', Str::title($district["sub_district"]))->first()->id;

                    $subDistricts = Arr::where($districts, fn($item) => $item['sub_district'] == $district);
                    $this->sub_district($countryId, $provId, $cityId, $districtId, $subDistricts);
                }
            }
        }
    }

    private function city($countryId, $provId, $cities): void
    {
        $i = 1;
        $data = [];
        foreach ($cities as $value) {
            $data[] = [
                'id' => (string) Str::orderedUuid(),
                'name' => Str::title($value),
                'province_id' => $provId,
                'country_id' => $countryId,
                'position' => $i++
            ];

            if(count($data) == 50) {
                DB::table('city')->insert($data);
                $data = [];
            }
        }

        if(count($data) > 0) {
            DB::table('city')->insert($data);
        }
    }

    private function district($countryId, $provId, $cityId, $districts): void
    {
        $i = 1;
        $data = [];
        foreach ($districts as $value) {
            $data[] = [
                'id' => (string) Str::orderedUuid(),
                'name' => Str::title($value["sub_district"]),
                'city_id' => $cityId,
                'province_id' => $provId,
                'country_id' => $countryId,
                'position' => $i++
            ];

            if(count($data) == 50) {
                DB::table('district')->insert($data);
                $data = [];
            }
        }

        if(count($data) > 0) {
            DB::table('district')->insert($data);
        }
    }

    private function sub_district($countryId, $provId, $cityId, $districtId, $subDistricts): void
    {
        $i = 1;
        $data = [];
        foreach ($subDistricts as $value) {
            $data[] = [
                'id' => (string) Str::orderedUuid(),
                'name' => Str::title($value["urban"]),
                'district_id' => $districtId,
                'city_id' => $cityId,
                'province_id' => $provId,
                'country_id' => $countryId,
                'postcode' => $value["postal_code"],
                'position' => $i++
            ];

            if(count($data) == 50) {
                DB::table('sub_district')->insert($data);
                $data = [];
            }
        }

        if(count($data) > 0) {
            DB::table('sub_district')->insert($data);
        }
    }
}
