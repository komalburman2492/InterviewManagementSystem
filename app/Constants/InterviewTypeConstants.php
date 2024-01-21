<?php
namespace App\Constants;

class InterviewTypeConstants
{
    const HR = 1;
    const SKILL = 2;
    const TECHNICAL = 3;
    const MACHINE = 4;

    public static function getTypes()
    {
        return [
            self::HR,
            self::SKILL,
            self::TECHNICAL,
            self::MACHINE
        ];
    }


    public static function getInterviewType($value)
    {
        switch ($value) {
            case self::HR:
                return 'HR';
            case self::SKILL:
                return 'SKILL';
            case self::TECHNICAL:
                return 'TECHNICAL';
            case self::MACHINE:
                return 'MACHINE';
            default:
                return null;
        }
    }
}
