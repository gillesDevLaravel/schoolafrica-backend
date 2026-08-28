<?php

namespace App\Jobs;

use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Matter;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RatingNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rating;
    public $matter;
    public $assessmentType;
    public $student;
    public $classe;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
        $this->matter = Matter::find($rating->idMatter);
        $this->assessmentType = AssessmentType::find($rating->idAssessmentType);
        $this->student = User::find($rating->idStudent);
        $this->classe = Classes::find($rating->idClasse ?? optional($this->student)->idClasse);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $studentName = optional($this->student)->name ?? '';
        $classeName = optional($this->classe)->name ?? '';
        $matterName = optional($this->matter)->name ?? '';
        $sequenceName = optional($this->assessmentType)->name ?? '';

        Notification::create([
            'notificationable_type' => Rating::class,
            'notificationable_id' => $this->rating->id,
            'title' => __('notifs.rating_title', ['matter_name' => $matterName, 'classe_name' => $classeName]),
            'description' => __('notifs.rating_desc', [
                'student_name' => $studentName,
                'classe_name' => $classeName,
                'note' => $this->rating->value,
                'matter_name' => $matterName,
                'num_sequence' => $sequenceName,
            ]),
            'grouped_users' => json_encode([$this->student->id, $this->student->idParent])
        ]);
    }
}
