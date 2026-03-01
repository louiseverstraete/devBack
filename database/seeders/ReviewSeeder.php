<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Sophie Martin',
                'message' => 'Événement parfaitement organisé ! L\'équipe était très professionnelle et l\'ambiance extraordinaire. Je recommande vivement !',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'name' => 'Thomas Dubois',
                'message' => 'Super expérience, networking de qualité et intervenants passionnants. Hâte de participer au prochain !',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'name' => 'Marie Lefebvre',
                'message' => 'Très belle découverte, organisation impeccable. Les sujets abordés étaient pertinents et enrichissants.',
                'rating' => 4,
                'approved' => true,
            ],
            [
                'name' => 'Jean Moreau',
                'message' => 'Excellent moment passé lors du séminaire. Cadre agréable et échanges de grande qualité avec les autres participants.',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'name' => 'Claire Petit',
                'message' => 'Événement très enrichissant, j\'ai beaucoup appris et fait de belles rencontres professionnelles. Merci à l\'équipe !',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'name' => 'Pierre Laurent',
                'message' => 'Organisation au top, contenu de qualité. Une vraie valeur ajoutée pour mon activité professionnelle.',
                'rating' => 4,
                'approved' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}