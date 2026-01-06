<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $optionsData = [
            // Question 1
            [
                'question' => 'Disebut apa blok penyusun utama UI Flutter?',
                'options' => [
                    ['Widgets', true],
                    ['Components', false],
                    ['Blocks', false],
                    ['Functions', false],
                ],
            ],
            // Question 2
            [
                'question' => 'Bagaimana UI Flutter di "build" ?',
                'options' => [
                    ['Dengan menggabungkan widget dalam kode', true],
                    ['Dengan menggabungkan widget dalam visual editor', false],
                    ['Dengan mendefinisikan widget dalam config file', false],
                    ['Dengan menggunakan XCode untuk iOS dan Android Studio untuk Android', false],
                ],
            ],
            // Question 3
            [
                'question' => 'apa tujuan dari sebuah StatefulWidget?',
                'options' => [
                    ['Merubah UI saat data berubah', true],
                    ['Merubah data saat UI berubah', false],
                    ['Menabaikan perubahan data', false],
                    ['Merender UI dan tidak bergantung pada data', false],
                ],
            ],
            // Question 4
            [
                'question' => 'Widget mana yang sebaiknya Anda coba gunakan lebih sering: StatelessWidget atau StatefulWidget ?',
                'options' => [
                    ['StatelessWidget', true],
                    ['StatefulWidget', false],
                    ['Keduanya sama-sama bagus', false],
                    ['Bukan salahsatu dari keduanya', false],
                ],
            ],
            // Question 5
            [
                'question' => 'Apa yang terjadi jika Anda mengubah data dalam StatelessWidget?',
                'options' => [
                    ['UI tidak diperbarui', true],
                    ['UI diperbarui', false],
                    ['StatefulWidget terdekat diperbarui', false],
                    ['Semua StatefulWidgets turunan diperbarui', false],
                ],
            ],
            // Question 6
            [
                'question' => 'Bagaimana Anda harus memperbarui data di dalam Widget Stateful?',
                'options' => [
                    ['dengan memanggil setState()', true],
                    ['dengan memanggil updateData()', false],
                    ['dengan memanggil updateUI()', false],
                    ['dengan memanggil updateState()', false],
                ],
            ],
            // Question 7
            [
                'question' => 'Apa fungsi dari Widget build(BuildContext context)?',
                'options' => [
                    ['Merender UI dari widget', true],
                    ['Menginisialisasi data', false],
                    ['Menghapus widget dari tree', false],
                    ['Menganimasikan widget', false],
                ],
            ],
            // Question 8
            [
                'question' => 'Apa yang dimaksud dengan "widget tree" di Flutter?',
                'options' => [
                    ['Struktur hierarki widget yang membentuk UI', true],
                    ['Koleksi widget yang tersimpan di database', false],
                    ['Widget yang berdiri sendiri tanpa keterkaitan', false],
                    ['Widget yang dihapus dari memori', false],
                ],
            ],
            // Question 9
            [
                'question' => 'Widget apa yang digunakan untuk membuat tata letak horizontal?',
                'options' => [
                    ['Row', true],
                    ['Column', false],
                    ['Stack', false],
                    ['Container', false],
                ],
            ],
            // Question 10
            [
                'question' => 'Widget apa yang digunakan untuk membuat tata letak vertikal?',
                'options' => [
                    ['Column', true],
                    ['Row', false],
                    ['Stack', false],
                    ['GridView', false],
                ],
            ],
            // Question 11
            [
                'question' => 'Apa fungsi dari Container widget?',
                'options' => [
                    ['Wrapper untuk widget dengan padding, margin, dan dekorasi', true],
                    ['Menyimpan data dalam memori', false],
                    ['Membuat navigasi antar halaman', false],
                    ['Menangani database operations', false],
                ],
            ],
            // Question 12
            [
                'question' => 'Bagaimana cara menambahkan padding pada widget?',
                'options' => [
                    ['Membungkus widget dengan Padding widget', true],
                    ['Menambahkan padding di Container widget', false],
                    ['Menggunakan property padding pada widget', false],
                    ['Menggunakan Spacer widget', false],
                ],
            ],
            // Question 13
            [
                'question' => 'Apa yang dimaksud dengan "Hot Reload" di Flutter?',
                'options' => [
                    ['Fitur untuk melihat perubahan kode tanpa restart aplikasi', true],
                    ['Fitur untuk mematikan aplikasi', false],
                    ['Fitur untuk menginstall aplikasi', false],
                    ['Fitur untuk debug kode', false],
                ],
            ],
            // Question 14
            [
                'question' => 'Widget apa yang digunakan untuk menampilkan gambar?',
                'options' => [
                    ['Image', true],
                    ['Icon', false],
                    ['Text', false],
                    ['CircleAvatar', false],
                ],
            ],
            // Question 15
            [
                'question' => 'Apa fungsi dari Navigator widget?',
                'options' => [
                    ['Mengelola navigasi antar layar/halaman', true],
                    ['Menavigasi ke website eksternal', false],
                    ['Menampilkan notifikasi', false],
                    ['Menyimpan state aplikasi', false],
                ],
            ],
        ];

        foreach ($optionsData as $data) {
            $question = Question::where('question_text', $data['question'])->first();

            if ($question) {
                foreach ($data['options'] as $option) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option[0],
                        'is_correct' => $option[1],
                    ]);
                }
            }
        }
    }
}
