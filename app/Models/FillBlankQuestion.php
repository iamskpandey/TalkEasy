<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FillBlankQuestion extends Model
{
    protected $fillable = [
        'exercise_id',
        'text_with_blanks',
        'order'
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function getBlanks()
    {
        $blanks = [];
        $pattern = '/\[blank:(.*?)\]/';
        
        if (preg_match_all($pattern, $this->text_with_blanks, $matches)) {
            $blanks = $matches[1];
        }
        
        return $blanks;
    }

    public function getTextWithBlanksForDisplay()
    {
        $pattern = '/\[blank:(.*?)\]/';
        return preg_replace_callback($pattern, function ($matches) {
            static $counter = 0;
            $counter++;
            return '<input type="text" class="blank-input" name="blank_' . $counter . '" data-answer="' . htmlspecialchars($matches[1]) . '">';
        }, $this->text_with_blanks);
    }
}
