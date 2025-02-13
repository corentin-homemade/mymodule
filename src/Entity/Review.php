<?php

namespace PrestaShop\Module\MyModule\Entity;

class Review
{
    private $rating_value;
    private $review_text;

    public function getRatingValue()
    {
        return $this->rating_value;
    }

    public function setRatingValue($rating_value)
    {
        $this->rating_value = $rating_value;
    }

    public function getReviewText()
    {
        return $this->review_text;
    }

    public function setReviewText($review_text)
    {
        $this->review_text = $review_text;
    }
}
