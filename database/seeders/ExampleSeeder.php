<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Example;
use DateTime;

class ExampleSeeder extends Seeder
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
        			'part_id' => '1',
        			'story' => '',
                    'direction' => '<p>In this section you will read several passages. Each one is followed by a number of questions about it. You are to choose the one best answer; (A), (B), (C), or (D), to each question. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letterof the answer you have chosen.<br>Answer all question about the information in a passage on the basis of what is implied or stated in that passage.</p>',
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        	]);
    }
}
