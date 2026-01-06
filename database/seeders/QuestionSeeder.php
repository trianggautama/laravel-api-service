<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            'Disebut apa blok penyusun utama UI Flutter?',
            'Bagaimana UI Flutter di "build" ?',
            'apa tujuan dari sebuah StatefulWidget?',
            'Widget mana yang sebaiknya Anda coba gunakan lebih sering: StatelessWidget atau StatefulWidget ?',
            'Apa yang terjadi jika Anda mengubah data dalam StatelessWidget?',
            'Bagaimana Anda harus memperbarui data di dalam Widget Stateful?',
            'Apa fungsi dari Widget build(BuildContext context)?',
            'Apa yang dimaksud dengan "widget tree" di Flutter?',
            'Widget apa yang digunakan untuk membuat tata letak horizontal?',
            'Widget apa yang digunakan untuk membuat tata letak vertikal?',
            'Apa fungsi dari Container widget?',
            'Bagaimana cara menambahkan padding pada widget?',
            'Apa yang dimaksud dengan "Hot Reload" di Flutter?',
            'Widget apa yang digunakan untuk menampilkan gambar?',
            'Apa fungsi dari Navigator widget?',
        ];

        foreach ($questions as $question) {
            Question::create([
                'question_text' => $question,
            ]);
        }
    }
}
