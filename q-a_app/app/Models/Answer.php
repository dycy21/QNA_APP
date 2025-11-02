<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    
    protected $fillable = ['question_id', 'text', 'instruction_page_id'];

    // Answer belongs to a Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Answer directs to one InstructionPage
    public function instructionPage()
    {
        return $this->belongsTo(InstructionPage::class);
    }
}