<?php

use App\Booking;
use App\BookingType;
use App\Car;
use App\Page;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => bcrypt("admin"),
        ]);

        Page::create([
            "banner_url" => null,
            "title" => "",
            "description" => "",
            "background_color" => "#ffffff",
            "text_color" => "#3c4047",
            "font" => "OPEL"
        ]);

        // Car::create([
        //     "model" => "MAZDA MX-30",
        //     "image_url" => "https://fr.cdn.mazda.media/1b9b228969b44369b02489fcf1b80bf5/f95f4e8e8e1f4170a241632549ba92e6.png?495990",
        //     "description" => "Le Nouveau Mazda MX-30 est conçu pour satisfaire tous les besoins quotidiens. Avec son extérieur résolument moderne et élégant ainsi que son intérieur spacieux, il offre une grande maniabilité ainsi que l’autonomie et la flexibilité dont vous avez besoin au quotidien.",
        // ]);

        // Car::create([
        //     "model" => "MAZDA 2",
        //     "image_url" => "https://fr.cdn.mazda.media/581c38bb7592498da976412238db31ff/25c531da8f6940188d48030a2d03997d.png?49685c",
        //     "description" => "Inspirés par la philosophie de design Kodo - l’âme du mouvement, nous avons créé une voiture à la fois audacieuse, élégante et ludique. La Nouvelle Mazda2 va bien au-delà d’un design extérieur sophistiqué en vous proposant des émissions de CO2 réduites et des fonctions de sécurité améliorées. Que ce soit en ville ou à la campagne, la Nouvelle Mazda2 est une voiture qui saura vous toucher en plein cœur avant même que vous ne passiez au volant.",
        // ]);

        // Car::create([
        //     "model" => "MAZDA MX-5",
        //     "image_url" => "https://fr.cdn.mazda.media/5727693478e6464c9d9ad9dcab13ee50/908534686bae40ac867ec3e19b14f2ad.png?492aef",
        //     "description" => "Ce nouvel opus conserve son âme de roadster. Sa légèreté, son agilité et sa maniabilité font honneur à sa lignée. Doté d’un centre de gravité très bas, d’une motricité aux roues arrière (propulsion) et des Technologies Skyactiv, ce cabriolet vous donne encore plus le sentiment de faire corps avec lui. Il se distingue par sa sobriété, ses faibles émissions et son système de connectivité.",
        // ]);

        BookingType::create([
            "name" => "phone_call",
            "label" => "Rendez-vous téléphonique"
        ]);
        BookingType::create([
            "name" => "date_with_commercial",
            "label" => "Rendez-vous en concession avec un commercial"
        ]);
        BookingType::create([
            "name" => "car_try",
            "label" => "Réservez un essai de vehicule"
        ]);

        // Booking::create([
        //     "firstname" => "Jean",
        //     "lastname" => "Dujardin",
        //     "email" => "jeandujardin@gmail.com",
        //     "phone" => "0683336525",
        //     "start_at" => Carbon::create(2020, 10, 17, 8, 30, 0),
        //     // "end_at" => Carbon::now(),
        //     "car_id" => 1
        // ]);
        // Booking::create([
        //     "firstname" => "Christophe",
        //     "lastname" => "test",
        //     "email" => "christophe48@gmail.com",
        //     "start_at" => Carbon::create(2020, 10, 17, 8, 30, 0),
        //     // "end_at" => Carbon::now(),
        //     "car_id" => 1
        // ]);
        // Booking::create([
        //     "firstname" => "Robert",
        //     "lastname" => "Darwin",
        //     "email" => "robert3485@gmail.com",
        //     "start_at" => Carbon::create(2020, 10, 17, 8, 30, 0),
        //     // "end_at" => Carbon::now(),
        //     "car_id" => 2
        // ]);
        // Booking::create([
        //     "firstname" => "John",
        //     "lastname" => "Belin",
        //     "email" => "johnbelin@gmail.com",
        //     "phone" => "0682541474",
        //     "start_at" => Carbon::create(2020, 10, 17, 7, 0, 0),
        //     // "end_at" => Carbon::now(),
        //     "car_id" => 1
        // ]);

    }
}
