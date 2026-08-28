<?php

use App\Models\ResponseUser;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
//        $sql = file_get_contents("database/test/u989816557_dev.sql");
//        \Illuminate\Support\Facades\DB::unprepared($sql);


        $users = [198, 37, 146, 142, 55];
        $idAssessment = 577;

        DB::table('questionnaires')->truncate();

        // On va créer 5 questions
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Questionnaire::create([
                'idAssessment' => $idAssessment,
                'idAssessmentType' => 1,
                'intitule' => Faker::create()->sentence(),
                'notemax' => 4,
                'reponse' => Faker::create()->sentence(),
            ]);
        }

        /**
         * On va enregistrer quelques réponses de quelques étudiants pour pouvoir travailler
         */
        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                ResponseUser::updateOrCreate([
                    'idUser' => $user,
                    'idQuestionnaire' => $i,
                ],[
                    'idUser' => $user,
                    'idQuestionnaire' => $i,
                    'idAssessment' => $idAssessment,
                    'response' => Faker::create()->sentence(), // Génère une phrase aléatoire
                ]);
            }
        }
    }
}
