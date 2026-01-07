<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'mountain_id' => 1, // Semeru
                'title' => 'Open Trip Semeru 3D2N - New Year Edition',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(32),
                'duration_days' => 3,
                'meeting_point' => 'Stasiun Malang',
                'price' => 850000,
                'max_participants' => 15,
                'min_participants' => 5,
                'status' => 'open',
                'itinerary' => "Hari 1: Perjalanan Malang - Ranu Pane - Ranu Kumbolo\nHari 2: Ranu Kumbolo - Kalimati - Summit Mahameru - Ranu Kumbolo\nHari 3: Ranu Kumbolo - Ranu Pane - Malang",
                'include_items' => "Guide berpengalaman, Porter logistik, Tenda kapasitas 2-3 orang, Sleeping bag, Makan 6x (3 breakfast, 2 lunch, 1 dinner), P3K standar, Dokumentasi foto, Sewa simaksi, Asuransi pendakian",
                'exclude_items' => "Transportasi Jakarta-Malang PP, Porter pribadi, Peralatan pribadi (carrier, jaket, sepatu, dll), Pengeluaran pribadi, Tips guide (optional)",
                'terms_conditions' => "Peserta wajib sehat jasmani dan rohani, Membawa identitas diri (KTP/SIM/Passport), Mengikuti arahan guide dan peraturan taman nasional, Menjaga kebersihan dan kelestarian alam, Deposit 50% saat booking, Pelunasan H-7 sebelum keberangkatan",
            ],
            [
                'mountain_id' => 2, // Rinjani
                'title' => 'Open Trip Rinjani 4D3N via Senaru',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(48),
                'duration_days' => 4,
                'meeting_point' => 'Bandara Lombok (LOP)',
                'price' => 1250000,
                'max_participants' => 12,
                'min_participants' => 6,
                'status' => 'open',
                'itinerary' => "Hari 1: Lombok - Senaru - Pos 1 - Pos 2\nHari 2: Pos 2 - Pos 3 - Pelawangan Senaru\nHari 3: Summit Attack - Segara Anak - Goa Susu\nHari 4: Goa Susu - Senaru - Lombok",
                'include_items' => "Guide profesional, Porter team, Tenda dome kapasitas 2-3 orang, Sleeping bag tebal, Matras, Makan 9x, Alat masak team, P3K lengkap, Simaksi, Asuransi, Dokumentasi",
                'exclude_items' => "Tiket pesawat, Pengeluaran pribadi, Porter pribadi (opsional Rp 600.000), Peralatan pribadi, Tips guide",
                'terms_conditions' => "Peserta minimal 17 tahun, Kondisi fisik prima, Tidak sedang hamil, Tidak memiliki penyakit jantung, asma akut, atau gangguan pernapasan berat, Deposit 30% untuk booking",
            ],
            [
                'mountain_id' => 3, // Bromo
                'title' => 'Open Trip Bromo Sunrise 2D1N',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(16),
                'duration_days' => 2,
                'meeting_point' => 'Stasiun Surabaya Gubeng',
                'price' => 450000,
                'max_participants' => 20,
                'min_participants' => 10,
                'status' => 'open',
                'itinerary' => "Hari 1: Surabaya - Bromo - Check in homestay - Istirahat\nHari 2: Sunrise hunting (02.00) - Kawah Bromo - Savana - Pasir Berbisik - Surabaya",
                'include_items' => "Transportasi Surabaya PP (Avanza/Innova), Jeep 4WD ke viewpoint, Homestay 1 malam, Makan 2x (dinner & breakfast), Guide lokal, Tiket masuk Bromo, Dokumentasi",
                'exclude_items' => "Transportasi menuju meeting point, Naik kuda (opsional), Sewa masker debu, Pengeluaran pribadi",
                'terms_conditions' => "Cocok untuk pemula dan keluarga, Membawa jaket tebal (suhu 2-5°C), Pelunasan H-3 sebelum keberangkatan, Minimal peserta 10 orang",
            ],
            [
                'mountain_id' => 4, // Merbabu
                'title' => 'Open Trip Merbabu 2D1N via Selo',
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(21),
                'duration_days' => 2,
                'meeting_point' => 'Basecamp Selo, Boyolali',
                'price' => 350000,
                'max_participants' => 18,
                'min_participants' => 8,
                'status' => 'open',
                'itinerary' => "Hari 1: Meeting point - Pos 1 - Pos 2 - Camping di sabana\nHari 2: Summit attack (03.00) - Sunrise - Turun via jalur yang sama - Selesai",
                'include_items' => "Guide bersertifikat, Tenda camping, Makan 3x, Logistik team (kompor, gas, alat masak), Welcome drink, P3K standar, Simaksi",
                'exclude_items' => "Sleeping bag (bisa sewa Rp 25.000), Carrier/tas gunung, Headlamp/senter, Jaket dan pakaian hangat, Porter pribadi",
                'terms_conditions' => "Peserta wajib mengikuti briefing, Membawa peralatan pribadi yang memadai, Deposit Rp 100.000 untuk booking, No refund jika cancel H-3",
            ],
            [
                'mountain_id' => 5, // Prau
                'title' => 'Open Trip Prau 2D1N - Paket Hemat',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(11),
                'duration_days' => 2,
                'meeting_point' => 'Basecamp Dieng/Patak Banteng',
                'price' => 250000,
                'max_participants' => 25,
                'min_participants' => 15,
                'status' => 'open',
                'itinerary' => "Hari 1: Basecamp - Pos 1 - Pos 2 - Camp area\nHari 2: Sunrise hunting - Turun - Telaga Warna (opsional) - Selesai",
                'include_items' => "Guide lokal, Tenda dome 2-3 orang, Makan 3x, Air mineral, Tiket masuk, P3K ringan, Dokumentasi GoPro",
                'exclude_items' => "Sleeping bag (sewa Rp 20.000), Matras (sewa Rp 10.000), Peralatan pribadi, Transportasi ke basecamp",
                'terms_conditions' => "Cocok untuk pemula, Bisa diikuti anak-anak di atas 12 tahun, Pelunasan saat meeting point, Trip berjalan minimal 15 peserta",
            ],
            [
                'mountain_id' => 1, // Semeru
                'title' => 'Open Trip Semeru 4D3N - Full Package',
                'start_date' => Carbon::now()->addDays(60),
                'end_date' => Carbon::now()->addDays(63),
                'duration_days' => 4,
                'meeting_point' => 'Stasiun Malang',
                'price' => 1100000,
                'max_participants' => 12,
                'min_participants' => 5,
                'status' => 'open',
                'itinerary' => "Hari 1: Malang - Ranu Pane - Ranu Kumbolo\nHari 2: Explore Ranu Kumbolo - Kalimati\nHari 3: Summit Mahameru - Ranu Kumbolo\nHari 4: Ranu Kumbolo - Ranu Pane - Malang",
                'include_items' => "Guide + asisten guide, Porter logistik, Tenda 4 season, Sleeping bag bulu angsa, Makan 10x, Cooking set lengkap, P3K complete, Simaksi, Asuransi komersial, Dokumentasi profesional",
                'exclude_items' => "Transport Jakarta-Malang PP, Porter pribadi (Rp 500.000), Sewa carrier (Rp 100.000), Tips guide",
                'terms_conditions' => "Peserta wajib fit dan berpengalaman, Medical check-up recommended, Deposit 40% untuk booking, Free reschedule 1x dengan pemberitahuan H-14",
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }

        $this->command->info('Trips data seeded successfully!');
    }
}