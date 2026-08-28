<?php

namespace App\Console\Commands;

use App\Models\School;
use App\Models\Section;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserMatricule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-matricule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Générer un matricule pour les utilisateurs qui n'en ont pas";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('schools','schools.id','=','users.idSchool')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('roles.id', 8)
            ->where('users.deleted',0)
            ->whereNull('users.matricule')
            ->select('users.id', 'users.matricule', 'users.idSection', 'users.idSchool', 'users.name')
            ->orderBy('users.id')
            ->get();

        $position = 1;
        // Pour chacun de ces users, il faut générer un matricule
        foreach ($users as $key => $user) {
            $school = School::find($user->idSchool);

            if(!empty($school->matricule_code)){
                $section = Section::find($user->idSection);

                $year = substr(date('Y'), 2, 2);
                $section = strtoupper(substr($section->name, 0, 3));

                if($section == "FRA") $section = "FR"; // On renomme pour francophone en FR
                if($section == "ANG") $section = "EN"; // On renomme pour anglophone en EN

                // Si $school->matricule_code est null, on ne génère pas du tout de matricule

                do{
                    $matricule = strtoupper($school->matricule_code.$year.$section.str_pad($position, 4, "0", STR_PAD_LEFT));
                    $position++;
                }while(User::where("matricule", $matricule)->first());

                $user->matricule = $matricule;

                $user->save();

                $this->info($user->name. " ----- " . $user->matricule);
            }else{
                $this->error("Code matricule pour {$school->name} non trouvé.");
            }
        }

//        $this->info(count($users) . " utilisateurs concernés");

        return 0;
    }
}
