<?php

use Behat\Gherkin\Node\PyStringNode;
use Illuminate\Support\Str;

trait BodyWithRandomValues
{

    /** @var string $lastRandomText */
    private $lastRandomText;

    /**
     * @Given the request body with random values is:
     */
    public function theRequestBodyWithRandomValuesIs(PyStringNode $string)
    {
        $pattern = '/{RandomText}/';
        $this->lastRandomText = Str::random(15);
        echo 'New RandomText: ' . $this->lastRandomText;

        $inputLines = $string->getStrings();
        $outputLines = preg_replace($pattern, $this->lastRandomText, $inputLines);

        $this->setRequestBody(new PyStringNode($outputLines, $string->getLine()));
    }

    /**
     * @Then the response body with random values contains JSON:
     */
    public function theResponseBodyWithRandomValuesContainsJson(PyStringNode $string)
    {
        $pattern = '/{LastRandomText}/';
        echo 'LastRandomText: ' . $this->lastRandomText;

        $inputLines = $string->getStrings();
        $outputLines = preg_replace($pattern, $this->lastRandomText, $inputLines);

        $this->assertResponseBodyContainsJson(new PyStringNode($outputLines, $string->getLine()));
    }
}
