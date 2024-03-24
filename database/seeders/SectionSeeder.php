<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use DateTime;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Section::count() < 1) {
        	Section::insert([
        		[
        			'id' => '1',
        			'title' => 'LISTENING COMPREHENSION',
                    'subtitle' => 'Time – approximatly 35 minutes<br>( Includes reading the directions for each part)',
                    'description' => '<p>In this section of the test, you will have an opportinity to demonstrate your ability to understand conversations and talks in English. There are three parts to this section. Answer all the questions on the basis of what is stated or implied by speakers you hear. Do not take notes or write in your test book at anytime. Do not turn the pages until you are told to do so.</p>',
                    'urutan' => '1',
                    'duration' => 35,
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '2',
        			'title' => 'STRUCTURE AND WRITTEN EXPRESSION',
                    'subtitle' => 'Time – 25 minutes<br>( Includes reading the direction)',
                    'description' => '<p>This section is designed to measure your ability to recognize language that is appropriate for standart written English. There are two types of questions in this section with special directions for each type.</p>',
                    'urutan' => '2',
                    'duration' => 25,
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        		[
        			'id' => '3',
        			'title' => 'READING COMPREHENSION',
                    'subtitle' => 'Time – 55 minutes<br>( Includes reading the directions)',
                    'description' => '<p>This section is designed to measure your ability to read and undertand short passages.</p>',
                    'urutan' => '2',
                    'duration' => 55,
                    'created_at'    => new DateTime,
                    'updated_at'    => new DateTime
        		],
        	]);
        }
    }
}
