<?php
use PHPUnit\Framework\TestCase;

class papacontrollerTest extends TestCase {

    public function testList() {
        $repo = $this->getMockBuilder(paparepository::class)
            ->getMock();
        $repo->method('count')->willReturn(42);

        $controller = new papacontroller($repo);
        $awaited = 'ok';

        $resultat = $controller->list();

        $this->assertEquals($awaited, $resultat);
    }

    /*public function testListNoktOk(){
        $mock = $this->getMockBuilder(papacontroller::class)
            ->onlyMethods(['afficherErreur'])
            ->getMock();
        $mock->expects($this->once())
            ->method('afficherErreur');

        $mock->list();
    }*/

    public function testBla(){
        $mock = $this->getMockBuilder(papacontroller::class)
            ->onlyMethods(['afficherErreur'])
            ->getMock();
        $mock->expects($this->once())
            ->method('afficherErreur');

        $mock->toto(0);
    }
}
