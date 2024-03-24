<?php
namespace App\Services;

use App\Models\Question;
use DB;

class QuestionService
{
	
	public function getNextUrutan($part)
	{
		$result = 1;
		$data = Question::where('part_id', $part)->max('urutan');

		if ($data) {
			$result = $data + 1;

			return $result;
		} else {
			return $result;
		}
	}
}