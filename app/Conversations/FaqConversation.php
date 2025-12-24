<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Faq;

class FaqConversation extends Conversation
{
    protected $faqQuestion;

    public function askFaqQuestion()
    {
        $this->ask('You selected FAQs. Please type your question.', function ($answer) {
            $this->faqQuestion = $answer->getText();
            $this->searchFaq();
        });
    }

    public function searchFaq()
    {
        $faq = Faq::whereRaw("LOWER(faq_question) LIKE ?", ['%' . strtolower($this->faqQuestion) . '%'])
          ->first();

        if ($faq) {
            $this->say('Here is an FAQ related to your question: ' . $faq->faq_answer);
            $this->askNextQuestion();
        } else {
            $this->say('Sorry, I couldn’t find any FAQs related to your question.');
            $this->askNextQuestion();
        }
    }

    public function askNextQuestion()
    {
        $this->ask('Would you like to ask another question? Type "Yes" or "No".', function ($answer) {
            if (strtolower($answer->getText()) === 'yes') {
                $this->askFaqQuestion();
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
        $this->askFaqQuestion();
    }
}
