<?php
class Paginador extends BD {
    private $conex;
    private $totalRegistros;
    private $filasPorPagina;
    private $paginaActual;
    private $totalPaginas;

    function __construct() {
        parent::__construct();
        $this->conex = parent::getConexion();
    }

    public function paginar($tabla, $pagina = 1, $filasPorPagina = 10, $condiciones = '') {
        $this->filasPorPagina = $filasPorPagina;
        $this->paginaActual = max(1, (int)$pagina);
        $inicio = ($this->paginaActual - 1) * $this->filasPorPagina;
    
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $tabla $condiciones LIMIT :inicio, :filas";
        $stmt = $this->conex->prepare($sql);
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':filas', $this->filasPorPagina, PDO::PARAM_INT);
        $stmt->execute();
        
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = $this->conex->query("SELECT FOUND_ROWS()")->fetchColumn();
        
        return [
            'datos' => $datos,
            'total' => $total,
            'inicio' => $inicio + 1,
            'fin' => min($this->paginaActual * $this->filasPorPagina, $total),
            'pagina_actual' => $this->paginaActual,
            'filas_por_pagina' => $this->filasPorPagina
        ];
    }
    public function getPiePaginacion($urlBase, $params = []) {
        $queryString = !empty($params) ? '&' . http_build_query($params) : '';
        
        $html = '<tfoot><tr>';
        
        // Selector de filas por página
        $html .= '<td>Filas por Página: 
            <select id="filasPorPagina" onchange="cambiarFilasPorPagina(this.value)">
                <option value="10" '.($this->filasPorPagina == 10 ? 'selected' : '').'>10</option>
                <option value="20" '.($this->filasPorPagina == 20 ? 'selected' : '').'>20</option>
                <option value="50" '.($this->filasPorPagina == 50 ? 'selected' : '').'>50</option>
                <option value="100" '.($this->filasPorPagina == 100 ? 'selected' : '').'>100</option>
            </select>
        </td>';
        
        // Info de paginación
        $html .= '<td>'.$this->getRangoTexto().'</td>';
        
        // Flecha izquierda
        $html .= '<td>';
        if ($this->paginaActual > 1) {
            $html .= '<a href="'.$urlBase.'?pagina='.($this->paginaActual - 1).$queryString.'">
                <i class="flecha-izquierda"><img src="img/flecha_izquierda.svg" alt="Anterior" width="16" height="16"></i>
            </a>';
        }
        $html .= '</td>';
        
        // Flecha derecha
        $html .= '<td>';
        if ($this->paginaActual < $this->totalPaginas) {
            $html .= '<a href="'.$urlBase.'?pagina='.($this->paginaActual + 1).$queryString.'">
                <i class="flecha-derecha"><img src="img/flecha_derecha.svg" alt="Siguiente" width="16" height="16"></i>
            </a>';
        }
        $html .= '</td>';
        
        $html .= '</tr></tfoot>';
        
        return $html;
    }

    private function getRangoTexto() {
        $inicio = ($this->paginaActual - 1) * $this->filasPorPagina + 1;
        $fin = min($this->paginaActual * $this->filasPorPagina, $this->totalRegistros);
        return "$inicio-$fin de $this->totalRegistros";
    }

    // Getters
    public function getTotalRegistros() { return $this->totalRegistros; }
    public function getFilasPorPagina() { return $this->filasPorPagina; }
    public function getPaginaActual() { return $this->paginaActual; }
    public function getTotalPaginas() { return $this->totalPaginas; }
}