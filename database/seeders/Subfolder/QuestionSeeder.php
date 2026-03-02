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
                'question' => 'Jungle?',
                'answers' => json_encode(['Massive', 'Massive - no doubt', 'Definetely, massive']),
            ],

            [
                'question' => 'Beer?',
                'answers' => json_encode(['Yes, two', 'No doubt', 'Definetely']),
            ],

            [
                'question' => 'What is the capital of France?',
                'answers' => json_encode(['Paris', 'Paris - the city of lights', 'Definetely Paris, France']),
            ],
            [
                'question' => 'How are you?',
                'answers' => json_encode(['I am fine', 'Doing well, thanks!', 'All good!', 'Screwed']),
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
                'answers' => json_encode(['I am John.', 'My name is Dima.', 'Call me Sarah.']),
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

            // Cards against humanity, light version
            [
                'question' => 'Pizza?',
                'answers' => json_encode(['Always', 'Without hesitation', 'Absolutely, every time']),
            ],
            [
                'question' => 'Monday?',
                'answers' => json_encode(['Unacceptable', 'Should be illegal', 'Hard pass']),
            ],

            [
                'question' => 'Coffee?',
                'answers' => json_encode(['Mandatory', 'IV drip level', 'Non-negotiable']),
            ],
            [
                'question' => 'WiFi down?',
                'answers' => json_encode(['Panic', 'Total chaos', 'Civilization collapses']),
            ],
            [
                'question' => 'Gym?',
                'answers' => json_encode(['Tomorrow', 'Next week', 'January for sure']),
            ],
            [
                'question' => 'Drama?',
                'answers' => json_encode(['Not today', 'I live for it', 'Only a little']),
            ],
            [
                'question' => 'Pineapple on pizza?',
                'answers' => json_encode(['Absolutely', 'Call the police', 'Debatable']),
            ],
            [
                'question' => 'Road trip?',
                'answers' => json_encode(['Pack snacks', 'Full send', 'No map needed']),
            ],
            [
                'question' => 'Group project?',
                'answers' => json_encode(['I’ll do it', 'Where is everyone?', 'Classic disaster']),
            ],
            [
                'question' => 'Sleep?',
                'answers' => json_encode(['Overrated', 'Need 12 hours', 'What is that?']),
            ],
            [
                'question' => 'Spicy food?',
                'answers' => json_encode(['Bring it on', 'Mild please', 'Regret incoming']),
            ],
            [
                'question' => 'Ghosts?',
                'answers' => json_encode(['Friendly', 'Definitely real', 'Nope nope nope']),
            ],
            [
                'question' => 'Text from ex?',
                'answers' => json_encode(['Ignore', 'Who dis?', 'Absolutely not']),
            ],
            [
                'question' => 'Dessert?',
                'answers' => json_encode(['First', 'Always room', 'Double portion']),
            ],
            [
                'question' => 'Conspiracy theories?',
                'answers' => json_encode(['Tell me more', 'Deep dive', 'Red string board ready']),
            ],
            [
                'question' => 'Rain?',
                'answers' => json_encode(['Cozy vibes', 'Cancel plans', 'Nap time']),
            ],
            [
                'question' => 'Autocorrect?',
                'answers' => json_encode(['Betrayal', 'Why though?', 'Never helpful']),
            ],
            [
                'question' => 'Dance floor?',
                'answers' => json_encode(['Main character', 'Two left feet', 'After three drinks']),
            ],
            [
                'question' => 'Surprise meeting?',
                'answers' => json_encode(['Decline', 'Camera off', 'Sudden WiFi issues']),
            ],

            // Cards against humanity, absurd / dark / chaotic CAH-style energy
            [
                'question' => 'My secret talent?',
                'answers' => json_encode(['Aggressively microwaving fish', 'Crying in HD', 'Weaponized incompetence']),
            ],
            [
                'question' => 'What ruined the family dinner?',
                'answers' => json_encode(['Grandma’s OnlyFans', 'A political podcast', 'Unsupervised tequila']),
            ],
            [
                'question' => 'My biggest fear?',
                'answers' => json_encode(['Being perceived', 'Slow WiFi during a crisis', 'Accidentally liking a 2014 post']),
            ],
            [
                'question' => 'What’s in the box?',
                'answers' => json_encode(['Emotional baggage', 'Bees. Just bees.', 'A disappointing sequel']),
            ],
            [
                'question' => 'Why am I single?',
                'answers' => json_encode(['Competitive oversharing', 'A PowerPoint presentation on crypto', 'Calling it “networking”']),
            ],
            [
                'question' => 'The school banned ____.',
                'answers' => json_encode(['Jazz hands', 'Existential dread', 'Gluten with attitude']),
            ],
            [
                'question' => 'My superpower?',
                'answers' => json_encode(['Turning red flags green', 'Summoning mild inconvenience', 'Explaining memes to boomers']),
            ],
            [
                'question' => 'What’s trending?',
                'answers' => json_encode(['Artificial confidence', 'Low-budget villain energy', 'Sponsored apologies']),
            ],
            [
                'question' => 'The wedding was ruined by ____.',
                'answers' => json_encode(['A gender reveal explosion', 'Unskippable ads', 'The groom’s search history']),
            ],
            [
                'question' => 'Doctors recommend ____ for better health.',
                'answers' => json_encode(['Screaming into the void', 'Organic chaos', 'Three hours of doomscrolling']),
            ],
            [
                'question' => 'What’s my retirement plan?',
                'answers' => json_encode(['Winning an argument online', 'Becoming cryptid folklore', 'Marrying into generational wealth']),
            ],
            [
                'question' => 'Breaking news: ____ causes global panic.',
                'answers' => json_encode(['A shortage of iced coffee', 'The moon acting suspicious', 'Another live-action remake']),
            ],
            [
                'question' => 'The real reason I got fired?',
                'answers' => json_encode(['Accidental honesty', 'Reply-all confidence', 'Vibes alone']),
            ],
            [
                'question' => 'My toxic trait?',
                'answers' => json_encode(['Clapping when the plane lands', 'Saying “let’s circle back”', 'Main character syndrome']),
            ],
            [
                'question' => 'What’s under the bed?',
                'answers' => json_encode(['Student loans', 'A Victorian child', 'Unfinished group projects']),
            ],
            [
                'question' => 'My autobiography is titled ____.',
                'answers' => json_encode(['Bold of You to Assume', 'Oops, Again', 'The Audacity']),
            ],
            [
                'question' => 'The government doesn’t want you to know about ____.',
                'answers' => json_encode(['Free breadsticks', 'Sentient pigeons', 'The true cost of guacamole']),
            ],
            [
                'question' => 'Date night?',
                'answers' => json_encode(['Competitive trauma bonding', 'Arguing about parking', 'A shared identity crisis']),
            ],
            [
                'question' => 'My childhood nickname?',
                'answers' => json_encode(['Budget Batman', 'Chaos Goblin', 'Mildly Concerning']),
            ],
            [
                'question' => 'The apocalypse started with ____.',
                'answers' => json_encode(['A TikTok challenge', 'Expired hummus', 'One guy named Greg']),
            ],

            // darker, more unhinged, or NSFW-level
            [
                'question' => 'The real cause of the apocalypse?',
                'answers' => json_encode(['A toddler with admin privileges', 'Weaponized essential oils', 'A group chat named “No Drama”']),
            ],
            [
                'question' => 'My villain origin story?',
                'answers' => json_encode(['They said “per my last email”', 'One unpaid internship too many', 'The ice cream machine was broken']),
            ],
            [
                'question' => 'What’s in my basement?',
                'answers' => json_encode(['Unfinished business', 'A startup podcast', 'Three raccoons in a trench coat']),
            ],
            [
                'question' => 'The worst thing to hear during surgery?',
                'answers' => json_encode(['“Oops.”', '“That’s not supposed to be there.”', '“Quick, Google it.”']),
            ],
            [
                'question' => 'My last words?',
                'answers' => json_encode(['“Watch this.”', '“It’ll be fine.”', '“Trust me.”']),
            ],
            [
                'question' => 'What did I bring to the potluck?',
                'answers' => json_encode(['Unseasoned confidence', 'A suspiciously wet lasagna', 'Emotional damage']),
            ],
            [
                'question' => 'The children yearn for ____.',
                'answers' => json_encode(['Structured chaos', 'Anarchy with snacks', 'A mildly cursed mascot']),
            ],
            [
                'question' => 'Breaking news: Local man arrested for ____.',
                'answers' => json_encode(['Excessive vibe checks', 'Illegal use of finger guns', 'Tax fraud but make it aesthetic']),
            ],
            [
                'question' => 'What’s hiding in the attic?',
                'answers' => json_encode(['Victorian secrets', 'A sentient Furby', 'My search history']),
            ],
            [
                'question' => 'The wedding vows included ____.',
                'answers' => json_encode(['A non-disclosure agreement', 'Shared trauma', 'Access to my streaming passwords']),
            ],
            [
                'question' => 'My toxic coping mechanism?',
                'answers' => json_encode(['Irony poisoning', 'Competitive suffering', 'Retail therapy at 2am']),
            ],
            [
                'question' => 'The theme of this year’s family reunion?',
                'answers' => json_encode(['Passive aggression', 'Inherited medical conditions', 'Who’s in jail now?']),
            ],
            [
                'question' => 'The science fair project was just ____.',
                'answers' => json_encode(['Unregulated ambition', 'A potato with WiFi', 'Moral bankruptcy']),
            ],
            [
                'question' => 'What ended my political career?',
                'answers' => json_encode(['A hot mic moment', 'Leaked karaoke footage', 'The phrase “hear me out”']),
            ],

            [
                'question' => 'What’s actually in the energy drink?',
                'answers' => json_encode(['Liquid anxiety', 'Crushed dreams', 'A legally concerning amount of caffeine']),
            ],
            [
                'question' => 'The support group is for people addicted to ____.',
                'answers' => json_encode(['Overexplaining', 'Doomscrolling', 'Starting sentences with “technically”']),
            ],
            [
                'question' => 'What’s trending in 2030?',
                'answers' => json_encode(['Renting oxygen', 'AI-generated childhood memories', 'Subscription-based emotions']),
            ],
            [
                'question' => 'The haunted house features ____.',
                'answers' => json_encode(['Affordable housing', 'A ghost with commitment issues', 'My unresolved childhood']),
            ],
            [
                'question' => 'Why was I banned from the zoo?',
                'answers' => json_encode(['Trying to unionize the penguins', 'Making eye contact with the alpha', 'Teaching the parrots profanity']),
            ],

            [
                'question' => 'Midlife crisis?',
                'answers' => json_encode(['Convertible acquired', 'New personality unlocked', 'Tattoo incoming']),
            ],
            [
                'question' => 'Trust issues?',
                'answers' => json_encode(['Earned, not given', 'Documented history', 'See attached evidence']),
            ],
            [
                'question' => 'Lie detector test?',
                'answers' => json_encode(['Immediately sweating', 'Define “lie”', 'Technical difficulties']),
            ],
            [
                'question' => 'Childhood trauma?',
                'answers' => json_encode(['Character development', 'Lore expansion', 'Director’s cut']),
            ],
            [
                'question' => 'Emergency contact?',
                'answers' => json_encode(['Do not call', 'They don’t know either', 'We ride together']),
            ],
            [
                'question' => 'Family group chat?',
                'answers' => json_encode(['Muted forever', 'Unhinged opinions', 'Forwarded misinformation']),
            ],
            [
                'question' => 'Life insurance?',
                'answers' => json_encode(['Suspicious timing', 'Asking for a friend', 'Just in case']),
            ],
            [
                'question' => 'Secret ingredient?',
                'answers' => json_encode(['Spite', 'Denial', 'Mild resentment']),
            ],
            [
                'question' => 'Witness protection?',
                'answers' => json_encode(['New haircut', 'Different accent', 'Delete Facebook']),
            ],
            [
                'question' => 'Polygraph results?',
                'answers' => json_encode(['Inconclusive', 'Concerning', 'Let’s move on']),
            ],
            [
                'question' => 'Tax audit?',
                'answers' => json_encode(['Sudden illness', 'Lost receipts', 'Spiritual journey']),
            ],
            [
                'question' => 'Inheritance?',
                'answers' => json_encode(['One spoon', 'Emotional baggage', 'A cursed painting']),
            ],
            [
                'question' => 'Last will?',
                'answers' => json_encode(['Delete my browser history', 'Burn the journals', 'No open casket']),
            ],
            [
                'question' => 'Anger management?',
                'answers' => json_encode(['Work in progress', 'Define anger', 'Punching air respectfully']),
            ],
            [
                'question' => 'Polyamory?',
                'answers' => json_encode(['Advanced difficulty', 'Color-coded calendar', 'Pray for me']),
            ],
            [
                'question' => 'Court appearance?',
                'answers' => json_encode(['Allegedly', 'No further questions', 'Smile politely']),
            ],
            [
                'question' => 'Hospital bill?',
                'answers' => json_encode(['Life-ending', 'Second injury', 'Guess I’ll pass away']),
            ],
            [
                'question' => 'Exorcism?',
                'answers' => json_encode(['Wrong demon', 'Try turning it off', 'Premium subscription required']),
            ],
            [
                'question' => 'Moral compass?',
                'answers' => json_encode(['Under maintenance', 'Spinning rapidly', 'Sold separately']),
            ],
            [
                'question' => 'Unsupervised?',
                'answers' => json_encode(['Bold move', 'Immediate regret', 'Chaos confirmed']),
            ],
            [
                'question' => 'Sleep paralysis?',
                'answers' => json_encode(['Roommate vibes', 'Shadow DLC', 'Not paying rent']),
            ],
            [
                'question' => 'Debt?',
                'answers' => json_encode(['Generational', 'Character building', 'Collector’s edition']),
            ],
            [
                'question' => 'Therapist notes?',
                'answers' => json_encode(['Concerned silence', 'Underline twice', 'Needs supervision']),
            ],
            [
                'question' => 'Internet history?',
                'answers' => json_encode(['Classified', 'Redacted', 'Destroy immediately']),
            ],
            [
                'question' => 'Fun fact?',
                'answers' => json_encode(['Not fun', 'Legally questionable', 'Emotionally damaging']),
            ],
            [
                'question' => 'Witness?',
                'answers' => json_encode(['Saw nothing', 'Suddenly blind', 'Out of town']),
            ],
            [
                'question' => 'Side effects?',
                'answers' => json_encode(['Mild chaos', 'Existential dread', 'Spontaneous honesty']),
            ],
            [
                'question' => 'Reputation?',
                'answers' => json_encode(['In shambles', 'Allegedly fine', 'Under investigation']),
            ],
            [
                'question' => 'Life choices?',
                'answers' => json_encode(['Bold strategy', 'We learn', 'Not reversible']),
            ],

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
