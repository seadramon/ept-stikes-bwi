<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;
use DateTime;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Part::count() < 1) {
        	Part::insert([
        		[
        			'id' => '1',
        			'section_id' => '1',
        			'title' => 'PART A',
                    'direction' => '<p>In part A you will hear short conversations between two people. After each conversation, you will hear a question about the conversation. The conversations and questions will not be repeated. After you hear question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have choosen.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '2',
        			'section_id' => '1',
        			'title' => 'PART B',
                    'direction' => '<p>In this part of the test, you will hear longer conversations. After each conversation, you will hear several questions. The conversations and questions will not be repeated. After you hear question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have choosen. Remember, you are not allowed to take notes or write in your test book.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '3',
        			'section_id' => '1',
        			'title' => 'PART C',
                    'direction' => '<p>In this part of the test, you will hear several talks. After each talk, you will hear some questions. The talks and the questions will not be repeated. After you hear question, read the four possible answers in your test book and choose the best answer. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have choosen. </p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '4',
        			'section_id' => '2',
        			'title' => 'STRUCTURE',
                    'direction' => '<p>Questions 1 – 15 are incomplete sentences. Beneath each sentence you will see four words or phrases, mark (A), (B), (C), and (D). Choose the one word or phrase that best completes the sentence. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter inside the oval cannot be seen.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '5',
        			'section_id' => '2',
        			'title' => 'WRITTEN EXPRESSION',
                    'direction' => '<p>In questions 66 – 90, each sentence has four underlined words or phrases. The four underlined parts of the sentence are marked (A), (B), (C), and (D). Identify the one underlined word or phrase that must be changed in order for the sentence to be correct. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have choosen.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '6',
        			'section_id' => '3',
        			'title' => 'READING',
                    'direction' => '<p>In this section you will read several passages. Each one is followed by a number of questions about it. You are to choose the one best answer; (A), (B), (C), or (D), to each question. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letterof the answer you have chosen.<br>Answer all question about the information in a passage on the basis of what is implied or stated in that passage.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        	]);
        }
    }
}
