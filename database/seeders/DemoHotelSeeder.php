<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoHotelSeeder extends Seeder
{
    public function run(): void
    {
        if (
            RoomType::exists() ||
            Room::exists() ||
            Customer::exists() ||
            Booking::exists() ||
            Payment::exists()
        ) {
            $this->command?->warn('Database hiện đã có dữ liệu khách sạn. Nếu muốn bộ demo sạch đẹp, hãy chạy: php artisan migrate:fresh --seed');
            return;
        }

        $faker = fake('vi_VN');
        $today = Carbon::today();

        User::updateOrCreate(
            ['email' => 'admin@hotel.test'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $roomTypes = collect([
            'standard_single' => RoomType::create([
                'name' => 'Standard Single',
                'description' => 'Phòng tiêu chuẩn 1 giường đơn, phù hợp công tác ngắn ngày.',
                'price' => 450000,
                'capacity' => 2,
            ]),
            'standard_double' => RoomType::create([
                'name' => 'Standard Double',
                'description' => 'Phòng tiêu chuẩn 1 giường đôi, phù hợp cặp đôi hoặc 2 khách.',
                'price' => 650000,
                'capacity' => 2,
            ]),
            'deluxe_double' => RoomType::create([
                'name' => 'Deluxe Double',
                'description' => 'Phòng deluxe rộng rãi, nội thất tốt hơn, phù hợp lưu trú thoải mái.',
                'price' => 900000,
                'capacity' => 3,
            ]),
            'family' => RoomType::create([
                'name' => 'Family Room',
                'description' => 'Phòng gia đình, phù hợp nhóm nhỏ hoặc gia đình có trẻ em.',
                'price' => 1200000,
                'capacity' => 4,
            ]),
            'premium_city_view' => RoomType::create([
                'name' => 'Premium City View',
                'description' => 'Phòng cao cấp với cửa sổ lớn và tầm nhìn thành phố.',
                'price' => 1500000,
                'capacity' => 3,
            ]),
            'suite' => RoomType::create([
                'name' => 'Suite',
                'description' => 'Phòng suite cao cấp, không gian rộng và đầy đủ tiện nghi.',
                'price' => 2200000,
                'capacity' => 4,
            ]),
        ]);

        $typeMapByUnit = [
            1 => 'standard_single',
            2 => 'standard_double',
            3 => 'deluxe_double',
            4 => 'family',
            5 => 'premium_city_view',
            6 => 'suite',
        ];

        $maintenanceRooms = ['205', '406'];
        $roomNotes = [
            'Gần thang máy',
            'View thoáng',
            'Yên tĩnh cuối hành lang',
            'Phù hợp khách gia đình',
            'Ưu tiên dọn sớm',
            null,
            null,
        ];

        $rooms = collect();

        for ($floor = 1; $floor <= 5; $floor++) {
            for ($unit = 1; $unit <= 6; $unit++) {
                $roomNumber = $floor . '0' . $unit;
                $typeKey = $typeMapByUnit[$unit];

                $room = Room::create([
                    'room_number' => $roomNumber,
                    'room_type_id' => $roomTypes[$typeKey]->id,
                    'floor' => $floor,
                    'status' => in_array($roomNumber, $maintenanceRooms, true) ? 'maintenance' : 'available',
                    'note' => $faker->randomElement($roomNotes),
                ]);

                $rooms->push($room->load('roomType'));
            }
        }

        $customers = collect();

        for ($i = 1; $i <= 50; $i++) {
            $customers->push(
                Customer::create([
                    'full_name' => $faker->name(),
                    'phone' => '09' . $faker->unique()->numerify('########'),
                    'email' => 'customer' . $i . '@demo.test',
                    'identity_number' => $faker->unique()->numerify('############'),
                    'address' => $faker->address(),
                ])
            );
        }

        $activeRooms = $rooms->whereNotIn('room_number', $maintenanceRooms)->values();

        foreach ($activeRooms as $index => $room) {
            $customerA = $customers->random();
            $customerB = $customers->random();
            $customerC = $customers->random();

            $pastCheckIn1 = $today->copy()->subDays(70 + ($index % 8));
            $pastCheckOut1 = $pastCheckIn1->copy()->addDays(2 + ($index % 3));

            $pastCheckIn2 = $today->copy()->subDays(30 + ($index % 6));
            $pastCheckOut2 = $pastCheckIn2->copy()->addDays(1 + ($index % 4));

            $booking1 = $this->createBooking($customerA, $room, $pastCheckIn1, $pastCheckOut1, 'checked_out', $faker);
            $booking2 = $this->createBooking($customerB, $room, $pastCheckIn2, $pastCheckOut2, 'checked_out', $faker);

            $this->seedPaymentsForBooking($booking1, 'checked_out', $faker);
            $this->seedPaymentsForBooking($booking2, 'checked_out', $faker);

            $statusPattern = $index % 5;

            if ($statusPattern === 0) {
                $checkIn = $today->copy()->subDay();
                $checkOut = $today->copy()->addDays(2);
                $status = 'checked_in';
            } elseif ($statusPattern === 1) {
                $checkIn = $today->copy()->addDays(3);
                $checkOut = $today->copy()->addDays(6);
                $status = 'confirmed';
            } elseif ($statusPattern === 2) {
                $checkIn = $today->copy()->addDays(5);
                $checkOut = $today->copy()->addDays(7);
                $status = 'pending';
            } elseif ($statusPattern === 3) {
                $checkIn = $today->copy()->subDays(8);
                $checkOut = $today->copy()->subDays(5);
                $status = 'checked_out';
            } else {
                $checkIn = $today->copy()->addDays(8);
                $checkOut = $today->copy()->addDays(10);
                $status = 'cancelled';
            }

            $booking3 = $this->createBooking($customerC, $room, $checkIn, $checkOut, $status, $faker);
            $this->seedPaymentsForBooking($booking3, $status, $faker);
        }

        foreach ($rooms as $room) {
            if ($room->status === 'maintenance') {
                continue;
            }

            $hasCheckedIn = $room->bookings()->where('status', 'checked_in')->exists();

            if ($hasCheckedIn) {
                $room->update(['status' => 'occupied']);
                continue;
            }

            $hasReserved = $room->bookings()
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('check_out_date', '>=', $today->toDateString())
                ->exists();

            $room->update([
                'status' => $hasReserved ? 'booked' : 'available',
            ]);
        }

        $this->command?->info('Seed demo hotel thành công.');
        $this->command?->info('Tài khoản demo: admin@hotel.test / 12345678');
        $this->command?->info('Đã tạo: 6 loại phòng, 30 phòng, 50 khách hàng, 84 booking + payment demo.');
    }

    private function createBooking(Customer $customer, Room $room, Carbon $checkIn, Carbon $checkOut, string $status, $faker): Booking
    {
        $nights = max($checkIn->diffInDays($checkOut), 1);
        $totalPrice = $room->roomType->price * $nights;

        $createdAt = $checkIn->copy()
            ->subDays($faker->numberBetween(2, 18))
            ->setTime($faker->numberBetween(8, 18), $faker->numberBetween(0, 59));

        $booking = new Booking([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in_date' => $checkIn->toDateString(),
            'check_out_date' => $checkOut->toDateString(),
            'adults' => min($room->roomType->capacity, $faker->numberBetween(1, max(1, $room->roomType->capacity))),
            'children' => $faker->numberBetween(0, 2),
            'total_price' => $totalPrice,
            'status' => $status,
        ]);

        $booking->created_at = $createdAt;
        $booking->updated_at = $createdAt;
        $booking->save();

        return $booking;
    }

    private function seedPaymentsForBooking(Booking $booking, string $status, $faker): void
    {
        if ($status === 'cancelled') {
            return;
        }

        $paidRatio = match ($status) {
            'checked_out' => $faker->randomElement([1, 1, 1, 0.5]),
            'checked_in' => $faker->randomElement([0.5, 0.7, 1]),
            'confirmed' => $faker->randomElement([0, 0.3, 0.5]),
            'pending' => $faker->randomElement([0, 0.3]),
            default => 0,
        };

        $paidAmount = round($booking->total_price * $paidRatio, 2);

        if ($paidAmount <= 0) {
            return;
        }

        $paymentParts = ($paidAmount >= 700000 && $faker->boolean(35)) ? 2 : 1;

        if ($paymentParts === 1) {
            $amounts = [$paidAmount];
        } else {
            $firstPart = round($paidAmount * $faker->randomFloat(2, 0.4, 0.7), 2);
            $secondPart = round($paidAmount - $firstPart, 2);
            $amounts = [$firstPart, $secondPart];
        }

        foreach ($amounts as $partIndex => $amount) {
            if ($amount <= 0) {
                continue;
            }

            $basePaidAt = match ($status) {
                'checked_out' => Carbon::parse($booking->check_out_date)->copy()->subDays(max(0, 1 - $partIndex)),
                'checked_in' => Carbon::parse($booking->check_in_date)->copy()->addDays($partIndex),
                'confirmed', 'pending' => Carbon::parse($booking->created_at)->copy()->addDays($partIndex),
                default => Carbon::parse($booking->created_at)->copy(),
            };

            $paidAt = $basePaidAt->setTime(
                $faker->numberBetween(8, 19),
                $faker->numberBetween(0, 59)
            );

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $amount,
                'payment_method' => $faker->randomElement(['cash', 'transfer', 'card']),
                'payment_status' => 'paid',
                'paid_at' => $paidAt,
                'note' => $partIndex === 0 ? 'Thanh toán đợt 1' : 'Thanh toán đợt 2',
            ]);
        }
    }
}