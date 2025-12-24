<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Job;

class JobSearchConversation extends Conversation
{
    protected $keyword;

    public function askJobKeyword()
    {
        $this->ask('What kind of job are you looking for? Please specify the role or keyword.', function ($answer) {
            $this->keyword = $answer->getText();

            $this->searchJobs();
        });
    }

    public function searchJobs()
    {
        
        $jobs = Job::whereRaw("LOWER(title) LIKE ?", ['%' . strtolower($this->keyword) . '%'])
                    ->where('expiry_date', '>', now())
                    ->where('is_active', 1)
                    ->with('company')
                    ->get();

        if ($jobs->isEmpty()) {
            $this->say("Sorry, I couldn't find any jobs related to '{$this->keyword}'. Please try again.");
            $this->askJobKeyword(); // Ask again
        } else {
            $response = "Here are some jobs related to '{$this->keyword}':\n\n";
            foreach ($jobs as $job) {
                $jobUrl = 'http://coolbuffs.com/job/' . $job->slug;
                $response .= "*Title:* {$job->title}\n";
                $response .= "*Description:* {$job->description}\n";
                $response .= "*Company:* {$job->company->name}\n";
                $response .= "*Link for more information:* <a href=\"{$jobUrl}\" target=\"_blank\">View Job</a><br><br>";
            }
            $this->say($response);
            $this->askNextJob();
        }
    }
    public function askNextJob()
    {
        $this->ask('Would you like to search another job? Type "Yes" or "No".', function ($answer) {
            if (strtolower($answer->getText()) === 'yes') {
                $this->askJobKeyword();
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
        $this->askJobKeyword();
    }
}
