<?php

namespace Tests;

use DOE_50001_Ready\Guidance;
use DOE_50001_Ready\Markup;
use DOE_50001_Ready\Task;
use PHPUnit\Framework\TestCase;

class MarkupTest extends TestCase
{
    public function test_resource_markup()
    {
        $initialText = 'Asdf [resource](Resource_Name) Asdf';
        $markedUpText = Markup::addResourceLinks($initialText);
        $this->assertEquals('Asdf Resource Name Asdf', $markedUpText);
    }

    public function test_task_markup()
    {
        $initialText = 'Asdf [task](Menu Name) Asdf';
        $markedUpText = Markup::addTaskLinks($initialText);
        $this->assertEquals('Asdf the Menu Name Task Asdf', $markedUpText);
    }

    public function test_accordions()
    {
        $initialText = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';

        $markedUpText = Markup::addExpandables($initialText, 'Accordion');
        $accordionChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';
        $this->assertEquals($accordionChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $learnMoreChanged = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        $this->assertEquals($learnMoreChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        $bothChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        $this->assertEquals($bothChanged, $markedUpText);

        $markedUpText = Markup::addExpandables('Asdf', 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        $this->assertEquals('Asdf', $markedUpText);
    }

    public function test_task_markups()
    {
        $guidance = new Guidance();
        foreach($guidance->getTasks() as $task){
            /** @var Task $task */
            $task->getGettingItDone();
            $task->getTaskOverview();
            $task->getFullDescription();
            $task->getOtherIsoTips();
            $task->getEnergyStarTips();
        }
    }


}
