<?php

namespace Database\Seeders\Subfolder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'question' => 'What is the capital of France?',
                'answers' => json_encode(['Paris', 'The city of lights', 'Paris, France']),
            ],
            [
                'question' => 'How are you?',
                'answers' => json_encode(['I am fine', 'Doing well, thanks!', 'All good!']),
            ],
            [
                'question' => 'What is 2 + 2?',
                'answers' => json_encode(['4', 'Four', '2 + 2 = 4']),
            ],
            [
                'question' => 'What is the color of the sky?',
                'answers' => json_encode(['Blue', 'Light blue', 'Sky blue']),
            ],
            [
                'question' => 'Who wrote Hamlet?',
                'answers' => json_encode(['William Shakespeare', 'Shakespeare', 'W. Shakespeare']),
            ],
            [
                'question' => 'What is the largest planet?',
                'answers' => json_encode(['Jupiter', 'The gas giant Jupiter']),
            ],
            [
                'question' => 'What is the boiling point of water?',
                'answers' => json_encode(['100°C', '212°F', '100 degrees Celsius']),
            ],
            [
                'question' => 'What is the speed of light?',
                'answers' => json_encode(['299,792 km/s', 'Approximately 300,000 km/s']),
            ],
            [
                'question' => 'Who painted the Mona Lisa?',
                'answers' => json_encode(['Leonardo da Vinci', 'Da Vinci']),
            ],
            [
                'question' => 'What is the tallest mountain?',
                'answers' => json_encode(['Mount Everest', 'Everest']),
            ],
            [
                'question' => 'What is the currency of USA?',
                'answers' => json_encode(['Dollar', 'US Dollar', 'USD']),
            ],
            [
                'question' => 'Who discovered gravity?',
                'answers' => json_encode(['Isaac Newton', 'Newton']),
            ],
            [
                'question' => 'What is the smallest prime number?',
                'answers' => json_encode(['2', 'Two']),
            ],
            [
                'question' => 'What is the main language in Spain?',
                'answers' => json_encode(['Spanish', 'Español']),
            ],
            [
                'question' => 'What is H2O?',
                'answers' => json_encode(['Water', 'Dihydrogen monoxide']),
            ],
            [
                'question' => 'What is 10 / 2?',
                'answers' => json_encode(['5', 'Five']),
            ],
            [
                'question' => 'Which animal barks?',
                'answers' => json_encode(['Dog', 'A dog']),
            ],
            [
                'question' => 'Which animal meows?',
                'answers' => json_encode(['Cat', 'A cat']),
            ],
            [
                'question' => 'What do bees produce?',
                'answers' => json_encode(['Honey', 'Bee honey']),
            ],
            [
                'question' => 'What is the opposite of hot?',
                'answers' => json_encode(['Cold', 'Cool']),
            ],
            [
                'question' => 'What is the currency of Japan?',
                'answers' => json_encode(['Yen', 'Japanese Yen']),
            ],
            [
                'question' => 'What do you call frozen water?',
                'answers' => json_encode(['Ice', 'Ice cube']),
            ],
            [
                'question' => 'What is the fastest land animal?',
                'answers' => json_encode(['Cheetah', 'The cheetah']),
            ],
            [
                'question' => 'Who is known as the father of computers?',
                'answers' => json_encode(['Charles Babbage', 'Babbage']),
            ],
            [
                'question' => 'What gas do humans breathe in?',
                'answers' => json_encode(['Oxygen', 'O2']),
            ],
            [
                'question' => 'What gas do humans exhale?',
                'answers' => json_encode(['Carbon dioxide', 'CO2']),
            ],
            [
                'question' => 'Which planet is known as the Red Planet?',
                'answers' => json_encode(['Mars']),
            ],
            [
                'question' => 'How many continents are there?',
                'answers' => json_encode(['7', 'Seven']),
            ],
            [
                'question' => 'Which ocean is the largest?',
                'answers' => json_encode(['Pacific Ocean', 'The Pacific']),
            ],
            [
                'question' => 'What is the main ingredient in bread?',
                'answers' => json_encode(['Flour', 'Wheat flour']),
            ],

            [
                'question' => 'Hello!',
                'answers' => json_encode(['Hi!', 'Hello there!', 'Hey!']),
            ],

            [
                'question' => 'Good morning!',
                'answers' => json_encode(['Morning!', 'Good morning to you!', 'Hello!']),
            ],
            [
                'question' => 'Good night!',
                'answers' => json_encode(['Night!', 'Sleep well!', 'Sweet dreams!']),
            ],
            [
                'question' => 'How is your day?',
                'answers' => json_encode(['Pretty good, thanks!', 'It’s going well.', 'Not bad.']),
            ],
            [
                'question' => 'What’s your name?',
                'answers' => json_encode(['I am John.', 'My name is Alex.', 'Call me Sarah.']),
            ],
            [
                'question' => 'Nice to meet you!',
                'answers' => json_encode(['Nice to meet you too!', 'Pleasure meeting you!', 'Likewise!']),
            ],
            [
                'question' => 'Thank you!',
                'answers' => json_encode(['You’re welcome!', 'No problem!', 'Anytime!']),
            ],
            [
                'question' => 'Excuse me',
                'answers' => json_encode(['Yes?', 'How can I help?', 'Yes, please?']),
            ],
            [
                'question' => 'I am sorry.',
                'answers' => json_encode(['It’s okay.', 'No worries.', 'Don’t mention it.']),
            ],
            [
                'question' => 'See you later!',
                'answers' => json_encode(['See you!', 'Later!', 'Bye!']),
            ],
            [
                'question' => 'Good afternoon!',
                'answers' => json_encode(['Hello!', 'Good afternoon to you!', 'Hi there!']),
            ],
            [
                'question' => 'Good evening!',
                'answers' => json_encode(['Evening!', 'Good evening to you!', 'Hello!']),
            ],
            [
                'question' => 'How was your weekend?',
                'answers' => json_encode(['It was great!', 'Pretty relaxing.', 'Had a good time!']),
            ],
            [
                'question' => 'What’s up?',
                'answers' => json_encode(['Not much.', 'All good.', 'Just chilling.']),
            ],
            [
                'question' => 'Can you help me?',
                'answers' => json_encode(['Sure!', 'Of course.', 'Yes, what do you need?']),
            ],
            [
                'question' => 'Where are you from?',
                'answers' => json_encode(['I am from USA.', 'I live in London.', 'I come from Canada.']),
            ],
            [
                'question' => 'How old are you?',
                'answers' => json_encode(['I am 25.', 'Twenty-five years old.', 'I am in my mid-20s.']),
            ],
            [
                'question' => 'What do you do?',
                'answers' => json_encode(['I am a teacher.', 'I work as a developer.', 'I am a student.']),
            ],
            [
                'question' => 'Have a nice day!',
                'answers' => json_encode(['Thank you!', 'You too!', 'Thanks, same to you!']),
            ],
            // Additional 69 questions
        ];

        // Generate remaining 69 questions dynamically
        /*
        for ($i = 32; $i <= 100; $i++) {
            $data[] = [
                'question' => "Sample question $i?",
                'answers' => json_encode(["Answer A $i", "Answer B $i", "Answer C $i"]),
            ];
        }
        */

        DB::table('questions')->insert($data);
    }
}
