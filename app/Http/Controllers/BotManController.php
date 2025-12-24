<?php


namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\JobSearchConversation;
use App\Conversations\ApplicantSearchConversation;
use App\Conversations\FaqConversation;
use App\Conversations\FeedbackConversation;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        // Main Menu
        $botman->hears('Menu', function (BotMan $bot) {
            $bot->userStorage()->save(['state' => null]);
            $bot->reply('Welcome to CoolBuffs Recruitment Bot!<br><br>'
                . 'Please choose one of the following options:<br>'
                . '0: Job Search<br>'
                . '1: Applicant Search<br>'
                . '2: FAQs<br>'
                . '3: Feedback<br>'
                . 'Please type the number of the service you want us to help you with.');
        });

        // Start conversation based on user selection
        $botman->hears('0', function (BotMan $bot) {
            $bot->startConversation(new JobSearchConversation());
        });

        $botman->hears('1', function (BotMan $bot) {
            $bot->startConversation(new ApplicantSearchConversation());
        });

        $botman->hears('2', function (BotMan $bot) {
            $bot->startConversation(new FaqConversation());
        });

        $botman->hears('3', function (BotMan $bot) {
            $bot->startConversation(new FeedbackConversation());
        });

        // Fallback for invalid inputs
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand that. Please type "Menu" to show the services i provide.');
        });

        $botman->listen();
    }

}
