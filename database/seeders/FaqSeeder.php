<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu Open Trip?',
                'answer' => 'Open Trip adalah sistem pendakian yang memungkinkan pendaki mendaftar secara individu dan akan digabungkan dengan pendaki lain dalam satu grup. Ini cocok untuk pendaki solo atau yang ingin berhemat biaya karena biaya dibagi bersama.',
            ],
            [
                'question' => 'Bagaimana cara booking trip?',
                'answer' => 'Cara booking sangat mudah: 1) Daftar/Login ke akun HikersHub, 2) Pilih trip yang diinginkan, 3) Isi formulir booking dengan lengkap, 4) Transfer DP sesuai nominal yang tertera, 5) Upload bukti pembayaran, 6) Tunggu konfirmasi dari admin maksimal 1x24 jam.',
            ],
            [
                'question' => 'Berapa DP yang harus dibayar?',
                'answer' => 'Down Payment (DP) bervariasi tergantung paket trip. Umumnya: 30% untuk trip pendek (1-2 hari), 40% untuk trip menengah (3-4 hari), 50% untuk trip panjang (5+ hari). Pelunasan dilakukan H-7 sebelum keberangkatan.',
            ],
            [
                'question' => 'Apakah ada refund jika cancel?',
                'answer' => 'Kebijakan refund: Cancel H-14 atau lebih = refund 70%, Cancel H-7 sampai H-13 = refund 40%, Cancel H-6 ke bawah = tidak ada refund. Force majeure (cuaca ekstrem, erupsi, dll) akan direschedule atau refund 90%.',
            ],
            [
                'question' => 'Apa saja yang sudah include dalam paket?',
                'answer' => 'Setiap paket berbeda, tapi umumnya sudah include: Guide bersertifikat, Porter logistik, Tenda & sleeping bag, Makan sesuai durasi, P3K standar, Simaksi/perizinan, Asuransi pendakian. Detail lengkap ada di halaman setiap trip.',
            ],
            [
                'question' => 'Apakah pemula boleh ikut?',
                'answer' => 'Tentu! Kami menyediakan trip untuk semua level. Untuk pemula, kami rekomendasikan gunung dengan difficulty "Easy" atau "Medium" seperti Prau, Bromo, atau Merbabu. Tim guide kami sangat berpengalaman membimbing pemula.',
            ],
            [
                'question' => 'Peralatan apa yang harus dibawa sendiri?',
                'answer' => 'Peralatan pribadi yang wajib: Carrier/tas gunung (30-40L untuk pendek, 50-60L untuk panjang), Sepatu tracking, Jaket tebal & windproof, Pakaian ganti, Headlamp + baterai cadangan, Matras (jika tidak disediakan), Peralatan mandi, Obat-obatan pribadi, Power bank, Kantong sampah.',
            ],
            [
                'question' => 'Apakah ada batasan usia?',
                'answer' => 'Batasan usia: Minimum 12 tahun (dengan pendampingan orangtua untuk difficulty Easy-Medium), 17 tahun untuk difficulty Hard-Extreme, Maximum 60 tahun (dengan surat keterangan sehat dari dokter). Kondisi fisik lebih penting dari usia.',
            ],
            [
                'question' => 'Bagaimana jika trip dibatalkan karena cuaca?',
                'answer' => 'Keselamatan adalah prioritas utama. Jika trip dibatalkan karena cuaca ekstrem, erupsi, atau force majeure lainnya, peserta dapat: 1) Reschedule ke jadwal lain tanpa biaya tambahan, atau 2) Refund 90% dari total pembayaran (10% untuk biaya administrasi).',
            ],
            [
                'question' => 'Apakah ada program khusus untuk grup/corporate?',
                'answer' => 'Ya! Kami menyediakan Private Trip untuk grup minimal 10 orang dengan harga spesial dan jadwal yang fleksibel. Cocok untuk gathering kantor, sekolah, atau komunitas. Hubungi admin untuk penawaran khusus.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('FAQs data seeded successfully!');
    }
}