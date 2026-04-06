<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCaptcha implements Rule
{
    protected $message = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Simple implementation - can be replaced with Google reCAPTCHA v3 or hCaptcha
        // For now, we'll check if CAPTCHA session matches the input

        if (session()->has('captcha_answer')) {
            $sessionAnswer = session()->get('captcha_answer');
            session()->forget('captcha_answer');

            return $value == $sessionAnswer;
        }

        $this->message = 'CAPTCHA tidak valid atau sudah kadaluarsa.';
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Generate simple math CAPTCHA
     */
    public static function generateCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operator = ['+', '-'][rand(0, 1)];

        if ($operator === '+') {
            $answer = $num1 + $num2;
        } else {
            $answer = $num1 - $num2;
        }

        $question = "$num1 $operator $num2 = ?";

        session()->put('captcha_answer', $answer);
        session()->put('captcha_expires', now()->addMinutes(5));

        return $question;
    }
}
