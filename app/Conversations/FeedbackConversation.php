<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class FeedbackConversation extends Conversation
{
    protected $feedback;

    public function askFeedback()
    {
        $this->ask('You selected Feedback. Please provide your feedback or suggestions.', function ($answer) {
            $this->feedback = $answer->getText();
            $this->thankUser();
        });
    }

    public function thankUser()
    {
        // Here, you could optionally store the feedback in the database if desired.
        // Feedback::create(['content' => $this->feedback]);

        $this->say('Thank you for your feedback! We really appreciate it.');
        $this->redirectToContactUs();
    }

    public function redirectToContactUs()
    {
        $contactUrl = 'https://coolbuffs.com/contact-us/';
        $this->say("If you would like to provide more feedback, feel free to visit our [Contact Us]({$contactUrl}) page.");
        $this->say('Please choose another service i can help you with:<br><br>'
                . '0: Job Search<br>'
                . '1: Applicant Search<br>'
                . '2: FAQs<br>'
                . '3: Feedback<br>'
                . 'Please type the number of the service you want us to help you with.');
    }

    public function run()
    {
        $this->askFeedback();
    }
}
