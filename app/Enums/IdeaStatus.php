<?php

namespace App\Enums;

enum IdeaStatus: string
{
    case Draft='draft';
    case Submitted='submitted';
    case UnderReview='under_review';
    case Approved='approved';
    case Rejected ='rejected ';
    case Implemented ='implemented ';
    case Rewarded ='rewarded ';
    case Archived ='archived ';
}
