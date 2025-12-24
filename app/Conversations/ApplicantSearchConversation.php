<?php
namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;
use App\FunctionalArea;

class ApplicantSearchConversation extends Conversation
{
    protected $functionalArea;

    public function askFunctionalArea()
    {
        $this->ask('Please provide the functional area you are looking for.', function ($answer) {
            $this->functionalArea = $answer->getText();

            $this->searchApplicants();
        });
    }

    public function searchApplicants()
    {
        $functionalArea = FunctionalArea::whereRaw("LOWER(functional_area) LIKE ?", ['%' . strtolower($this->functionalArea) . '%'])
                                ->first();

        if ($functionalArea) {
             $users = User::where('functional_area_id', $functionalArea->id)->take(5)->get();
            $totalUsersCount = User::where('functional_area_id', $functionalArea->id)->count(); // Get total number of users in this functional area

            if ($users->isEmpty()) {
                $this->say("No applicants found for '{$this->functionalArea}'.");
                $this->askNextApplicant();
            } else {
                $response = "Found the following applicants in {$this->functionalArea}:\n";
                foreach ($users as $user) {
                    $applicantUrl = 'https://coolbuffs.com/user-profile/' . $user->id;
                    $response .= "Name: {$user->name}<br>";
                    $response .= "Email: {$user->email}<br>";
                    $response .= "Phone: {$user->phone}<br>";
                    $response .= "Profile: <a href=\"{$applicantUrl}\" target=\"_blank\">View Applicant</a><br><br>";
                }
                if ($totalUsersCount > 5) {
                    $remainingUsersCount = $totalUsersCount - 5;
                    $response .= "<br><a href=\"https://coolbuffs.com/job-seekers?\">View {$remainingUsersCount} more applicants</a>";
                }
                $this->say($response);
                $this->askNextApplicant();
            }
        } else {
            $this->say("Sorry, no functional area matches '{$this->functionalArea}'. Please try again.");
            $this->askFunctionalArea();
        }
    }
    public function askNextApplicant()
    {
        $this->ask('Would you like to search for another applicant? Type "Yes" or "No".', function ($answer) {
            if (strtolower($answer->getText()) === 'yes') {
                $this->askFunctionalArea();
            } else {
                $this->say('Please choose another service i can help you with:<br><br>'
                . '0: Job Search<br>'
                . '1: Applicant Search<br>'
                . '2: FAQs<br>'
                . '3: Feedback<br>'
                . 'Please type the number of the service you want us to help you with.');
            }
        });
    }

    public function run()
    {
        $this->askFunctionalArea();
    }
}
