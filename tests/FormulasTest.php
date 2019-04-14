<?php

/**
 * @Author:  Jaime Díaz | Frontend Developer & Backend PHP
 * 
 * NOTA:
 * ejecutar las pruebas por consola escribiendo este comando:  ./vendor/bin/phpunit tests/FormulaTest  +  [ TECLA ENTER ]
 * 
 */

use PHPUnit\Framework\TestCase;

class FormulasTest extends TestCase
{
    // TODO: Test para la fórmula de la publicación básica
    public function testCalcularPublicacionBasica() {
        $precioUsd      = 32;
        $pesoProducto   = 6;
        $valorTrm       = 3120;
        $this->assertEquals($this->calcularPublicacionBasica($precioUsd, $pesoProducto, $valorTrm), 350338.56);
    }

    // TODO: Test para la fórmula de la publicación premium
    public function testCalcularPublicacionPremium() {
        $precioUsd      = 32;
        $pesoProducto   = 6;
        $valorTrm       = 3120;
        $this->assertEquals($this->calcularPublicacionPremium($precioUsd, $pesoProducto, $valorTrm), 338607.36);
    }    

    // Test para redonear al 900 más cercano
    public function testRedondearAl900MasCercanoBasico() {
        $valorAredondear = 350338.56;
        $this->assertEquals($this->redondearAl900MasCercano($valorAredondear), 349900);
    }

    public function testRedondearAl900MasCercanoPremium() {
        $valorAredondear = 338607.36;
        $this->assertEquals($this->redondearAl900MasCercano($valorAredondear), 338900);
    }    

    // Fórmula #1
    function calcularPublicacionBasica($precioBase, $peso, $trm) {
        $comision = 0;
        $valorComision= 0;
        $comisionMercadoLibre = 0.16;
        $valorComisionML = 0;
        $formulaParte1 = 0;
        $formula = 0;

        if ($peso > 0 && $peso <= 10) {
            $comision = 0.15;
        }
        if ($peso > 10 && $peso <= 20) {
            $comision = 0.25;
        }
        if ($peso > 20 && $peso <= 30) {
            $comision = 0.35;
        }
        if ($peso > 40 && $peso <= 50) {
            $comision = 0.45;
        }
        if ($peso > 50 && $peso <= 60) {
            $comision = 0.55;
        }

        // comisión básica por peso sobre valor base:
        $valorComision = ($precioBase * $comision);
        $formulaParte1 = (($precioBase + ($peso * 10) + $valorComision) * $trm);
        $valorComisionML = $formulaParte1 * $comisionMercadoLibre;
        $formula = $formulaParte1 + $valorComisionML;

        return $formula;
    }

    // Fórmula #2
    public function calcularPublicacionPremium($precioBase, $peso, $trm) {

        $comision = 0;
        $valorComision= 0;
        $comisionMercadoLibre = 0.14;
        $valorComisionML = 0;
        $formulaParte1 = 0;
        $formula = 0;

        if ($peso > 0 && $peso <= 10) {
            $comision = 0.1;
        }
        if ($peso > 10 && $peso <= 20) {
            $comision = 0.2;
        }
        if ($peso > 20 && $peso <= 30) {
            $comision = 0.3;
        }
        if ($peso > 40 && $peso <= 50) {
            $comision = 0.4;
        }
        if ($peso > 50 && $peso <= 60) {
            $comision = 0.5;
        }

        // comisión básica por peso sobre valor base:
        $valorComision = ($precioBase * $comision);
        $formulaParte1 = (($precioBase + ($peso * 10) + $valorComision) * $trm);
        $valorComisionML = $formulaParte1 * $comisionMercadoLibre;
        $formula = $formulaParte1 + $valorComisionML;

        return $formula;
    }

    // Aproximar al 900 más cercano
    public function redondearAl900MasCercano($valor) {
        $round1    = round($valor)/1000*1000;
        $valorBase = round($round1, -3);
        $valorRetorno = 0;

        if ($valor > $valorBase) {
            $valorRestante = ($valor - $valorBase);
        } else {
            $valorRestante = ($valorBase - $valor);
        }

        if($valorRestante < 400) {
            // restar 100 al valor base, redondear hacia abajo
            $valorRetorno = $valorBase - 100;
        }
        else if ($valorRestante >= 400) {
            // sumar 900 al valor base, redondear hacia arriba
            $valorRetorno = $valorBase + 900;
        }
        return $valorRetorno;
    }    
}