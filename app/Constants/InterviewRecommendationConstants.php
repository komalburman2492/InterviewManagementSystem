<?php
namespace App\Constants;

class InterviewRecommendationConstants
{
    const NEW  = 0;
    const REJECTED = 1;
    const HIRED = 2;
    const FURTHER_INTERVIEW = 3;

    public static function getTypes()
    {
        return [
            self::NEW,
            self::REJECTED,
            self::HIRED,
            self::FURTHER_INTERVIEW,
        ];
    }

    public static function getInterviewRecommendationType($value)
    {
        switch ($value) {
            case self::NEW:
                return 'NEW';
            case self::REJECTED:
                return 'REJECTED';
            case self::HIRED:
                return 'HIRED';
            case self::FURTHER_INTERVIEW:
                return 'FURTHER_INTERVIEW';
            default:
                return null;
        }
    }
}
