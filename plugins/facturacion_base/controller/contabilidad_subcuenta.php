<?php

require_once 'plugins/facturacion_base/extras/fbase_controller.php';
require_once 'plugins/facturacion_base/extras/libromayor.php';

class contabilidad_subcuenta extends fbase_controller
{

    public $cuenta;
    public $divisa;
    public $ejercicio;
    public $pdf_libromayor;
    public $resultados;
    public $subcuenta;
    public $offset;

    public function __construct()
    {
        parent::__construct(__CLASS__, 'Subcuenta', 'contabilidad', FALSE, FALSE);
    }

    protected function private_core()
    {
        parent::private_core();
        $this->divisa = new divisa();

        $subcuenta = new subcuenta();
        $this->subcuenta = FALSE;
        if (isset($_GET['id'])) {
            $this->subcuenta = $subcuenta->get($_GET['id']);
        }

        if ($this->subcuenta) {
            /// configuramos la página previa
            $this->ppage = $this->page->get('contabilidad_cuenta');
            $this->ppage->title = 'Cuenta: ' . $this->subcuenta->codcuenta;
            $this->ppage->extra_url = '&id=' . $this->subcuenta->idcuenta;

            $this->page->title = 'Subcuenta: ' . $this->subcuenta->codsubcuenta;
            $this->cuenta = $this->subcuenta->get_cuenta();
            $this->ejercicio = $this->subcuenta->get_ejercicio();

            $this->offset = 0;
            if (isset($_GET['offset'])) {
                $this->offset = intval($_GET['offset']);
            }

            $this->resultados = $this->subcuenta->get_partidas($this->offset);

            if (isset($_POST['puntear'])) {
                $this->modificar();
            } else if (isset($_GET['genlm'])) {
                $this->generar_libro_mayor();
            }

            $this->pdf_libromayor = FALSE;
            if (file_exists('tmp/' . FS_TMP_NAME . 'libro_mayor/' . $this->subcuenta->idsubcuenta . '.pdf')) {
                $this->pdf_libromayor = 'tmp/' . FS_TMP_NAME . 'libro_mayor/' . $this->subcuenta->idsubcuenta . '.pdf';
            }

            /// comprobamos la subcuenta
            $this->subcuenta->test();
        } else {
            $this->new_error_msg("Subcuenta no encontrada.", 'error', FALSE, FALSE);
            $this->ppage = $this->page->get('contabilidad_cuentas');
        }
    }

    public function url()
    {
        if (!isset($this->subcuenta)) {
            return parent::url();
        } else if ($this->subcuenta) {
            return $this->subcuenta->url();
        }
        
        return $this->ppage->url();
    }

    public function paginas()
    {
        return $this->fbase_paginas($this->url(), $this->subcuenta->count_partidas(), $this->offset);
    }

    private function modificar()
    {
        if ($_POST['descripcion'] != $this->subcuenta->descripcion) {
            $this->subcuenta->descripcion = $_POST['descripcion'];
            $this->subcuenta->coddivisa = $_POST['coddivisa'];
            $this->subcuenta->save();
        }

        foreach ($this->resultados as $pa) {
            if (isset($_POST['punteada'])) {
                $valor = in_array($pa->idpartida, $_POST['punteada']);
            } else {
                $valor = FALSE;
            }

            if ($pa->punteada != $valor) {
                $pa->punteada = $valor;
                $pa->save();
            }
        }

        $this->new_message('Datos guardados correctamente.');
    }

    private function generar_libro_mayor()
    {
        /// generamos el PDF del libro mayor si no existe
        $libro_mayor = new libro_mayor();
        $libro_mayor->libro_mayor($this->subcuenta);
        if (file_exists('tmp/' . FS_TMP_NAME . 'libro_mayor/' . $this->subcuenta->idsubcuenta . '.pdf')) {
            header('Location: ' . FS_PATH . 'tmp/' . FS_TMP_NAME . 'libro_mayor/' . $this->subcuenta->idsubcuenta . '.pdf');
        } else {
            $this->new_error_msg('Error al generar el libro mayor.');
        }
    }
}
